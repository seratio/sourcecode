using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class RetailPolicy_API
    {
        public int UserID { get; set; }
        public int? RequiredCoinID { get; set; }
        public int? ProcessedBy { get; set; }
        public string Name { get; set; }
        public string Description { get; set; }
        public string PolicyType { get; set; }
        public decimal? MinSESCore { get; set; }
        public decimal? MaxSEScore { get; set; }
        public string DiscountMode { get; set; }
        public decimal? RequiredCoinQty { get; set; }
        public decimal DiscountValue { get; set; }
        public bool? IsApproved { get; set; }
        public DateTime? ApprovedOn { get; set; }
        public DateTime? RejectedOn { get; set; }
        public DateTime CreatedOn { get; set; }
        public DateTime LastUpdatedOn { get; set; }
        public DateTime? DeletedOn { get; set; }
        public string Category { get; set; }
        public string VoucherCode { get; set; }
    }
}