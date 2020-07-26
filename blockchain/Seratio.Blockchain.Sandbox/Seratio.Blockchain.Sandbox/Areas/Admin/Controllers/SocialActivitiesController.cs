using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Web.Mvc;
using System.Globalization;
using System.Threading.Tasks;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Admin.Controllers
{
    [AuthorizeAccess(RequireSuperAdmin = true)]
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
                         join u in db.Users on s.UserID equals u.ID
                         where s.IsDataActive && s.IsApproved == null
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
                             RewardingBody = u.Email,
                             ProcessedBy = s.ProcessedBy != null ? s.User1.Email : null
                         };

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
                _query = _query.Where(s => s.Name.Contains(request.sSearch) || s.RewardingBody.Contains(request.sSearch) || s.Description.Contains(request.sSearch) || s.ProcessedBy.Contains(request.sSearch) || s.IsApproved.ToString().Contains(request.sSearch) || s.RewardAmount.ToString().Contains(request.sSearch) || s.LastUpdatedOn.ToString().Contains(request.sSearch));
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
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.RewardAmount) : _query.OrderByDescending(s => s.RewardAmount);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.IsApproved) : _query.OrderByDescending(m => m.IsApproved);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.ProcessedBy) : _query.OrderByDescending(m => m.ProcessedBy);
                    break;
                case 5:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Description) : _query.OrderByDescending(s => s.Description);
                    break;
                case 6:
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
                _row.Add(_rowData.RewardingBody);
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

                _row.Add(@"<a href='/wallet/admin/socialactivities/approve/" + _rowData.ID +
                         "' title='Approve' class='mr5'><i class='fa fa-thumbs-up'></i></a> <a href='/wallet/admin/socialactivities/reject/" + _rowData.ID +
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

        [AuthorizeAccess(RequireSuperAdmin = true)]
        public async Task<ActionResult> Approve(int ID)
        {
            var _activity = await db.SocialActivities.FirstOrDefaultAsync(r => r.ID == ID && r.IsApproved != true);

            if (_activity != null)
            {
                _activity.ApprovedOn = DateTime.Now;
                _activity.RejectedOn = null;
                _activity.ProcessedBy = AppManager.User.ID;
                _activity.IsApproved = true;

                await db.SaveChangesAsync();

                User _admin = await db.Users.FirstOrDefaultAsync(u => u.ID == _activity.UserID);

                if (_admin != null)
                {
                    ActivityNotification _activitynotification = new ActivityNotification();

                    _activitynotification.UserID = _admin.ID;
                    _activitynotification.RelatedItemID = ID;
                    _activitynotification.Type = "Social Activity";
                    _activitynotification.Message = "The Social Activity that you had requested has been approved.";
                    _activitynotification.Time = AppManager.Now;
                    _activitynotification.IsRead = false;
                    _activitynotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activitynotification);
                    await db.SaveChangesAsync();
                }

                string _body = $"Hello {(_activity.User.NickName != null ? _activity.User.NickName : _activity.User.Email.ToLower())} ,<br /><br />Your request for the new Social Activity has been approved by the administrator. Please log in to your account to review. ";
                AppManager.SendEmail($"Your Social Activity request", _activity.User.Email, _body);

                TempData["Notification"] = new Notification("Success", "Social Activity has been approved successfully.");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");

            }

            return RedirectToAction("Index");
        }

        [AuthorizeAccess(RequireSuperAdmin = true)]
        public async Task<ActionResult> Reject(int ID)
        {
            var _activity = await db.SocialActivities.FirstOrDefaultAsync(r => r.ID == ID && r.IsApproved != false);

            if (_activity != null)
            {
                _activity.ApprovedOn = null;
                _activity.RejectedOn = DateTime.Now;
                _activity.ProcessedBy = AppManager.User.ID;
                _activity.IsApproved = false;

                await db.SaveChangesAsync();

                User _admin = await db.Users.FirstOrDefaultAsync(u => u.ID == _activity.UserID);

                if (_admin != null)
                {
                    ActivityNotification _activitynotification = new ActivityNotification();

                    _activitynotification.UserID = _admin.ID;
                    _activitynotification.RelatedItemID = ID;
                    _activitynotification.Type = "Social Activity";
                    _activitynotification.Message = "The Social Activity that you had requested has been rejected.";
                    _activitynotification.Time = AppManager.Now;
                    _activitynotification.IsRead = false;
                    _activitynotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activitynotification);
                    await db.SaveChangesAsync();
                }

                string _body = $"Hello {(_activity.User.NickName != null ? _activity.User.NickName : _activity.User.Email.ToLower())},<br /><br />Your request for the new Social Activity has failed our security & guidelines check and therefore has been rejected by the administrator. Please log in to your account to review.";
                AppManager.SendEmail($"Your Social Activity request", _activity.User.Email, _body);

                TempData["Notification"] = new Notification("Success", "Social Activity has been rejected.");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
            }

            return RedirectToAction("Index");
        }
    }
}

