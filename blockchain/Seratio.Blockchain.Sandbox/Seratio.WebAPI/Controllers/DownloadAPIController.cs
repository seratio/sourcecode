using Microsoft.Owin.Security;
using QRCoder;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Data.Entity;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web.Hosting;
using System.Web.Http;
using System.Web.Http.Cors;

namespace Seratio.WebAPI.Controllers
{
    //[APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class DownloadAPIController : BaseAPIController
    {
        [HttpPost]
        [Route("api/DownloadFile")]
        public async Task< HttpResponseMessage> DownloadFile(string file)
        {
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                byte[] _downloadBytes = System.IO.File.ReadAllBytes(HostingEnvironment.MapPath($"~//Files//{file}"));
                // return File(_downloadBytes, file.ToLower().EndsWith(".pdf") ? "application/pdf" : "text/plain", Server.UrlEncode(Path.GetFileName(file)));

                //adding bytes to memory stream   
                var dataStream = new MemoryStream(_downloadBytes);

                HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.OK);
                httpResponseMessage.Content = new StreamContent(dataStream);
                httpResponseMessage.Content.Headers.ContentDisposition = new System.Net.Http.Headers.ContentDispositionHeaderValue("attachment");
                httpResponseMessage.Content.Headers.ContentDisposition.FileName = file;
                httpResponseMessage.Content.Headers.ContentType = new System.Net.Http.Headers.MediaTypeHeaderValue("application/octet-stream");
                return httpResponseMessage;
            }
            else
            {
                HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.Unauthorized);
                return httpResponseMessage;
            }
        }

        //[HttpGet]
        //[Route("api/DownloadKeys")]
        //public async Task<HttpResponseMessage> DownloadKeys(string file)
        //{
        //    AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
        //    if (ticket != null)
        //    {
        //        int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
        //        User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
        //        string path = HostingEnvironment.MapPath($"~\\keys") + "\\" + file;
        //        byte[] _downloadBytes = System.IO.File.ReadAllBytes(path);
        //        // return File(_downloadBytes, file.ToLower().EndsWith(".pdf") ? "application/pdf" : "text/plain", Server.UrlEncode(Path.GetFileName(file)));

        //        //adding bytes to memory stream
        //        var dataStream = new MemoryStream(_downloadBytes);

        //        HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.OK);
        //        httpResponseMessage.Content = new StreamContent(dataStream);
        //        httpResponseMessage.Content.Headers.ContentDisposition = new System.Net.Http.Headers.ContentDispositionHeaderValue("attachment");
        //        httpResponseMessage.Content.Headers.ContentDisposition.FileName = file;
        //        httpResponseMessage.Content.Headers.ContentType = new System.Net.Http.Headers.MediaTypeHeaderValue("application/octet-stream");
        //        return httpResponseMessage;
        //    }
        //    else
        //    {
        //        HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.Unauthorized);
        //        return httpResponseMessage;
        //    }
        //}

        [HttpPost]
        [Route("api/DownloadAddressQRImage")]
        public async Task<DownloadAddressQRImageResult> DownloadAddressQRImage(DownloadAddressQRImageRequest model)
        {
            DownloadAddressQRImageResult result = new DownloadAddressQRImageResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);

                if (_user != null)
                {
                    try
                    {
                        using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
                        {
                            using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode(model.address, QRCodeGenerator.ECCLevel.Q))
                            {
                                using (QRCode _qrCode = new QRCode(_qrCodeData))
                                {
                                    using (Bitmap _qrCodeImage = _qrCode.GetGraphic(20, "#0067a3", "#ffffff"))
                                    {
                                        using (MemoryStream _ms = new MemoryStream())
                                        {
                                            var dataStream = _ms;
                                            //HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.OK);
                                            //httpResponseMessage.Content = new StreamContent(dataStream);
                                            //httpResponseMessage.Content.Headers.ContentDisposition = new System.Net.Http.Headers.ContentDispositionHeaderValue("attachment");
                                            //httpResponseMessage.Content.Headers.ContentDisposition.FileName = model.address + ".jpeg";
                                            //httpResponseMessage.Content.Headers.ContentType = new System.Net.Http.Headers.MediaTypeHeaderValue("application/octet-stream");
                                            //return httpResponseMessage;
                                            _qrCodeImage.Save(_ms, ImageFormat.Jpeg);
                                            byte[] _imageData =  _ms.ToArray();
                                            string _sigBase64 = Convert.ToBase64String(_imageData);
                                            result._sigBase64 = _sigBase64;
                                            result.Status = true;
                                            return  result;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    catch (Exception ex)
                    {
                        result.Message =ex.Message;
                        return result;
                    }

                   
                }
                else
                {
                    result.Message = "You are not authorized.";
                    return result;
                }

            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        //[HttpGet]
        //[Route("api/DownloadAddressQRImage")]
        //public async Task<string> DownloadAddressQRImage()
        //{
        //    AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
        //    if (ticket != null)
        //    {
        //        int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
        //        User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);

        //        if (_user != null)
        //        {
        //            try
        //            {
        //                using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
        //                {
        //                    using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode("0xaceA6F75293E9b7bffE6e6192Fa07A9F920E151A", QRCodeGenerator.ECCLevel.Q))
        //                    {
        //                        using (QRCode _qrCode = new QRCode(_qrCodeData))
        //                        {
        //                            using (Bitmap _qrCodeImage = _qrCode.GetGraphic(20, "#0067a3", "#ffffff"))
        //                            {
        //                                using (MemoryStream _ms = new MemoryStream())
        //                                {
        //                                    var dataStream = _ms;

        //                                    //HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.OK);
        //                                    //httpResponseMessage.Content = new StreamContent(dataStream);
        //                                    //httpResponseMessage.Content.Headers.ContentDisposition = new System.Net.Http.Headers.ContentDispositionHeaderValue("attachment");
        //                                    //httpResponseMessage.Content.Headers.ContentDisposition.FileName = "0xaceA6F75293E9b7bffE6e6192Fa07A9F920E151A.jpeg";
        //                                    //httpResponseMessage.Content.Headers.ContentType = new System.Net.Http.Headers.MediaTypeHeaderValue("application/octet-stream");
        //                                    //return httpResponseMessage;
        //                                    _qrCodeImage.Save(_ms, ImageFormat.Jpeg);
        //                                     byte[] _imageData = _ms.ToArray();
        //                                     string _sigBase64 = Convert.ToBase64String(_imageData);
        //                                     return _sigBase64;
        //                                }
        //                            }
        //                        }
        //                    }
        //                }
        //            }
        //            catch (Exception ex)
        //            {
        //                HttpResponseMessage httpResponseMessage = Request.CreateResponse(ex.Message);
        //                return "error";
        //            }

        //        }
        //        else
        //        {
        //            HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.Unauthorized);
        //            return httpResponseMessage;
        //        }

        //    }
        //    else
        //    {
        //        HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.Unauthorized);
        //        return httpResponseMessage;
        //    }
        //}
    }
}
