using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using System.Web;
using System.Web.Mvc;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Areas.L0C5A3E8915871B710C2CC98073748424.Controllers
{
    public class WalletsController : BackendBaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from i in db.Wallets
                         join u in db.Users on i.UserID equals u.ID
                         join a in db.Administrators on i.CreatedByID equals a.ID
                         where i.IsDataActive
                         select new
                         {
                             i.ID,
                             i.Address,
                             i.WalletFile,
                             i.WalletHTMLFile,
                             i.WalletImageFile,
                             i.LastUpdatedOn,
                             i.CreatedByID,
                             u.LastName,
                             u.Title,
                             u.FirstName,
                             a.Name,
                             u.Email,
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
                _query = _query.Where(u => u.LastUpdatedOn.ToString().Contains(request.sSearch) || u.Address.Contains(request.sSearch) || u.Email.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.Email) : _query.OrderByDescending(i => i.Email);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.Address) : _query.OrderByDescending(i => i.Address);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(i => i.LastUpdatedOn) : _query.OrderByDescending(i => i.LastUpdatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(i => i.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add(_rowData.Email);
                _row.Add(_rowData.Address);
                _row.Add(@"<a href='/uploads/" + _rowData.WalletFile + "' target=_blank>Download</a>");
                _row.Add(@"<a href='/uploads/" + _rowData.WalletHTMLFile + "' target=_blank>Download</a>");
                _row.Add(@"<a href='/uploads/" + _rowData.WalletImageFile + "' target=_blank>Download</a>");
                _row.Add(_rowData.LastUpdatedOn.ToString());
                _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/wallets/details/" + _rowData.ID + "' title='Details' class='mr5'><i class='icon-magazine'></i></a>");

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

            Wallet _wallet = await db.Wallets.FindAsync(ID);

            if (_wallet == null)
            {
                return HttpNotFound();
            }

            return View(_wallet);
        }

        public ActionResult Create(int id)
        {
            ViewBag.ID = id;
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Create(Wallet model, HttpPostedFileBase json, HttpPostedFileBase image, HttpPostedFileBase html)
        {
            if (ModelState.IsValid)
            {
                string _jsonfilename = null;
                string _htmlfilename = null;
                string _imagefilename = null;

                if (json != null)
                {
                    _jsonfilename = Path.GetFileName(json.FileName);

                    if (System.IO.File.Exists(Path.Combine(Server.MapPath("~/Uploads"), _jsonfilename)))
                    {
                        _jsonfilename = Guid.NewGuid().ToString() + Path.GetExtension(json.FileName);
                    }

                    var _pathforjson = Path.Combine(Server.MapPath("~/Uploads"), _jsonfilename);
                    json.SaveAs(_pathforjson);

                    model.WalletFile = _jsonfilename;
                }

                if (html != null)
                {
                    _htmlfilename = Path.GetFileName(html.FileName);

                    if (System.IO.File.Exists(Path.Combine(Server.MapPath("~/Uploads"), _htmlfilename)))
                    {
                        _htmlfilename = Guid.NewGuid().ToString() + Path.GetExtension(html.FileName);
                    }

                    var _pathforhtml = Path.Combine(Server.MapPath("~/Uploads"), _htmlfilename);
                    html.SaveAs(_pathforhtml);

                    model.WalletHTMLFile = _htmlfilename;
                }


                if (image != null)
                {
                    _imagefilename = Path.GetFileName(image.FileName);

                    if (System.IO.File.Exists(Path.Combine(Server.MapPath("~/Uploads"), _imagefilename)))
                    {
                        _imagefilename = Guid.NewGuid().ToString() + Path.GetExtension(image.FileName);
                    }

                    var _pathforimage = Path.Combine(Server.MapPath("~/Uploads"), _imagefilename);
                    image.SaveAs(_pathforimage);

                    model.WalletImageFile = _imagefilename;
                }

                model.CreatedOn = DateTime.Now;
                model.LastUpdatedOn = DateTime.Now;
                model.CreatedByID = AppManager.Administrator.ID;
                model.IsDataActive = true;

                db.Wallets.Add(model);
                await db.SaveChangesAsync();

                List<Investment> _investments = await db.Investments
                    .Where(i => i.UserID == model.UserID &&
                                (i.Status == "Waiting for Wallet to be ready" || i.Status == "Confirmed"))
                    .ToListAsync();

                foreach (Investment _item in _investments)
                {
                    var _investment = await db.Investments.FirstOrDefaultAsync(i => i.ID == _item.ID);

                    if (_investment != null)
                    {
                        _investment.Status = "Wallet Created";

                        await db.SaveChangesAsync();
                    }
                }
                string _image = string.Empty;

                User _user = await db.Users.FindAsync(model.UserID);

                //if (_investment.Type != null)
                //{
                //    _body = $"Hello {_investment.User.Title} {_investment.User.FirstName} {_investment.User.LastName},<br /><br />Your {_investment.Type} ICO Investment with the reference number {_investment.Token} has been confirmed by the ICO Operator.<br />Sign in to your Dashboard to download the receipt. Please note that <b>{_investment.Type}</b> will be minted to the <b>Seratio Wallets</b> only on <b>31<sup>st</sup> January 2018</b>. <b>Microshares tokens</b> will be issued on <b>30<sup>th</sup> April 2018</b>. Therefore,<br />it is important you <b>keep your password and your wallet file safe</b> to access your {_investment.Type} tokens. The funds cannot be restored if one of the above is lost.<br /><br/>Regards,<br/>CCEG and {_investment.Type}<br/>";
                //}
                //else
                //{
                //    _body = $"Hello {_investment.User.Title} {_investment.User.FirstName} {_investment.User.LastName},<br /><br />Your {_investment.Type} ICO Investment with the reference number {_investment.Token} has been confirmed by the ICO Operator.<br />Sign in to your Dashboard to download the receipt. Please note that <b>{_investment.Type}</b> will be minted to the <b>Seratio Wallets</b> only on <b>31<sup>st</sup> January 2018</b>. <b>Microshares tokens</b> will be issued on <b>30<sup>th</sup> April 2018</b>. Therefore,<br />it is important you <b>keep your password and your wallet file safe</b> to access your {_investment.Type} tokens. The funds cannot be restored if one of the above is lost.<br /><br/>Regards,<br/>CCEG<br/>";

                //}

                string _body = $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br />Your Seratio Platform ICO Wallet is ready.<br />Please sign in to the member's area to download it.<br/><br/>Regards,<br/>CCEG<br/>";
                AppManager.SendEmail("Your Seratio ICO Wallet is ready", _user.Email, _body, _image);

                TempData["Notification"] = new Notification("Success", "Wallet has been created successfully.");
                return RedirectToAction("Index");
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contains invalid value. Please try again later.");
            return View(model);
        }

        public async Task<ActionResult> Edit(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Wallet _wallet = await db.Wallets.FindAsync(ID);

            if (_wallet == null)
            {
                return HttpNotFound();
            }

            return View(_wallet);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(Wallet model)
        {
            if (ModelState.IsValid)
            {
                Wallet _wallet = await db.Wallets.FindAsync(model.ID);

                if (_wallet != null)
                {
                    _wallet.Address = model.Address;
                    _wallet.WalletFile = model.WalletFile;
                    _wallet.WalletHTMLFile = model.WalletHTMLFile;
                    _wallet.WalletImageFile = model.WalletImageFile;
                    _wallet.Administrator.Email = model.Administrator.Email;
                    _wallet.User.Title = model.User.Title;
                    _wallet.LastUpdatedOn = DateTime.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Wallet has been saved successfully.");
                    return RedirectToAction("Index");
                }
                else
                {
                    return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
                }
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contains invalid value. Please try again later.");
            return View(model);
        }

        public async Task<ActionResult> Delete(int ID)
        {
            Wallet _wallet = await db.Wallets.FindAsync(ID);

            if (_wallet != null)
            {
                _wallet.DeletedOn = DateTime.Now;
                _wallet.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested Wallet has been deleted successfully.");
                await db.SaveChangesAsync();
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }
    }
}

