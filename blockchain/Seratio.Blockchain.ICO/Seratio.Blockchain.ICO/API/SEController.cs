using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.API;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Models;
using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Data.Entity.Validation;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web.Http;

namespace Seratio.Platform.ICO.API
{
    public class SEController : BaseAPIController
    {
        [HttpPost]
        [AllowAnonymous]
        [Route("api/se/storesocialvalue")]
        public async Task<IHttpActionResult> StoreSocialValue(SocialValueParams model)
        {
            if (model.ID == 0 || model.Token == new Guid() || string.IsNullOrEmpty(model.SuccessUrl))
            {
                return BadRequest("Invalid Parameters");
            }
            else
            {

            }

            return Ok();
        }
    }
}
