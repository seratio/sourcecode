using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using System;
using System.ComponentModel.DataAnnotations;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class SocialActivityMetaData
    {
        [Display(Name = "User")]
        [Required(ErrorMessage = "Please select a value for User")]
        public int UserID { get; set; }

        [Display(Name = "Name")]
        [Required(ErrorMessage = "Please enter a value for Name")]
        [MaxLength(100, ErrorMessage = "Name should not have more than 100 characters")]
        public string Name { get; set; }

        [Display(Name = "Description")]
        [MaxLength(4000, ErrorMessage = "Description should not have more than 4000 characters")]
        public string Description { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }

        [Display(Name = "Reward Amount")]
        [Required(ErrorMessage = "Please enter a value for Reward Amount")]
        public decimal RewardAmount { get; set; }

        [Display(Name = "Is Approved?")]
        public bool? IsApproved { get; set; }

        [Display(Name = "Approved On")]
        public DateTime? ApprovedOn { get; set; }

        [Display(Name = "Rejected On")]
        public DateTime? RejectedOn { get; set; }

        [Display(Name = "Rewarding Coin")]
        [Required(ErrorMessage = "Please select a value for Rewarding Coin")]
        public int RewardingCoinID { get; set; }
    }

    [MetadataType(typeof(SocialActivityMetaData))]
    public partial class SocialActivity
    {
        public Select2Item SelectedUser { get; set; }

        public Select2Item SelectedRewardingCoin { get; set; }
    }
}