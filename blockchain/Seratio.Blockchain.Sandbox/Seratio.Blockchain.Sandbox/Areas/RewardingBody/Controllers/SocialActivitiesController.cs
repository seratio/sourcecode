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

namespace Seratio.Blockchain.Sandbox.Areas.RewardingBody.Controllers
{
    [AuthorizeAccess(RequiresRewardingBodyAccess = true)]
    public class SocialActivitiesController : BaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from s in db.SocialActivities
                         join c in db.Coins on s.RewardingCoinID equals c.ID
                         where s.IsDataActive
                         select new
                         {
                             s.ID,
                             s.Name,
                             s.Description,
                             CoinName = c.Name,
                             CoinCode = c.Symbol,
                             s.ApprovedOn,
                             s.RejectedOn,
                             s.IsApproved,
                             s.RewardAmount,
                             s.LastUpdatedOn,
                             s.UserID,
                             ProcessedBy = s.ProcessedBy != null ? "Administrator" : null
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
                _query = _query.Where(s => s.Name.Contains(request.sSearch) || s.Description.Contains(request.sSearch) || s.ProcessedBy.Contains(request.sSearch) || s.IsApproved.ToString().Contains(request.sSearch) || s.RewardAmount.ToString().Contains(request.sSearch) || s.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Name) : _query.OrderByDescending(s => s.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.RewardAmount) : _query.OrderByDescending(s => s.RewardAmount);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.IsApproved) : _query.OrderByDescending(m => m.IsApproved);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.ProcessedBy) : _query.OrderByDescending(m => m.ProcessedBy);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Description) : _query.OrderByDescending(s => s.Description);
                    break;
                case 5:
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

                _row.Add("<a href='/wallet/rewardingbody/socialactivities/details/" + _rowData.ID + "' ></i>" + _rowData.Name + "</a>");

                _row.Add(_rowData.RewardAmount + " " + _rowData.CoinCode);

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

                _row.Add("<div class=\"text-muted text-size-small\">" + _status + "</div>");

                if (!string.IsNullOrEmpty(_rowData.ProcessedBy))
                {
                    _row.Add(_rowData.ProcessedBy);
                }
                else
                {
                    _row.Add("-");
                }


                if (_rowData.Description != null)
                {
                    _row.Add(_rowData.Description);
                }
                else
                {
                    _row.Add("-");

                }
                _row.Add(_rowData.LastUpdatedOn.ToString());

                if (_rowData.IsApproved == null)
                {
                    _row.Add(@"<a href='/wallet/rewardingbody/socialactivities/edit/" + _rowData.ID +
                             "' title='Edit' class='mr5'><i class='fa fa-pencil-square-o'></i></a>  <a class='confirm' data-confirm='Are you sure you want to delete this Social Activity?' href='/wallet/rewardingbody/socialactivities/delete/" +
                             _rowData.ID + "' title='Delete'><i class='fa fa-trash'></i></a> ");
                }
                else
                {
                    _row.Add(@"<a class='confirm' data-confirm='Are you sure you want to delete this Social Activity?' href='/wallet/rewardingbody/socialactivities/delete/" +
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

        [AuthorizeAccess]
        public ActionResult Available()
        {
            return View();
        }

        [AuthorizeAccess]
        public async Task<JsonResult> AvailableList(DataTableRequest request)
        {
            var _query = from s in db.SocialActivities
                         join c in db.Coins on s.RewardingCoinID equals c.ID
                         where s.IsDataActive && s.IsApproved == true
                         select new
                         {
                             s.ID,
                             s.Name,
                             s.Description,
                             CoinName = c.Name,
                             CoinCode = c.Symbol,
                             s.ApprovedOn,
                             s.RejectedOn,
                             s.IsApproved,
                             s.RewardAmount,
                             s.LastUpdatedOn,
                             s.UserID,
                             RewardingBody = s.User.NickName
                         };

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(s => s.Name.Contains(request.sSearch) || s.Description.Contains(request.sSearch) || s.IsApproved.ToString().Contains(request.sSearch) || s.RewardAmount.ToString().Contains(request.sSearch) || s.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Name) : _query.OrderByDescending(s => s.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.RewardingBody) : _query.OrderByDescending(s => s.RewardingBody);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.RewardAmount) : _query.OrderByDescending(m => m.RewardAmount);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.Description) : _query.OrderByDescending(m => m.Description);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add(_rowData.Name);
                _row.Add(_rowData.RewardingBody);
                _row.Add(_rowData.RewardAmount + " " + _rowData.CoinCode);
                _row.Add(_rowData.Description);

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

        public ActionResult Create()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Create(SocialActivity model)
        {
            if (ModelState.IsValid)
            {
                model.UserID = AppManager.User.ID;
                model.CreatedOn = DateTime.Now;
                model.LastUpdatedOn = DateTime.Now;
                model.IsDataActive = true;

                db.SocialActivities.Add(model);
                await db.SaveChangesAsync();


                var _administrators = await db.Users.Where(u => u.IsDataActive && u.IsSuperAdmin && u.IsEmailVerified).ToListAsync();

                foreach (User _admin in _administrators)
                {
                    ActivityNotification _activitynotification = new ActivityNotification();

                    _activitynotification.UserID = _admin.ID;
                    _activitynotification.RelatedItemID = model.ID;
                    _activitynotification.Type = "Social Activity";
                    _activitynotification.Message = "Request for Social Activity";
                    _activitynotification.Time = AppManager.Now;
                    _activitynotification.IsRead = false;
                    _activitynotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activitynotification);
                    await db.SaveChangesAsync();

                    string _body =
                        $"Hello {_admin.NickName ?? _admin.Email.ToLower()} ,<br /><br /> You have a new request from {(AppManager.User.NickName != null ? AppManager.User.NickName : AppManager.User.Email.ToLower())} for authorizing the permission for social activity.<br/>Please login to your account to review this request.";
                    AppManager.SendEmail($"A User has requested permission to Activity", _admin.Email, _body);

                }

                TempData["Notification"] = new Notification("Success", "Social Activity has been created successfully.");
                return RedirectToAction("Index");
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
            return View(model);
        }

        public async Task<ActionResult> Edit(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            SocialActivity _socialactivity = await db.SocialActivities.FirstOrDefaultAsync(a => a.IsDataActive && a.ID == ID && a.IsApproved == null && (a.UserID == AppManager.User.ID || AppManager.User.IsSuperAdmin));

            if (_socialactivity == null)
            {
                return HttpNotFound();
            }

            if (_socialactivity.RewardingCoinID != null && _socialactivity.RewardingCoinID != 0)
            {
                if (db.Coins.Any(n => n.ID == _socialactivity.RewardingCoinID))
                {
                    _socialactivity.SelectedRewardingCoin = new Select2Item
                    {
                        id = (int)_socialactivity.RewardingCoinID,
                        text = db.Coins.FirstOrDefault(p => p.ID == _socialactivity.RewardingCoinID).Name,
                    };
                }
            }

            return View(_socialactivity);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(SocialActivity model)
        {
            if (ModelState.IsValid)
            {
                SocialActivity _socialactivity = await db.SocialActivities.FindAsync(model.ID);

                if (_socialactivity != null)
                {
                    _socialactivity.Name = model.Name;
                    _socialactivity.Description = model.Description;
                    _socialactivity.UserID = AppManager.User.ID;
                    _socialactivity.LastUpdatedOn = DateTime.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Social Activity has been saved successfully.");
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

            SocialActivity _socialactivity = await db.SocialActivities.FirstOrDefaultAsync(s => s.ID == ID && (s.UserID == AppManager.User.ID || AppManager.User.IsSuperAdmin));

            if (_socialactivity != null)
            {
                _socialactivity.DeletedOn = DateTime.Now;
                _socialactivity.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested Social Activity has been deleted successfully.");
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
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            SocialActivity _request = await db.SocialActivities.FirstOrDefaultAsync(s => s.ID == ID && (s.UserID == AppManager.User.ID || AppManager.User.IsSuperAdmin));

            if (_request == null)
            {
                return HttpNotFound();
            }

            ActivityNotification _activityNotification =
                await db.ActivityNotifications.FirstOrDefaultAsync(
                    n => n.RelatedItemID == ID && n.UserID == AppManager.User.ID && n.IsRead == false && n.Type == "Social Activity");

            if (_activityNotification != null)
            {
                _activityNotification.IsRead = true;
                _activityNotification.ReadOn = AppManager.Now;

                await db.SaveChangesAsync();
            }
            return View(_request);
        }
    }
}