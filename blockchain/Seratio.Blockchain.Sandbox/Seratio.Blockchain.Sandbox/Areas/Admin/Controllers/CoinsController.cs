using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using System.Globalization;
using System.IO;
using System.Threading.Tasks;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Admin.Controllers
{
    [AuthorizeAccess(RequireSuperAdmin = true)]
    public class CoinsController : BaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from c in db.Coins
                         join b in db.Blockchains on c.BlockchainID equals b.ID
                         join a in db.Users on c.UserID equals a.ID
                         where c.IsDataActive && !c.IsMCRCategory
                         select new
                         {
                             c.ID,
                             c.Name,
                             c.Description,
                             c.Address,
                             c.LastUpdatedOn,
                             a.Email,
                             c.Symbol,
                             c.UserID,
                             c.Image,
                             BlockchainName = b.Name,
                             c.BlockchainID
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
                _query = _query.Where(c => c.LastUpdatedOn.ToString().Contains(request.sSearch) || c.Symbol.Contains(request.sSearch) || c.BlockchainName.Contains(request.sSearch) || c.Name.Contains(request.sSearch) || c.Address.Contains(request.sSearch) || c.Email.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(c => c.Name) : _query.OrderByDescending(c => c.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(c => c.Symbol) : _query.OrderByDescending(c => c.Symbol);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(c => c.BlockchainName) : _query.OrderByDescending(c => c.BlockchainName);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(c => c.Address) : _query.OrderByDescending(c => c.Address);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(c => c.LastUpdatedOn) : _query.OrderByDescending(c => c.LastUpdatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(c => c.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add("<a href='/wallet/admin/coins/details/" + _rowData.ID + "' >" + _rowData.Name + "</a>");
                _row.Add(_rowData.Symbol);
                _row.Add("<a href='/wallet/admin/blockchains/details/" + _rowData.BlockchainID + "' >" + _rowData.BlockchainName + "</a>");
                _row.Add(_rowData.Address);

                _row.Add(_rowData.LastUpdatedOn.ToString());

                if (_rowData.Name.ToLower() == "ether" || _rowData.Address == null)
                {
                    _row.Add(@"<a href='/wallet/admin/coins/edit/" + _rowData.ID + "' title='Edit' class='mr5'><i class='os-icon os-icon-edit-1 text-primary'></i></a>");
                }
                else
                {
                    _row.Add(@"<a href='/wallet/admin/coins/edit/" + _rowData.ID + "' title='Edit' class='mr5'><i class='os-icon os-icon-edit-1 text-primary'></i></a>  <a class='confirm' data-confirm='Are you sure you want to cancel this Coin?' href='/wallet/admin/coins/delete/" + _rowData.ID + "' title='Delete'><i class='fa fa-trash'></i></a> ");
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

        public async Task<ActionResult> Details(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Coin _coin = await db.Coins.FindAsync(ID);

            if (_coin == null)
            {
                return HttpNotFound();
            }

            return View(_coin);
        }

        [AuthorizeAccess]
        public async Task<ActionResult> GetCoins(string q, int i)
        {
            int _skip = i == 1 ? 0 : (i - 1) * 20;
            var _query = from r in db.Coins
                         where r.IsDataActive && r.Name.Contains(q) && !r.IsMCRCategory
                         orderby r.Name
                         select new
                         {
                             r.ID,
                             r.Name,
                             r.Address,
                             r.Symbol,
                         };


            Select2PagedResult _result = new Select2PagedResult
            {
                Total = await _query.OrderBy(t => t.Name).CountAsync(),
                Results = (await _query.OrderBy(t => t.Name).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2Item
                {
                    id = r.ID,
                    text = r.Name,
                }).ToList()
            };

            return Json(_result, JsonRequestBehavior.AllowGet);
        }

        [AuthorizeAccess]
        public async Task<ActionResult> GetSocialCoins(string q, int i)
        {
            int _skip = i == 1 ? 0 : (i - 1) * 20;
            var _query = from r in db.Coins
                         where r.IsDataActive && r.Name.Contains(q) && r.Symbol != "MCR"
                         orderby r.Name
                         select new
                         {
                             r.ID,
                             r.Name,
                             r.Address,
                             r.Symbol,
                         };


            Select2PagedResult _result = new Select2PagedResult
            {
                Total = await _query.OrderBy(t => t.Name).CountAsync(),
                Results = (await _query.OrderBy(t => t.Name).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2Item
                {
                    id = r.ID,
                    text = r.Name,
                }).ToList()
            };

            return Json(_result, JsonRequestBehavior.AllowGet);
        }

        public ActionResult Create()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Create(Coin model, HttpPostedFileBase image)
        {
            if (ModelState.IsValid)
            {
                string _fileName = null;

                if (image != null)
                {
                    _fileName = Path.GetFileName(image.FileName);
                    if (System.IO.File.Exists(Path.Combine(Server.MapPath("~/Uploads"), _fileName)))
                    {
                        _fileName = Guid.NewGuid().ToString() + Path.GetExtension(image.FileName);
                    }
                    var _path = Path.Combine(Server.MapPath("~/Uploads"), _fileName);
                    image.SaveAs(_path);
                    model.Image = _fileName;
                }

                model.CreatedOn = DateTime.Now;
                model.LastUpdatedOn = DateTime.Now;
                model.UserID = AppManager.User.ID;
                model.IsDataActive = true;

                db.Coins.Add(model);
                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Coin has been created successfully.");
                return RedirectToAction("Index");
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
            return View(model);
        }

        public async Task<ActionResult> Edit(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            Coin _coin = await db.Coins.FindAsync(ID);

            if (_coin == null)
            {
                return HttpNotFound();
            }
            if (_coin.BlockchainID != null && _coin.BlockchainID != 0)
            {
                if (db.Blockchains.Any(n => n.ID == _coin.BlockchainID))
                {
                    _coin.SelectedBlockchain = new Select2Item
                    {
                        id = (int)_coin.BlockchainID,
                        text = db.Blockchains.FirstOrDefault(p => p.ID == _coin.BlockchainID).Name,
                    };
                }
            }

            return View(_coin);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(Coin model, HttpPostedFileBase image)
        {
            if (ModelState.IsValid)
            {
                Coin _coin = await db.Coins.FindAsync(model.ID);

                if (_coin != null)
                {
                    string _fileName = null;

                    if (image != null)
                    {
                        _fileName = Path.GetFileName(image.FileName);
                        if (System.IO.File.Exists(Path.Combine(Server.MapPath("~/Uploads"), _fileName)))
                        {
                            _fileName = Guid.NewGuid().ToString() + Path.GetExtension(image.FileName);
                        }
                        var _path = Path.Combine(Server.MapPath("~/Uploads"), _fileName);
                        image.SaveAs(_path);
                    }

                    if (!string.IsNullOrEmpty(_fileName))
                    {
                        _coin.Image = _fileName;
                    }
                    else
                    {
                        _coin.Image = model.Image;
                    }

                    _coin.Name = model.Name;
                    _coin.NumberOfDecimals = model.NumberOfDecimals;
                    _coin.Description = model.Description;
                    _coin.Address = model.Address;
                    _coin.Symbol = model.Symbol;
                    _coin.BlockchainID = model.BlockchainID;
                    _coin.LastUpdatedOn = DateTime.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Coin has been saved successfully.");
                    return RedirectToAction("Index");
                }
                else
                {
                    return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
                }
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
            return View(model);
        }

        public async Task<ActionResult> Delete(int ID)
        {
            Coin _coin = await db.Coins.FindAsync(ID);



            if (_coin != null)
            {
                if (_coin.Name.ToLower() != "ether" || _coin.Address != null)
                {
                    _coin.DeletedOn = DateTime.Now;
                    _coin.IsDataActive = false;

                    TempData["Notification"] =
                        new Notification("Success", "Requested Coin has been deleted successfully.");
                    await db.SaveChangesAsync();
                }
                else
                {
                    TempData["Notification"] =
                        new Notification("Error", "Sorry, we are unable to process your request at the moment. Please try again later.");
                }

            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }
    }
}



