using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Platform.ICO.Core.Entities.Common;

namespace Seratio.Platform.ICO.Models
{
    public class WalletMetaData
    {
        [Display(Name = "User")]
        public int UserID { get; set; }

        [Display(Name = "Created By")]
        public int CreatedByID { get; set; }

        [Display(Name = "Address")]
        [Required(ErrorMessage = "Please enter the Address of the Wallet")]
        [MaxLength(250, ErrorMessage = "Address should not have more than 250 characters")]
        public string Address { get; set; }

        [Display(Name = "Wallet File")]
        [MaxLength(250, ErrorMessage = "Wallet File should not have more than 250 characters")]
        public string WalletFile { get; set; }

        [Display(Name = "Wallet HTML File")]
        [MaxLength(250, ErrorMessage = "Wallet HTML File should not have more than 250 characters")]
        public string WalletHTMLFile { get; set; }

        [Display(Name = "Wallet Image File")]
        [MaxLength(250, ErrorMessage = "Wallet Image File should not have more than 250 characters")]
        public string WalletImageFile { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }
    }

    [MetadataType(typeof(WalletMetaData))]
    public partial class Wallet
    {
        public Select2Item SelectedUser { get; set; }

        public Select2Item SelectedCreatedBy { get; set; }
    }
}