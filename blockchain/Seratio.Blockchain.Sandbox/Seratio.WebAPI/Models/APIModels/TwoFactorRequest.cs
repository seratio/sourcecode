using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class TwoFactorRequest
    {
        public string otp { get; set; }
        public string id { get; set; }
    }
}