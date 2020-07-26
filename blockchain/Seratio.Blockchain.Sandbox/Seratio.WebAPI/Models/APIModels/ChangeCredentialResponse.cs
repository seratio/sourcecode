using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class ChangeCredentialResponse :ResultSet
    {
        public string _hash { get; set; }
        public Guid? token { get; set; }
    }
}