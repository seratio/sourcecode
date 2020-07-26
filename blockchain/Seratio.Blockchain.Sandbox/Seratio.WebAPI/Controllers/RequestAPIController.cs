using Microsoft.Owin.Security;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Data.Entity;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Cors;
using System.Web.Http.Results;

namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class RequestAPIController : BaseAPIController
    {
        [HttpPost]
        [Route("api/ListRequests")]
        public async Task<DataTableResponse_Request_Result> ListRequests(DataTableRequest request)
        {
            DataTableResponse_Request_Result result = new DataTableResponse_Request_Result();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                string UserName = ticket.Properties.Dictionary["userName"];
                List<Request> _requests = await db.Requests.Where(r => r.IsDataActive && r.HasRejected).ToListAsync();

                foreach (Request _item in _requests)
                {
                    if (_item.SenderID == UserID)
                    {
                        _item.HasRejected = false;

                        await db.SaveChangesAsync();
                    }
                }

                var _query = from r in db.Requests
                             where r.IsDataActive && r.SenderID == UserID || r.Recipient == _user.Email
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
                List<DataTableRowAPI_Request> _rows = new List<DataTableRowAPI_Request>();

                foreach (var _rowData in _data)
                {
                    DataTableRowAPI_Request _row = new DataTableRowAPI_Request();

                    _row.Sender = string.IsNullOrEmpty(_rowData.User.NickName) ? _rowData.User.Email : _rowData.User.NickName;

                    if (_rowData.Receiver != null)
                    {
                        _row.Reciever = string.IsNullOrEmpty(_rowData.Receiver.NickName) ? _rowData.Receiver.Email : _rowData.Receiver.NickName;

                    }
                    _row.SentOn = _rowData.SentOn;
                    _row.Status = _rowData.Status;

                    if (_rowData.RespondedOn != null)
                    {
                        _row.RespondedOn = _rowData.RespondedOn.Value;
                    }

                    if (_rowData.Status == "Approved" && !_rowData.HasDownloaded && (_rowData.User.Email == _user.Email || _rowData.User.Email == _user.Email))
                    {
                        _row.ID = _rowData.ID;
                        _row.Recipient = _rowData.Recipient;
                    }
                    else
                    {
                        _row.ID = _rowData.ID;
                    }

                    _rows.Add(_row);
                }
                result.Status = true;
                result.DataTableResponse = new DataTableResponse_Request
                {
                    sEcho = request.sEcho,
                    iDisplayLength = request.iDisplayLength,
                    iTotalRecords = _count,
                    iDisplayStart = request.iDisplayStart,
                    iTotalDisplayRecords = _count,
                    aaData = _rows
                };
                return result;
            }
            else
            {
                result.DataTableResponse = new DataTableResponse_Request
                {
                    sEcho = request.sEcho,
                    iDisplayLength = request.iDisplayLength,
                    iTotalRecords = 0,
                    iDisplayStart = request.iDisplayStart,
                    iTotalDisplayRecords = 0,
                    aaData = null
                };
                return result;
            }
        }

        [HttpPost]
        [Route("api/RequestDetails")]
        public async Task<RequestDetailsResult> RequestDetails(int ID)
        {
            RequestDetailsResult result = new RequestDetailsResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                string UserName = ticket.Properties.Dictionary["userName"];

                if (ID == 0)
                {
                    result.Message = "Bad Request.";
                    return result;
                }

                Request_API _request = await db.Requests.Include(r => r.User).Select(r=>new Request_API { ID = r.ID, Sender = r.User.Email, Recipient = r.Recipient, Message = r.Message, Status = r.Status, HasDownloaded = r.HasDownloaded, HasRejected = r.HasRejected, IsDataActive = r.IsDataActive, RespondedOn = r.RespondedOn, SenderID = r.SenderID, SentOn = r.SentOn }).FirstOrDefaultAsync(r => r.ID == ID && (r.SenderID == UserID || r.Recipient == _user.Email));


                if (_request == null)
                {
                    result.Message = "Reqest not found.";
                    return result;
                }

                ActivityNotification _activityNotification =
                    await db.ActivityNotifications.FirstOrDefaultAsync(
                        n => n.RelatedItemID == ID && n.UserID == UserID && n.IsRead == false && n.Type == "S/E Request");

                if (_activityNotification != null)
                {
                    _activityNotification.IsRead = true;
                    _activityNotification.ReadOn = AppManager.Now;

                    await db.SaveChangesAsync();
                }

                //ViewBag.receiver = await db.Users.AnyAsync(u => u.IsDataActive && u.Email == _request.Recipient && u.NickName != null) ? db.Users.FirstOrDefault(u => u.IsDataActive && u.Email == _request.Recipient && u.NickName != null).NickName : db.Users.FirstOrDefault(u => u.IsDataActive && u.Email == _request.Recipient).Email;

                result.Request = _request;
                result.Status = true;
                return result;
            }
            else
            {
                result.Request = null;
                result.Message  = "You are not authorized";
                return result;
            }
        }

        [HttpPost]
        [Route("api/RequestCertificate")]
        public async Task<ResultSet> RequestCertificate(RequestCertificateRequest request)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                string UserName = ticket.Properties.Dictionary["userName"];
                string _emailaddress = string.Empty;

                if (!string.IsNullOrEmpty(request.receiver))
                {
                    request.recipient = request.receiver;
                }

                if (new EmailAddressAttribute().IsValid(request.recipient))
                {
                    _emailaddress = request.recipient;
                }
                else
                {
                    request.recipient = request.recipient.Trim('@');
                    if (db.Users.Any(u => u.IsDataActive && (u.NickName == request.recipient || u.Email == request.recipient)))
                    {
                        _emailaddress = db.Users.FirstOrDefault(u => u.IsDataActive && (u.NickName == request.recipient || u.Email == request.recipient)).Email;
                    }
                    else
                    {
                        result.Message = "The specified Recipient doesn't have a Seratio Blockchain Account.";
                        return result;
                    }

                }
                _emailaddress = _emailaddress.Trim();

                User Receiver = await db.Users.FirstOrDefaultAsync(u => u.Email == _emailaddress && u.IsDataActive);

                Request _request = new Request();
                _request.SenderID = UserID;
                _request.Recipient = _emailaddress;
                _request.Message = request.message;
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

                string _body = $"Hello,<br /><br />Greeting of the day!<br /><br /><b>{(_user.NickName != null ? _user.NickName : _user.Email)} </b> has sent you a request for your Social Earnings Certificate via Seratio Platform.<br />Please <a href='{AppManager.AppURL}'>Click Here</a> to generate your Certificate.";
                AppManager.SendEmail("Request for your S/E Certificate - Seratio Blockchain", _emailaddress, _body);

                result.Message = "Your request for S/E Certificate has been sent successfully.";
                result.Status = true;
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }


        [HttpPost]
        [Route("api/RequestCertificateAddress")]
        public async Task<ResultSet> RequestCertificateAddress(RequestCertificateRequest request)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                string UserName = ticket.Properties.Dictionary["userName"];
                string _emailaddress = string.Empty;

                if (!string.IsNullOrEmpty(request.recipient))
                {
                    try
                    {
                        var wallet = db.UserWalletHistories.Where(p => p.NewWalletAddress == request.recipient).OrderByDescending(p => p.Time).FirstOrDefault();
                        if(wallet==null)
                        {
                             wallet = db.UserWalletHistories.Where(p => p.OldWalletAddress == request.recipient).OrderByDescending(p => p.Time).FirstOrDefault();
                        }
                        if(wallet == null)
                        {
                            result.Message = "The specified Recipient doesn't have a Seratio Blockchain Account.";
                            return result;
                        }
                        else
                        {
                            int reciepentid = wallet.UserID;
                            var rec = db.Users.FirstOrDefault(u => u.ID == reciepentid);
                            if (rec != null)
                            {
                                _emailaddress = rec.Email;
                            }
                            else
                            {
                                result.Message = "The specified Recipient doesn't have a Seratio Blockchain Account.";
                                return result;
                            }
                        }
                        
                    }
                    catch (Exception)
                    {
                        result.Message = "The specified Recipient doesn't have a Seratio Blockchain Account";
                        return result;
                    }
                   
                }

                _emailaddress = _emailaddress.Trim();

                User Receiver = await db.Users.FirstOrDefaultAsync(u => u.Email == _emailaddress && u.IsDataActive);

                Request _request = new Request();
                _request.SenderID = UserID;
                _request.Recipient = _emailaddress;
                _request.Message = request.message;
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

                string _body = $"Hello,<br /><br />Greeting of the day!<br /><br /><b>{(_user.NickName != null ? _user.NickName : _user.Email)} </b> has sent you a request for your Social Earnings Certificate via Seratio Platform.<br />Please <a href='{AppManager.AppURL}'>Click Here</a> to generate your Certificate.";
                AppManager.SendEmail("Request for your S/E Certificate - Seratio Blockchain", _emailaddress, _body);

                result.Message = "Your request for S/E Certificate has been sent successfully.";
                result.Status = true;
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/AccountList")]
        public async Task<AccountListResult> AccountList(string q)
        {
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            AccountListResult result = new AccountListResult();
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                var _users = await (from u in db.Users
                                    where u.IsDataActive && u.IsSearchable && (u.NickName.Contains(q) || u.Email.Contains(q) || u.WalletAddress.Contains(q)) && u.ID != _user.ID
                                    orderby u.NickName
                                    select new AccountModel
                                    {
                                        id = u.Email,
                                        text = u.Email + " (" + u.WalletAddress + ")",
                                    }).ToListAsync();
                result.AccountModels = _users;
                result.Status = true;
                return result;
            }
            else
            {
                result.AccountModels = null;
                result.Status = false ;
                return result;
            }
        }


        [HttpPost]
        [Route("api/ApproveRequest")]
        public async Task<ResultSet> ApproveRequest(int ID)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                string UserName = ticket.Properties.Dictionary["userName"];
                
                if (ID == 0)
                {
                    result.Message = "Bad request.";
                    return result;
                }

                Request _request = await db.Requests.FirstOrDefaultAsync(r => r.ID == ID && r.Status == "Pending" && (r.Recipient == _user.Email || r.Recipient == _user.NickName) && r.IsDataActive);

                if (_request != null)
                {
                    SAPIResponse _response = await AppManager.GetSE(_user.Email);

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

                        string _body = $"Hello {(_request.User.NickName != null ? _request.User.NickName : _request.User.Email)} ,<br /><br />Greeting of the day!<br /><br /><b>{(_user.NickName != null ? _user.NickName : _user.Email)} </b> has approved your request for the Social Earnings Certificate.<br />Please <a href='http://localhost:55409'>Click Here</a> to view it.";
                        AppManager.SendEmail("Request for your Social Earnings Certificate has been approved - Seratio Blockchain", _request.User.Email, _body);

                        result.Message = "Request has been Approved and your Certificate has been shared successfully.";
                        result.Status = true;
                    }
                    else
                    {
                        result.Message = "Sorry, you do not have a S/E Certificate. Please create one before approving this Request.";
                    }

                    return result;
                }
                else
                {
                    result.Message = "Request not found.";
                    return result;
                }
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/RejectRequest")]
        public async Task<ResultSet> RejectRequest(int ID)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                string UserName = ticket.Properties.Dictionary["userName"];

                if (ID == 0)
                {
                    result.Message = "Bad request.";
                    return result;
                }

                Request _request = await db.Requests.FirstOrDefaultAsync(r => r.ID == ID && r.Recipient == _user.Email && r.IsDataActive && r.Status == "Pending");

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


                    string _body = $"Hello {(_request.User.NickName != null ? _request.User.NickName : _user.Email)},<br /><br /><b>{(_user.NickName != null ? _user.NickName : _user.Email)} </b> has rejected your request for the Social Earnings Certificate.";
                    AppManager.SendEmail("Request for the Social Earnings Certificate has been rejected - Seratio Blockchain", _request.User.Email, _body);


                    result.Message = "Requested S/E Certificate is rejected successfully.";
                    result.Status = true;
                }
                else
                {
                    result.Message = "Request not found.";
                }

                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/ModuleAccessRequest")]
        public async Task<ResultSet> RequestAccess(ModuleAccessAPIRequest model)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == model.UserID);



                string _module = null;

                switch (model.Module)
                {
                    case "retail":
                        _module = "Retail End";
                        break;
                    case "rb":
                        _module = "Rewarding Body";
                        break;
                    case "provenance":
                        _module = "Provenance";
                        break;
                    default:
                        break;
                }

                if (!string.IsNullOrEmpty(_module))
                {
                    if (await db.ModuleAccessRequests.AnyAsync(m => m.Module == _module && m.UserID == _user.ID && m.IsApproved == null))
                    {
                        result.Message = "Your request to access this Module is already in process.";
                        return result;
                    }
                    else
                    {
                        model.Module = _module;
                        model.UserID = _user.ID;
                        model.CreatedOn = DateTime.Now;
                        ModuleAccessRequest req = new ModuleAccessRequest();
                        req.ID = model.ID;
                        req.UserID = model.UserID;
                        req.ApprovedOn = model.ApprovedOn;
                        req.CreatedOn = model.CreatedOn;
                        req.IsApproved = model.IsApproved;
                        req.Message = model.Message;
                        req.Module = model.Module;
                        req.ProcessedBy = model.ProcessedBy;
                        req.RejectedOn = model.RejectedOn;
                        db.ModuleAccessRequests.Add(req);
                        await db.SaveChangesAsync();

                        var _administrators = await db.Users.Where(u => u.IsDataActive && u.IsSuperAdmin && u.IsEmailVerified).ToListAsync();

                        foreach (User _admin in _administrators)
                        {
                            ActivityNotification _activitynotification = new ActivityNotification();

                            _activitynotification.UserID = _admin.ID;
                            _activitynotification.RelatedItemID = model.ID;
                            _activitynotification.Type = "Module Access Request";
                            _activitynotification.Message = "Access Request for " + model.Module;
                            _activitynotification.Time = AppManager.Now;
                            _activitynotification.IsRead = false;
                            _activitynotification.CreatedOn = AppManager.Now;

                            db.ActivityNotifications.Add(_activitynotification);
                            await db.SaveChangesAsync();

                            string _body = $"Hello {_admin.NickName ?? _admin.Email.ToLower()} ,<br /><br /> You have a new request from {(_user.NickName != null ? _user.NickName : _user.Email.ToLower())} for authorizing the access to {model.Module}.<br/>Please login to your account to review this request.";
                            AppManager.SendEmail($"A User has requested access to {model.Module}", _admin.Email, _body);
                        }
                        result.Message =  $"Your request to access {model.Module} Module has been submitted.";
                        result.Status = true;
                        return result;
                    }
                }
                else
                {
                    result.Message = "Request not found.";
                    return result;
                }
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

    }
}
