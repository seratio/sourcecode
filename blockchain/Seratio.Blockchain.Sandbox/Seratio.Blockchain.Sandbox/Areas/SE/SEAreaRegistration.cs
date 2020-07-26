using System.Web.Mvc;

namespace Seratio.Blockchain.Sandbox.Areas.SE
{
    public class SEAreaRegistration : AreaRegistration
    {
        public override string AreaName
        {
            get
            {
                return "SE";
            }
        }

        public override void RegisterArea(AreaRegistrationContext context)
        {
            context.MapRoute(
                "SE_default",
                "SE/{controller}/{action}/{id}",
                new { controller = "Default", action = "Index", id = UrlParameter.Optional }
            );
        }
    }
}