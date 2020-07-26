using System;
using System.Data.Entity;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Core.Security;
using Seratio.Platform.ICO.Models;
using UAParser;

namespace Seratio.Platform.ICO.Areas.L0C5A3E8915871B710C2CC98073748424.Controllers
{
    public class DefaultController : BackendBaseController
    {
        // GET: Backend/Default
        [HttpGet]
        [AllowAnonymous]
        public ActionResult Index()
        {
            if (AppManager.Administrator != null)
            {
                return Redirect("/L0C5A3E8915871B710C2CC98073748424/default/dashboard");
            }

            return View();
        }
        [HttpPost]
        [AllowAnonymous]
        public async Task<ActionResult> Index(string email, string password)
        {
            AppUser _loggedInUser = await AppManager.AuthenticateUserAsync(email, password);

            if (_loggedInUser != null)
            {
                Session["ICO_Administrator"] = _loggedInUser;

                var uaParser = Parser.GetDefault();

                ClientInfo _clientInfo = uaParser.Parse(Request.UserAgent);

                AdministratorSession _session =
                    await db.AdministratorSessions.FirstOrDefaultAsync(u => u.ID == _loggedInUser.SessionID && u.AdministratorID == _loggedInUser.ID && u.IsActive);

                string _body = $"Hello {_loggedInUser.Name ?? _loggedInUser.Email.ToLower()},<br /><br />Your Seratio Platform Administrative account was just used to sign in from {_clientInfo.UserAgent.Family} on {_clientInfo.OS.Family}.<br />.If not you<br />Please <a href='{AppManager.AppURL}/L0C5A3E8915871B710C2CC98073748424/default/TerminateSession?token={_session.Token}'>click here</a> to deny access your Account.<br/><br/>Regards,<br/>CCEG<br/>";
                AppManager.SendEmail($"New sign-in from {_clientInfo.UserAgent.Family} {_clientInfo.UserAgent.Major} on {_clientInfo.OS.Family} {_clientInfo.OS.Major}", _loggedInUser.Email, _body);

                return Redirect("/L0C5A3E8915871B710C2CC98073748424/default/dashboard");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Email and password do not match. Please try again.");
                return View();
            }
        }

        [AuthorizeBackendAccess]
        public async Task<ActionResult> Dashboard(DateTime? start, DateTime? end)
        {
            if (start == null && end == null)
            {
                end = AppManager.Now.Date;
                start = AppManager.Now.Date.AddDays(-30);
            }

            end = end.Value.AddDays(1);
            return View(await AppManager.GetDashboardData(start.Value, end.Value));
        }

        public async Task<ActionResult> Logout()
        {
            if (AppManager.Administrator != null)
            {
                await AppManager.EndAdminSession(AppManager.Administrator.ID, AppManager.Administrator.SessionID);

                Session.Contents.RemoveAll();
                Session.Clear();
                Session.Abandon();
            }

            return RedirectToAction("Index");
        }

        [AllowAnonymous]
        public async Task<ActionResult> TerminateSession(Guid token)
        {
            AdministratorSession _session = await db.AdministratorSessions.FirstOrDefaultAsync(u => u.IsActive && u.Token == token);

            if (_session != null)
            {
                _session.EndTime = DateTime.Now;
                _session.HasTerminated = true;
                _session.IsActive = false;

                await db.SaveChangesAsync();


                TempData["Notification"] = new Notification("Success", "Your Access denayed  .");
                return RedirectToAction("Index");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. please try later.");
                return RedirectToAction("Index");
            }
        }

    }
}