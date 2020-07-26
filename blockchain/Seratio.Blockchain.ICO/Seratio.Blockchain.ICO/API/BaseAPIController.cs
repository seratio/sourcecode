using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web.Http;

namespace Seratio.Platform.ICO.API
{
    public class BaseAPIController : ApiController
    {
        protected DatabaseEntities db = DatabaseContextManager.Current;

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
