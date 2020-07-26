using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class DataTableResponseResult : ResultSet
    {
        public DataTableResponse DataTableResponse { get; set; }
    }

    public class DataTableResponse_Request_Result : ResultSet
    {
        public DataTableResponse_Request DataTableResponse { get; set; }
    }

    public class DataTableResponse_Wallet_Result : ResultSet
    {
        public DataTableResponse_Wallet DataTableResponse { get; set; }
    }
}