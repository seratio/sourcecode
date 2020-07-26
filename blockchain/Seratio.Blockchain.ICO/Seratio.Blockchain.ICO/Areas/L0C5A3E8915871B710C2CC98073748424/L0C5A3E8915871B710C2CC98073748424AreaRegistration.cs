using System.Web.Mvc;

namespace Seratio.Platform.ICO.Areas.L0C5A3E8915871B710C2CC98073748424
{
    public class L0C5A3E8915871B710C2CC98073748424AreaRegistration : AreaRegistration
    {
        public override string AreaName
        {
            get
            {
                return "L0C5A3E8915871B710C2CC98073748424";
            }
        }

        public override void RegisterArea(AreaRegistrationContext context)
        {
            context.MapRoute(
                "L0C5A3E8915871B710C2CC98073748424_default",
                "L0C5A3E8915871B710C2CC98073748424/{controller}/{action}/{id}",
                new { controller = "Default", action = "Index", id = UrlParameter.Optional }
            );
        }
    }
}