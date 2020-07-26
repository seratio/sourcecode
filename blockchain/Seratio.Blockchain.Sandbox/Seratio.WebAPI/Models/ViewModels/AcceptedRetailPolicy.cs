using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class AcceptedRetailPolicyMetaData
    {
        [Display(Name = "User")]
        [Required(ErrorMessage = "Please select a value for User")]
        public int UserID { get; set; }

        [Display(Name = "Policy")]
        [Required(ErrorMessage = "Please select a value for Policy")]
        public int PolicyID { get; set; }

        [Display(Name = "Amount")]
        [Required(ErrorMessage = "Please enter a value for Amount")]
        public decimal Amount { get; set; }

        [Display(Name = "Description")]
        [MaxLength(4000, ErrorMessage = "Description should not have more than 4000 characters")]
        public string Description { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }
    }

    [MetadataType(typeof(AcceptedRetailPolicyMetaData))]
    public partial class AcceptedRetailPolicy
    {
        public Select2Item SelectedUser { get; set; }

        public Select2Item SelectedPolicy { get; set; }

        public string WalletAddress { get; set; }
    }
}


