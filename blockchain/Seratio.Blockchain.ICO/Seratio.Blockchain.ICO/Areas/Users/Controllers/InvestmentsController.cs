using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Net;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Web.Mvc;
using MaxMind.GeoIP2;
using MaxMind.GeoIP2.Responses;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Core.Utilities;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Areas.Users.Controllers
{
    public class InvestmentsController : FrontendBaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from i in db.Investments
                         join u in db.Users on i.UserID equals u.ID
                         select new
                         {
                             i.ID,
                             i.Mode,
                             i.Amount,
                             i.Status,
                             i.InitializedOn,
                             i.LastUpdatedOn,
                             i.TxRefNoUpdatedOn,
                             i.TxReferenceNumber,
                             i.UserID,
                             i.Token,
                             i.Type,
                             i.HasTransferred,
                             i.TokenAmount
                             ,
                             i.ReceivedAmount
                         };

            if (!string.IsNullOrEmpty(daterange))
            {
                string[] _daterange = daterange.Split(new string[] { " " }, StringSplitOptions.RemoveEmptyEntries);
                DateTime? _start = Convert.ToDateTime(_daterange[0], new CultureInfo("en-CA"));
                DateTime? _end = Convert.ToDateTime(_daterange[2], new CultureInfo("en-CA"));
                _end = _end.Value.AddDays(1);
                _query = _query.Where(u => u.LastUpdatedOn >= _start.Value && u.LastUpdatedOn < _end.Value);
            }

            _query = _query.Where(i => i.UserID == AppManager.User.ID);

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(u => u.LastUpdatedOn.ToString().Contains(request.sSearch) || u.InitializedOn.ToString().Contains(request.sSearch) || u.Type.ToString().Contains(request.sSearch) || u.Mode.Contains(request.sSearch) || u.Amount.ToString().Contains(request.sSearch) || u.Status.Contains(request.sSearch) || u.Token.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.Type) : _query.OrderByDescending(i => i.Type);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.Status) : _query.OrderByDescending(i => i.Status);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(i => i.InitializedOn) : _query.OrderBy(i => i.InitializedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(u => u.ID);
                    break;
            }

            int _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();
                string _statusHtml = "";
                _row.Add($"<a href='/users/investments/details/{ _rowData.ID }' title='Details'>{_rowData.Token}</a>");
                _row.Add(_rowData.Type);

                switch (_rowData.Mode)
                {
                    case "AUD":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "CAD":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "CHF":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "CNY":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "EUR":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "USD":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "GBP":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "JPY":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "SEK":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "NZD":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "MXN":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "SGD":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "HKD":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "NOK":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "KRW":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "TRY":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;

                    case "RUB":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "INR":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "BRL":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    case "ZAR":
                        _row.Add($"{ String.Format("{0:0.00}", _rowData.Amount, MidpointRounding.AwayFromZero) } {_rowData.Mode}");
                        break;
                    default:
                        _row.Add($"{_rowData.Amount} {_rowData.Mode}");
                        break;
                }

                switch (_rowData.Status)
                {
                    case "Waiting for transaction reference number":
                    case "Waiting for you to update your payment reference":
                        _statusHtml = $"<span class=\"label label-default\">Waiting for you to update your payment reference</span> [<a class='confirm' data-confirm='Please confirm your action as this could only be done once?' href='/users/investments/updatereferencenumber/{ _rowData.ID }' title='Confirm using your Wallet Address/ Bank Payment Reference'>Update</a>]";
                        break;
                    case "Waiting for Confirmation":
                        _statusHtml = "<span class=\"label label-primary\">Waiting for Confirmation</span>";
                        break;
                    case "Waiting for Wallet to be ready":
                    case "Confirmed":
                        _statusHtml = $"<span class=\"label label-success\">Confirmed</span>";
                        break;
                    //if (_rowData.WalletPassPhrase != null)
                    //{
                    //    _statusHtml =
                    //        $"<span class=\"label label-success\">Waiting for Wallet to be ready</span> [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' title='Add Wallet Password Phrase'>Download Receipt</a>]";
                    //}
                    //else
                    //{
                    //    _statusHtml = $"<span class=\"label label-success\">Confirmed</span> [<a href='/users/investments/addwalletpassphrase/{ _rowData.ID }' title='Add Wallet Password Phrase'>Update</a>] [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' title='Add Wallet Password Phrase'>Download Receipt</a>]";
                    //}
                    //break;

                    //case "Waiting for Wallet to be ready":
                    //    _statusHtml = $"<span class=\"label label-success\">Waiting for Wallet to be ready</span> [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' >Download Receipt</a>]";
                    //    break;

                    //case "Wallet Created":
                    //    _statusHtml = $"<span class=\"label label-success\">Wallet Created</span> [<a href='/users/investments/download/{ _rowData.UserID }' target='_blank' >Download Wallet</a>]";
                    //    break;
                    case "Rejected":
                        _statusHtml = $"<span class=\"label label-danger\">Rejected</span>";
                        break;
                    //case "Coins Issued":
                    //    _statusHtml = $"<span class=\"label label-info\">Coins Issued</span> [<a href='/users/investments/download/{ _rowData.UserID }' target='_blank' >Download Wallet</a>]";
                    //    break;
                    default:
                        _statusHtml = "Unknown";
                        break;
                }

                if (_rowData.Type == "Growth Token" && _rowData.Status == "Confirmed" && _rowData.HasTransferred == true)
                {
                    _statusHtml = $"<span class='label label-success'>YOUR {_rowData.ReceivedAmount} SER TOKENS HAVE NOW BEEN TRANSFERRED TO THE GROWTH TOKEN CRYPTOFUND</span>";
                }
                else if (_rowData.Type == "Growth Token" && _rowData.Status == "Confirmed")
                {
                    _statusHtml = "<span class='label label-success1'>INVESTMENT CONFIRMED, PENDING TRANSFER TO THE GROWTH TOKEN CRYPTOFUND</span>";
                }

                _row.Add(_statusHtml);
                _row.Add(_rowData.InitializedOn.ToString());
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

        public async Task<ActionResult> Details(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Investment _investment = await db.Investments.FindAsync(ID);

            if (_investment == null)
            {
                return HttpNotFound();
            }

            if (_investment == null)
            {
                return HttpNotFound();
            }
            if (_investment.UserID != AppManager.User.ID)
            {
                return HttpNotFound();
            }

            return View(_investment);
        }

        public ActionResult Create(string ICOType)
        {
            ViewBag.InvestmentID = Guid.NewGuid();

            if (ICOType == "Seratio Coin")
            {
                TempData["Notification"] = new Notification("Error",
                    "Seratio Coin ICO has been ended.");
                return RedirectToAction("index");
            }
            else if (ICOType == "Growth Token")
            {
                TempData["Notification"] = new Notification("Error",
                    "The Growth Token Fund is now closed.");
                return RedirectToAction("index");
            }

            else
            {
                if (Session["ICOType"] != null && ICOType != null)
                {
                    if (Session["ICOType"].ToString() != ICOType)
                    {
                        TempData["Notification"] = new Notification("Info",
                            $"You are already Signed in to the {Session["ICOType"]} ICO. Please logout of that session to continue with new Investment.");
                        return RedirectToAction("index");
                    }
                    else
                    {
                        Session["ICOType"] = ICOType;
                    }
                }

            }

            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Create(Investment model, string fiatcoin, string ICOType, Guid investmentid)
        {
            if (ICOType == "Seratio Coin")
            {
                TempData["Notification"] = new Notification("Error",
                    "Seratio Coin ICO has been ended.");
                return RedirectToAction("index");
            }
            else if (ICOType == "Growth Token")
            {
                TempData["Notification"] = new Notification("Error",
                    "The Growth Token Fund is now closed.");
                return RedirectToAction("index");
            }

            if (await db.Investments.AnyAsync(t => t.InvestmentID == investmentid))
            {
                TempData["Notification"] = new Notification("Error", "Invalid or Duplicate investment detected. Please try again later.");
                return RedirectToAction("Create");
            }

            model.Type = ICOType;

            if (model.Mode == "Fiat")
            {
                model.Mode = fiatcoin;
            }

            string _exchangerate = "1";

            #region Min and Max Amount

            try
            {
                decimal _minval;

                switch (model.Mode)
                {
                    case "Bitcoin":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "BTC") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "BTC").Result.ExchangePrice : "1");
                        break;
                    case "Ethereum":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "ETH") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "ETH").Result.ExchangePrice : "1");
                        break;
                    case "AUD":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "AUD") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "AUD").Result.ExchangePrice : "1");
                        break;
                    case "CAD":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "CAD") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "CAD").Result.ExchangePrice : "1");
                        break;
                    case "CHF":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "CHF") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "CHF").Result.ExchangePrice : "1");
                        break;
                    case "CNY":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "CNY") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "CNY").Result.ExchangePrice : "1");
                        break;
                    case "EUR":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "EUR") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "EUR").Result.ExchangePrice : "1");
                        break;
                    case "USD":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "USD") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "USD").Result.ExchangePrice : "1");

                        break;
                    case "GBP":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "GBP") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "GBP").Result.ExchangePrice : "1");

                        break;
                    case "JPY":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "JPY") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "JPY").Result.ExchangePrice : "1");
                        break;
                    case "SEK":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "SEK") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "SEK").Result.ExchangePrice : "1");

                        break;
                    case "NZD":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "NZD") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "NZD").Result.ExchangePrice : "1");

                        break;
                    case "MXN":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "MXN") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "MXN").Result.ExchangePrice : "1");

                        break;
                    case "SGD":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "SGD") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "SGD").Result.ExchangePrice : "1");
                        break;

                    case "HKD":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "HKD") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "HKD").Result.ExchangePrice : "1");

                        break;
                    case "NOK":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "NOK") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "NOK").Result.ExchangePrice : "1");

                        break;
                    case "KRW":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "KRW") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "KRW").Result.ExchangePrice : "1");

                        break;
                    case "TRY":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "TRY") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "TRY").Result.ExchangePrice : "1");
                        break;

                    case "RUB":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "RUB") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "RUB").Result.ExchangePrice : "1");

                        break;
                    case "INR":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "INR") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "INR").Result.ExchangePrice : "1");

                        break;
                    case "BRL":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "BRL") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "BRL").Result.ExchangePrice : "1");

                        break;
                    case "ZAR":
                        _exchangerate = (await db.ExchangeRates.AnyAsync(e => e.From == "ZAR") ? db.ExchangeRates.OrderByDescending(e => e.Time).FirstOrDefaultAsync(e => e.From == "ZAR").Result.ExchangePrice : "1");
                        break;
                }

                decimal _investmentInGBP = Convert.ToDecimal(_exchangerate) * (decimal)model.Amount;
                decimal _minimumInvestmentNeeded = 0;

                switch (model.Type)
                {
                    case "Womens Coin":
                        _minimumInvestmentNeeded = 1000;
                        break;
                    case "Student Coin":
                        _minimumInvestmentNeeded = 50;
                        break;
                    case "Growth Token":
                        _minimumInvestmentNeeded = 0;
                        break;
                    case "TimeTraveler Coin":
                        _minimumInvestmentNeeded = 10000;
                        break;
                }

                if (_investmentInGBP < _minimumInvestmentNeeded)
                {
                    _minval = _minimumInvestmentNeeded / Convert.ToDecimal(_exchangerate);

                    if (model.Type == "Growth Token")
                    {
                        model.Mode = "GBP";
                    }

                    TempData["Notification"] = new Notification("Error",
                         $"The minimum investment amount required is { String.Format("{0:0.00}", _minval, MidpointRounding.AwayFromZero) } {model.Mode} as per the current exchange rates. Please resubmit with the correct minimum amount.");

                    return RedirectToAction("Index");
                }
            }
            catch (Exception ex)
            {
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request at this time. Please try again later.");
                return View();
            }


            #endregion

            string val = string.Empty;
            bool _flag = true;
            while (_flag)
            {
                val = Guid.NewGuid().ToString().Replace("-", "");
                val = val.Substring(0, 8);

                if (!await db.Investments.AnyAsync(i => i.Token == val))
                {
                    _flag = false;
                }
            }

            model.Token = val;

            if (ModelState.IsValid)
            {
                model.InitializedOn = model.LastUpdatedOn = DateTime.Now;
                model.UserID = AppManager.User.ID;
                model.Status = "Waiting for you to update your payment reference";
                model.OriginalExchangeRate = _exchangerate;
                model.UserSessionID = AppManager.User.SessionID;
                model.InvestmentID = investmentid;

                db.Investments.Add(model);
                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "New Investment has been initialized successfully.");

                User _user = await db.Users.FindAsync(AppManager.User.ID);

                string _body = string.Empty;
                string _topImage = string.Empty;
                string _footerImage = string.Empty;

                string _etherWalletAddress = String.Empty;
                string _bitcoinWalletAddress = String.Empty;

                switch (model.Type)
                {
                    case "Seratio Coin":
                        _footerImage = "logo.png";
                        _topImage = "**************logo.jpg";
                        break;
                    case "Womens Coin":
                        _etherWalletAddress = "0x205b6ab657e4F8Af2BC62534b1785F95c737174A";
                        _bitcoinWalletAddress = "34cbHGZYCYwVeDz8zXCupamjH4VyryyR93";

                        _footerImage = "logo.png";
                        _topImage = "womenscoinlogov2.png";

                        break;
                    case "Student Coin":
                        _etherWalletAddress = "0x56446d67E8e0494f5FeA026Da25f5e0094E2Bab0";
                        _bitcoinWalletAddress = "3M2r9iYiStgrnBNe2afCw7XssprXe9R1NY";

                        _footerImage = "logo.png";
                        _topImage = "studentcoin.png";
                        break;
                    case "Growth Token":
                        _etherWalletAddress = "0xF77e43A8b2c2Da1C923f02D2Dc75313B6882c200";
                        _bitcoinWalletAddress = "3E8KA3MoT1jpQE9Excii7Lqxm28idhLETH";

                        _footerImage = "logo.png";
                        _topImage = "10xtokenlogo.png";
                        break;
                    case "TimeTraveler Coin":
                        _etherWalletAddress = "0x42035254b55fe448bEc0e178C8c86A140BB0Cb48";
                        _bitcoinWalletAddress = "3CwNHqsvK1e83qp66ym1iGubeyYcGUcWMD";
                        _footerImage = "logo.png";
                        _topImage = "timetraveler.png";
                        break;
                    default:
                        _footerImage = _topImage = "logo.png";
                        break;
                }

                string _accountInfo = "Please now transfer <strong>" + model.Amount + " " + model.Mode + "</strong> to the account given below:<br />Account Name: Centre for Citizenship, Enterprise and Governance Limited <br />" +
                                      "Bank: Metro Bank <br />" +
                                      "International Bank Account Number:  GB46MYMB23058025080785 <br />" +
                                      "SWIFT:  MYMBGB2L </br />" +
                                      "Sort Code:  23-05-80 <br />" +
                                      "Account:  25080785 <br />" +
                                      "Address:<br />" +
                                      "         160-166 High Street Kensington <br />" +
                                      "         London W8 7RG <br /><br />Note: Swiss Bank Account details will follow.";

                if (model.Type == "Growth Token")
                {
                    _accountInfo = "Please now transfer <strong>" + model.Amount + " " + model.Mode + "</strong> to the account given below:<br />Account Name: Centre for Citizenship, Enterprise and Governance Limited <br />" +
                                   "Bank: Metro Bank <br />" +
                                   "International Bank Account Number:GB46MYMB23058026958547  <br />" +
                                   "SWIFT:  MYMBGB2L </br />" +
                                   "Sort Code:  23-05-80 <br />" +
                                   "Account:  26958547 <br />" +
                                   "Address:<br />" +
                                   "         160-166 High Street Kensington <br />" +
                                   "         London W8 7RG <br />";
                }

                if (model.Type == "Womens Coin")
                {
                    _accountInfo = "Please now transfer <strong>" + model.Amount + " " + model.Mode + "</strong> to the account given below:<br />Account Name: Centre for Citizenship, Enterprise and Governance Limited <br />" +
                                   "Bank: Metro Bank <br />" +
                                   "International Bank Account Number:  GB88MYMB23058026958725 <br />" +
                                   "SWIFT:  MYMBGB2L </br />" +
                                   "Sort Code:  23-05-80 <br />" +
                                   "Account:  26958725 <br />" +
                                   "Address:<br />" +
                                   "         160-166 High Street Kensington <br />" +
                                   "         London W8 7RG <br />";
                }

                if (model.Type == "Student Coin")
                {
                    _accountInfo = "Please now transfer <strong>" + model.Amount + " " + model.Mode + "</strong> to the account given below:<br />Account Name: Seratio Limited <br />" +
                                   "Bank: NatWest Bank <br />" +
                                   "International Bank Account Number:  GB63NWBK53613365953533 <br />" +
                                   "SWIFT:  NWBKGB2L </br />" +
                                   "Sort Code:  53-61-33 <br />" +
                                   "Account:  65953533 <br />" +
                                   "Address:<br />" +
                                   "         18 High Street, Kettering <br />" +
                                   "         Northamptonshire, NN16 8SZ<br />";
                }

                if (model.Type == "TimeTraveler Coin")
                {
                    _accountInfo = "Please now transfer <strong>" + model.Amount + " " + model.Mode + "</strong> to the account given below:<br /><br />" +
                                   "Lloyds Bank Plc<br />Oldham Branch<br />PO Box 1000<br />BX1 1LT<br />UK<br /><br />For UK<br />Sort Code:<br />30 -96-26<br /><br />Account:<br />35379668<br /><br />For International<br /><br />BIC:<br />LOYDGB21446<br /><br />IBAN:<br />GB44 LOYD 3096 2635 3796 68 ";
                }

                switch (model.Mode)
                {
                    case "Bitcoin":
                        _accountInfo = $"Now you need to transfer <b>{model.Amount}</b> Bitcoin to the account given below;<br />Wallet Address: {_bitcoinWalletAddress}<br />Following your payment, Please update your \"Investments\" page by clicking \"Update\" on the investment to insert your Wallet Address.<br />Please proceed to the Investments (side menu) to update and track the status of your investment.";
                        break;
                    case "Ethereum":
                        _accountInfo = $"Now you need to transfer <b>{model.Amount}</b> Ethereum to the account given below;<br />Wallet Address: {_etherWalletAddress}<br />Following your payment, Please update your \"Investments\" page by clicking \"Update\" on the investment to insert your Wallet Address. <br />Please proceed to the Investments (side menu) to update and track the status of your investment.";
                        break;
                    case "Card":
                        _accountInfo =
                            $"<br/>Your requested  investment amount is noted as  £{model.Amount}<br/><br/>If your payment has already been processed by credit/debit card by the Growth Token team, then your investment will be confirmed once the funds are received by CCEG (usually within 3 days). <br/>Please note your investment will then be complete and not be reversible as per the terms and conditions,<br/><br/>If your payment has not already been made via the Growth Token team,<br/> then please contact us with your ID reference for further instructions of how to pay.";

                        break;
                }

                if (model.Mode != "Card")
                {
                    _body =
                        $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br />Thank you for participating in the {ICOType} ICO. Your Token ID reference number for the same is: {model.Token}.<br /><br />Also, please update the investment with the corresponding Wallet Address (if you make a cryptocurrency contribution) or Bank Payment Reference you have quoted in your bank transfer (ideally your token ID) (if you make a fiat (money) contribution).<br /><br/>{_accountInfo}<br /><br/>Regards,<br/>CCEG and {model.Type}<br/>";
                }
                else
                {
                    _body =
                        $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br />Thank you for participating in the {ICOType} ICO. Your Token ID reference number for the same is: {model.Token}.<br /><br/>{_accountInfo}<br /><br/>Regards,<br/>CCEG and {model.Type}<br/>";
                }

                List<string> _attachments = new List<string>();

                if (model.Type == "Growth Token")
                {
                    _attachments.Add(Server.MapPath("/files/Growth Token private placement memorandum (7 Feb 2018).pdf"));
                }
                else if (model.Type == "Womens Coin")
                {
                    _attachments.Add(Server.MapPath("/files/Women's Coin private placement memorandum (12 March 2018).pdf"));
                }

                AppManager.SendEmail("New Investment - Seratio Platform", _user.Email, _body, _topImage, null, _attachments, _footerImage);

                return View("WalletInfo", model);
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contains invalid value. Please try again later.");
            return View(model);
        }


        public async Task<ActionResult> Delete(int ID)
        {
            Investment _investment = await db.Investments.FindAsync(ID);

            if (_investment != null)
            {
                //_investment.DeletedOn = DateTime.Now;
                //_investment.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested Investment has been deleted successfully.");
                await db.SaveChangesAsync();
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> UpdateReferenceNumber(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Investment _investment = await db.Investments.FindAsync(ID);

            if (_investment == null)
            {
                return HttpNotFound();
            }
            if (_investment.UserID != AppManager.User.ID)
            {
                return HttpNotFound();
            }

            if (_investment.TxReferenceNumber != null)
            {
                TempData["Notification"] = new Notification("Error",
                    "Transaction Reference Number already exist.");

                return RedirectToAction("Index");
            }


            return View(_investment);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> UpdateReferenceNumber(Investment model)
        {
            Investment _investment = await db.Investments.FirstOrDefaultAsync(i => i.ID == model.ID && i.UserID == AppManager.User.ID);

            if (_investment != null)
            {
                if (_investment.Mode == "Bitcoin" || _investment.Mode == "Ethereum" || _investment.Mode == "Litecoin" ||
                    _investment.Mode == "Ethereum Classic")
                {
                    string _formatOne = @"^[A-Fa-f0-9]{64}$";
                    string _formatTwo = @"^[0x]{2}[A-Fa-f0-9]{64}$";

                    if (_investment.Mode == "Bitcoin")
                    {
                        _formatOne = @"^[13][a-zA-Z0-9]{27,34}$";
                        _formatTwo = @"^[a-zA-Z0-9]{42}$";
                    }
                    if (_investment.Mode == "Ethereum")
                    {
                        _formatOne = @"^0x[a-fA-F0-9]{40}$";
                        _formatTwo = @"^0x[a-fA-F0-9]{40}$";
                    }

                    Regex _formatOneValidator = new Regex(_formatOne);
                    Regex _formatTwoValidator = new Regex(_formatTwo);

                    if (!_formatOneValidator.IsMatch(model.TxReferenceNumber) && !_formatTwoValidator.IsMatch(model.TxReferenceNumber))
                    {
                        TempData["Notification"] = new Notification("Error",
                                "The numbers and characters (your wallet address of the cryptocurrency you used to make investment) that you have entered is not valid. Please make sure that you are using the full (long) hash of your public wallet.");
                        return RedirectToAction("Index");
                    }
                }
                //else
                //{
                //    string _regexfiat = @"^[A-Za-z0-9]{16}$";
                //    Regex refiat = new Regex(_regexfiat);

                //    if (!refiat.IsMatch(model.TxReferenceNumber))
                //    {
                //        TempData["Notification"] = new Notification("Error",
                //            "The transaction reference number that you have entered is not valid. Please try again later.");
                //        return RedirectToAction("Index");
                //    }

                //}

                if (_investment.TxReferenceNumber == null)
                {
                    _investment.TxReferenceNumber = model.TxReferenceNumber;
                    _investment.LastUpdatedOn = DateTime.Now;
                    _investment.TxRefNoUpdatedOn = DateTime.Now;
                    _investment.Status = "Waiting for Confirmation";
                    _investment.LastUpdatedOn = DateTime.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success",
                        "You have updated the requested investment successfully. We will update the status when the payment is confirmed as received.");
                    User _user = await db.Users.FindAsync(AppManager.User.ID);

                    string _body = String.Empty;
                    string _topImage = string.Empty;

                    _body =
                       $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br />Thank you for confirming the payment has been made for your investment ({_investment.Token}).<br /><br />We shall review your payment with our account in the next 24 hours and will update the status when the payment is confirmed as received.<br />Please note at busy times, cryptocurrency transfers may take several hours to be completed and cross-border bank transfers longer depending on the banking system in question. In the event of a delay, we will review the position daily.<br /><br/>Regards,<br/>CCEG and {_investment.Type}<br/>";

                    switch (_investment.Type)
                    {
                        case "Seratio Coin":
                            _topImage = "**************logo.jpg";
                            break;
                        case "Womens Coin":
                            _topImage = "womenscoinlogov2.png";
                            break;
                        case "Student Coin":
                            _topImage = "studentcoin.png";
                            break;
                        case "Growth Token":
                            _topImage = "10xtokenlogo.png";
                            break;
                        case "TimeTraveler Coin":
                            _topImage = "timetraveler.png";
                            break;
                    }

                    AppManager.SendEmail("Your Investment has been updated- Seratio Platform", _user.Email, _body, _topImage);

                    if (!Request.IsLocal)
                    {
                        _body =
                            $"Hello,<br /><br />The user {_user.Email} has updated the Transaction details for the investment ({_investment.Token}).<br />Please login to the back-end to confirm the same.<br /><br/>Regards,<br/>CCEG and {_investment.Type}<br/>";

                        AppManager.SendEmail("New Investment Update - Seratio Platform", "sajin.abdu@seratio.com", _body, _topImage);
                        AppManager.SendEmail("New Investment Update - Seratio Platform", "maryam.taghiyeva@cceg.org.uk", _body, _topImage);
                    }
                }
                else
                {
                    TempData["Notification"] = new Notification("Error",
                        "Transaction Reference Number already exist.");
                }

                return RedirectToAction("Index");
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
        }

        [AllowAnonymous]
        public async Task<ActionResult> Receipt(int ID)
        {
            Investment _investment = await db.Investments.FindAsync(ID);

            if (_investment == null)
            {
                return HttpNotFound();
            }

            if (AppManager.Administrator != null)
            {
                if (await db.Administrators.AnyAsync(i => i.ID == AppManager.Administrator.ID))
                {
                    return View(_investment);
                }
            }
            else if (AppManager.User != null)
            {
                if (_investment.UserID == AppManager.User.ID)
                {
                    return View(_investment);
                }
            }
            return HttpNotFound();
        }

        [AllowAnonymous]
        public async Task<ActionResult> PrintReceipt(int id)
        {

            Investment _investment = await db.Investments.FindAsync(id);

            if (_investment == null)
            {
                return HttpNotFound();
            }

            if (AppManager.Administrator != null)
            {
                if (!await db.Administrators.AnyAsync(i => i.ID == AppManager.Administrator.ID))
                {
                    return HttpNotFound();
                }
            }
            else if (AppManager.User != null)
            {
                if (_investment.UserID != AppManager.User.ID)
                {
                    return HttpNotFound();
                }
            }

            string _url = AppManager.AppURL + "/users/investments/receipt/?ID=" + id + "&id=" + id;
            string _path = Server.MapPath("~//Print//SER-ICO-RCP-" + Guid.NewGuid().ToString() + ".pdf");
            string _file = await AppManager.SavePDF(_url, _path);
            FileStream fs = new FileStream(_path, FileMode.Open, FileAccess.Read);
            MemoryStream ms = new MemoryStream();

            fs.CopyTo(ms);

            return File(ms.ToArray(), "application/x-pdf", "SER-ICO-RCP-" + id + ".pdf");

            //        document.Info.Title = "Created with PDFsharp";

            //// Writing the workbook content to the FileStream...
            //templateWorkbook.Write(ms);

            //    return Redirect("/print/" + _file);
        }

        private bool IsPrivateIP(string ipAddress)
        {
            int[] _ipParts = ipAddress.Split(new String[] { "." }, StringSplitOptions.RemoveEmptyEntries)
                .Select(s => int.Parse(s)).ToArray();

            if (_ipParts[0] == 10 ||
                (_ipParts[0] == 192 && _ipParts[1] == 168) ||
                (_ipParts[0] == 172 && (_ipParts[1] >= 16 && _ipParts[1] <= 31)))
            {
                return true;
            }

            return false;
        }

        public async Task<ActionResult> Download(int ID)
        {
            return HttpNotFound();
        }

    }
}

