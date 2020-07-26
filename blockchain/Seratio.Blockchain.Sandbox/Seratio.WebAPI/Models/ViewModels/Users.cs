using System;
using System.ComponentModel.DataAnnotations;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class UserMetaData
    {
        [Display(Name = "Email")]
        [Required(ErrorMessage = "Please enter a value for Email")]
        [MaxLength(100, ErrorMessage = "Email should not have more than 100 characters")]
        [EmailAddress(ErrorMessage = "Please enter a valid Email Address")]
        public string Email { get; set; }

        [Display(Name = "Gender")]
        [MaxLength(10, ErrorMessage = "Gender should not have more than 10 characters")]
        public string Gender { get; set; }

        [Display(Name = "Phone")]
        [MaxLength(50, ErrorMessage = "Phone should not have more than 50 characters")]
        public string Phone { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Preferred Name")]
        public string NickName { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }

        [Display(Name = "Forgot Password Token")]
        public Guid? ForgotPasswordToken { get; set; }
        //[Display(Name = "Username")]
        //[Required(ErrorMessage = "Please enter a value for Username")]
        //[MaxLength(50, ErrorMessage = "Username should not have more than 50 characters")]
        //public string Username { get; set; }

        [Display(Name = "Allow My Profile to be Searched")]
        public bool IsSearchable { get; set; }

        [Display(Name = "S/E Value")]
        public decimal? SE { get; set; }

        [Display(Name = "Asset Transaction Criteria")]
        [MaxLength(50, ErrorMessage = "Asset Transaction Criteria should not have more than 50 characters")]
        public string AssetTransactionCriteria { get; set; }

        [Display(Name = "Asset Transaction Criteria Value")]
        public decimal? AssetTransactionCriteriaValue { get; set; }

        [Display(Name = "Email Verification Token")]
        public Guid? EmailVerificationToken { get; set; }

        [Display(Name = "Is Email Verified?")]
        public bool IsEmailVerified { get; set; }

        [Display(Name = "Email Verified On")]
        public DateTime? EmailVerifiedOn { get; set; }

        [Display(Name = "Security Question")]
        [MaxLength(250, ErrorMessage = "Security Question should not have more than 250 characters")]
        public string SaftyQuestion { get; set; }

        [Display(Name = "Security Answer")]
        public byte[] SaftyAnswer { get; set; }

        [Display(Name = "Allow identification using QR Code?")]
        public bool ShouldAllowSignInWithQR { get; set; }

        [Display(Name = "Allow Email Notifications?")]
        public bool AllowEmailNotifications { get; set; }
    }

    [MetadataType(typeof(UserMetaData))]
    public partial class User
    {
        //[RegularExpression(@"^[a-zA-Z\s.,0-9@#$%*():;""'/?!+=_-]{1,10}$", ErrorMessage = "Valid password required")]
        //  [MaxLength(10)]
        [MinLength(5)]
        [DataType(DataType.Password)]
        //[RegularExpression("^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*?[#?!@$%^&*-])$", ErrorMessage = "Invalid Password")]
        //[RegularExpression(@"^[(?=.*\d)][?=.*[A-Z]][?=.*[a-z]][(?=.*\W)]", ErrorMessage = "Invalid Password")]
        public string Password { get; set; }
     
        [DataType(DataType.Password)]
        [Compare("Password")]
        [Display(Name = "Confirm Password")]
        public string ConfirmPassword { get; set; }

        public string Answer { get; set; }

    }
}