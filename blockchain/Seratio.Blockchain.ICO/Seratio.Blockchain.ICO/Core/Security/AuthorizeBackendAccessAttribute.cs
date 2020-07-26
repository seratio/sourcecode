using Seratio.Platform.ICO.Models;
using System;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace Seratio.Platform.ICO.Core.Security
{
    [AttributeUsage(AttributeTargets.Class | AttributeTargets.Method, Inherited = true, AllowMultiple = false)]
    public sealed class AuthorizeBackendAccessAttribute : AuthorizeAttribute
    {
        public bool RequiresSupreAdmin { get; set; }

        private bool IsNoPermission { get; set; }

        protected override bool AuthorizeCore(HttpContextBase httpContext)
        {
            if (AppManager.Administrator == null)
            {
                return false;
            }

            using (DatabaseEntities db = new DatabaseEntities())
            {
                if (db.AdministratorSessions.Any(s => s.ID == AppManager.Administrator.SessionID && s.IsActive))
                {
                    if (AppManager.Administrator.IsSuperAdmin)
                    {
                        return true;
                    }
                    else if (RequiresSupreAdmin)
                    {
                        if (!AppManager.Administrator.IsSuperAdmin)
                        {
                            IsNoPermission = true;
                            return AppManager.Administrator.IsSuperAdmin;
                        }
                        return true;
                    }             
                    else
                    {
                        return true;
                    }
                }
                else
                {
                    httpContext.Session["ICO_Administrator"] = null;
                    return false;
                }
            }
        }

        protected override void HandleUnauthorizedRequest(AuthorizationContext filterContext)
        {
            filterContext.Result = this.IsNoPermission ? (new LoginCheckController()).RedirectToDashBoard() : (new LoginCheckController()).RedirectToLogin();
        }
    }

    public sealed class LoginCheckController : Controller
    {
        public ActionResult RedirectToLogin()
        {
            return Redirect("/L0C5A3E8915871B710C2CC98073748424");
        }

        public ActionResult RedirectToDashBoard()
        {
            return Redirect("/L0C5A3E8915871B710C2CC98073748424/default/dashboard");
        }
    }
}