using System.Web.Mvc;

namespace Seratio.Platform.ICO.Areas.Users
{
    public class UsersAreaRegistration : AreaRegistration
    {
        public override string AreaName
        {
            get
            {
                return "Users";
            }
        }

        public override void RegisterArea(AreaRegistrationContext context)
        {
            context.MapRoute(
                "Users_default",
                "Users/{controller}/{action}/{id}",
                new { controller = "Default", action = "Index", id = UrlParameter.Optional },
                  namespaces: new string[] {
                    "Seratio.Platform.ICO.Areas.Users.Controllers"
                }
            );
        }
    }
}