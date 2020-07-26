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
    public class AdministratorsController : BackendBaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from a in db.Administrators
                         where a.IsDataActive
                         select new
                         {
                             a.ID,
                             a.IsSuperAdmin,
                             a.Email,
                             a.AuthString,
                             a.Name,
                             a.Phone,
                             a.IsActive,
                             a.LastUpdatedOn,
                         };

            if (!string.IsNullOrEmpty(daterange))
            {
                string[] _daterange = daterange.Split(new string[] { " " }, StringSplitOptions.RemoveEmptyEntries);
                DateTime? _start = Convert.ToDateTime(_daterange[0], new CultureInfo("en-CA"));
                DateTime? _end = Convert.ToDateTime(_daterange[2], new CultureInfo("en-CA"));
                _end = _end.Value.AddDays(1);
                _query = _query.Where(a => a.LastUpdatedOn >= _start.Value && a.LastUpdatedOn < _end.Value);
            }

            if (!AppManager.Administrator.IsSuperAdmin)
            {
                _query = _query.Where(a => a.ID == AppManager.Administrator.ID);
            }

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(a => a.Name.Contains(request.sSearch) || a.Email.Contains(request.sSearch) || a.Phone.Contains(request.sSearch) || (a.IsActive ? "Yes" : "No").Contains(request.sSearch) || (a.IsSuperAdmin ? "Yes" : "No").Contains(request.sSearch) || a.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.Name) : _query.OrderByDescending(a => a.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.Email) : _query.OrderByDescending(a => a.Email);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.Phone) : _query.OrderByDescending(a => a.Phone);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.IsSuperAdmin) : _query.OrderByDescending(a => a.IsSuperAdmin);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.IsActive) : _query.OrderByDescending(a => a.IsActive);
                    break;
                case 5:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.LastUpdatedOn) : _query.OrderByDescending(a => a.LastUpdatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(a => a.ID);
                    break;
            }

            int _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/administrators/details/" + _rowData.ID + "'> " + _rowData.Name + " </a> ");
                _row.Add(_rowData.Email);
                _row.Add(!string.IsNullOrEmpty(_rowData.Phone) ? _rowData.Phone : "-");
                _row.Add(_rowData.IsSuperAdmin ? "<span class='label label-success'>Yes</span>" : "<span class='label label-warning'>No</span>");
                _row.Add(_rowData.IsActive ? "<span class='label label-success'>Yes</span>" : "<span class='label label-warning'>No</span>");
                _row.Add(_rowData.LastUpdatedOn.ToString("dd/MM/yyyy hh:mm tt"));

                if (AppManager.Administrator.ID == _rowData.ID)
                {
                    _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/administrators/edit/" + _rowData.ID + "' title='Edit' class='mr5'><i class='icon-pencil7'></i></a>");
                }
                else
                {
                    _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/administrators/edit/" + _rowData.ID + "' title='Edit' class='mr5'><i class='icon-pencil7'></i></a>  <a class='confirm' data-confirm='Are you sure you want to cancel this Administator?' href='/L0C5A3E8915871B710C2CC98073748424/administrators/delete/" + _rowData.ID + "' title='Cancel'><i class='icon-cancel-square'></i></a>");
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

            Administrator _administrator = await db.Administrators.FindAsync(ID);

            if (_administrator == null)
            {
                return HttpNotFound();
            }

            return View(_administrator);
        }

        public async Task<ActionResult> GetAdministrators(string q, int i)
        {
            int _skip = i == 1 ? 0 : (i - 1) * 20;

            var _query = from a in db.Administrators
                         where a.IsDataActive && a.Name.Contains(q)
                         orderby a.Name
                         select new
                         {
                             a.ID,
                             a.Name,
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
        public async Task<ActionResult> Create(Administrator model, string password)
        {
            model.ConfirmPassword = model.Password;
            ModelState.Clear();
            TryValidateModel(model);

            if (ModelState.IsValid)
            {
                if (!db.Administrators.Any(a => a.Email.Equals(model.Email)))
                {
                    byte[] _authString = AppManager.GetAuthstring(model.Email, model.Password);

                    model.AuthString = _authString;
                    model.CreatedOn = AppManager.Now;
                    model.LastUpdatedOn = AppManager.Now;
                    model.IsDataActive = true;
                    model.IsSuperAdmin = false;
                    model.IsActive = true;

                    db.Administrators.Add(model);
                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Administrator account has been created successfully.");
                    return RedirectToAction("Index");
                }

                else
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, this Username is already taken. Please try another one.");
                    return View(model);
                }
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

            Administrator _administrator = await db.Administrators.FindAsync(ID);

            if (_administrator == null)
            {
                return HttpNotFound();
            }

            return View(_administrator);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(Administrator model)
        {
            model.ConfirmPassword = model.Password;
            ModelState.Clear();
            TryValidateModel(model);

            if (ModelState.IsValid)
            {
                Administrator _administrator = await db.Administrators.FindAsync(model.ID);

                if (_administrator != null)
                {
                    if (await db.Administrators.AnyAsync(a => a.IsDataActive && a.ID != AppManager.Administrator.ID && a.Email == model.Email && !string.IsNullOrEmpty(model.Email)))
                    {
                        TempData["Notification"] = new Notification("Error", "Requested Email already exist. Please try another one.");
                        return Redirect("/L0C5A3E8915871B710C2CC98073748424/administrators/edit/" + AppManager.Administrator.ID);
                    }

                    _administrator.AuthString = model.Password == null ? _administrator.AuthString : AppManager.GetAuthstring(model.Email, model.Password);

                    _administrator.Email = model.Email;
                    _administrator.Name = model.Name;
                    _administrator.Phone = model.Phone;
                    _administrator.IsActive = model.IsActive;
                    _administrator.LastUpdatedOn = AppManager.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Requested Administrator account has been saved successfully.");
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
            Administrator _administrator = await db.Administrators.FindAsync(ID);

            if (_administrator != null)
            {
                _administrator.DeletedOn = AppManager.Now;
                _administrator.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested Administrator account has been deleted successfully.");
                await db.SaveChangesAsync();
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return RedirectToAction("Index");
        }

        public async Task<JsonResult> HistoryList(DataTableRequest request, int ID)
        {
            var _query = db.AdministratorSessions.Where(a => a.AdministratorID == ID).Select(a => new
            {
                a.StartTime,
                a.EndTime,
                a.IPAddress,
                a.UserAgent,
                a.ID,
                a.AdministratorID
            });

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(a => a.IPAddress.Contains(request.sSearch) || a.UserAgent.Contains(request.sSearch) || a.StartTime.ToString().Contains(request.sSearch) || a.EndTime.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.IPAddress) : _query.OrderByDescending(a => a.IPAddress);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.UserAgent) : _query.OrderByDescending(a => a.UserAgent);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.StartTime) : _query.OrderByDescending(a => a.StartTime);
                    break;

                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(a => a.EndTime) : _query.OrderByDescending(a => a.EndTime);
                    break;

                default:
                    _query = _query.OrderByDescending(a => a.ID);
                    break;
            }

            int _count = await _query.CountAsync();
            var data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in data)
            {
                DataTableRow _row = new DataTableRow();

                if(_rowData.IPAddress!=null)
                {
                    _row.Add(_rowData.IPAddress);
                }
                else
                {
                    _row.Add("-");
                }

                if (_rowData.UserAgent != null)
                {
                    _row.Add(@"<span data-toggle='popover' data-trigger='hover' data-content='" + _rowData.UserAgent + "' data-placement='top' data-container='body' data-animation='true'>" + _rowData.UserAgent.Remove(20) + "...</span>");
                }
                else
                {
                    _row.Add("-");
                }

                _row.Add(_rowData.StartTime.ToString("dd MMMM, yyyy hh:mm:ss tt"));
                _row.Add(_rowData.EndTime == null ? _rowData.StartTime.AddMinutes(20).ToString("dd MMMM, yyyy hh:mm:ss tt") : _rowData.EndTime.Value.ToString("dd MMMM, yyyy hh:mm:ss tt"));
                _row.Add(AppManager.FormattedDuration(_rowData.EndTime != null ? _rowData.EndTime.Value.Subtract(_rowData.StartTime) : _rowData.StartTime.AddMinutes(20).Subtract(_rowData.StartTime)));

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

        public ActionResult ChangePassword()
        {
            return View();
        }

        [HttpPost]
        public async Task<ActionResult> ChangePassword(Administrator model)
        {
            if (model.Password != null)
            {
                if (model.Password == model.ConfirmPassword)
                {
                    Administrator _administrator = await db.Administrators.FirstOrDefaultAsync(c => c.ID == AppManager.Administrator.ID && c.IsDataActive);

                    if (_administrator != null)
                    {
                        byte[] _authString = AppManager.GetAuthstring(_administrator.Email, model.Password);

                        _administrator.AuthString = _authString;
                        await db.SaveChangesAsync();

                        TempData["Notification"] = new Notification("Success", "Password has been changed successfully.");
                        return Redirect("/L0C5A3E8915871B710C2CC98073748424/default/dashboard");
                    }
                    else
                    {
                        TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                        return RedirectToAction("changepassword");
                    }
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Passwords do not match. Please try again later.");
                    return RedirectToAction("changepassword");
                }
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                return RedirectToAction("changepassword");
            }
        }
    }
}

