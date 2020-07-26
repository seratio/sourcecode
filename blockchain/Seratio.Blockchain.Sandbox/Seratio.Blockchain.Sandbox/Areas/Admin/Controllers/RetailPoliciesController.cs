using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Globalization;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Admin.Controllers
{
    [AuthorizeAccess(RequireSuperAdmin = true)]
    public class RetailPoliciesController : BaseController
    {
        public async Task<ActionResult> Index()
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from s in db.RetailPolicies
                         join c in db.Coins on s.RequiredCoinID equals c.ID into joined
                         from c in joined.DefaultIfEmpty()
                         where s.IsDataActive && s.IsApproved == null
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
                             RetailEnd = s.User.Email
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
                _query = _query.Where(s => s.Name.Contains(request.sSearch) || s.Category.Contains(request.sSearch) || s.RetailEnd.Contains(request.sSearch) || s.IsApproved.ToString().Contains(request.sSearch) || s.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Name) : _query.OrderByDescending(s => s.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.IsApproved) : _query.OrderByDescending(m => m.IsApproved);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.RetailEnd) : _query.OrderByDescending(m => m.RetailEnd);
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

                _row.Add("<a href='/wallet/retailend/retailpolicies/details/" + _rowData.ID + "' ></i>" + _rowData.Name + "</a>");


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

                if (!string.IsNullOrEmpty(_rowData.RetailEnd))
                {
                    _row.Add(_rowData.RetailEnd);
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

                _row.Add(@"<a href='/wallet/admin/retailpolicies/approve/" + _rowData.ID +
                         "' title='Approve' class='mr5'><i class='fa fa-thumbs-up'></i></a> <a href='/wallet/admin/retailpolicies/reject/" + _rowData.ID +
                         "' title='Reject' class='mr5'><i class='fa fa-thumbs-down'></i></a> ");

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

        public async Task<ActionResult> Approve(int ID)
        {
            var _retailPolicy = await db.RetailPolicies.FirstOrDefaultAsync(r => r.ID == ID && r.IsApproved != true);

            if (_retailPolicy != null)
            {
                _retailPolicy.ApprovedOn = DateTime.Now;
                _retailPolicy.RejectedOn = null;
                _retailPolicy.ProcessedBy = AppManager.User.ID;
                _retailPolicy.IsApproved = true;

                await db.SaveChangesAsync();

                User _admin = await db.Users.FirstOrDefaultAsync(u => u.ID == _retailPolicy.UserID);

                if (_admin != null)
                {
                    ActivityNotification _activityNotification = new ActivityNotification();

                    _activityNotification.UserID = _admin.ID;
                    _activityNotification.RelatedItemID = ID;
                    _activityNotification.Type = "Retail Policy";
                    _activityNotification.Message = "Your Retail Policy has been approved";
                    _activityNotification.Time = AppManager.Now;
                    _activityNotification.IsRead = false;
                    _activityNotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activityNotification);
                    await db.SaveChangesAsync();
                }

                string _body = $"Hello {(_retailPolicy.User.NickName != null ? _retailPolicy.User.NickName : _retailPolicy.User.Email.ToLower())},<br /><br />Your request for the new Retail Policy has been approved by the administrator. Please log in to your account to review.";
                AppManager.SendEmail($"Your Retail Policy", _retailPolicy.User.Email, _body);

                TempData["Notification"] = new Notification("Success", "Requested Retail Policy has been approved successfully.");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Reject(int ID)
        {
            var _retailPolicy = await db.RetailPolicies.FirstOrDefaultAsync(r => r.ID == ID && r.IsApproved != false);

            if (_retailPolicy != null)
            {
                _retailPolicy.ApprovedOn = null;
                _retailPolicy.RejectedOn = DateTime.Now;
                _retailPolicy.ProcessedBy = AppManager.User.ID;
                _retailPolicy.IsApproved = false;

                await db.SaveChangesAsync();

                User _admin = await db.Users.FirstOrDefaultAsync(u => u.ID == _retailPolicy.UserID);

                if (_admin != null)
                {
                    ActivityNotification _activityNotification = new ActivityNotification();

                    _activityNotification.UserID = _admin.ID;
                    _activityNotification.RelatedItemID = ID;
                    _activityNotification.Type = "Retail Policy";
                    _activityNotification.Message = "Your Retail Policy has been rejected";
                    _activityNotification.Time = AppManager.Now;
                    _activityNotification.IsRead = false;
                    _activityNotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activityNotification);
                    await db.SaveChangesAsync();
                }


                string _body = $"Hello {(_retailPolicy.User.NickName != null ? _retailPolicy.User.NickName : _retailPolicy.User.Email.ToLower())},<br /><br />Your request for the new Retail Policy has failed our security & policy check and therefore has been rejected by the administrator. Please log in to your account to review.";
                AppManager.SendEmail($"Your Retail Policy", _retailPolicy.User.Email, _body);

                TempData["Notification"] = new Notification("Success", "Requested Retail Policy has been rejected successfully.");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
            }

            return RedirectToAction("Index");
        }

    }
}