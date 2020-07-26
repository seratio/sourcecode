using System;
using System.Diagnostics;
using System.IO;
using System.Net;
using System.Web.Hosting;
using System.Web.Mvc;
using System.Web.Routing;
using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.BackgroundJobs;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Utilities;

namespace Seratio.Blockchain.Sandbox
{
    public class MvcApplication : System.Web.HttpApplication
    {
        protected void Application_Start()
        {
            ServicePointManager.Expect100Continue = true;
            ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls
                                                   | SecurityProtocolType.Tls11
                                                   | SecurityProtocolType.Tls12
                                                   | SecurityProtocolType.Ssl3;

            AreaRegistration.RegisterAllAreas();
            RouteConfig.RegisterRoutes(RouteTable.Routes);

            AppManager.IsTransactionStatusMonitorRunning = false;

            Scheduler.Schedule();
        }

        protected void Session_Start()
        {
            if (Request.Headers["X_RequesterUser"] != null)
            {
                Session["Blockchain_User"] = JsonConvert.DeserializeObject<AppUser>(Request.Headers["X_RequesterUser"]);
            }
        }

        protected void Session_End(object sender, EventArgs e)
        {
            try
            {
                if (Session["_w"] != null)
                {
                    string _address = Session["_w"].ToString().Replace("0x", string.Empty);
                    string[] _files = Directory.GetFiles(HostingEnvironment.MapPath($"~//keys"), $"*{_address}*");

                    foreach (string _file in _files)
                    {
                        try
                        {
                            File.Delete(_file);
                        }
                        catch (Exception ex)
                        {
                            ExceptionHandler.Handle(ex);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }
        }

        protected void Application_Error(object sender, EventArgs e)
        {
            if (!Debugger.IsAttached)
            {
                ExceptionHandler.Handle(Server.GetLastError());
            }
        }

        protected void Application_End(object sender, EventArgs e)
        {
            try
            {
                string[] _files = Directory.GetFiles(HostingEnvironment.MapPath($"~//keys"));

                foreach (string _file in _files)
                {
                    try
                    {
                        File.Delete(_file);
                    }
                    catch (Exception ex)
                    {
                        ExceptionHandler.Handle(ex);
                    }
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }
        }
    }
}
