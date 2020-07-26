using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using System.Data.Entity;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Security;
using System.Net;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Admin.Controllers
{
    [AuthorizeAccess(RequireSuperAdmin = true)]
    public class AccessRequestsController : BaseController
    {
        public ActionResult Index()
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request)
        {
            var _query = from r in db.ModuleAccessRequests
                         join u in db.Users on r.UserID equals u.ID
                         where u.IsDataActive
                         select new
                         {
                             r.ID,
                             r.Message,
                             r.UserID,
                             r.IsApproved,
                             r.ApprovedOn,
                             r.RejectedOn,
                             r.CreatedOn,
                             u.Email,
                             u.NickName,
                             r.Module,
                             ProcessedBy = r.ProcessedBy != null ? "Administrator" : null
                         };

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(r => r.Email.Contains(request.sSearch) || r.Module.Contains(request.sSearch) || r.Message.Contains(request.sSearch) || r.NickName.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.NickName) : _query.OrderByDescending(m => m.NickName);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.Module) : _query.OrderByDescending(m => m.Module);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.Message) : _query.OrderByDescending(m => m.Message);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.IsApproved) : _query.OrderByDescending(m => m.IsApproved);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.ProcessedBy) : _query.OrderByDescending(m => m.ProcessedBy);
                    break;
                default:
                    _query = _query.OrderByDescending(m => m.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();
                _row.Add($"{_rowData.NickName} ({_rowData.Email})");
                _row.Add("<a href='/wallet/admin/accessrequests/details/" + _rowData.ID + "' ></i>" + _rowData.Module + "</a>");

                if (_rowData.Message != null)
                {
                    _row.Add(_rowData.Message);
                }
                else
                {
                    _row.Add("-");
                }

                string _status = string.Empty;

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

                if (_rowData.IsApproved == null)
                {
                    _row.Add(@"<a href='/wallet/admin/accessrequests/approve/" + _rowData.ID + "' title='Approve' class='confirm' data-confirm='Are you sure you want to approve this Request?'><i class='fa fa-thumbs-up'></i></a> <a href='/wallet/admin/accessrequests/reject/" + _rowData.ID + "' title='Reject' class='confirm' data-confirm='Are you sure you want to reject this Request?'><i class='fa fa-thumbs-down'></i></a>   <a href='/wallet/admin/accessrequests/delete/" + _rowData.ID + "' title='Delete' class='confirm' data-confirm='Are you sure you want to delete this Request?'><i class='fa fa-trash'></i></a> ");
                }
                else
                {
                    _row.Add("<a href='/wallet/admin/accessrequests/delete/" + _rowData.ID + "' title='Delete' class='confirm' data-confirm='Are you sure you want to delete this Request?'><i class='fa fa-trash'></i></a>");
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

        public async Task<ActionResult> Approve(int ID)
        {
            var _request = await db.ModuleAccessRequests.FirstOrDefaultAsync(r => r.ID == ID && r.IsApproved != true);

            if (_request != null)
            {
                _request.ApprovedOn = DateTime.Now;
                _request.RejectedOn = null;
                _request.ProcessedBy = AppManager.User.ID;
                _request.IsApproved = true;

                await db.SaveChangesAsync();

                User _admin = await db.Users.FirstOrDefaultAsync(u => u.ID == _request.UserID);

                if (_admin != null)
                {
                    ActivityNotification _activitynotification = new ActivityNotification();

                    _activitynotification.UserID = _admin.ID;
                    _activitynotification.RelatedItemID = ID;
                    _activitynotification.Type = "Module Access Request";
                    _activitynotification.Message = "Access Request Approval for " + _request.Module;
                    _activitynotification.Time = AppManager.Now;
                    _activitynotification.IsRead = false;
                    _activitynotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activitynotification);
                    await db.SaveChangesAsync();
                }

                if (_request.Module == "Retail End")
                {
                    RetailPolicy _policy = new RetailPolicy();

                    _policy.Name = "Default Retail Policy";
                    _policy.DiscountMode = "Discount";
                    _policy.DiscountValue = 10;
                    _policy.Description = "";
                    _policy.UserID = _request.UserID;
                    _policy.CreatedOn = AppManager.Now;
                    _policy.LastUpdatedOn = AppManager.Now;
                    _policy.IsDataActive = true;
                    _policy.PolicyType = "Default";
                    _policy.MaxSEScore = null;
                    _policy.MinSESCore = null;
                    _policy.IsApproved = true;
                    _policy.ApprovedOn = AppManager.Now;
                    _policy.ProcessedBy = AppManager.User.ID;
                    _policy.VoucherCode = "N/A";

                    _policy.RequiredCoinQty = null;
                    _policy.RequiredCoinID = null;


                    db.RetailPolicies.Add(_policy);
                    await db.SaveChangesAsync();
                }


                string _body = $"Hello {(_request.User.NickName != null ? _request.User.NickName : _request.User.Email.ToLower())} ,<br /><br /> Your Access request for {_request.Module} Service has been processed. Please logout and login again for this to take effect.";
                AppManager.SendEmail($"Your request for accessing {_request.Module} has been processed", _request.User.Email, _body);

                TempData["Notification"] = new Notification("Success", "Selected Request has been successfully marked as Approved.");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Reject(int ID)
        {
            var _request = await db.ModuleAccessRequests.FirstOrDefaultAsync(r => r.ID == ID && r.IsApproved != false);

            if (_request != null)
            {
                _request.ApprovedOn = null;
                _request.RejectedOn = DateTime.Now;
                _request.ProcessedBy = AppManager.User.ID;
                _request.IsApproved = false;

                await db.SaveChangesAsync();

                User _admin = await db.Users.FirstOrDefaultAsync(u => u.ID == _request.UserID);

                if (_admin != null)
                {
                    ActivityNotification _activitynotification = new ActivityNotification();

                    _activitynotification.UserID = _admin.ID;
                    _activitynotification.RelatedItemID = ID;
                    _activitynotification.Type = "Module Access Request";
                    _activitynotification.Message = "Access Request Rejection for " + _request.Module;
                    _activitynotification.Time = AppManager.Now;
                    _activitynotification.IsRead = false;
                    _activitynotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activitynotification);
                    await db.SaveChangesAsync();
                }

                string _body = $"Hello {(_request.User.NickName != null ? _request.User.NickName : _request.User.Email.ToLower())},<br /><br /> Your Access request for {_request.Module} Service has been rejected by the Administrator.";
                AppManager.SendEmail($"Your request for accessing {_request.Module} has been processed", _request.User.Email, _body);

                TempData["Notification"] = new Notification("Success", "Selected Request has been successfully marked as Rejected.");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Delete(int ID)
        {
            var _request = await db.ModuleAccessRequests.FirstOrDefaultAsync(r => r.ID == ID);

            if (_request != null)
            {
                if (_request.IsApproved == true)
                {
                    foreach (UserSession _session in await db.UserSessions.Where(s => s.UserID == _request.UserID && s.IsActive).ToListAsync())
                    {
                        _session.IsActive = false;
                        _session.EndTime = DateTime.Now;

                        await db.SaveChangesAsync();
                    }
                }

                db.ModuleAccessRequests.Remove(_request);
                await db.SaveChangesAsync();

                var _activityNotification =
                    await db.ActivityNotifications.FirstOrDefaultAsync(
                        n => n.Type == "Module Access Request" && n.RelatedItemID == ID);



                if (_activityNotification != null)
                {
                    db.ActivityNotifications.Remove(_activityNotification);
                    await db.SaveChangesAsync();
                }

                TempData["Notification"] = new Notification("Success", "Selected Request has been successfully Deleted.");
            }
            else
            {
                return HttpNotFound();
            }

            return RedirectToAction("Index");
        }

        [AuthorizeAccess]
        public async Task<ActionResult> Details(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            ModuleAccessRequest _request = await db.ModuleAccessRequests.FindAsync(ID);

            if (_request == null)
            {
                return HttpNotFound();
            }

            ActivityNotification _activityNotification =
                await db.ActivityNotifications.FirstOrDefaultAsync(
                    n => n.RelatedItemID == ID && n.UserID == AppManager.User.ID && n.IsRead == false && n.Type == "Module Access Request");

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