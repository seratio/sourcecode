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

namespace Seratio.Blockchain.Sandbox.Areas.RetailEnd.Controllers
{
    [AuthorizeAccess(RequiresRetailEndAccess = true)]
    public class DefaultController : BaseController
    {
        // GET: RetailEnd/Default
        public async Task<ActionResult> Index()
        {
            ViewBag.Policies = await db.RetailPolicies.Where(p => p.IsDataActive && p.UserID == AppManager.User.ID && p.IsApproved == true && p.PolicyType == "Coin").ToListAsync();

            return View();
        }

        [HttpPost]
        public async Task<ActionResult> Index(AcceptedRetailPolicy model)
        {
            if (ModelState.IsValid)
            {
                User _user = await db.Users.FirstOrDefaultAsync(u => u.WalletAddress == model.WalletAddress);

                if (_user == null)
                {
                    TempData["Notification"] = new Notification("Error", "Transaction failed. Requested User doesn't have a Seratio Platform Account.");
                    return RedirectToAction("Index");
                }

                AcceptedRetailPolicy _acceptedRetailPolicy = new AcceptedRetailPolicy();

                _acceptedRetailPolicy.UserID = _user.ID;
                _acceptedRetailPolicy.PolicyID = model.PolicyID;
                _acceptedRetailPolicy.Description = model.Description;
                _acceptedRetailPolicy.CreatedOn = _acceptedRetailPolicy.LastUpdatedOn = DateTime.Now;
                _acceptedRetailPolicy.IsDataActive = true;
                _acceptedRetailPolicy.Amount = model.Amount;

                db.AcceptedRetailPolicies.Add(_acceptedRetailPolicy);
                await db.SaveChangesAsync();

                PaymentRequest _paymentRequest = new PaymentRequest();
                _paymentRequest.Amount = model.Amount;
                _paymentRequest.CreatedOn = AppManager.Now;
                _paymentRequest.PayerID = _user.ID;
                _paymentRequest.RelatedItemID = _acceptedRetailPolicy.ID;
                _paymentRequest.RequestedByID = AppManager.User.ID;
                _paymentRequest.Status = "Pending";
                _paymentRequest.Type = "Retail";
                _paymentRequest.CoinID = (await db.RetailPolicies.Where(p => p.ID == _acceptedRetailPolicy.PolicyID).Select(p => p.RequiredCoinID).FirstOrDefaultAsync()).Value;

                db.PaymentRequests.Add(_paymentRequest);
                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Payment request to the user has been sent successfully.");

                return Redirect($"/wallet/retailend/paymentrequests/new?senderID={_paymentRequest.RequestedByID}&payerID={_paymentRequest.PayerID}&requestID={_paymentRequest.ID}");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try later.");
            }

            return RedirectToAction("index");
        }

        public JsonResult GetDiscount(int policyID, decimal billAmount)
        {
            decimal _netAmount = 0;
            decimal _discount = 0;
            RetailPolicy _retailPolicy = db.RetailPolicies.FirstOrDefault(a => a.ID == policyID);


            if (_retailPolicy.DiscountMode == "Amount")
            {
                _netAmount = billAmount - _retailPolicy.DiscountValue;
                _discount = _retailPolicy.DiscountValue;
            }
            else
            {
                _netAmount = billAmount - ((billAmount / 100) * _retailPolicy.DiscountValue);
                _discount = (billAmount / 100) * _retailPolicy.DiscountValue;
            }

            return Json(new { netamount = _netAmount, discount = _discount });
        }

        public ActionResult AcceptedPolicies(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from p in db.AcceptedRetailPolicies
                         where p.IsDataActive
                         select new
                         {
                             p.ID,
                             p.PolicyID,
                             p.RetailPolicy,
                             p.User.WalletAddress,
                             p.UserID,
                             p.Description,
                             p.CreatedOn,
                         };
            _query = _query.Where(i => i.RetailPolicy.UserID == AppManager.User.ID);

            if (!string.IsNullOrEmpty(daterange))
            {
                string[] _daterange = daterange.Split(new string[] { " " }, StringSplitOptions.RemoveEmptyEntries);
                DateTime? _start = Convert.ToDateTime(_daterange[0], new CultureInfo("en-CA"));
                DateTime? _end = Convert.ToDateTime(_daterange[2], new CultureInfo("en-CA"));
                _end = _end.Value.AddDays(1);
                _query = _query.Where(u => u.CreatedOn >= _start.Value && u.CreatedOn < _end.Value);
            }

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(s => s.WalletAddress.Contains(request.sSearch) || s.Description.Contains(request.sSearch) || s.RetailPolicy.Name.ToString().Contains(request.sSearch) || s.CreatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.WalletAddress) : _query.OrderByDescending(s => s.WalletAddress);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.RetailPolicy.Name) : _query.OrderByDescending(s => s.RetailPolicy.Name);
                    break;

                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(s => s.CreatedOn) : _query.OrderBy(s => s.CreatedOn);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Description) : _query.OrderByDescending(s => s.Description);
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

                _row.Add(_rowData.WalletAddress);
                _row.Add("<a href='/wallet/retailend/retailpolicies/details/" + _rowData.PolicyID + "' ></i>" + _rowData.RetailPolicy.Name + "</a>");
                _row.Add(_rowData.CreatedOn.ToString());

                if (_rowData.Description != null)
                {
                    _row.Add(_rowData.Description);
                }
                else
                {
                    _row.Add("-");

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

    }
}