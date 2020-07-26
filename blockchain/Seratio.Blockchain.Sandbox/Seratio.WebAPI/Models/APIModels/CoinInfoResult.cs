using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class CoinInfoResult :ResultSet
    {
        public decimal GasPrice { get; set; }
        public decimal SafeGasPrice { get; set; }
        public decimal FastGasPrice { get; set; }
        public decimal FastestGasPrice { get; set; }
        public string Icon { get; set; }
    }
}