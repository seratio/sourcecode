using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class ModuleAccessAPIRequest
    {
        public int ID { get; set; }
        public int UserID { get; set; }
        public Nullable<int> ProcessedBy { get; set; }
        public string Module { get; set; }
        public string Message { get; set; }
        public Nullable<bool> IsApproved { get; set; }
        public System.DateTime CreatedOn { get; set; }
        public Nullable<System.DateTime> ApprovedOn { get; set; }
        public Nullable<System.DateTime> RejectedOn { get; set; }
    }
}