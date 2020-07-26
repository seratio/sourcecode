using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class ChangeCredentialRequest
    {
        public string email { get; set; }
        public string SaftyQuestion { get; set; }
        public string Answer { get; set; }
    }
}