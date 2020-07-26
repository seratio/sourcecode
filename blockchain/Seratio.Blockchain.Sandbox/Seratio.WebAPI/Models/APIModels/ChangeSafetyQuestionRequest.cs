using Seratio.Blockchain.Sandbox.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class ChangeSafetyQuestionRequest
    {
        public string NewSaftyQuestion { get; set; }
        public string OldAnswer { get; set; }
        public string NewAnswer { get; set; }
    }
}