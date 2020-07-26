using System.Web.Mvc;
using System.Web.Routing;

namespace Seratio.Blockchain.Sandbox
{
    public class RouteConfig
    {
        public static void RegisterRoutes(RouteCollection routes)
        {
            routes.IgnoreRoute("{resource}.axd/{*pathInfo}");

            routes.MapRoute(
                name: "Default",
                url: "{controller}/{action}/{id}",
                defaults: new { controller = "Default", action = "Index", id = UrlParameter.Optional },
                namespaces: new string[] { "Seratio.Blockchain.Sandbox.Controllers" }
            );
        }
    }
}
