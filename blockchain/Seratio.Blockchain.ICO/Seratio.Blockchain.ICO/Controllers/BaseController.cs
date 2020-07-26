using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Controllers
{
    public class BaseController : Controller
    {
        protected DatabaseEntities db = new DatabaseEntities();

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