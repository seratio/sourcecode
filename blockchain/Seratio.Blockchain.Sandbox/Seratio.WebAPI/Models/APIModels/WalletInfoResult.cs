using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class WalletInfoResult : ResultSet
    {
        public WalletInfo WalletInfo { get; set; }
        public string PaperWallet { get; set; }
        public string Mnemonic { get; set; }
    }
}