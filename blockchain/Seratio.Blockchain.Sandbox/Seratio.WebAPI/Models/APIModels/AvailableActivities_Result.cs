using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class AvailableActivities_Result
    {
        public int ID { get; set; }
        public string Name { get; set; }
        public string RewardAmount { get; set; }
        public DateTime RespondedOn { get; set; }
        public string Status { get; set; }
        public string ProcessedBy { get; set; }
        public string Description { get; set; }
        public string LastUpdatedOn { get; set; }
        public string UserName { get; set; }
        public int UserID { get; set; }
        public int? ProcessedByID { get; set; }
        public string SenderName { get; set; }
    }
}