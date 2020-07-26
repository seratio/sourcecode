using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class RetailPolicyMetaData
    {
        [Display(Name = "User")]
        [Required(ErrorMessage = "Please select a value for User")]
        public int UserID { get; set; }

        [Display(Name = "Coin")]
        public int? RequiredCoinID { get; set; }

        [Display(Name = "Processed By")]
        public int? ProcessedBy { get; set; }

        [Display(Name = "Name")]
        [Required(ErrorMessage = "Please enter a value for Name")]
        [MaxLength(100, ErrorMessage = "Name should not have more than 100 characters")]
        public string Name { get; set; }

        [Display(Name = "Description")]
        [MaxLength(4000, ErrorMessage = "Description should not have more than 4000 characters")]
        public string Description { get; set; }

        [Display(Name = "Policy Type")]
        [Required(ErrorMessage = "Please enter a value for Policy Type")]
        [MaxLength(50, ErrorMessage = "Policy Type should not have more than 50 characters")]
        public string PolicyType { get; set; }

        [Display(Name = "Minimum SE Score")]
        public decimal? MinSESCore { get; set; }

        [Display(Name = "Maximum SE Score")]
        public decimal? MaxSEScore { get; set; }

        [Display(Name = "Discount Type")]
        [Required(ErrorMessage = "Please enter a value for Discount Type")]
        [MaxLength(50, ErrorMessage = "Discount Type should not have more than 50 characters")]
        public string DiscountMode { get; set; }

        [Display(Name = "Coin Amount")]
        public decimal? RequiredCoinQty { get; set; }

        [Display(Name = "Discount Value")]
        [Required(ErrorMessage = "Please enter a value for Discount Value")]
        public decimal DiscountValue { get; set; }

        [Display(Name = "Is Approved?")]
        public bool? IsApproved { get; set; }

        [Display(Name = "Approved On")]
        public DateTime? ApprovedOn { get; set; }

        [Display(Name = "Rejected On")]
        public DateTime? RejectedOn { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }

        [Display(Name = "Related Category")]
        public string Category { get; set; }

        [Display(Name = "Voucher Code")]
        [Required(ErrorMessage = "Please enter a Voucher Code")]
        [MaxLength(10)]
        public string VoucherCode { get; set; }
    }

    [MetadataType(typeof(RetailPolicyMetaData))]
    public partial class RetailPolicy
    {
        public Select2Item SelectedUser { get; set; }

        public Select2Item SelectedRequiredCoin { get; set; }
    }
}


