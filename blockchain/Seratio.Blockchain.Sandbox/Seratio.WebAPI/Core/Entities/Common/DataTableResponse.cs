using System;
using System.Collections.Generic;

namespace Seratio.Blockchain.Sandbox.Core.Entities.Common
{
    public class DataTableResponse
    {
        public int sEcho { get; set; }

        public int iDisplayLength { get; set; }

        public int iDisplayStart { get; set; }

        public long iTotalRecords { get; set; }

        public long iTotalDisplayRecords { get; set; }

        public List<DataTableRow> aaData { get; set; }
    }

    public class DataTableRow : List<object>
    {

    }

    public class DataTableResponse_Request
    {
        public int sEcho { get; set; }

        public int iDisplayLength { get; set; }

        public int iDisplayStart { get; set; }

        public long iTotalRecords { get; set; }

        public long iTotalDisplayRecords { get; set; }

        public List<DataTableRowAPI_Request> aaData { get; set; }
    }

    public class DataTableRowAPI_Request
    {
        public int ID { get; set; }
        public string Sender { get; set; }
        public string Reciever { get; set; }
        public DateTime SentOn { get; set; }
        public DateTime RespondedOn { get; set; }
        public string Status { get; set; }
        public string Recipient { get; set; }
    }

    public class DataTableResponse_Wallet
    {
        public int sEcho { get; set; }

        public int iDisplayLength { get; set; }

        public int iDisplayStart { get; set; }

        public long iTotalRecords { get; set; }

        public long iTotalDisplayRecords { get; set; }

        public List<DataTableRowAPI_Wallet> aaData { get; set; }
    }


    public class DataTableRowAPI_Wallet
    {
        public int ID { get; set; }
        public string Recipient { get; set; }
        public string Symbol { get; set; }
        public string WalletAddress { get; set; }
        public decimal Amount { get; set; }
        public DateTime Time { get; set; }
        public string TransactionHash { get; set; }
    }



}
