using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Web;
using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.WebAPI.Models.APIModels
{

    public class Request_API
    {
        public int ID { get; set; }
        public int SenderID { get; set; }
        public string Sender { get; set; }
        public string Recipient { get; set; }
        public string Message { get; set; }
        public string Status { get; set; }
        public bool HasDownloaded { get; set; }
        public bool HasRejected { get; set; }
        public System.DateTime SentOn { get; set; }
        public Nullable<System.DateTime> RespondedOn { get; set; }
        public bool IsDataActive { get; set; }
    }

    public class RequestResult: ResultSet
    {
        public List<Request_API> Requests { get; set; }
    }
}