using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.WebAPI.Models.APIModels
{
    public class SignUpResult : ResultSet
    {
        public User User { get; set; }
    }
}