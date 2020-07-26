using System;
using System.Diagnostics;
using System.Web.Mvc;
using System.Web.Routing;
using Newtonsoft.Json;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Core.Utilities;
using System.Web.Http;

namespace Seratio.Platform.ICO
{
    public class MvcApplication : System.Web.HttpApplication
    {
        protected void Application_Start()
        {
            AreaRegistration.RegisterAllAreas();
            GlobalConfiguration.Configure(WebApiConfig.Register);
            RouteConfig.RegisterRoutes(RouteTable.Routes);

            Scheduler.Schedule();
        }

        protected void Session_Start()
        {
            //LoggedInUser _user = AppManager.AuthenticateLoggedInUser("savitha@markuplab.net", "savitha");
            //Session["ICO_User"] = _user;

            if (Request.Headers["X_RequesterUser"] != null)
            {
                Session["ICO_User"] = JsonConvert.DeserializeObject<LoggedInUser>(Request.Headers["X_RequesterUser"]);
            }

            if (Request.Headers["X_RequesterAdministrator"] != null)
            {
                Session["ICO_Administrator"] = JsonConvert.DeserializeObject<AppUser>(Request.Headers["X_RequesterAdministrator"]);
            }
        }

        protected void Application_Error(object sender, EventArgs e)
        {
            ExceptionHandler.Handle(Server.GetLastError());
        }
    }
}
