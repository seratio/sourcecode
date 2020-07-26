using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Platform.ICO.Core.Entities.Common;

namespace Seratio.Platform.ICO.Models
{
    public class administratorSessionMetaData
    {
        [Display(Name = "Administrator")]
        [Required(ErrorMessage = "Please select a value for Administrator")]
        public int AdministratorID { get; set; }

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

    [MetadataType(typeof(administratorSessionMetaData))]
    public partial class administratorSession
    {
        public Select2Item SelectedAdministrator { get; set; }
    }
}