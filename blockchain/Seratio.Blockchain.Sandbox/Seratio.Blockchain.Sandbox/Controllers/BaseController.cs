using System.Text.RegularExpressions;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;
using System.Web.Mvc;
namespace Seratio.Blockchain.Sandbox.Controllers
{
    [AuthorizeAccess]
    public class BaseController : Controller
    {
        protected PlatformDatabaseEntities db = DatabaseContextManager.Current;

        public bool IsValidAddress(string address)
        {
            if (string.IsNullOrEmpty(address))
            {
                return false;
            }

            return new Regex(@"^0x[a-fA-F0-9]{40}$").IsMatch(address);
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }

            base.Dispose(disposing);
        }
    }
}