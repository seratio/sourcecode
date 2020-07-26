using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web.Mvc;
using System.Globalization;
using System.Threading.Tasks;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;

namespace Seratio.Blockchain.Sandbox.Areas.Admin
{
    public class BlockchainsController : BaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from i in db.Blockchains
                         where i.IsDataActive
                         select new
                         {
                             i.ID,
                             i.Name,
                             i.Host,
                             i.IsActive,
                             i.Comments,
                             i.LastUpdatedOn,
                             i.IsPrimaryNode
                         
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
                _query = _query.Where(c => c.LastUpdatedOn.ToString().Contains(request.sSearch) || c.Host.Contains(request.sSearch) || c.Name.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.Name) : _query.OrderByDescending(u => u.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.Host) : _query.OrderByDescending(u => u.Host);
                    break;      
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.IsPrimaryNode) : _query.OrderByDescending(u => u.IsPrimaryNode);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.IsActive) : _query.OrderByDescending(u => u.IsActive);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.LastUpdatedOn) : _query.OrderByDescending(u => u.LastUpdatedOn);
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

                _row.Add("<a href='/wallet/admin/blockchains/details/" + _rowData.ID + "'>" + _rowData.Name + "</a>");
                _row.Add(_rowData.Host);
             
                if (_rowData.IsPrimaryNode)
                {
                    _row.Add("<span class='label label-success'>Yes</span></a>");
                }
                else
                {
                    _row.Add("<span class='label label-danger'>No</span>");
                }

                if (_rowData.IsActive)
                {
                    _row.Add("<span class='label label-success'>Yes</span></a>");
                }
                else
                {
                    _row.Add("<span class='label label-danger'>No</span>");
                }

                _row.Add(_rowData.LastUpdatedOn.ToString());
                _row.Add(@"<a href='/wallet/admin/blockchains/edit/" + _rowData.ID + "' title='Edit' class='mr5'><i class='os-icon os-icon-edit-1 text-primary'></i></a>  <a class='confirm' data-confirm='Are you sure you want to cancel this Blockchain?' href='/wallet/admin/blockchains/delete/" + _rowData.ID + "' title='Delete'><i class='fa fa-trash'></i></a> ");


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

            Models.Blockchain _blockchain = await db.Blockchains.FindAsync(ID);

            if (_blockchain == null)
            {
                return HttpNotFound();
            }

            return View(_blockchain);
        }

        public async Task<ActionResult> GetBlockchains(string q, int i)
        {
            int _skip = i == 1 ? 0 : (i - 1) * 20;

            var _query = from r in db.Blockchains
                         where r.IsDataActive && r.Name.Contains(q)
                         orderby r.Name
                         select new
                         {
                             r.ID,
                             r.Name,
                         };

            Select2PagedResult _result = new Select2PagedResult
            {
                Total = await _query.OrderBy(t => t.Name).CountAsync(),
                Results = (await _query.OrderBy(t => t.Name).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2Item
                {
                    id = r.ID,
                    text = r.Name
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
        public async Task<ActionResult> Create(Models.Blockchain model)
        {
            if (ModelState.IsValid)
            {
                model.CreatedOn = DateTime.Now;
                model.LastUpdatedOn = DateTime.Now;
                model.IsDataActive = true;
                model.IsActive = true;
               
                db.Blockchains.Add(model);
                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Blockchain has been created successfully.");
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

            Models.Blockchain _blockchain = await db.Blockchains.FindAsync(ID);

            if (_blockchain == null)
            {
                return HttpNotFound();
            }

            return View(_blockchain);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(Models.Blockchain model)
        {
            if (ModelState.IsValid)
            {
                Models.Blockchain _blockchain = await db.Blockchains.FindAsync(model.ID);

                if (_blockchain != null)
                {
                    _blockchain.Name = model.Name;
                    _blockchain.Host = model.Host;
                    _blockchain.IsActive = model.IsActive;
                    _blockchain.Comments = model.Comments;
                    _blockchain.LastUpdatedOn = DateTime.Now;
                    _blockchain.IsPrimaryNode = model.IsPrimaryNode;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Blockchain has been saved successfully.");
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
            Models.Blockchain _blockchain = await db.Blockchains.FindAsync(ID);

            if (_blockchain != null)
            {
                _blockchain.DeletedOn = DateTime.Now;
                _blockchain.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested Blockchain has been deleted successfully.");
                await db.SaveChangesAsync();
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }

        public async Task<ActionResult> Info(int ID)
        {
            List<Tuple<object, object>> model = new List<Tuple<object, object>>();

            Models.Blockchain _blockchain = await db.Blockchains.FindAsync(ID);

            if (_blockchain != null)
            {
                using (BlockChainManager bm =
                    new BlockChainManager($"http://{_blockchain.Host}/"))
                {
                    model.Add(new Tuple<object, object>(await bm.GetNodeInfo(), await bm.GetPeers()));
                }

                return View(model);
            }
            else
            {
                return View();
            }
        }
    }
}

