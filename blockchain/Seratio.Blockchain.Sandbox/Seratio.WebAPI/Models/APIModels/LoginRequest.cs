using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class LoginRequest
    {
        public string username { get; set; }
        public string password { get; set; }
        public string next { get; set; }
        public bool remindme { get; set; } = false;

    }
}