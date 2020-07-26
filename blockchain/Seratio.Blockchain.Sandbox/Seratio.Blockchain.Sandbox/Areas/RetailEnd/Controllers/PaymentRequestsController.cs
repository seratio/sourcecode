using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using QRCoder;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Utilities;

namespace Seratio.Blockchain.Sandbox.Areas.RetailEnd.Controllers
{
    public class PaymentRequestsController : BaseController
    {
        // GET: Wallets/PaymentRequests
        public ActionResult Index()
        {
            return View();
        }

        public ActionResult New(int senderID, int payerID, int requestID)
        {
            string _qrData = $"{requestID}|{senderID}|{payerID}";

            using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
            {
                using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode(_qrData, QRCodeGenerator.ECCLevel.Q))
                {
                    using (QRCode _qrCode = new QRCode(_qrCodeData))
                    {
                        Bitmap _image = _qrCode.GetGraphic(20, "#0067a3", "#ffffff");

                        byte[] _bytes;

                        using (MemoryStream _ms = new MemoryStream())
                        {
                            _image.Save(_ms, ImageFormat.Jpeg);
                            _bytes = _ms.ToArray();
                        }

                        ViewBag.QRCode = Convert.ToBase64String(_bytes);
                    }
                }
            }

            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request)
        {
            var _query = from r in db.PaymentRequests
                         select new
                         {
                             r.ID,
                             r.Coin.Symbol,
                             r.Coin.NumberOfDecimals,
                             r.Amount,
                             r.Type,
                             r.Status,
                             r.CreatedOn,
                             r.RequestedByID,
                             r.PayerID,
                             RequestedBy = r.User.WalletAddress,
                             Payer = r.User1.WalletAddress,
                             r.WalletTransactionID
                         };

            if (!AppManager.User.IsSuperAdmin)
            {
                _query = _query.Where(i => i.RequestedByID == AppManager.User.ID || i.PayerID == AppManager.User.ID);
            }

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(w => w.Type.Contains(request.sSearch) || w.Status.Contains(request.sSearch) || w.RequestedBy.Contains(request.sSearch) || w.Payer.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(w => w.Amount) : _query.OrderBy(w => w.Amount);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(w => w.RequestedBy) : _query.OrderByDescending(r => r.RequestedBy);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(w => w.Payer) : _query.OrderBy(w => w.Payer);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(w => w.Status) : _query.OrderByDescending(w => w.Status);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(w => w.CreatedOn) : _query.OrderBy(w => w.CreatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(r => r.ID);
                    break;
            }

            int _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                string _status = string.Empty;

                switch (_rowData.Status)
                {
                    case "Pending":
                        _status = "<span class=\"label bg-grey-300\">Pending</span>";
                        break;
                    case "Paid":
                        _status = "<span class=\"label bg-success\">Paid</span>";
                        break;
                    default:
                        break;
                }

                _row.Add($"{decimal.Round(_rowData.Amount, _rowData.NumberOfDecimals, MidpointRounding.AwayFromZero)} {_rowData.Symbol}<br />{_status}");
                _row.Add($"<span class='tooltipster' title='{_rowData.RequestedBy}'>{_rowData.RequestedBy.Ellipsisfy()}</span>");
                _row.Add($"<span class='tooltipster' title='{_rowData.Payer}'>{_rowData.Payer.Ellipsisfy()}</span>");
                _row.Add(_rowData.CreatedOn.ToString());

                if (_rowData.Status == "Pending" && _rowData.PayerID == AppManager.User.ID)
                {
                    _row.Add(@"<a class='btn btn-primary' title='Details' href='/wallet/wallets/seratiowallet/pay/" +
                             _rowData.ID + "'>Pay Now</a>");
                }
                else
                {
                    if (_rowData.WalletTransactionID != null)
                    {
                        _row.Add($"<a href='/wallet/wallets/seratiowallet/details/" + _rowData.WalletTransactionID +
                                 "'>View</a>");
                    }
                    else
                    {
                        _row.Add("Pending");
                    }
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