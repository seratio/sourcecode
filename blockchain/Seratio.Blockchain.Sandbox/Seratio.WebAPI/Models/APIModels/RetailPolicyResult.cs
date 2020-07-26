using Seratio.Blockchain.Sandbox.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Script.Serialization;

namespace Seratio.WebAPI.Models.APIModels
{
    public class RetailPolicyResult : ResultSet
    {
        public int PaymentID {get;set;}
        [ScriptIgnoreAttribute]
        public RetailPolicy_API RetailPolicy { get; set; }
    }
}