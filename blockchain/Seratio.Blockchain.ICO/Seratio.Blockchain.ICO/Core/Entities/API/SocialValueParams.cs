using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Newtonsoft.Json;

namespace Seratio.Platform.ICO.Core.Entities.API
{
    public class SocialValueParams
    {
        [JsonIgnore]
        public int ID { get; set; }

        [JsonIgnore]
        public Guid Token { get; set; }

        [JsonIgnore]
        public string ErrorUrl { get; set; }

        [JsonIgnore]
        public string SuccessUrl { get; set; }

        public decimal positive { get; set; }

        public decimal neutral { get; set; }

        public decimal negative { get; set; }

        public DateTime sentimentDate { get; set; }

        public decimal targetPopulation { get; set; }

        public double marginErrors { get; set; }

        public decimal nonstatutorySpend { get; set; }

        public decimal serviceUsers { get; set; }

        public decimal assetValue { get; set; }

        public decimal staff { get; set; }

        public decimal carbonReduction { get; set; }

        public decimal carbonOffset { get; set; }

        public decimal people { get; set; }

        public decimal moneyLeveraged { get; set; }
    }
}