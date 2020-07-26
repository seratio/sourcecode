using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Globalization;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;

namespace Seratio.Blockchain.Sandbox.Areas.RetailEnd.Controllers
{
    [AuthorizeAccess(RequiresRetailEndAccess = true)]
    public class RetailPoliciesController : BaseController
    {
        public async Task<ActionResult> Index(string daterange)
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score to access this page.");
                return Redirect("/wallet/default/dashboard");
            }
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from s in db.RetailPolicies
                         join c in db.Coins on s.RequiredCoinID equals c.ID into joined
                         from c in joined.DefaultIfEmpty()
                         where s.IsDataActive
                         select new
                         {
                             s.ID,
                             s.Name,
                             s.Category,
                             CoinName = c.Name,
                             CoinCode = c.Symbol,
                             s.ApprovedOn,
                             s.RejectedOn,
                             s.IsApproved,
                             s.LastUpdatedOn,
                             s.UserID,
                             ProcessedBy = s.ProcessedBy != null ? "Administrator" : null,
                             s.VoucherCode
                         };

            if (!AppManager.User.IsSuperAdmin)
            {
                _query = _query.Where(q => q.UserID == AppManager.User.ID);
            }

            if (!string.IsNullOrEmpty(daterange))
            {
                string[] _daterange = daterange.Split(new string[] { " " }, StringSplitOptions.RemoveEmptyEntries);
                DateTime? _start = Convert.ToDateTime(_daterange[0], new CultureInfo("en-CA"));
                DateTime? _end = Convert.ToDateTime(_daterange[2], new CultureInfo("en-CA"));
                _end = _end.Value.AddDays(1);
                _query = _query.Where(u => u.LastUpdatedOn >= _start.Value && u.LastUpdatedOn < _end.Value);
            }

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(s => s.Name.Contains(request.sSearch) || s.Category.Contains(request.sSearch) || s.ProcessedBy.Contains(request.sSearch) || s.IsApproved.ToString().Contains(request.sSearch) || s.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Name) : _query.OrderByDescending(s => s.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.VoucherCode) : _query.OrderByDescending(m => m.VoucherCode);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.ProcessedBy) : _query.OrderByDescending(m => m.ProcessedBy);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Category) : _query.OrderByDescending(s => s.Category);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.LastUpdatedOn) : _query.OrderByDescending(s => s.LastUpdatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(s => s.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                string _status = string.Empty;
                string _processedby = string.Empty;

                switch (_rowData.IsApproved)
                {
                    case null:
                        _status = "<span class=\"label bg-grey-300\">Pending</span>";
                        break;
                    case true:
                        _status = "<span class=\"label bg-success\">Approved</span>";
                        break;
                    case false:
                        _status = "<span class=\"label bg-danger\">Rejected</span>";
                        break;
                    default:
                        break;
                }
                _row.Add("<a href='/wallet/retailend/retailpolicies/details/" + _rowData.ID + "' ></i>" + _rowData.Name + "</a><br /><div class=\"text-muted text-size-small\">" + _status + "</div>");
                _row.Add(_rowData.VoucherCode);

                if (!string.IsNullOrEmpty(_rowData.ProcessedBy))
                {
                    _row.Add(_rowData.ProcessedBy);
                }
                else
                {
                    _row.Add("-");
                }

                if (_rowData.Category != null)
                {
                    _row.Add(_rowData.Category);
                }
                else
                {
                    _row.Add("-");

                }
                _row.Add(_rowData.LastUpdatedOn.ToString());

                if (_rowData.IsApproved == null)
                {
                    _row.Add(@"<a href='/wallet/retailend/retailpolicies/edit/" + _rowData.ID +
                             "' title='Edit' class='mr5'><i class='fa fa-pencil-square-o'></i></a>  <a class='confirm' data-confirm='Are you sure you want to delete this Retail Policy?' href='/wallet/retailend/retailpolicies/delete/" +
                             _rowData.ID + "' title='Delete'><i class='fa fa-trash'></i></a> ");
                }
                else
                {
                    _row.Add(@"<a class='confirm' data-confirm='Are you sure you want to delete this Retail Policy?' href='/wallet/retailend/retailpolicies/delete/" +
                             _rowData.ID + "' title='Delete'><i class='fa fa-trash'></i></a> ");
                }


                _rows.Add(_row);
            }

            return Json(new DataTableResponse
            {
                sEcho = request.sEcho,
                iDisplayLength = request.iDisplayLength,
                iTotalRecords = _count,
                iDisplayStart = request.iDisplayStart,
                iTotalDisplayRecords = _count,
                aaData = _rows
            }, JsonRequestBehavior.AllowGet);
        }

        public async Task<ActionResult> GetSocialActivities(string q, int i)
        {
            int _skip = i == 1 ? 0 : (i - 1) * 20;

            var _query = from s in db.SocialActivities
                         where s.IsDataActive && s.Name.Contains(q)
                         orderby s.Name
                         select new
                         {
                             s.ID,
                             s.Name,
                         };

            Select2PagedResult _result = new Select2PagedResult
            {
                Total = await _query.OrderBy(t => t.Name).CountAsync(),
                Results = (await _query.OrderBy(t => t.Name).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2Item
                {
                    id = r.ID,
                    text = r.Name
                }).ToList()
            };

            return Json(_result, JsonRequestBehavior.AllowGet);
        }

        public async Task<ActionResult> Create()
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score to access this page.");
                return Redirect("/wallet/default/dashboard");
            }

            ViewBag.VoucherCode = string.Join("", Guid.NewGuid().ToString("n").Take(8).OrderBy(i => Guid.NewGuid()).Select(o => o)).ToUpper();

            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Create(RetailPolicy model)
        {
            if (ModelState.IsValid)
            {
                model.UserID = AppManager.User.ID;
                model.CreatedOn = DateTime.Now;
                model.LastUpdatedOn = DateTime.Now;
                model.IsDataActive = true;

                if (model.PolicyType == "Coin")
                {
                    model.MaxSEScore = null;
                    model.MinSESCore = null;
                }
                else
                {
                    model.RequiredCoinQty = null;
                    model.RequiredCoinID = null;
                }

                db.RetailPolicies.Add(model);
                await db.SaveChangesAsync();


                var _administrators = await db.Users.Where(u => u.IsDataActive && u.IsSuperAdmin && u.IsEmailVerified).ToListAsync();

                foreach (User _admin in _administrators)
                {
                    ActivityNotification _activityNotification = new ActivityNotification();

                    _activityNotification.UserID = _admin.ID;
                    _activityNotification.RelatedItemID = model.ID;
                    _activityNotification.Type = "Retail Policy";
                    _activityNotification.Message = "Request for Retail Policies";
                    _activityNotification.Time = AppManager.Now;
                    _activityNotification.IsRead = false;
                    _activityNotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activityNotification);
                    await db.SaveChangesAsync();

                    string _body =
                        $"Hello {_admin.NickName ?? _admin.Email.ToLower()} ,<br /><br /> You have a new request from {(AppManager.User.NickName != null ? AppManager.User.NickName : AppManager.User.Email.ToLower())} for authorizing the permission for Retail Policies.<br/>Please login to your account to review this request.";
                    AppManager.SendEmail($"A User has requested permission to Policy", _admin.Email, _body);

                }

                TempData["Notification"] = new Notification("Success", "Retail Policy has been created successfully.");
                return RedirectToAction("Index");
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
            return View(model);
        }

        public async Task<ActionResult> Edit(int ID)
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score to access this page.");
                return Redirect("/wallet/default/dashboard");
            }

            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            RetailPolicy _retailPolicy = await db.RetailPolicies.FirstOrDefaultAsync(a => a.IsDataActive && a.ID == ID && a.IsApproved == null && (a.UserID == AppManager.User.ID || AppManager.User.IsSuperAdmin));

            if (_retailPolicy == null)
            {
                return HttpNotFound();
            }

            if (_retailPolicy.RequiredCoinID != null && _retailPolicy.RequiredCoinID != 0)
            {
                if (db.Coins.Any(n => n.ID == _retailPolicy.RequiredCoinID))
                {
                    _retailPolicy.SelectedRequiredCoin = new Select2Item
                    {
                        id = (int)_retailPolicy.RequiredCoinID,
                        text = db.Coins.FirstOrDefault(p => p.ID == _retailPolicy.RequiredCoinID).Name,
                    };
                }
            }

            return View(_retailPolicy);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(RetailPolicy model)
        {
            if (ModelState.IsValid)
            {
                RetailPolicy _retailPolicy = await db.RetailPolicies.FindAsync(model.ID);

                if (_retailPolicy != null)
                {
                    _retailPolicy.Name = model.Name;
                    _retailPolicy.Description = model.Description;
                    _retailPolicy.UserID = AppManager.User.ID;
                    _retailPolicy.LastUpdatedOn = DateTime.Now;
                    _retailPolicy.PolicyType = model.PolicyType;
                    _retailPolicy.DiscountMode = model.DiscountMode;
                    _retailPolicy.DiscountValue = model.DiscountValue;
                    _retailPolicy.Category = model.Category;

                    if (model.PolicyType == "Coin")
                    {
                        _retailPolicy.MaxSEScore = null;
                        _retailPolicy.MinSESCore = null;
                        _retailPolicy.RequiredCoinQty = model.RequiredCoinQty;
                        _retailPolicy.RequiredCoinID = model.RequiredCoinID;

                    }
                    else
                    {
                        _retailPolicy.MaxSEScore = model.MaxSEScore;
                        _retailPolicy.MinSESCore = model.MinSESCore;
                        _retailPolicy.RequiredCoinQty = null;
                        _retailPolicy.RequiredCoinID = null;
                    }

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Retail Policy has been saved successfully.");
                    return RedirectToAction("Index");
                }
                else
                {
                    return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
                }
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
            return View(model);
        }

        public async Task<ActionResult> Delete(int ID)
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score to access this page.");
                return Redirect("/wallet/default/dashboard");
            }

            RetailPolicy _retailPolicy = await db.RetailPolicies.FirstOrDefaultAsync(s => s.ID == ID && (s.UserID == AppManager.User.ID || AppManager.User.IsSuperAdmin));

            if (_retailPolicy != null)
            {
                _retailPolicy.DeletedOn = DateTime.Now;
                _retailPolicy.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested Retail Policy has been deleted successfully.");
                await db.SaveChangesAsync();
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Details(int ID)
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score to access this page.");
                return Redirect("/wallet/default/dashboard");
            }

            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            RetailPolicy _request =
                await db.RetailPolicies.FirstOrDefaultAsync(
                    s => s.ID == ID && (s.UserID == AppManager.User.ID || AppManager.User.IsSuperAdmin));

            if (_request == null)
            {
                return HttpNotFound();
            }

            ActivityNotification _activityNotification =
                await db.ActivityNotifications.FirstOrDefaultAsync(
                    n => n.RelatedItemID == ID && n.UserID == AppManager.User.ID && n.IsRead == false && n.Type == "Retail Policy");

            if (_activityNotification != null)
            {
                _activityNotification.IsRead = true;
                _activityNotification.ReadOn = AppManager.Now;

                await db.SaveChangesAsync();
            }
            return View(_request);
        }

        [AuthorizeAccess]
        public async Task<ActionResult> GetCoins(string q, int i)
        {
            int _skip = i == 1 ? 0 : (i - 1) * 20;
            var _query = from r in db.Coins
                         where r.IsDataActive && r.Name.Contains(q) && r.Symbol == "MCR"
                         orderby r.Name
                         select new
                         {
                             r.ID,
                             r.Name,
                             r.Address,
                             r.Symbol,
                         };


            Select2PagedResult _result = new Select2PagedResult
            {
                Total = await _query.OrderBy(t => t.Name).CountAsync(),
                Results = (await _query.OrderBy(t => t.Name).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2Item
                {
                    id = r.ID,
                    text = r.Name,
                }).ToList()
            };

            return Json(_result, JsonRequestBehavior.AllowGet);
        }

    }
}