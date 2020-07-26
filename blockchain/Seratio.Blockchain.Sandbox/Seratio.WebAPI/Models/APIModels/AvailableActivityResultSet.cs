using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class AvailableActivityResultSet
    {
        public int sEcho { get; set; }

        public int iDisplayLength { get; set; }

        public int iDisplayStart { get; set; }

        public long iTotalRecords { get; set; }

        public long iTotalDisplayRecords { get; set; }

        public List<AvailableActivities_Result> aaData { get; set; }
    }
}