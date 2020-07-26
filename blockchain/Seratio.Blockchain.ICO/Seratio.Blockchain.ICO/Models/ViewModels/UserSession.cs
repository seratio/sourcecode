using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Platform.ICO.Core.Entities.Common;

namespace Seratio.Platform.ICO.Models
{
    public class UserSessionMetaData
    {
        [Display(Name = "User")]
        [Required(ErrorMessage = "Please select a value for User")]
        public int UserID { get; set; }

        [Display(Name = "Start Time")]
        [Required(ErrorMessage = "Please select a value for Start Time")]
        public DateTime StartTime { get; set; }

        [Display(Name = "End Time")]
        public DateTime? EndTime { get; set; }

        [Display(Name = "IP Address")]
        public string IPAddress { get; set; }

        [Display(Name = "User Agent")]
        public string UserAgent { get; set; }
    }

    [MetadataType(typeof(UserSessionMetaData))]
    public partial class UserSession
    {
        public Select2Item SelectedUser { get; set; }
    }
}