using System;
using System.ComponentModel.DataAnnotations;

namespace Seratio.Platform.ICO.Models
{
    public class AdministratorMetaData
    {
        [Display(Name = "Is Super Admin?")]
        public bool IsSuperAdmin { get; set; }

        [Display(Name = "Email")]
        [Required(ErrorMessage = "Please enter a value for Email")]
        [MaxLength(50, ErrorMessage = "Email should not have more than 50 characters")]
        [EmailAddress(ErrorMessage = "Please enter a valid Email Address")]
        public string Email { get; set; }

        [Display(Name = "Name")]
        [Required(ErrorMessage = "Please enter a value for Name")]
        [MaxLength(50, ErrorMessage = "Name should not have more than 50 characters")]
        public string Name { get; set; }

        [Display(Name = "Phone")]
        [MaxLength(50, ErrorMessage = "Phone should not have more than 50 characters")]
        public string Phone { get; set; }

        [Display(Name = "Is Active?")]
        public bool IsActive { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }
    }

    [MetadataType(typeof(AdministratorMetaData))]
    public partial class Administrator
    {
        [DataType(DataType.Password)]
        public string Password { get; set; }


        [DataType(DataType.Password)]
        [Compare(nameof(Password), ErrorMessage = "Passwords do not match")]
        [Display(Name = "Confirm Password")]
        public string ConfirmPassword { get; set; }
    }
}