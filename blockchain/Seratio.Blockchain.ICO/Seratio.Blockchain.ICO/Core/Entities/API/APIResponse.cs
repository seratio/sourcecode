using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.Platform.ICO.Core.Entities.API
{
    public class APIResponse
    {
        public bool WasSuccess { get; set; }

        public string Message { get; set; }

        public object Data { get; set; }
    }
}