using System.Web.Mvc;

namespace Seratio.Blockchain.Sandbox.Areas.RetailEnd
{
    public class RetailEndAreaRegistration : AreaRegistration 
    {
        public override string AreaName 
        {
            get 
            {
                return "RetailEnd";
            }
        }

        public override void RegisterArea(AreaRegistrationContext context) 
        {
            context.MapRoute(
                "RetailEnd_default",
                "RetailEnd/{controller}/{action}/{id}",
                new { controller = "Default", action = "Index", id = UrlParameter.Optional }
            );
        }
    }
}