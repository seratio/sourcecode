using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Platform.ICO.Core.Entities.Common;

namespace Seratio.Platform.ICO.Models
{
    public class OfferMetaData
    {
        [Display(Name = "Created By")]
        [Required(ErrorMessage = "Please select a value for Created By")]
        public int CreatedByID { get; set; }

        [Display(Name = "Edited By")]
        [Required(ErrorMessage = "Please select a value for Last Updated By")]
        public int LastUpdatedByID { get; set; }

        [Display(Name = "Title")]
        [Required(ErrorMessage = "Please enter a value for Title")]
        [MaxLength(50, ErrorMessage = "Title should not have more than 50 characters")]
        public string Title { get; set; }

        [Display(Name = "Discount")]
        [Required(ErrorMessage = "Please enter a value for Discount")]
        public int Discount { get; set; }

        [Display(Name = "Last Date")]
        [Required(ErrorMessage = "Please select a value for Last Date")]
        public DateTime LastDate { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }
    }

    [MetadataType(typeof(OfferMetaData))]
    public partial class Offer
    {
        public Select2Item SelectedCreatedBy { get; set; }

        public Select2Item SelectedLastUpdatedBy { get; set; }
    }
}