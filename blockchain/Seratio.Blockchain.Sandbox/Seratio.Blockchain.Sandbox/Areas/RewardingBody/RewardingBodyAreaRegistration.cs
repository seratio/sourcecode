using System.Web.Mvc;

namespace Seratio.Blockchain.Sandbox.Areas.RewardingBody
{
    public class RewardingBodyAreaRegistration : AreaRegistration
    {
        public override string AreaName
        {
            get
            {
                return "RewardingBody";
            }
        }

        public override void RegisterArea(AreaRegistrationContext context)
        {
            context.MapRoute(
                "RewardingBody_default",
                "RewardingBody/{controller}/{action}/{id}",
                new { controller = "Default", action = "Index", id = UrlParameter.Optional }
            );
        }
    }
}