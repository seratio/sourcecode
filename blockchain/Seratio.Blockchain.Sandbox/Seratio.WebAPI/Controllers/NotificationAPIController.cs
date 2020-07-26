using Microsoft.Owin.Security;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Cors;

namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class NotificationAPIController : BaseAPIController
    {
        [HttpPost]
        [Route("api/ListNotifications")]
        public async Task<NotificationResult> ListNotifications()
        {
            NotificationResult result = new NotificationResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                DateTime _date = DateTime.Now.AddDays(-30);
                try
                {
                    result.ActivityNotifications = db.ActivityNotifications.Where(i => i.UserID == _user.ID && (i.IsRead == false || i.CreatedOn >= _date)).OrderByDescending(i => i.Time).ToList();
                    result.Status = true;
                    return result;
                }
                catch (Exception ex)
                {
                    result.Message = ex.Message;
                    return result;
                }
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/NotificationCount")]
        public async Task<NotificationCountResult> NotificationCount()
        {
            NotificationCountResult result = new NotificationCountResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                DateTime _date = DateTime.Now.AddDays(-30);
                try
                {
                    result.Count = db.ActivityNotifications.Where(i => i.UserID == _user.ID && (i.IsRead == false || i.CreatedOn >= _date)).OrderByDescending(i => i.Time).Count();
                    result.Status = true;
                    return result;
                }
                catch (Exception ex)
                {
                    result.Message = ex.Message;
                    return result;
                }
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        

        [HttpPost]
        [Route("api/MarkAllAsRead")]
        public async Task<ResultSet> MarkAllAsRead()
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                List<ActivityNotification> _notifications = await db.ActivityNotifications.Where(n => n.IsRead == false && n.UserID == _user.ID).ToListAsync();

                foreach (ActivityNotification notification in _notifications)
                {
                    ActivityNotification _item = await db.ActivityNotifications.FirstOrDefaultAsync(n => n.ID == notification.ID);

                    if (_item != null)
                    {
                        _item.IsRead = true;
                        await db.SaveChangesAsync();
                    }
                }
                result.Status = true;
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }
    }
}
