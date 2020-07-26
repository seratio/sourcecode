using System;
using System.ComponentModel.DataAnnotations;

namespace Seratio.Platform.ICO.Models
{
    public class UserMetaData
    {

        [Display(Name = "Title")]
        [MaxLength(50, ErrorMessage = "Title should not have more than 50 characters")]
        public string Title { get; set; }

        [Display(Name = "First Name")]
        [MaxLength(50, ErrorMessage = "First Name should not have more than 50 characters")]
        public string FirstName { get; set; }

        [Display(Name = "Last Name")]
        [MaxLength(50, ErrorMessage = "Last Name should not have more than 50 characters")]
        public string LastName { get; set; }

        [Display(Name = "Postal Address")]
        [MaxLength(500, ErrorMessage = "Postal Address should not have more than 500 characters")]
        public string PostalCode { get; set; }

        [Display(Name = "Gender")]
        [Required(ErrorMessage = "Please enter a value for Gender", AllowEmptyStrings = true)]
        [MaxLength(50, ErrorMessage = "Gender should not have more than 50 characters")]
        public string Gender { get; set; }

        [Display(Name = "Position")]
        [MaxLength(50, ErrorMessage = "Position should not have more than 50 characters")]
        public string Position { get; set; }

        [Display(Name = "Organization")]
        [MaxLength(50, ErrorMessage = "Organization should not have more than 50 characters")]
        public string Organization { get; set; }

        [Display(Name = "Email")]
        [Required(ErrorMessage = "Please enter a value for Email")]
        [MaxLength(50, ErrorMessage = "Email should not have more than 50 characters")]
        [EmailAddress(ErrorMessage = "Please enter a valid Email Address")]
        public string Email { get; set; }

        [Display(Name = "Phone")]
        [MaxLength(50, ErrorMessage = "Phone should not have more than 50 characters")]
        public string Phone { get; set; }

        [Display(Name = "Email Verification Token")]
        public Guid? EmailVerificationToken { get; set; }

        [Display(Name = "Is Email Verified?")]
        public bool IsEmailVerified { get; set; }

        [Display(Name = "Email Verified On")]
        public DateTime? EmailVerifiedOn { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }
    }

    [MetadataType(typeof(UserMetaData))]
    public partial class User
    {
        [DataType(DataType.Password)]
        public string Password { get; set; }


        [DataType(DataType.Password)]
        [Compare(nameof(Password), ErrorMessage = "Passwords do not match")]
        [Display(Name = "Confirm Password")]
        public string ConfirmPassword { get; set; }
    }
}