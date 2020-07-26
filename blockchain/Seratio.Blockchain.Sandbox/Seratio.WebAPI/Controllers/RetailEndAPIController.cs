using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Data.Entity;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Cors;
using Microsoft.Owin.Security;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using Seratio.Blockchain.Sandbox.Core;

namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class RetailEndAPIController : BaseAPIController
    {

        [HttpPost]
        [Route("api/RetailEndList")]
        public async Task<RetailEndListResult> RetailEndList(DataTableRequest_DarteRange request)
        {
            RetailEndListResult result = new RetailEndListResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int ID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == ID);
                if (_user != null)
                {

                    var _query = from p in db.RetailPolicies
                                 join c in db.Coins on p.RequiredCoinID equals c.ID into joined
                                 from c in joined.DefaultIfEmpty()
                                 where p.IsDataActive && p.IsApproved == true && p.PolicyType != "Default"
                                 select new
                                 {
                                     p.ID,
                                     p.Name,
                                     p.Description,
                                     CoinName = c.Name,
                                     CoinCode = c.Symbol,
                                     p.ApprovedOn,
                                     p.RejectedOn,
                                     p.IsApproved,
                                     p.CreatedOn,
                                     p.UserID,
                                     ProcessedBy = p.ProcessedBy != null ? p.User1.Email : null,
                                     p.User.NickName
                                 };

                    if (!string.IsNullOrEmpty(request.sSearch))
                    {
                        _query = _query.Where(s => s.Name.Contains(request.sSearch) || s.Description.Contains(request.sSearch) || s.ProcessedBy.Contains(request.sSearch) || s.IsApproved.ToString().Contains(request.sSearch) || s.CreatedOn.ToString().Contains(request.sSearch));
                    }

                    switch (request.iSortCol_0)
                    {
                        case 0:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Name) : _query.OrderByDescending(s => s.Name);
                            break;
                        case 1:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.Description) : _query.OrderByDescending(m => m.Description);
                            break;
                        case 2:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.NickName) : _query.OrderByDescending(s => s.NickName);
                            break;
                        case 3:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.CreatedOn) : _query.OrderByDescending(s => s.CreatedOn);
                            break;
                        default:
                            _query = _query.OrderByDescending(s => s.ID);
                            break;
                    }

                    var _count = await _query.CountAsync();

                    var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
                    List<RetailEndListResultSet> _rows = new List<RetailEndListResultSet>();

                    foreach (var _rowData in _data)
                    {
                        RetailEndListResultSet _row = new RetailEndListResultSet();

                        _row.ID = _rowData.ID;
                        _row.Name = _rowData.Name;
                        _row.Description = _rowData.Description;
                        _row.NickName = _rowData.NickName;
                        _row.CreatedOn = _rowData.CreatedOn.ToString();
                        _rows.Add(_row);
                    }

                    result = new RetailEndListResult
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
                    result = new RetailEndListResult
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
            else
            {
                result = new RetailEndListResult
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
        [Route("api/RetailEndMyList")]
        public async Task<RetailEndListResult> RetailEndMyList(DataTableRequest_DarteRange request)
        {
            RetailEndListResult result = new RetailEndListResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int ID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == ID);
                if (_user != null)
                {
                    var _query = from v in db.CollectedVouchers
                                 join p in db.RetailPolicies on v.PolicyID equals p.ID
                                 where p.IsDataActive && p.IsApproved == true && v.UserID == _user.ID
                                 select new
                                 {
                                     p.ID,
                                     p.Name,
                                     v.Time,
                                     p.UserID,
                                     p.User.NickName,
                                     p.VoucherCode,
                                     v.HasRedeemed
                                 };

                    if (!string.IsNullOrEmpty(request.sSearch))
                    {
                        _query = _query.Where(s => s.Name.Contains(request.sSearch));
                    }

                    switch (request.iSortCol_0)
                    {
                        case 0:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Name) : _query.OrderByDescending(s => s.Name);
                            break;
                        case 1:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.VoucherCode) : _query.OrderByDescending(s => s.VoucherCode);
                            break;
                        case 2:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.NickName) : _query.OrderByDescending(s => s.NickName);
                            break;
                        case 3:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Time) : _query.OrderByDescending(s => s.Time);
                            break;
                        case 4:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.HasRedeemed) : _query.OrderByDescending(s => s.HasRedeemed);
                            break;
                    }

                    var _count = await _query.CountAsync();

                    var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
                    List<RetailEndListResultSet> _rows = new List<RetailEndListResultSet>();

                    foreach (var _rowData in _data)
                    {
                        RetailEndListResultSet _row = new RetailEndListResultSet();

                        _row.ID = _rowData.ID;
                        _row.Name = _rowData.Name;
                        _row.VoucherCode = _rowData.VoucherCode;
                        _row.NickName = _rowData.NickName;
                        _row.CreatedOn = _rowData.Time.ToString();
                        _row.HasRedeemed = _rowData.HasRedeemed;
                        _rows.Add(_row);
                    }

                    result = new RetailEndListResult
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
                    result = new RetailEndListResult
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
            else
            {
                result = new RetailEndListResult
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
        [Route("api/RetailEndDetails")]
        public async Task<RetailPolicyResult> Details(int ID)
        {
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            RetailPolicyResult result = new RetailPolicyResult();
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                if (_user != null)
                {
                    RetailPolicy _retailPolicy =
                        await db.RetailPolicies.FirstOrDefaultAsync(
                            s => s.ID == ID);

                    if (_retailPolicy == null)
                    {
                        result.Message = "Return policy not found";
                        return result;
                    }

                    CollectedVoucher _collectedVoucher = await db.CollectedVouchers.OrderByDescending(v => v.ID).FirstOrDefaultAsync(v => v.HasRedeemed && v.PolicyID == _retailPolicy.ID && v.UserID == _user.ID);

                    result.Status = true;

                    result.RetailPolicy = new RetailPolicy_API();
                    result.RetailPolicy.UserID = _retailPolicy.UserID;
                    result.RetailPolicy.RequiredCoinID = _retailPolicy.RequiredCoinID;
                    result.RetailPolicy.ProcessedBy = _retailPolicy.ProcessedBy;
                    result.RetailPolicy.Name = _retailPolicy.Name;
                    result.RetailPolicy.Description = _retailPolicy.Description;
                    result.RetailPolicy.PolicyType = _retailPolicy.PolicyType;
                    result.RetailPolicy.MinSESCore = _retailPolicy.MinSESCore;
                    result.RetailPolicy.MaxSEScore = _retailPolicy.MaxSEScore;
                    result.RetailPolicy.DiscountMode = _retailPolicy.DiscountMode;
                    result.RetailPolicy.RequiredCoinQty = _retailPolicy.RequiredCoinQty;
                    result.RetailPolicy.DiscountValue = _retailPolicy.DiscountValue;
                    result.RetailPolicy.IsApproved = _retailPolicy.IsApproved;
                    result.RetailPolicy.ApprovedOn = _retailPolicy.ApprovedOn;
                    result.RetailPolicy.RejectedOn = _retailPolicy.RejectedOn;
                    result.RetailPolicy.CreatedOn = _retailPolicy.CreatedOn;
                    result.RetailPolicy.LastUpdatedOn = _retailPolicy.LastUpdatedOn;
                    result.RetailPolicy.DeletedOn = _retailPolicy.DeletedOn;
                    result.RetailPolicy.Category = _retailPolicy.Category;
                    result.RetailPolicy.VoucherCode = _retailPolicy.VoucherCode;
                    return result;
                }
                else
                {
                    result.Status = false;
                    result.Message = "User not found.";
                    return result;
                }
            }
            else
            {
                result.Status = false;
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/RetailEndCollect")]
        public async Task<RetailPolicyResult> Collect(int ID)
        {

            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            RetailPolicyResult result = new RetailPolicyResult();
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                if (_user != null)
                {
                    SAPIResponse _sapiResponse = await AppManager.GetSE(_user.Email);

                    if (_sapiResponse.data == null)
                    {
                        result.Status = false;

                        result.Message = "Please calculate your S/E Score to access this page.";
                        return result;
                    }

                    RetailPolicy _policy = await db.RetailPolicies.FirstOrDefaultAsync(s => s.ID == ID);

                    if (_policy == null)
                    {
                        result.Status = false;

                        result.Message = "Return policy not found";
                        return result;
                    }

                    if (_policy.PolicyType == "SE")
                    {
                        if (_sapiResponse.data.pv >= (double)_policy.MinSESCore.Value)
                        {
                            CollectedVoucher _collectedVoucher = new CollectedVoucher();
                            _collectedVoucher.UserID = _user.ID;
                            _collectedVoucher.PolicyID = _policy.ID;
                            _collectedVoucher.WalletTransactionID = null;
                            _collectedVoucher.Time = AppManager.Now;

                            db.CollectedVouchers.Add(_collectedVoucher);
                            await db.SaveChangesAsync();
                            result.Status = true;
                            result.Message = "The Voucher has been successfully added to your account.";
                            string _body = $"Hello,<br /><br />New Voucher from retail end has been added to your account.<br />Please log in to your account to review.";
                            AppManager.SendEmail("New Voucher Collected", _user.Email, _body, false);
                            return result;
                        }
                        else
                        {
                            result.Status = false;

                            result.Message = "Sorry, your S/E Score does not match the criteria set by the retailer.";
                            return result;
                        }
                    }
                    else if (_policy.PolicyType == "Coin")
                    {
                        if (_policy.RequiredCoinQty == 0)
                        {
                            CollectedVoucher _collectedVoucher = new CollectedVoucher();
                            _collectedVoucher.UserID = _user.ID;
                            _collectedVoucher.PolicyID = _policy.ID;
                            _collectedVoucher.WalletTransactionID = null;
                            _collectedVoucher.Time = AppManager.Now;
                            result.Status = true;
                            db.CollectedVouchers.Add(_collectedVoucher);
                            await db.SaveChangesAsync();
                            result.Message = "The Voucher has been successfully added to your account.";
                            return result;
                        }
                        else
                        {
                            PaymentRequest _paymentRequest = new PaymentRequest();
                            _paymentRequest.Amount = _policy.RequiredCoinQty.Value;
                            _paymentRequest.CreatedOn = AppManager.Now;
                            _paymentRequest.PayerID = _user.ID;
                            _paymentRequest.RelatedItemID = _policy.ID;
                            _paymentRequest.RequestedByID = _policy.UserID;
                            _paymentRequest.Status = "Pending";
                            _paymentRequest.Type = "Voucher";
                            _paymentRequest.CoinID = _policy.RequiredCoinID.Value;

                            db.PaymentRequests.Add(_paymentRequest);
                            await db.SaveChangesAsync();
                            result.PaymentID = _paymentRequest.ID;
                            result.Status = false;
                            result.Message = "Please complete this payment to collect the Voucher.";
                            return result;
                        }
                    }

                    return result;
                }
                else
                {
                    result.Status = false;
                    result.Message = "User not found";
                    return result;
                }
            }
            else
            {
                result.Status = false;
                result.Message = "You are not authorized.";
                return result;
            }
        }

        //[HttpPost]
        //public async Task<ActionResult> Accept(string customer, string VoucherCode)
        //{
        //    if (!string.IsNullOrEmpty(customer) && !string.IsNullOrEmpty(VoucherCode))
        //    {
        //        User _user = await db.Users.FirstOrDefaultAsync(u => u.WalletAddress == customer || u.Email == customer);

        //        if (_user == null)
        //        {
        //            TempData["Notification"] = new Notification("Error", "Requested User doesn't have a Seratio Platform Account.");
        //            return RedirectToAction("Accept");
        //        }

        //        RetailPolicy _policy = await db.RetailPolicies.FirstOrDefaultAsync(p => p.VoucherCode == VoucherCode);

        //        if (_policy == null)
        //        {
        //            TempData["Notification"] = new Notification("Error", "Invalid Voucher Code. Please try again later.");
        //            return RedirectToAction("Accept");
        //        }

        //        CollectedVoucher _voucher = await db.CollectedVouchers.FirstOrDefaultAsync(p => p.PolicyID == _policy.ID && !p.HasRedeemed);

        //        if (_voucher == null)
        //        {
        //            TempData["Notification"] = new Notification("Error", "The User is not eligible for this Voucher. Please try again later.");
        //            return RedirectToAction("Accept");
        //        }

        //        AcceptedRetailPolicy _acceptedRetailPolicy = new AcceptedRetailPolicy();

        //        _acceptedRetailPolicy.UserID = _user.ID;
        //        _acceptedRetailPolicy.PolicyID = _policy.ID;
        //        _acceptedRetailPolicy.Description = "Accepted Voucher";
        //        _acceptedRetailPolicy.CreatedOn = _acceptedRetailPolicy.LastUpdatedOn = DateTime.Now;
        //        _acceptedRetailPolicy.IsDataActive = true;
        //        _acceptedRetailPolicy.Amount = _policy.RequiredCoinQty ?? 0;

        //        db.AcceptedRetailPolicies.Add(_acceptedRetailPolicy);
        //        await db.SaveChangesAsync();

        //        _voucher.HasRedeemed = true;
        //        _voucher.RedeemedOn = AppManager.Now;

        //        await db.SaveChangesAsync();

        //        TempData["Notification"] = new Notification("Success", "Submitted Voucher has been redeemed successfully.");

        //        string _body = $"Hello,<br /><br />Your Voucher ({VoucherCode}) has been redeemed at the retailer ({AppManager.User.NickName}). Please log in to your account to review.";
        //        AppManager.SendEmail("Your Voucher has been redeemed", AppManager.User.Email, _body, false);
        //    }
        //    else
        //    {
        //        TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
        //    }

        //    return RedirectToAction("Accept");
        //}
    }
}
