using System;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Core.Security
{
    [AttributeUsage(AttributeTargets.Class | AttributeTargets.Method, Inherited = true, AllowMultiple = false)]
    public sealed class AuthorizeAccessAttribute : AuthorizeAttribute
    {
        public bool RequireSuperAdmin { get; set; }

        public bool RequiresRewardingBodyAccess { get; set; }

        public bool RequiresRetailEndAccess { get; set; }

        private bool HasNoPermission { get; set; }

        public bool AllowPendingWalletCreation { get; set; }

        protected override bool AuthorizeCore(HttpContextBase httpContext)
        {
            if (AppManager.User == null)
            {
                return false;
            }
            else if (AppManager.User.RequiresTwoFactorAuthentication && AppManager.User.PendingTwoFactorAuthentication)
            {
                return false;
            }

            else if (AppManager.User.PendingWalletCreation && !AllowPendingWalletCreation)
            {
                return false;
            }

            using (PlatformDatabaseEntities db = new PlatformDatabaseEntities())
            {
                if (db.UserSessions.Any(s => s.ID == AppManager.User.SessionID && s.IsActive))
                {
                    if (AppManager.User.IsSuperAdmin)
                    {
                        return true;
                    }
                    else if (RequireSuperAdmin)
                    {
                        if (!AppManager.User.IsSuperAdmin)
                        {
                            HasNoPermission = true;
                            return false;
                        }

                        return true;
                    }
                    else if (RequiresRewardingBodyAccess)
                    {
                        if (!AppManager.User.CanAccessRewardingBody)
                        {
                            HasNoPermission = true;
                            return false;
                        }
                        return true;
                    }
                    else if (RequiresRetailEndAccess)
                    {
                        if (!AppManager.User.CanAccessRetailEnd)
                        {
                            HasNoPermission = true;
                            return false;
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
                    httpContext.Session["Blockchain_User"] = null;
                    return false;
                }
            }
        }

        protected override void HandleUnauthorizedRequest(AuthorizationContext filterContext)
        {
            string _url = "/wallet/";

            if (HasNoPermission)
            {
                if (RequiresRewardingBodyAccess)
                {
                    _url = "/wallet/users/requestaccess?module=rb";
                }
                else if (RequiresRetailEndAccess)
                {
                    _url = "/wallet/users/requestaccess?module=retail";
                }
                else
                {
                    _url = "/wallet/default/dashboard";
                }
            }
            else
            {
                _url = filterContext.RequestContext.HttpContext.Request.Url.PathAndQuery;
                _url = "/wallet/?next=" + _url;
            }

            filterContext.Result = new RedirectResult(_url);
        }
    }
}