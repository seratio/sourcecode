using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class TransferCoinRequest
    {
        public string recipient { get; set; }
        public decimal amount { get; set; }
        public int CoinID { get; set; }
        public string mnemonic { get; set; }
        public Guid transactionid { get; set; }
        public int gas { get; set; } = 40;
    }
}