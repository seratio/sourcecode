using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class RetailEndListResult
    {
        public int sEcho { get; set; }

        public int iDisplayLength { get; set; }

        public int iDisplayStart { get; set; }

        public long iTotalRecords { get; set; }

        public long iTotalDisplayRecords { get; set; }

        public List<RetailEndListResultSet> aaData { get; set; }
    }

    public class RetailEndListResultSet
    {
        public int ID { get; set; }
        public string Name { get; set; }
        public string RewardAmount { get; set; }
        public string Description { get; set; }
        public string CreatedOn { get; set; }
        public string NickName { get; set; }
        public bool HasRedeemed { get; set; }
        public string VoucherCode { get; set; }
    }
}