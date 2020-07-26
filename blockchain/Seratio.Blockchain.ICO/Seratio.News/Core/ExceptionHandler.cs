using System;
using System.Collections.Generic;
using System.Configuration;
using System.Diagnostics;
using System.Linq;
using System.Net;
using System.Net.Mail;
using System.Net.Mime;
using System.Web;
using System.Web.Mvc;
using Newtonsoft.Json;

namespace Seratio.News.Core
{
    public class ExceptionHandler
    {
        public static void Handle(Exception ex)
        {
            if (!Debugger.IsAttached && ConfigurationManager.AppSettings["X_EmailExceptions"] == "true")
            {
                try
                {
                    HttpException _httpEx = ex as HttpException;

                    if (_httpEx != null && _httpEx.GetHttpCode() == 404)
                    {
                        return;
                    }

                    string _body = JsonConvert.SerializeObject(ex, Formatting.Indented);

                    _body = _body.Replace("\r\n", "<br />");

                    if (HttpContext.Current != null)
                    {
                        if (ex is HttpAntiForgeryException && HttpContext.Current.Session["_forgeryException"] != null)
                        {
                            return;
                        }
                        else if (ex is HttpAntiForgeryException)
                        {
                            HttpContext.Current.Session["_forgeryException"] = true;
                        }

                        _body = "URL: " + HttpContext.Current.Request.Url + "<br />" + "Prev URL: " +
                                HttpContext.Current.Request.UrlReferrer + "<br />" + _body;

                        if (HttpContext.Current.Request.Form.Count > 0)
                        {
                            _body += $"<br />------------- POST DATA -------------<br />";

                            for (int i = 0; i < HttpContext.Current.Request.Form.Count; i++)
                            {
                                _body +=
                                    $"{HttpContext.Current.Request.Form.Keys[i]} ==> {string.Join("|", HttpContext.Current.Request.Form.GetValues(HttpContext.Current.Request.Form.Keys[i]))} <br />";
                                i++;
                            }
                        }

                        if (HttpContext.Current.Request.QueryString.Count > 0)
                        {
                            _body += $"<br />------------- GET DATA -------------<br />";

                            for (int i = 0; i < HttpContext.Current.Request.QueryString.Count; i++)
                            {
                                _body +=
                                    $"{HttpContext.Current.Request.QueryString.Keys[i]} ==> {string.Join("|", HttpContext.Current.Request.QueryString.GetValues(HttpContext.Current.Request.QueryString.Keys[i]))} <br />";
                                i++;
                            }
                        }

                        if (HttpContext.Current.Request.Cookies.Count > 0)
                        {
                            _body += $"<br />------------- COOKIES -------------<br />";

                            for (int i = 0; i < HttpContext.Current.Request.Cookies.Count; i++)
                            {
                                _body +=
                                    $"{HttpContext.Current.Request.Cookies.Keys[i]} ==> {HttpContext.Current.Request.Cookies[HttpContext.Current.Request.Cookies.Keys[i]].Value} <br />";
                                i++;
                            }
                        }
                    }

                    MailMessage _msg = new MailMessage();

                    _msg.To.Add("developer@markuplab.com");
                    //_msg.CC.Add("sajin.abdu@seratio.com");

                    _msg.From = new MailAddress("dev@markuplab.net", ".NET Development");
                    _msg.Subject = "Application Error in Seratio News (" +
                                   (HttpContext.Current != null ? HttpContext.Current.Request.Url.DnsSafeHost : "") +
                                   ")";
                    _msg.AlternateViews.Add(
                        AlternateView.CreateAlternateViewFromString(_body, null, MediaTypeNames.Text.Html));

                    SmtpClient _smtpClient = new SmtpClient("smtp.sendgrid.net", Convert.ToInt32(587));
                    NetworkCredential _credentials = new NetworkCredential("**************", "**************");
                    _smtpClient.Credentials = _credentials;

                    _smtpClient.Send(_msg);
                }
                catch
                {

                }
            }
        }
    }
}