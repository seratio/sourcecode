using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Platform.ICO.Core.Entities.Common;

namespace Seratio.Platform.ICO.Models
{
    public class InvestmentMetaData
    {
        [Display(Name = "User")]
        [Required(ErrorMessage = "Please select a value for User")]
        public int UserID { get; set; }

        [Display(Name = "Mode")]
        [Required(ErrorMessage = "Please enter a value for Mode")]
        [MaxLength(50, ErrorMessage = "Mode should not have more than 50 characters")]
        public string Mode { get; set; }

        [Display(Name = "Amount")]
        [Required(ErrorMessage = "Please enter a value for Amount")]
        public decimal Amount { get; set; }

        [Display(Name = "Token")]
        //[Required(ErrorMessage = "Please enter a value for Token")]
        public Guid Token { get; set; }

        [Display(Name = "ICO Type")]
        public string Type { get; set; }

        [Display(Name = "Status")]
        [MaxLength(50, ErrorMessage = "Status should not have more than 50 characters")]
        public string Status { get; set; }

        [Display(Name = "Comments")]
        [MaxLength(4000, ErrorMessage = "Comments should not have more than 4000 characters")]
        public string Comments { get; set; }

        [Display(Name = "Tx Reference Number")]
        [MaxLength(500, ErrorMessage = "Tx Reference Number should not have more than 500 characters")]
        public string TxReferenceNumber { get; set; }

        [Display(Name = "Initialized On")]
        [Required(ErrorMessage = "Please select a value for Initialized On")]
        public DateTime InitializedOn { get; set; }

        [Display(Name = "Tx Ref No Updated On")]
        public DateTime? TxRefNoUpdatedOn { get; set; }

        [Display(Name = "Confirmed On")]
        public DateTime? ConfirmedOn { get; set; }

        [Display(Name = "Rejected On")]
        public DateTime? RejectedOn { get; set; }

        [Display(Name = "Issued On")]
        public DateTime? IssuedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Last Updated By")]
        public int LastUpdatedByID { get; set; }

        [Display(Name = "Received Amount")]
        public decimal ReceivedAmount { get; set; }

        [Display(Name = "Exchange Rate")]
        public string ExchangeRate { get; set; }

        [Display(Name= "Token Amount or Microshare numbers")]
        public decimal TokenAmount { get; set; }
    }

    [MetadataType(typeof(InvestmentMetaData))]
    public partial class Investment
    {
        public Select2Item SelectedUser { get; set; }

        [DataType(DataType.Password)]
        public string Password { get; set; }


        [DataType(DataType.Password)]
        [Compare(nameof(Password), ErrorMessage = "Wallet Password Phrase do not match")]
        [Display(Name = "Confirm Password")]
        public string ConfirmPassword { get; set; }
    }
}