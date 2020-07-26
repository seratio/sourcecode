using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.Blockchain.Sandbox.Core.Entities.Blockchain
{
    public class EtherChainApiresponse
    {
        public decimal safeLow { get; set; }

        public decimal standard { get; set; }

        public decimal fast { get; set; }

        public decimal fastest { get; set; }
    }
}