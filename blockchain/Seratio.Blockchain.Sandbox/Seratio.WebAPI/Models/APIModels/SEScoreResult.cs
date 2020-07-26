using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class SEScoreResult : ResultSet
    {
        public SAPIResponse SAPIResponse { get; set; }
    }
}