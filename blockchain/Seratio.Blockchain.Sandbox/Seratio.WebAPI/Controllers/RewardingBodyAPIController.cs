using Microsoft.Owin.Security;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Data.Entity;
using System.Net;
using System.Net.Http;
using System.Web.Http;
using System.Web.Http.Cors;
using System.Threading.Tasks;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;

namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class RewardingBodyAPIController : BaseAPIController
    {

        [HttpPost]
        [Route("api/AvailableActivities")]
        public async Task<AvailableActivityResultSet> AvailableActivities(DataTableRequest_DarteRange request)
        {
            AvailableActivityResultSet result = new AvailableActivityResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                if(_user!=null)
                {
                    string UserName = ticket.Properties.Dictionary["userName"];
                    var _query = from s in db.SocialActivities
                                 join c in db.Coins on s.RewardingCoinID equals c.ID
                                 where s.IsDataActive
                                 select new
                                 {
                                     s.ID,
                                     s.Name,
                                     s.Description,
                                     CoinName = c.Name,
                                     CoinCode = c.Symbol,
                                     s.ApprovedOn,
                                     s.RejectedOn,
                                     s.IsApproved,
                                     s.RewardAmount,
                                     s.LastUpdatedOn,
                                     s.UserID,
                                     ProcessedByID = s.ProcessedBy,
                                     UserFirstName  =  db.Users.FirstOrDefault(p => p.ID == s.UserID).FirstName,
                                     UserLastName = db.Users.FirstOrDefault(p => p.ID == s.UserID).LastName,
                                     SenderFirstName = s.ProcessedBy == null ? string.Empty :  db.Users.FirstOrDefault(p=>p.ID ==s.ProcessedBy).FirstName,
                                     SenderLastName = s.ProcessedBy == null ? string.Empty : db.Users.FirstOrDefault(p => p.ID == s.ProcessedBy).LastName,
                                     ProcessedBy = s.ProcessedBy != null ? s.User1.Email : null
                                 };

                    //if (!_user.IsSuperAdmin)
                    //{
                    //    _query = _query.Where(q => q.UserID == _user.ID);
                    //}

                    if (!string.IsNullOrEmpty(request.daterange))
                    {
                        string[] _daterange = request.daterange.Split(new string[] { " " }, StringSplitOptions.RemoveEmptyEntries);
                        DateTime? _start = Convert.ToDateTime(_daterange[0], new CultureInfo("en-CA"));
                        DateTime? _end = Convert.ToDateTime(_daterange[2], new CultureInfo("en-CA"));
                        _end = _end.Value.AddDays(1);
                        _query = _query.Where(u => u.LastUpdatedOn >= _start.Value && u.LastUpdatedOn < _end.Value);
                    }

                    if (!string.IsNullOrEmpty(request.sSearch))
                    {
                        _query = _query.Where(s => s.Name.Contains(request.sSearch) || s.Description.Contains(request.sSearch) || s.ProcessedBy.Contains(request.sSearch) || s.IsApproved.ToString().Contains(request.sSearch) || s.RewardAmount.ToString().Contains(request.sSearch) || s.LastUpdatedOn.ToString().Contains(request.sSearch));
                    }

                    switch (request.iSortCol_0)
                    {
                        case 0:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Name) : _query.OrderByDescending(s => s.Name);
                            break;
                        case 1:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.RewardAmount) : _query.OrderByDescending(s => s.RewardAmount);
                            break;
                        case 2:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.IsApproved) : _query.OrderByDescending(m => m.IsApproved);
                            break;
                        case 3:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.ProcessedBy) : _query.OrderByDescending(m => m.ProcessedBy);
                            break;
                        case 4:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Description) : _query.OrderByDescending(s => s.Description);
                            break;
                        case 5:
                            _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.LastUpdatedOn) : _query.OrderByDescending(s => s.LastUpdatedOn);
                            break;
                        default:
                            _query = _query.OrderByDescending(s => s.ID);
                            break;
                    }

                    var _count = await _query.CountAsync();

                    var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
                    List<AvailableActivities_Result> _rows = new List<AvailableActivities_Result>();

                    foreach (var _rowData in _data)
                    {
                        AvailableActivities_Result _row = new AvailableActivities_Result();

                        _row.ID = _rowData.ID;
                        _row.Name = _rowData.Name;
                        _row.UserID = _rowData.UserID;
                        _row.ProcessedByID = _rowData.ProcessedByID;
                        _row.RewardAmount = _rowData.RewardAmount + " " + _rowData.CoinCode;
                        _row.UserName = _rowData.UserFirstName + " " + _rowData.UserLastName;
                        _row.SenderName = _rowData.SenderFirstName + " " + _rowData.SenderLastName;
                        string _status = string.Empty;
                        string _processedby = string.Empty;

                        switch (_rowData.IsApproved)
                        {
                            case null:
                                _status = "Pending";
                                break;
                            case true:
                                _status = "Approved";
                                break;
                            case false:
                                _status = "Rejected";
                                break;
                            default:
                                break;
                        }
                        _row.Status = _status;

                        if (!string.IsNullOrEmpty(_rowData.ProcessedBy))
                        {
                            _row.ProcessedBy = _rowData.ProcessedBy;
                        }
                        _row.Description = _rowData.Description;
                        _row.LastUpdatedOn = _rowData.LastUpdatedOn.ToString();

                        _rows.Add(_row);
                    }
                    result = new AvailableActivityResultSet
                    {
                        sEcho = request.sEcho,
                        iDisplayLength = request.iDisplayLength,
                        iTotalRecords = _count,
                        iDisplayStart = request.iDisplayStart,
                        iTotalDisplayRecords = _count,
                        aaData = _rows
                    };
                    return result;
                }
                else
                {
                    result = new AvailableActivityResultSet
                    {
                        sEcho = request.sEcho,
                        iDisplayLength = request.iDisplayLength,
                        iTotalRecords = 0,
                        iDisplayStart = request.iDisplayStart,
                        iTotalDisplayRecords = 0,
                        aaData = null
                    };
                    return result;
                }
               
            }
            else
            {
                result = new AvailableActivityResultSet
                {
                    sEcho = request.sEcho,
                    iDisplayLength = request.iDisplayLength,
                    iTotalRecords = 0,
                    iDisplayStart = request.iDisplayStart,
                    iTotalDisplayRecords = 0,
                    aaData = null
                };
                return result;
            }
        }
    }
}
