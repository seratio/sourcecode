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
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Areas.L0C5A3E8915871B710C2CC98073748424.Controllers
{
    [AuthorizeBackendAccess]
    public class UsersController : BackendBaseController
    {
        public ActionResult Index(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from u in db.Users
                         where u.IsDataActive
                         select new
                         {
                             u.ID,
                             u.FirstName,
                             u.Title,
                             u.LastName,
                             u.Position,
                             u.Organization,
                             u.Email,
                             u.Phone,
                             u.LastUpdatedOn,
                             u.PostalCode
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
                _query = _query.Where(u => u.FirstName.Contains(request.sSearch) || u.Email.Contains(request.sSearch) || u.PostalCode.Contains(request.sSearch) || u.Phone.Contains(request.sSearch) || u.Position.Contains(request.sSearch) || u.Organization.Contains(request.sSearch) || u.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.FirstName) : _query.OrderByDescending(u => u.FirstName);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.Email) : _query.OrderByDescending(u => u.Email);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.Phone) : _query.OrderByDescending(u => u.Phone);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.PostalCode) : _query.OrderByDescending(u => u.PostalCode);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.Position) : _query.OrderByDescending(u => u.Position);
                    break;
                case 5:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.Organization) : _query.OrderByDescending(u => u.Organization);
                    break;
                case 6:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.LastUpdatedOn) : _query.OrderByDescending(u => u.LastUpdatedOn);
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

                _row.Add(_rowData.Title + ". " + _rowData.FirstName + " " + _rowData.LastName);
                _row.Add(@"<a href='/L0C5A3E8915871B710C2CC98073748424/users/details/" + _rowData.ID + "'>" + _rowData.Email + "</a>");


                if (!string.IsNullOrEmpty(_rowData.Phone))
                {
                    _row.Add(_rowData.Phone);
                }
                else
                {
                    _row.Add("-");
                }

                if (!string.IsNullOrEmpty(_rowData.PostalCode))
                {
                    _row.Add(_rowData.PostalCode);
                }
                else
                {
                    _row.Add("-");
                }

                if (!string.IsNullOrEmpty(_rowData.Position))
                {
                    _row.Add(_rowData.Position);
                }
                else
                {
                    _row.Add("-");
                }

                if (!string.IsNullOrEmpty(_rowData.Organization))
                {
                    _row.Add(_rowData.Organization);
                }
                else
                {
                    _row.Add("-");
                }

                _row.Add(_rowData.LastUpdatedOn.ToString());

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

            User _user = await db.Users.FindAsync(ID);

            if (_user == null)
            {
                return HttpNotFound();
            }

            return View(_user);
        }

        public async Task<JsonResult> HistoryList(DataTableRequest request, int ID)
        {
            var _query = db.UserSessions.Where(a => a.UserID == ID).Select(a => new
            {
                a.StartTime,
                a.EndTime,
                a.IPAddress,
                a.UserAgent,
                a.ID,
                a.UserID
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

                if (_rowData.IPAddress != null)
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

        public async Task<FileStreamResult> Export()
        {
            string _file = Server.MapPath(await GenerateExcelFile());
            return File(System.IO.File.OpenRead(_file), MimeMapping.GetMimeMapping(_file), System.IO.Path.GetFileName(_file));
        }

        private async Task<string> GenerateExcelFile()
        {
            DateTime Now = AppManager.Now.Date;

            var _query = from u in db.Users
                         where u.IsDataActive
                         select new
                         {
                             u.ID,
                             u.FirstName,
                             u.LastName,
                             u.Title,
                             u.Position,
                             u.Organization,
                             u.Email,
                             u.Phone,
                             u.PostalCode,
                             u.LastUpdatedOn,
                         };

            var _data = await _query.OrderByDescending(o => o.ID).ToListAsync();

            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {

                DataTableRow _row = new DataTableRow();

                string _statusHtml = string.Empty;

                _row.Add(_rowData.FirstName + " " + _rowData.LastName);
                _row.Add(_rowData.Email);
                _row.Add(_rowData.Phone);
                _row.Add(_rowData.PostalCode);
                _row.Add(_rowData.Position);
                _row.Add(_rowData.Organization);
                _row.Add(_rowData.LastUpdatedOn.ToString());

                _rows.Add(_row);
            }

            var _workbook = new XLWorkbook();
            var _worksheet = _workbook.Worksheets.Add("Users");

            _worksheet.Cell("A1").Value = "Name";
            _worksheet.Cell("B1").Value = "Email";
            _worksheet.Cell("C1").Value = "Phone";
            _worksheet.Cell("D1").Value = "Postal Code";
            _worksheet.Cell("E1").Value = "Position";
            _worksheet.Cell("F1").Value = "Organization";
            _worksheet.Cell("G1").Value = "Last Updated On";
         
            int _rowIndex = 2;

            foreach (DataTableRow _row in _rows)
            {
                _worksheet.Cell("A" + _rowIndex).Value = _row.ElementAt(0);
                _worksheet.Cell("B" + _rowIndex).Value = _row.ElementAt(1);
                _worksheet.Cell("C" + _rowIndex).Value = "'" + _row.ElementAt(2);
                _worksheet.Cell("D" + _rowIndex).Value = "'" + _row.ElementAt(3);
                _worksheet.Cell("E" + _rowIndex).Value = "'" + _row.ElementAt(4);
                _worksheet.Cell("F" + _rowIndex).Value = _row.ElementAt(5);
                _worksheet.Cell("G" + _rowIndex).Value = _row.ElementAt(6);               
                _rowIndex++;
            }

            _worksheet.Row(1).Style.Font.Bold = true;
            _workbook.SaveAs(HostingEnvironment.MapPath("/Exports/users.xlsx"));

            return "/Exports/users.xlsx";
        }
    }
}

