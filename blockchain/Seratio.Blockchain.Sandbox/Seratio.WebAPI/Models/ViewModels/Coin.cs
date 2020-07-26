using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class CoinMetaData
    {
        [Display(Name = "User")]
        [Required(ErrorMessage = "Please select a value for User")]
        public int UserID { get; set; }

        [Display(Name = "Name")]
        [Required(ErrorMessage = "Please enter a value for Name")]
        [MaxLength(100, ErrorMessage = "Name should not have more than 100 characters")]
        public string Name { get; set; }

        [Display(Name = "Blockchain")]
        [Required(ErrorMessage = "Please select a value for Blockchain")]
        public int BlockchainID { get; set; }

        [Display(Name = "Symbol")]
        [Required(ErrorMessage = "Please enter a value for Name")]
        [MaxLength(50, ErrorMessage = "Name should not have more than 100 characters")]
        public string Symbol { get; set; }

        [Display(Name = "Description")]
        [MaxLength(1000, ErrorMessage = "Description should not have more than 1000 characters")]
        public string Description { get; set; }

        [Display(Name = "Address")]
        [MaxLength(50, ErrorMessage = "Address should not have more than 50 characters")]
        //[RegularExpression("Please enter valid Addrees", "^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$")]
        public string Address { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Number of Decimal")]
        [Required(ErrorMessage = "Please select a value for Number of Decimals")]
        public int NumberOfDecimals { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }
    }

    [MetadataType(typeof(CoinMetaData))]
    public partial class Coin
    {
        public Select2Item SelectedUser { get; set; }

        public decimal Balance { get; set; }

        public decimal LockedDepositValue { get; set; }

        public decimal TotalDepositValue { get; set; }

        public Select2Item SelectedBlockchain { get; set; }
    }
}