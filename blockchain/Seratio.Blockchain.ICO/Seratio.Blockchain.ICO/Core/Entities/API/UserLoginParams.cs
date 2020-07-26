using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.Platform.ICO.Core.Entities.API
{
    public class UserLoginParams
    {
        public string Email { get; set; }

        public string Password { get; set; }
    }
}