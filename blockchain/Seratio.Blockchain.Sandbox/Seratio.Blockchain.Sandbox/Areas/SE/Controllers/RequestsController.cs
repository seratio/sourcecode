using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web.Mvc;
using System.Threading.Tasks;
using System.ComponentModel.DataAnnotations;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;

namespace Seratio.Blockchain.Sandbox.Areas.SE.Controllers
{
    [AuthorizeAccess]
    public class RequestsController : BaseController
    {
        public ActionResult Index()
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request)
        {
            List<Request> _requests = await db.Requests.Where(r => r.IsDataActive && r.HasRejected).ToListAsync();

            foreach (Request _item in _requests)
            {
                if (_item.SenderID == AppManager.User.ID)
                {
                    _item.HasRejected = false;

                    await db.SaveChangesAsync();
                }
            }

            var _query = from r in db.Requests
                         where r.IsDataActive && r.SenderID == AppManager.User.ID || r.Recipient == AppManager.User.Email
                         select new
                         {
                             r.ID,
                             r.Message,
                             r.Status,
                             r.SentOn,
                             r.RespondedOn,
                             r.SenderID,
                             r.Recipient,
                             r.HasDownloaded,
                             r.User,
                             Receiver = db.Users.FirstOrDefault(u => u.IsDataActive && (u.Email == r.Recipient || u.NickName == r.Recipient))

                         };

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(r => r.User.NickName.Contains(request.sSearch) | r.User.Email.Contains(request.sSearch) || r.Recipient.Contains(request.sSearch) || r.SentOn.ToString().Contains(request.sSearch) || r.RespondedOn.ToString().Contains(request.sSearch) || r.Status.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(r => (string.IsNullOrEmpty(r.User.NickName) ? r.User.Email : r.User.NickName)) : _query.OrderByDescending(r => (string.IsNullOrEmpty(r.User.NickName) ? r.User.Email : r.User.NickName));
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(r => (string.IsNullOrEmpty(r.Receiver.NickName) ? r.Receiver.Email : r.Receiver.NickName)) : _query.OrderByDescending(r => (string.IsNullOrEmpty(r.Receiver.NickName) ? r.Receiver.Email : r.Receiver.NickName));
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(r => r.SentOn) : _query.OrderBy(r => r.SentOn);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(r => r.RespondedOn) : _query.OrderByDescending(r => r.RespondedOn);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(r => r.Status) : _query.OrderByDescending(r => r.Status);
                    break;
                default:
                    _query = _query.OrderByDescending(r => r.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add((string.IsNullOrEmpty(_rowData.User.NickName) ? _rowData.User.Email : _rowData.User.NickName));

                if (_rowData.Receiver != null)
                {
                    _row.Add((string.IsNullOrEmpty(_rowData.Receiver.NickName) ? _rowData.Receiver.Email : _rowData.Receiver.NickName));

                }
                else
                {
                    _row.Add("-");
                }
                _row.Add(_rowData.SentOn.ToString("dd/MM/yyyy hh:mm tt"));

                switch (_rowData.Status)
                {
                    case "Pending":
                        _row.Add(@"<span class='label bg-grey-300'>" + _rowData.Status + "</span>");
                        break;
                    case "Rejected":
                        _row.Add(@"<span class='label bg-danger'>" + _rowData.Status + "</span>");
                        break;
                    case "Approved":
                        _row.Add(@"<span class='label bg-success'>" + _rowData.Status + "</span>");
                        break;
                    default:
                        _row.Add(@"<span class='label bg-grey-300'>" + _rowData.Status + "</span>");
                        break;
                }

                if (_rowData.RespondedOn != null)
                {
                    _row.Add(_rowData.RespondedOn.Value.ToString("dd/MM/yyyy hh:mm tt"));
                }
                else
                {
                    _row.Add("-");
                }

                if (_rowData.Status == "Approved" && !_rowData.HasDownloaded && (_rowData.User.Email == AppManager.User.Email || _rowData.User.Email == AppManager.User.Email))
                {
                    _row.Add(@"<a href='/wallet/se/requests/details/" + _rowData.ID + "' title='Details'><i class='os-icon os-icon-agenda-1 text-primary'></i></a> | <a href='/wallet/se/certificate/printse/?email=" + _rowData.Recipient + "&id=" + _rowData.ID + "' title='Print S/E'><i class='os-icon os-icon-email-2-at2 text-primary'></i></a>");
                }
                else
                {
                    _row.Add(@"<a href='/wallet/se/requests/details/" + _rowData.ID + "' title='Details'><i class='os-icon os-icon-agenda-1 text-primary'></i></a>");
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

        public ActionResult Send()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Send(string receiver, string recipient, string message)
        {
            string _emailaddress = string.Empty;

            if (!string.IsNullOrEmpty(receiver))
            {
                recipient = receiver;
            }

            if (new EmailAddressAttribute().IsValid(recipient))
            {
                _emailaddress = recipient;
            }
            else
            {
                recipient = recipient.Trim('@');
                if (db.Users.Any(u => u.IsDataActive && (u.NickName == recipient || u.Email == recipient)))
                {
                    _emailaddress = db.Users.FirstOrDefault(u => u.IsDataActive && (u.NickName == recipient || u.Email == recipient)).Email;
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "The specified Recipient doesn't have a Seratio Blockchain Account.");
                    return View();
                }

            }

            User Receiver = await db.Users.FirstOrDefaultAsync(u => u.Email == _emailaddress && u.IsDataActive);

            Request _request = new Request();
            _request.SenderID = AppManager.User.ID;
            _request.Recipient = _emailaddress;
            _request.Message = message;
            _request.Status = "Pending";
            _request.HasDownloaded = false;
            _request.SentOn = DateTime.Now;
            _request.IsDataActive = true;

            db.Requests.Add(_request);
            await db.SaveChangesAsync();

            ActivityNotification _activitynotification = new ActivityNotification();

            _activitynotification.UserID = Receiver.ID;
            _activitynotification.RelatedItemID = _request.ID;
            _activitynotification.Type = "S/E Request";
            _activitynotification.Message = "Request for S/E Certificate";
            _activitynotification.Time = AppManager.Now;
            _activitynotification.IsRead = false;
            _activitynotification.CreatedOn = AppManager.Now;

            db.ActivityNotifications.Add(_activitynotification);
            await db.SaveChangesAsync();

            string _body = $"Hello,<br /><br />Greeting of the day!<br /><br /><b>{(AppManager.User.NickName != null ? AppManager.User.NickName : AppManager.User.Email)} </b> has sent you a request for your Social Earnings Certificate via Seratio Platform.<br />Please <a href='{AppManager.AppURL}'>Click Here</a> to generate your Certificate.";
            AppManager.SendEmail("Request for your S/E Certificate - Seratio Blockchain", _emailaddress, _body);

            TempData["Notification"] = new Notification("Success", "Your request for S/E Certificate has been sent successfully.");
            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Details(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Request _request = await db.Requests.FirstOrDefaultAsync(r => r.ID == ID && (r.SenderID == AppManager.User.ID || r.Recipient == AppManager.User.Email));


            if (_request == null)
            {
                return HttpNotFound();
            }

            ActivityNotification _activityNotification =
                await db.ActivityNotifications.FirstOrDefaultAsync(
                    n => n.RelatedItemID == ID && n.UserID == AppManager.User.ID && n.IsRead == false && n.Type == "S/E Request");

            if (_activityNotification != null)
            {
                _activityNotification.IsRead = true;
                _activityNotification.ReadOn = AppManager.Now;

                await db.SaveChangesAsync();
            }

            ViewBag.receiver = await db.Users.AnyAsync(u => u.IsDataActive && u.Email == _request.Recipient && u.NickName != null) ? db.Users.FirstOrDefault(u => u.IsDataActive && u.Email == _request.Recipient && u.NickName != null).NickName : db.Users.FirstOrDefault(u => u.IsDataActive && u.Email == _request.Recipient).Email;

            return View(_request);
        }

        public async Task<ActionResult> Reject(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Request _request = await db.Requests.FirstOrDefaultAsync(r => r.ID == ID && r.Recipient == AppManager.User.Email && r.IsDataActive && r.Status == "Pending");

            if (_request != null)
            {
                _request.Status = "Rejected";
                _request.HasRejected = true;
                _request.RespondedOn = DateTime.Now;

                await db.SaveChangesAsync();

                ActivityNotification _activitynotification = new ActivityNotification();

                _activitynotification.UserID = _request.SenderID;
                _activitynotification.RelatedItemID = _request.ID;
                _activitynotification.Type = "S/E Request";
                _activitynotification.Message = "Response for S/E Certificate Request";
                _activitynotification.Time = AppManager.Now;
                _activitynotification.IsRead = false;
                _activitynotification.CreatedOn = AppManager.Now;

                db.ActivityNotifications.Add(_activitynotification);
                await db.SaveChangesAsync();


                string _body = $"Hello {(_request.User.NickName != null ? _request.User.NickName : AppManager.User.Email)},<br /><br /><b>{(AppManager.User.NickName != null ? AppManager.User.NickName : AppManager.User.Email)} </b> has rejected your request for the Social Earnings Certificate.";
                AppManager.SendEmail("Request for the Social Earnings Certificate has been rejected - Seratio Blockchain", _request.User.Email, _body);

                TempData["Notification"] = new Notification("Success", "Requested S/E Certificate is rejected successfully.");
            }
            else
            {
                return HttpNotFound();
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Approve(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Request _request = await db.Requests.FirstOrDefaultAsync(r => r.ID == ID && r.Status == "Pending" && (r.Recipient == AppManager.User.Email || r.Recipient == AppManager.User.NickName) && r.IsDataActive);

            if (_request != null)
            {
                SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

                if (_response.data != null)
                {
                    _request.Status = "Approved";
                    _request.RespondedOn = DateTime.Now;

                    await db.SaveChangesAsync();

                    ActivityNotification _activitynotification = new ActivityNotification();

                    _activitynotification.UserID = _request.SenderID;
                    _activitynotification.RelatedItemID = _request.ID;
                    _activitynotification.Type = "S/E Request";
                    _activitynotification.Message = "Response for S/E Certificate Request";
                    _activitynotification.Time = AppManager.Now;
                    _activitynotification.IsRead = false;
                    _activitynotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activitynotification);
                    await db.SaveChangesAsync();

                    string _body = $"Hello {(_request.User.NickName != null ? _request.User.NickName : _request.User.Email)} ,<br /><br />Greeting of the day!<br /><br /><b>{(AppManager.User.NickName != null ? AppManager.User.NickName : AppManager.User.Email)} </b> has approved your request for the Social Earnings Certificate.<br />Please <a href='http://localhost:55409'>Click Here</a> to view it.";
                    AppManager.SendEmail("Request for your Social Earnings Certificate has been approved - Seratio Blockchain", _request.User.Email, _body);

                    TempData["Notification"] = new Notification("Success", "Request has been Approved and your Certificate has been shared successfully.");
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, you do not have a S/E Certificate. Please create one before approving this Request.");
                }

                return RedirectToAction("Index");
            }
            else
            {
                return HttpNotFound();
            }
        }

        [HttpPost]
        public async Task<JsonResult> AutoComplete(string q)
        {
            var _users = await (from u in db.Users
                                where u.IsDataActive && u.IsSearchable && (u.NickName.Contains(q) || u.Email.Contains(q) || u.WalletAddress.Contains(q)) && u.ID != AppManager.User.ID
                                orderby u.NickName
                                select new
                                {
                                    id = u.Email,
                                    text = u.Email + " (" + u.WalletAddress + ")",
                                }).ToListAsync();

            return Json(_users);
        }
    }
}

