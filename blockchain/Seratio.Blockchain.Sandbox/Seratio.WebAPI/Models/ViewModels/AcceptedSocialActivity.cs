using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using System;
using System.ComponentModel.DataAnnotations;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class AcceptedSocialActivityMetaData
    {
        [Display(Name = "User")]
        [Required(ErrorMessage = "Please select a value for User")]
        public int UserID { get; set; }

        [Display(Name = "Activity")]
        [Required(ErrorMessage = "Please select a value for Activity")]
        public int ActivityID { get; set; }

        [Display(Name = "Description")]
        [MaxLength(4000, ErrorMessage = "Description should not have more than 4000 characters")]
        public string Description { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }

        [Display(Name = "Rewarded Amount")]
        [Required(ErrorMessage = "Please Enter the Rewarded Amount")]
        public decimal RewardedAmount { get; set; }
    }

    [MetadataType(typeof(AcceptedSocialActivityMetaData))]
    public partial class AcceptedSocialActivity
    {
        public Select2Item SelectedUser { get; set; }

        public Select2Item SelectedActivity { get; set; }

        public string WalletAddress { get; set; }
    }
}