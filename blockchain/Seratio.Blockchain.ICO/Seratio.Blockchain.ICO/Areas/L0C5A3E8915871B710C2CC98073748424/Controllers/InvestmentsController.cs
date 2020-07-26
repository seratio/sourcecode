using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Globalization;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using System.Web;
using System.Web.Hosting;
using System.Web.Mvc;
using ClosedXML.Excel;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Core.Security;
using Seratio.Platform.ICO.Core.Utilities;
using Seratio.Platform.ICO.Models;
using System.Text.RegularExpressions;

namespace Seratio.Platform.ICO.Areas.L0C5A3E8915871B710C2CC98073748424.Controllers
{
    [AuthorizeBackendAccess]
    public class InvestmentsController : BackendBaseController
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
                             u.Title,
                             u.FirstName,
                             u.LastName,
                             i.Token,
                             u.Email,
                             i.CampaignCode,
                             i.Type,
                             i.HasTransferred,
                             i.TokenAmount,
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

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(u => u.LastUpdatedOn.ToString().Contains(request.sSearch) || u.InitializedOn.ToString().Contains(request.sSearch) || u.Type.ToString().Contains(request.sSearch) || u.Mode.Contains(request.sSearch) || u.Amount.ToString().Contains(request.sSearch) || u.Token.ToString().Contains(request.sSearch) || u.Status.Contains(request.sSearch) || u.TxReferenceNumber.ToString().Contains(request.sSearch) || u.Email.Contains(request.sSearch) || u.CampaignCode.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.Email) : _query.OrderByDescending(i => i.Email);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.Type) : _query.OrderByDescending(i => i.Type);
                    break;
                case 5:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.Status) : _query.OrderByDescending(i => i.Status);
                    break;
                case 6:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.InitializedOn) : _query.OrderByDescending(i => i.InitializedOn);
                    break;
                case 7:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.CampaignCode) : _query.OrderByDescending(i => i.CampaignCode);
                    break;
                default:
                    _query = _query.OrderByDescending(u => u.ID);
                    break;
            }


            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();
                string _statusHtml = "";
                _row.Add($"<a href='/L0C5A3E8915871B710C2CC98073748424/investments/details/{ _rowData.ID }' title='Details'>{_rowData.Token}</a>");
                _row.Add(_rowData.Email);
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

                _row.Add(_rowData.TxReferenceNumber);

                switch (_rowData.Status)
                {
                    case "Waiting for transaction reference number":
                    case "Waiting for you to update your payment reference":
                        _statusHtml = $"<span class=\"label label-default\">Waiting for you to update your payment reference</span> [<a class='confirm' data-confirm='Please confirm your action as this could only be done once?' href='/L0C5A3E8915871B710C2CC98073748424/investments/updatereferencenumber/{ _rowData.ID }' title='Confirm using your wallet (Tx hash/Tx ID) or Bank Reference (UTRN)'>Update</a>]";

                        break;
                    case "Waiting for Confirmation":
                        _statusHtml = $"<span class=\"label label-primary\">Waiting for Confirmation</span> [<a href='/L0C5A3E8915871B710C2CC98073748424/investments/confirm/{ _rowData.ID }' title='Add Wallet Password Phrase' class='confirm' data-confirm='Are you sure want to confirm this Investment? '>Confirm</a>]";
                        break;
                    case "Waiting for Wallet to be ready":
                    case "Confirmed":
                        _statusHtml = $"<span class=\"label label-success\">Confirmed</span>";
                        break;
                    //if (_rowData.WalletPassPhrase != null)
                    //{
                    //    _statusHtml = $"<span class=\"label label-success\">Confirmed and Waiting for Wallet to be ready</span>  [<a href='/L0C5A3E8915871B710C2CC98073748424/wallets/create/{ _rowData.UserID }' title='Create Wallet'>Update</a>] [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' title='Add Wallet Password Phrase'>Download Receipt</a>]";

                    //}
                    //else
                    //{
                    //    _statusHtml = $"<span class=\"label label-success\">Waiting For Wallet Pass Phrase</span>  [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' title='Add Wallet Password Phrase'>Download Receipt</a>]";
                    //}
                    //break;

                    //case "Waiting for Wallet to be ready":
                    //    _statusHtml = $"<span class=\"label label-success\">Waiting for Wallet to be ready</span> [<a href='/L0C5A3E8915871B710C2CC98073748424/wallets/create/{ _rowData.UserID }' title='Create Wallet'>Update</a>] [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' title='Add Wallet Password Phrase'>Download Receipt</a>]";
                    //    break;
                    //case "Wallet Created":
                    //    _statusHtml = $"<span class=\"label label-success\">Wallet Created </span> [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' title='Add Wallet Password Phrase'>Download Receipt</a>]";
                    //    break;
                    case "Rejected":
                        _statusHtml = "<span class=\"label label-danger\">Rejected</span>";
                        break;
                    //case "Coins Issued":
                    //    _statusHtml = $"<span class=\"label label-info\">Coins Issued</span> [<a href='/users/investments/printreceipt/{ _rowData.ID }' target='_blank' title='Add Wallet Password Phrase'>Download Receipt</a>]";
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

                if (!string.IsNullOrEmpty(_rowData.CampaignCode))
                {
                    _row.Add(_rowData.CampaignCode);
                }
                else
                {
                    _row.Add("-");
                }

                string _optionsText =
                    @"<a class='confirm' data-confirm='Are you sure you want to Reject this Investment?' href='/L0C5A3E8915871B710C2CC98073748424/investments/reject/" +
                    _rowData.ID + "' title='Reject'>Reject</a> ";

                if (_rowData.Type == "Growth Token" && _rowData.Status == "Confirmed" &&
                    _rowData.HasTransferred != true)
                {
                    _optionsText += @" | <a class='confirm' data-confirm='Are you sure you want to mark this Investment as transferred?' href='/L0C5A3E8915871B710C2CC98073748424/investments/transfer/" +
                                    _rowData.ID + "' title='Mark as Transferred'>Mark as Transferred</a> ";
                }
                _row.Add(_optionsText);

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

        public async Task<ActionResult> Transfer(int ID)
        {
            Investment _investment = await db.Investments.FindAsync(ID);

            if (_investment != null)
            {
                _investment.HasTransferred = true;
                _investment.LastUpdatedByID = AppManager.Administrator.ID;

                TempData["Notification"] = new Notification("Success", "Requested Investment has been successfully marked as Transferred.");
                await db.SaveChangesAsync();

                string _body = string.Empty;
                string _topImage = string.Empty;

                _body =
                    $"Dear {_investment.User.FirstName},<br /><br /> Your {_investment.ReceivedAmount} SER Tokens have now been transferred to the Growth Token CryptoFund and will be managed as part of the CryptoBasket of Currencies as per your private placement agreement with the Easy Access Crypto Company Ltd.<br /><br />You will receive updates on the progress of that Cryptofund directly from The Easy Access Crypto Company Ltd.<br /><br />We will write to you separately to enable you to become a registered shareholder in Golgotharism Ltd, the Social Enterprise Vehicle.<br /><br />Thank you for participating in the Growth Token Fund-raise. Please get back to us if you require any further assistance.<br /><br />CCEG Blockchain Team";

                switch (_investment.Type)
                {
                    case "Growth Token":
                        _topImage = "ser_10x1.png";
                        break;
                }

                AppManager.SendEmail($"Status update of your {_investment.Type} Investment", _investment.User.Email, _body, _topImage, null, null, "logo.png", "template1.html");
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

            Investment _investment = await db.Investments.FindAsync(ID);

            if (_investment == null)
            {
                return HttpNotFound();
            }

            return View(_investment);
        }

        public async Task<ActionResult> Reject(int ID)
        {
            Investment _investment = await db.Investments.FindAsync(ID);

            if (_investment != null)
            {
                _investment.RejectedOn = DateTime.Now;
                _investment.Status = "Rejected";
                _investment.LastUpdatedByID = AppManager.Administrator.ID;

                TempData["Notification"] = new Notification("Success", "Requested Investment has been rejected successfully.");
                await db.SaveChangesAsync();

                string _body = string.Empty;
                string _topImage = string.Empty;

                if (_investment.Type != null)
                {
                    _body = $"Hello {_investment.User.Title} {_investment.User.FirstName} {_investment.User.LastName},<br /><br />Your {_investment.Type} ICO investment with the reference number {_investment.Token} has been rejected by the Platform Operator.<br /><br/>Regards,<br/>CCEG and {_investment.Type}<br/>";

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
                }
                else
                {
                    _body = $"Hello {_investment.User.Title} {_investment.User.FirstName} {_investment.User.LastName},<br /><br />Your {_investment.Type} ICO investment with the reference number {_investment.Token} has been rejected by the Platform Operator.<br /><br/>Regards,<br/>CCEG<br/>";
                }

                AppManager.SendEmail($"Status update of your {_investment.Type} Investment", _investment.User.Email, _body, _topImage);
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Confirm(int ID)
        {
            Investment _investment = await db.Investments.FindAsync(ID);

            return View(_investment);
        }

        [HttpPost]
        public async Task<ActionResult> Confirm(Investment model)
        {
            Investment _investment = await db.Investments.FindAsync(model.ID);

            if (_investment != null)
            {
                _investment.Status = "Confirmed";
                _investment.ConfirmedOn = DateTime.Now;
                _investment.Comments = model.Comments;
                _investment.TokenAmount = model.TokenAmount;
                _investment.ExchangeRate = model.ExchangeRate;
                _investment.ReceivedAmount = model.ReceivedAmount;
                _investment.LastUpdatedByID = AppManager.Administrator.ID;

                TempData["Notification"] = new Notification("Success", "Requested Investment has been confirmed successfully.");
                await db.SaveChangesAsync();
                string _body = string.Empty;
                string _topImage = string.Empty;

                _body = $"Hello {_investment.User.Title} {_investment.User.FirstName} {_investment.User.LastName},<br /><br />Your {_investment.Type} ICO Investment with the reference number {_investment.Token} has been confirmed by the Platform Operator.<br /><br />Please sign in to your Dashboard to download the receipt.<br /><br/>Regards,<br/>CCEG and {_investment.Type}<br/>";

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

                AppManager.SendEmail($"Status update of your Seratio {_investment.Type} Investment", _investment.User.Email, _body, _topImage);
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }

        public async Task<FileStreamResult> Export(string type)
        {
            string _file = Server.MapPath(await GenerateExcelFile(type));
            return File(System.IO.File.OpenRead(_file), MimeMapping.GetMimeMapping(_file), System.IO.Path.GetFileName(_file));
        }

        private async Task<string> GenerateExcelFile(string type)
        {

            if (type == "seratio")
            {
                type = "Seratio Coin";
            }
            else if (type == "womenscoin")
            {
                type = "Womens Coin";
            }
            else if (type == "studentcoin")
            {
                type = "Student Coin";
            }
            else if (type == "10xgrowth")
            {
                type = "Growth Token";
            }
            else if (type == "ttc")
            {
                type = "TimeTraveler Coin";
            }


            var _query = from i in db.Investments
                         join u in db.Users on i.UserID equals u.ID
                         where i.Type == type
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
                             u.Title,
                             u.FirstName,
                             i.ReceivedAmount,
                             u.LastName,
                             i.Token,
                             u.Email,
                             i.ExchangeRate,
                             i.ConfirmedOn,
                             i.RejectedOn,
                             i.OriginalExchangeRate,
                             i.UserSessionID,
                             i.UserSession,
                             i.CampaignCode,
                             i.InvestmentType,
                             i.TokenAmount,
                             i.Type,
                             u.Phone,
                             u.ReferralSource,
                             i.HasTransferred,
                             u.PostalCode
                         };


            var _data = await _query.OrderByDescending(o => o.ID).ToListAsync();

            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {

                DataTableRow _row = new DataTableRow();

                _row.Add(_rowData.Title);
                _row.Add($"{_rowData.FirstName} {_rowData.LastName}");
                _row.Add(_rowData.Email);
                _row.Add(_rowData.Phone);
                _row.Add(_rowData.Mode);
                _row.Add(_rowData.Type);
                _row.Add(_rowData.Amount);
                _row.Add(_rowData.Token);

                if (_rowData.UserSessionID != null)
                {
                    _row.Add(_rowData.UserSession.IPAddress);
                }
                else
                {
                    _row.Add("N/A");
                }

                _row.Add(_rowData.CampaignCode);

                if (_rowData.InvestmentType != null)
                {
                    _row.Add(_rowData.InvestmentType);
                }
                else
                {
                    _row.Add("N/A");
                }

                _row.Add(_rowData.InitializedOn.ToString());

                if (_rowData.OriginalExchangeRate != null)
                {
                    _row.Add(String.Format("'{0:0.0000000}", _rowData.OriginalExchangeRate.ToString()));
                }
                else
                {
                    _row.Add("N/A");
                }

                if (_rowData.TxReferenceNumber != null)
                {
                    _row.Add(_rowData.TxReferenceNumber);
                }
                else
                {
                    _row.Add("Pending");
                }

                if (_rowData.ConfirmedOn != null)
                {
                    _row.Add(_rowData.ConfirmedOn);
                }
                else
                {
                    _row.Add("Pending");
                }
                if (_rowData.ConfirmedOn != null)
                {
                    _row.Add(_rowData.ReceivedAmount.ToString());
                }
                else
                {
                    _row.Add("Pending");
                }

                if (_rowData.ExchangeRate != null)
                {
                    _row.Add(String.Format("{0:0.00}", _rowData.ExchangeRate.ToString()));
                }
                else
                {
                    _row.Add("N/A");
                }

                string _statusHtml = "";

                if (_rowData.ConfirmedOn != null)
                {
                    _statusHtml = "Confirmed";
                }
                else
                {
                    if (_rowData.RejectedOn != null)
                    {
                        _statusHtml = "Rejected";
                    }
                    else
                    {
                        _statusHtml = "Pending";
                    }
                }

                if (_rowData.Type == "Growth Token" && _rowData.Status == "Confirmed" && _rowData.HasTransferred == true)
                {
                    _statusHtml = $"YOUR {_rowData.ReceivedAmount} SER TOKENS HAVE NOW BEEN TRANSFERRED TO THE GROWTH TOKEN CRYPTOFUND";
                }
                else if (_rowData.Type == "Growth Token" && _rowData.Status == "Confirmed")
                {
                    _statusHtml = "INVESTMENT CONFIRMED, PENDING TRANSFER TO THE GROWTH TOKEN CRYPTOFUND";
                }

                _row.Add(_statusHtml);

                if (!string.IsNullOrEmpty(_rowData.TokenAmount))
                {
                    _row.Add(_rowData.TokenAmount);
                }
                else
                {
                    _row.Add("N/A");
                }

                _row.Add(_rowData.ReferralSource);
                _row.Add(_rowData.PostalCode);

                _rows.Add(_row);
            }

            var _workbook = new XLWorkbook();
            var _worksheet = _workbook.Worksheets.Add("Investments");
            _worksheet.Cell("A1").Value = "Contributor (Title)";
            _worksheet.Cell("B1").Value = "Contributor (Name)";
            _worksheet.Cell("C1").Value = "Contributor (Email)";
            _worksheet.Cell("D1").Value = "Contributor (Phone)";

            _worksheet.Cell("E1").Value = "Contribution Type";
            _worksheet.Cell("F1").Value = "ICO Type";
            _worksheet.Cell("G1").Value = "Amount";
            _worksheet.Cell("H1").Value = "Token ID ";
            _worksheet.Cell("I1").Value = "IP Address";
            _worksheet.Cell("J1").Value = "Campaign code";
            _worksheet.Cell("K1").Value = "Token Type";
            _worksheet.Cell("L1").Value = "Contribution Requested On";
            _worksheet.Cell("M1").Value = "Original Exchange rate";
            _worksheet.Cell("N1").Value = "Transaction ID";
            _worksheet.Cell("O1").Value = "Contribution Received On";
            _worksheet.Cell("P1").Value = "Contribution Received Amount";
            _worksheet.Cell("Q1").Value = "Exchange Rate";
            _worksheet.Cell("R1").Value = "Confirmed";
            _worksheet.Cell("S1").Value = "Token Amount";
            _worksheet.Cell("T1").Value = "Referral Source";
            _worksheet.Cell("U1").Value = "Postal Address";

            int _rowIndex = 2;

            foreach (DataTableRow _row in _rows)
            {
                _worksheet.Cell("A" + _rowIndex).Value = _row.ElementAt(0);
                _worksheet.Cell("B" + _rowIndex).Value = _row.ElementAt(1);
                _worksheet.Cell("C" + _rowIndex).Value = _row.ElementAt(2);
                _worksheet.Cell("D" + _rowIndex).Value = "'" + _row.ElementAt(3);
                _worksheet.Cell("E" + _rowIndex).Value = "'" + _row.ElementAt(4);
                _worksheet.Cell("F" + _rowIndex).Value = _row.ElementAt(5);
                _worksheet.Cell("G" + _rowIndex).Value = _row.ElementAt(6);
                _worksheet.Cell("H" + _rowIndex).Value = _row.ElementAt(7);
                _worksheet.Cell("I" + _rowIndex).Value = _row.ElementAt(8);
                _worksheet.Cell("J" + _rowIndex).Value = _row.ElementAt(9);
                _worksheet.Cell("K" + _rowIndex).Value = _row.ElementAt(10);
                _worksheet.Cell("L" + _rowIndex).Value = _row.ElementAt(11);
                _worksheet.Cell("M" + _rowIndex).Value = _row.ElementAt(12);
                _worksheet.Cell("N" + _rowIndex).Value = "'" + _row.ElementAt(13);
                _worksheet.Cell("O" + _rowIndex).Value = "'" + _row.ElementAt(14);
                _worksheet.Cell("P" + _rowIndex).Value = _row.ElementAt(15);
                _worksheet.Cell("Q" + _rowIndex).Value = _row.ElementAt(16);
                _worksheet.Cell("R" + _rowIndex).Value = _row.ElementAt(17);
                _worksheet.Cell("S" + _rowIndex).Value = _row.ElementAt(18);
                _worksheet.Cell("T" + _rowIndex).Value = _row.ElementAt(19);
                _worksheet.Cell("U" + _rowIndex).Value = _row.ElementAt(20);

                _rowIndex++;
            }

            _worksheet.Row(1).Style.Font.Bold = true;
            _workbook.SaveAs(HostingEnvironment.MapPath($"/Exports/Investments_{type}.xlsx"));

            return $"/Exports/Investments_{type}.xlsx";
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
            Investment _investment = await db.Investments.FirstOrDefaultAsync(i => i.ID == model.ID && i.UserID == model.UserID);

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
                            "The transaction reference number that you have entered is not valid. Please make sure that you are using the full (long) hash of your transaction.");
                        return RedirectToAction("Index");
                    }
                }

                if (_investment.TxReferenceNumber == null)
                {
                    _investment.TxReferenceNumber = model.TxReferenceNumber;
                    _investment.LastUpdatedOn = DateTime.Now;
                    _investment.TxRefNoUpdatedOn = DateTime.Now;
                    _investment.Status = "Waiting for Confirmation";
                    _investment.LastUpdatedOn = DateTime.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success",
                        "Transaction Reference Number for the requested investment has been updated successfully.");
                    User _user = await db.Users.FindAsync(model.UserID);
                    string _body = string.Empty;
                    string _topImage = string.Empty;

                    _body =
                        $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br />Transaction Reference Number for your investment ({_investment.Token}) has been updated by the Platform Operator.<br /><br/>Regards,<br/>CCEG and {_investment.Type}<br/>";

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

                    AppManager.SendEmail("Your Investment has been updated - Seratio Platform", _user.Email, _body, _topImage);
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
    }
}



