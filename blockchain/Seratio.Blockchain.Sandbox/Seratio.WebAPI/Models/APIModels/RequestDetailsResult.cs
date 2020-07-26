using Seratio.Blockchain.Sandbox.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class RequestDetailsResult : ResultSet
    {
        public Request_API Request { get; set; }
    }
}