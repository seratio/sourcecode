using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Net.Mail;
using System.Net.Mime;

public partial class Contact : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        if (Request.HttpMethod == "POST" && !Request.IsLocal && !string.IsNullOrEmpty(Request.Form["first_name"]) && !string.IsNullOrEmpty(Request.Form["last_name"]) && !string.IsNullOrEmpty(Request.Form["email"]))
        {
            if (Request.Form["t"] != null && Session["X_Email_Key"] != null && Request.Form["t"].ToString() == Session["X_Email_Key"].ToString())
            {
                MailMessage _msg = new MailMessage();

                //_msg.To.Add("info@cceg.org.uk");
                //_msg.To.Add("info@seratio.com");
                _msg.To.Add("blockchain.lab@cceg.org.uk");

                _msg.From = new MailAddress("no-reply@seratio-coins.world", "Seratio ICO Website");
                _msg.Subject = "Contact Us - seratio-coins.world";
                string body =
                    "Name: " + string.Format("{0} {1}", Request.Form["first_name"], Request.Form["last_name"]) +
                    "<br><br>Email: " + Request.Form["email"] + "<br><br>Phone: " + Request.Form["phone"] +
                    "<br><br>Notes: " + Request.Form["notes"];
                _msg.AlternateViews.Add(
                    AlternateView.CreateAlternateViewFromString(body, null, MediaTypeNames.Text.Html));

                SmtpClient smtpClient = new SmtpClient("smtp.sendgrid.net", Convert.ToInt32(587));
                System.Net.NetworkCredential credentials =
                    new System.Net.NetworkCredential("**************", "**************");
                smtpClient.Credentials = credentials;

                smtpClient.Send(_msg);

                Session["X_Email_Key"] = null;

                Response.Write("OK");
                Response.End();
            }
            else
            {
                Response.Write($"'{Request.Form["t"]}' does not match '{Session["X_Email_Key"]}'");
                Response.End();
            }
        }
        else if (Request.HttpMethod == "GET")
        {
            string _key = Guid.NewGuid().ToString();
            Session["X_Email_Key"] = _key;

            Response.Write(_key);
            Response.End();
        }
    }
}