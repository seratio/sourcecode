using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class LoginResult :ResultSet
    {
        public AppUser AppUser { get; set; }
    }
}