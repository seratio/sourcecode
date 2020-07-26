namespace Seratio.Blockchain.Sandbox.Core.Entities.Common
{
    public class DataTableRequest
    {
        public int sEcho { get; set; }

        public int iDisplayLength { get; set; }

        public int iDisplayStart { get; set; }

        private string _sSearch { get; set; }

        public string sSearch
        {
            get
            {
                return _sSearch;
            }
            set
            {
                _sSearch = !string.IsNullOrEmpty(value) ? value.Trim() : _sSearch;
            }
        }

        public int iSortCol_0 { get; set; }

        public string sSortDir_0 { get; set; }
    }

    public class DataTableRequest_DarteRange
    {
        public int sEcho { get; set; }

        public int iDisplayLength { get; set; }

        public int iDisplayStart { get; set; }

        private string _sSearch { get; set; }

        public string sSearch
        {
            get
            {
                return _sSearch;
            }
            set
            {
                _sSearch = !string.IsNullOrEmpty(value) ? value.Trim() : _sSearch;
            }
        }

        public int iSortCol_0 { get; set; }

        public string sSortDir_0 { get; set; }
        public string daterange { get; set; }
    }
}
