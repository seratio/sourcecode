using System;
using System.Collections.Generic;
using System.Data.Entity;
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
    public class VouchersController : BaseController
    {
        [AuthorizeAccess]
        public async Task<ActionResult> Index(string daterange)
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score first to get access to retail vouchers.");
                return Redirect("/wallet/default/dashboard");
            }

            return View();
        }

        [AuthorizeAccess]
        public async Task<JsonResult> List(DataTableRequest request, string daterange)
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
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add($"<a href='/wallet/retailend/vouchers/details/{_rowData.ID}'>{_rowData.Name}</a>");
                _row.Add(_rowData.Description);
                _row.Add(_rowData.NickName);
                _row.Add(_rowData.CreatedOn.ToString());
                _row.Add(@"<a class='btn btn-primary' title='Collect' href='/wallet/retailend/vouchers/collect/" +
                         _rowData.ID + "'>Collect</a>");

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
        public async Task<ActionResult> My()
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score first to get access to retail vouchers.");
                return Redirect("/wallet/default/dashboard");
            }

            CollectedVoucher _collectedVoucher = await db.CollectedVouchers.OrderByDescending(v => v.ID).FirstOrDefaultAsync(v => v.HasRedeemed && v.UserID == AppManager.User.ID);

            if (_collectedVoucher != null && _collectedVoucher.FeedbackDate == null)
            {
                ViewBag.RecentRedeemID = _collectedVoucher.PolicyID;
            }

            return View();
        }

        [AuthorizeAccess]
        public async Task<JsonResult> MyList(DataTableRequest request, string daterange)
        {
            var _query = from v in db.CollectedVouchers
                         join p in db.RetailPolicies on v.PolicyID equals p.ID
                         where p.IsDataActive && p.IsApproved == true && v.UserID == AppManager.User.ID
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
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add($"<a href='/wallet/retailend/vouchers/details/{_rowData.ID}'>{_rowData.Name}</a>");
                _row.Add(_rowData.VoucherCode);
                _row.Add(_rowData.NickName);
                _row.Add(_rowData.Time.ToString());

                if (_rowData.HasRedeemed)
                {
                    _row.Add("<span class='label bg-grey-300'>Redeemed</span>");
                }
                else
                {
                    _row.Add("<span class='label bg-success'>Available</span>");
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
        public async Task<ActionResult> Details(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            RetailPolicy _retailPolicy =
                await db.RetailPolicies.FirstOrDefaultAsync(
                    s => s.ID == ID);

            if (_retailPolicy == null)
            {
                return HttpNotFound();
            }

            CollectedVoucher _collectedVoucher = await db.CollectedVouchers.OrderByDescending(v => v.ID).FirstOrDefaultAsync(v => v.HasRedeemed && v.PolicyID == _retailPolicy.ID && v.UserID == AppManager.User.ID);

            if (_collectedVoucher != null)
            {
                ViewBag.RecentRedeemID = _collectedVoucher.PolicyID;
            }

            return View(_retailPolicy);
        }

        [AuthorizeAccess]
        public async Task<ActionResult> Collect(int ID)
        {
            SAPIResponse _sapiResponse = await AppManager.GetSE(AppManager.User.Email);

            if (_sapiResponse.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score to access this page.");
                return Redirect("/wallet/default/dashboard");
            }

            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            RetailPolicy _policy = await db.RetailPolicies.FirstOrDefaultAsync(s => s.ID == ID);

            if (_policy == null)
            {
                return HttpNotFound();
            }

            if (_policy.PolicyType == "SE")
            {
                if (_sapiResponse.data.pv >= (double)_policy.MinSESCore.Value)
                {
                    CollectedVoucher _collectedVoucher = new CollectedVoucher();
                    _collectedVoucher.UserID = AppManager.User.ID;
                    _collectedVoucher.PolicyID = _policy.ID;
                    _collectedVoucher.WalletTransactionID = null;
                    _collectedVoucher.Time = AppManager.Now;

                    db.CollectedVouchers.Add(_collectedVoucher);
                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "The Voucher has been successfully added to your account.");

                    string _body = $"Hello,<br /><br />New Voucher from retail end has been added to your account.<br />Please log in to your account to review.";
                    AppManager.SendEmail("New Voucher Collected", AppManager.User.Email, _body, false);
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, your S/E Score does not match the criteria set by the retailer.");
                }
            }
            else if (_policy.PolicyType == "Coin")
            {
                if (_policy.RequiredCoinQty == 0)
                {
                    CollectedVoucher _collectedVoucher = new CollectedVoucher();
                    _collectedVoucher.UserID = AppManager.User.ID;
                    _collectedVoucher.PolicyID = _policy.ID;
                    _collectedVoucher.WalletTransactionID = null;
                    _collectedVoucher.Time = AppManager.Now;

                    db.CollectedVouchers.Add(_collectedVoucher);
                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "The Voucher has been successfully added to your account.");
                }
                else
                {
                    PaymentRequest _paymentRequest = new PaymentRequest();
                    _paymentRequest.Amount = _policy.RequiredCoinQty.Value;
                    _paymentRequest.CreatedOn = AppManager.Now;
                    _paymentRequest.PayerID = AppManager.User.ID;
                    _paymentRequest.RelatedItemID = _policy.ID;
                    _paymentRequest.RequestedByID = _policy.UserID;
                    _paymentRequest.Status = "Pending";
                    _paymentRequest.Type = "Voucher";
                    _paymentRequest.CoinID = _policy.RequiredCoinID.Value;

                    db.PaymentRequests.Add(_paymentRequest);
                    await db.SaveChangesAsync();

                    TempData["Notification"] =
                        new Notification("Info", "Please complete this payment to collect the Voucher.");

                    return Redirect($"/wallet/wallets/seratiowallet/pay/{_paymentRequest.ID}");
                }
            }

            return RedirectToAction("My");
        }

        public ActionResult Accept()
        {
            return View();
        }

        [HttpPost]
        public async Task<ActionResult> Accept(string customer, string VoucherCode)
        {
            if (!string.IsNullOrEmpty(customer) && !string.IsNullOrEmpty(VoucherCode))
            {
                User _user = await db.Users.FirstOrDefaultAsync(u => u.WalletAddress == customer || u.Email == customer);

                if (_user == null)
                {
                    TempData["Notification"] = new Notification("Error", "Requested User doesn't have a Seratio Platform Account.");
                    return RedirectToAction("Accept");
                }

                RetailPolicy _policy = await db.RetailPolicies.FirstOrDefaultAsync(p => p.VoucherCode == VoucherCode);

                if (_policy == null)
                {
                    TempData["Notification"] = new Notification("Error", "Invalid Voucher Code. Please try again later.");
                    return RedirectToAction("Accept");
                }

                CollectedVoucher _voucher = await db.CollectedVouchers.FirstOrDefaultAsync(p => p.PolicyID == _policy.ID && !p.HasRedeemed);

                if (_voucher == null)
                {
                    TempData["Notification"] = new Notification("Error", "The User is not eligible for this Voucher. Please try again later.");
                    return RedirectToAction("Accept");
                }

                AcceptedRetailPolicy _acceptedRetailPolicy = new AcceptedRetailPolicy();

                _acceptedRetailPolicy.UserID = _user.ID;
                _acceptedRetailPolicy.PolicyID = _policy.ID;
                _acceptedRetailPolicy.Description = "Accepted Voucher";
                _acceptedRetailPolicy.CreatedOn = _acceptedRetailPolicy.LastUpdatedOn = DateTime.Now;
                _acceptedRetailPolicy.IsDataActive = true;
                _acceptedRetailPolicy.Amount = _policy.RequiredCoinQty ?? 0;

                db.AcceptedRetailPolicies.Add(_acceptedRetailPolicy);
                await db.SaveChangesAsync();

                _voucher.HasRedeemed = true;
                _voucher.RedeemedOn = AppManager.Now;

                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Submitted Voucher has been redeemed successfully.");

                string _body = $"Hello,<br /><br />Your Voucher ({VoucherCode}) has been redeemed at the retailer ({AppManager.User.NickName}). Please log in to your account to review.";
                AppManager.SendEmail("Your Voucher has been redeemed", AppManager.User.Email, _body, false);
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
            }

            return RedirectToAction("Accept");
        }

        [AuthorizeAccess]
        public async Task<ActionResult> Feedback(int ID)
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

            RetailPolicy _retailPolicy =
                await db.RetailPolicies.FirstOrDefaultAsync(
                    s => s.ID == ID);

            if (_retailPolicy == null)
            {
                return HttpNotFound();
            }

            return View(_retailPolicy);
        }

        [AuthorizeAccess]
        [HttpPost]
        public async Task<ActionResult> SaveFeedback(int cvID, string Feedback)
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            if (_response.data == null)
            {
                TempData["Notification"] = new Notification("Info", "Please calculate your S/E Score to access this page.");
                return Redirect("/wallet/default/dashboard");
            }

            if (cvID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            CollectedVoucher _collectedVoucher =
                await db.CollectedVouchers.FirstOrDefaultAsync(
                    s => s.ID == cvID);

            if (_collectedVoucher == null)
            {
                return HttpNotFound();
            }

            _collectedVoucher.FeedbackDate = AppManager.Now;
            _collectedVoucher.Feedback = Feedback;

            await db.SaveChangesAsync();

            TempData["Notification"] = new Notification("Success", "Thank you for sharing your feedback.");
            return RedirectToAction("My");
        }
    }
}