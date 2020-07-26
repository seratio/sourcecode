using System.Web.Mvc;
using Seratio.Platform.ICO.Core.Security;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Controllers
{
    [AuthorizeFrontendAccess]
    public class FrontendBaseController : BaseController
    {

    }
}