using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class RequestCertificateRequest
    {
        public string receiver { get; set; }
        public string recipient { get; set; }
        public string message { get; set; }
    }
}