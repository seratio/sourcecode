using System;
using System.Web.Mvc;

namespace Seratio.Platform.ICO.Controllers
{
    public class DefaultController : Controller
    {
        [AllowAnonymous]
        public ActionResult Error()
        {
            return View();
        }

        [AllowAnonymous]
        public bool HasICOStarted()
        {
            return DateTime.Now >= new DateTime(2017, 09, 15, 00, 01, 00);
        }
    }
}