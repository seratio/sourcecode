using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.WebAPI.Core.Security;
using System.Web;
using System.Web.Mvc;

namespace Seratio.WebAPI
{
    public class FilterConfig
    {
        public static void RegisterGlobalFilters(GlobalFilterCollection filters)
        {
            filters.Add(new HandleErrorAttribute());
        }
    }
}
