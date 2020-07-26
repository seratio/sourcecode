using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class DownloadAddressQRImageResult :ResultSet
    {
        public string _sigBase64 { get; set; }
    }
}