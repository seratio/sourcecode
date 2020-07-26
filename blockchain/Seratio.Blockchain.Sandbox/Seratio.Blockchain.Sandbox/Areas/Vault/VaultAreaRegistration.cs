using System.Web.Mvc;

namespace Seratio.Blockchain.Sandbox.Areas.Vault
{
    public class VaultAreaRegistration : AreaRegistration
    {
        public override string AreaName
        {
            get
            {
                return "Vault";
            }
        }

        public override void RegisterArea(AreaRegistrationContext context)
        {
            context.MapRoute(
                "Vault_default",
                "Vault/{controller}/{action}/{id}",
                new { action = "Index", controller = "Default", id = UrlParameter.Optional }
            );
        }
    }
}