using System;

namespace Seratio.Blockchain.Sandbox.Core.Entities.SAPI
{
    public class SAPIResponse
    {
        public Data data { get; set; }

        public string status { get; set; }
    }

    public class Data
    {
        public int id { get; set; }

        public string email { get; set; }

        public string country { get; set; }

        public string currency { get; set; }

        public decimal family { get; set; }

        public decimal worth { get; set; } 

        public decimal carbon_reduction { get; set; }

        public decimal csr { get; set; }

        public decimal people { get; set; }

        public decimal money_leveraged { get; set; }

        public double pv { get; set; }

        public DateTime created_at { get; set; }

        public DateTime updated_at { get; set; }
    }

}