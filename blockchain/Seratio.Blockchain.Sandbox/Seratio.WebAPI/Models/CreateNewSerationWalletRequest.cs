using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models
{
    public class CreateNewSerationWalletRequest
    {
        public string password { get; set; }
        public string confirmpassword { get; set; }
    }
}