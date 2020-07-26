using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Globalization;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Core.Security;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Areas.L0C5A3E8915871B710C2CC98073748424.Controllers
{
    [AuthorizeBackendAccess]
    public class OffersController : BackendBaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from o in db.Offers
                         where o.IsDataActive
                         select new
                         {
                             o.ID,
                             o.Title,
                             o.Discount,
                             o.LastDate,
                             o.LastUpdatedOn,
                             o.CreatedByID,
                             o.LastUpdatedByID,
                             CreatedBy = db.Administrators.FirstOrDefault(a => a.IsDataActive && a.ID == o.CreatedByID).Name,
                             EditedBy = db.Administrators.FirstOrDefault(a => a.IsDataActive && a.ID == o.LastUpdatedByID).Name
                         };

            if (!string.IsNullOrEmpty(daterange))
            {
                string[] _daterange = daterange.Split(new string[] { " " }, StringSplitOptions.RemoveEmptyEntries);
                DateTime? _start = Convert.ToDateTime(_daterange[0], new CultureInfo("en-CA"));
                DateTime? _end = Convert.ToDateTime(_daterange[2], new CultureInfo("en-CA"));
                _end = _end.Value.AddDays(1);
                _query = _query.Where(o => o.LastUpdatedOn >= _start.Value && o.LastUpdatedOn < _end.Value);
            }

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(o => o.Title.Contains(request.sSearch) || o.Discount.ToString().Contains(request.sSearch) || o.LastDate.ToString().Contains(request.sSearch) || o.CreatedBy.ToString().Contains(request.sSearch) || o.EditedBy.ToString().Contains(request.sSearch) || o.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(o => o.Title) : _query.OrderByDescending(o => o.Title);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(o => o.Discount) : _query.OrderByDescending(o => o.Discount);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(o => o.CreatedBy) : _query.OrderByDescending(o => o.CreatedBy);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(o => o.EditedBy) : _query.OrderByDescending(o => o.EditedBy);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(o => o.LastDate) : _query.OrderByDescending(o => o.LastDate);
                    break;
                case 5:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(o => o.LastUpdatedOn) : _query.OrderByDescending(o => o.LastUpdatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(o => o.ID);
                    break;
            }

            int _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add(_rowData.Title);
                _row.Add(_rowData.Discount);

                if(AppManager.Administrator.IsSuperAdmin || AppManager.Administrator.ID==_rowData.CreatedByID)
                {
                    _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/administrators/details/" + _rowData.CreatedByID + "'>" + _rowData.CreatedBy + "</a>");
                }
                else
                {
                    _row.Add(_rowData.CreatedBy);
                }

                if (AppManager.Administrator.IsSuperAdmin || AppManager.Administrator.ID == _rowData.LastUpdatedByID)
                {
                    _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/administrators/details/" + _rowData.LastUpdatedByID + "'>" + _rowData.EditedBy + "</a>");
                }
                else
                {
                    _row.Add(_rowData.EditedBy);
                }

                _row.Add(_rowData.LastDate.ToShortDateString());
                _row.Add(_rowData.LastUpdatedOn.ToString());

                _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/offers/edit/" + _rowData.ID + "' title='Edit' class='mr5'><i class='icon-pencil7'></i></a>  <a class='confirm' data-confirm='Are you sure you want to delete this Offer?' href='/L0C5A3E8915871B710C2CC98073748424/offers/delete/" + _rowData.ID + "' title='Delete'><i class='icon-cancel-square'></i></a> ");

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

            Offer _offer = await db.Offers.FindAsync(ID);

            if (_offer == null)
            {
                return HttpNotFound();
            }

            return View(_offer);
        }

        //public async Task<ActionResult> GetOffers(string q, int i)
        //{
        //    int _skip = i == 1 ? 0 : (i - 1) * 20;

        //    var _query = from r in db.Offers
        //                 where r.IsDataActive && r.Name.Contains(q)
        //                 orderby r.Name
        //                 select new
        //                 {
        //                     r.ID,
        //                     r.Name,
        //                 };

        //    Select2PagedResult _result = new Select2PagedResult
        //    {
        //        Total = await _query.OrderBy(t => t.Name).CountAsync(),
        //        Results = (await _query.OrderBy(t => t.Name).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2Item
        //        {
        //            id = r.ID,
        //            text = r.Name
        //        }).ToList()
        //    };

        //    return Json(_result, JsonRequestBehavior.AllowGet);
        //}

        public ActionResult Create()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Create(Offer model)
        {
            if (ModelState.IsValid)
            {
                model.CreatedByID = model.LastUpdatedByID = AppManager.Administrator.ID;
                model.CreatedOn = model.LastUpdatedOn = AppManager.Now;
                model.IsDataActive = true;

                db.Offers.Add(model);
                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Early Bird Offer has been created successfully.");
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

            Offer _offer = await db.Offers.FindAsync(ID);

            if (_offer == null)
            {
                return HttpNotFound();
            }

            return View(_offer);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(Offer model)
        {
            if (ModelState.IsValid)
            {
                Offer _offer = await db.Offers.FindAsync(model.ID);

                if (_offer != null)
                {
                    _offer.Title = model.Title;
                    _offer.Discount = model.Discount;
                    _offer.LastDate = model.LastDate;
                    _offer.LastUpdatedByID = AppManager.Administrator.ID;
                    _offer.LastUpdatedOn = AppManager.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Early Bird Offer has been saved successfully.");
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
            Offer _offer = await db.Offers.FindAsync(ID);

            if (_offer != null)
            {
                _offer.DeletedOn = AppManager.Now;
                _offer.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested Early Bird Offer has been deleted successfully.");
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

