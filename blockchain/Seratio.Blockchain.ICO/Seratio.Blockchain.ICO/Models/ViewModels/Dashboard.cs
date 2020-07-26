using System.Collections.Generic;
using Seratio.Platform.ICO.Core.Entities.Common;

namespace Seratio.Platform.ICO.Models
{
    public class Dashboard
    {
        public List<ChartItem> Summary { get; set; }

        public List<ChartItem> SummaryWithSum { get; set; }

        public List<InvestmentDetail> Investments { get; set; }

        public List<DonutChartItem> TopModes { get; set; }
    }
}