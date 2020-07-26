using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.BackgroundJobs;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Web;
using System.Web.Hosting;
using System.Web.Http;
using System.Web.Mvc;
using System.Web.Optimization;
using System.Web.Routing;

namespace Seratio.WebAPI
{
    public class WebApiApplication : System.Web.HttpApplication
    {
        protected void Application_Start()
        {
            AreaRegistration.RegisterAllAreas();
            GlobalConfiguration.Configure(WebApiConfig.Register);
            FilterConfig.RegisterGlobalFilters(GlobalFilters.Filters);
            RouteConfig.RegisterRoutes(RouteTable.Routes);
            BundleConfig.RegisterBundles(BundleTable.Bundles);
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
                            //ExceptionHandler.Handle(ex);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                //ExceptionHandler.Handle(ex);
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
                        //ExceptionHandler.Handle(ex);
                    }
                }
            }
            catch (Exception ex)
            {
                //ExceptionHandler.Handle(ex);
            }
        }
    }
}
