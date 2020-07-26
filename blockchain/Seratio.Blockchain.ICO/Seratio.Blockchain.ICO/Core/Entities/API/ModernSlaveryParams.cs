using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Newtonsoft.Json;

namespace Seratio.Platform.ICO.Core.Entities.API
{
    public class ModernSlaveryParams
    {
        [JsonIgnore]
        public int ID { get; set; }

        [JsonIgnore]
        public Guid Token { get; set; }

        [JsonIgnore]
        public string ErrorUrl { get; set; }

        [JsonIgnore]
        public string SuccessUrl { get; set; }

        public int financialYear { get; set; }

        public decimal totalSalary { get; set; }

        public int totalStaff { get; set; }

        public double sentiment { get; set; }
    }
}