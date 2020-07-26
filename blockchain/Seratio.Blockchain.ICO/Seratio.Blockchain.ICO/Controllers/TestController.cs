using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Mail;
using System.Net.Mime;
using System.Threading.Tasks;
using System.Web;
using System.Web.Hosting;
using System.Web.Mvc;
using Excel;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Controllers
{
    public class TestController : BaseController
    {
        public bool IsValidEmail(string email)
        {
            try
            {
                var addr = new System.Net.Mail.MailAddress(email);
                return addr.Address == email;
            }
            catch
            {
                return false;
            }
        }

        //[AllowAnonymous]
        //public async Task<ActionResult> DoIt()
        //{
        //    string path = Path.Combine(Server.MapPath("~/"), "SeratioBountyCampaign1.xlsx");
        //    FileStream _stream = System.IO.File.Open(path, FileMode.Open, FileAccess.Read);
        //    Excel.IExcelDataReader reader = ExcelReaderFactory.CreateOpenXmlReader(_stream);
        //    DataSet result = reader.AsDataSet();
        //    reader.Close();

        //    int total = result.Tables[0].Rows.Count;
        //    int _processed = 0;

        //    for (int rowIndex = 0; rowIndex < total; rowIndex++)
        //    {
        //        try
        //        {
        //            System.Data.DataRow row = result.Tables[0].Rows[rowIndex];
        //            if ((row[0] != null &&
        //                 !string.IsNullOrEmpty(row[0].ToString())
        //            ))
        //            {
        //                string _email = row[0].ToString().Trim();

        //                if (rowIndex == 112)
        //                {

        //                }

        //                if (IsValidEmail(_email))
        //                {
        //                    string _password = Path.GetRandomFileName();
        //                    _password = _password.Replace(".", "").ToUpper();

        //                    User _user = new User();

        //                    _user.Email = _email;
        //                    _user.AuthString = AppManager.GetAuthstring(_email, _password);
        //                    _user.CreatedOn = _user.LastUpdatedOn = DateTime.Now;
        //                    _user.IsDataActive = true;
        //                    _user.EmailVerificationToken = new Guid();
        //                    _user.EmailVerifiedOn = DateTime.Now;
        //                    _user.IsEmailVerified = true;
        //                    _user.FirstName = _user.LastName = _user.Title = String.Empty;
        //                    _user.Gender = "Male";

        //                    var _user1 = await db.Users.FirstOrDefaultAsync(u => u.Email == _email && u.IsDataActive);

        //                    if (_user1 == null)
        //                    {
        //                        db.Users.Add(_user);
        //                        await db.SaveChangesAsync();

        //                        string _body =
        //                            $"Hello,<br /><br />Thank you for participating in the Seratio ICO. This email is to confirm our team has created an account for you. We kindly ask you to follow the instructions below:<br /><br />- Follow the link:  <a href='https://seratio-coins.world/users'>www.seratio-coins.world/users</a><br />- Sign in using the following credentials:<br />&nbsp;&nbsp;&nbsp;User name: {_email}<br />&nbsp;&nbsp;&nbsp;Password: {_password}<br />-It is very important that you should change this password after you first login.<br /><br />We strongly recommend you to keep your password safe as your account will be connected to your Seratio wallet. Instructions on how to access your Seratio Wallet will be sent to you by our team in the next few days.<br /><br />Please email us at <a href='mailto:blockchain.lab@cceg.org.uk'>blockchain.lab@cceg.org.uk</a> should you have any questions.<br /><br />If you believe you received this email by mistake, please email us at <a href='mailto:blockchain.lab@cceg.org.uk'>blockchain.lab@cceg.org.uk</a>.<br /><br />Kindest regards,<br />CCEG Blockchain UN Lab team";
        //                        AppManager.SendEmail("Your Seratio Platform Account", _email, _body, "**************logo.jpg", "sajin.abdu@seratio.com");
        //                    }
        //                    else
        //                    {

        //                    }
        //                }
        //            }
        //        }
        //        catch (Exception ex)
        //        {
        //            Response.Write($"{rowIndex + 1}/{total} <br/>");
        //            Response.Write(ex.Message);
        //            Response.End();
        //        }

        //        Debug.WriteLine($"{rowIndex + 1}/{total}");
        //    }


        //    return null;
        //}

        //[AllowAnonymous]
        //public async Task<string> pluck()
        //{
        //    using (db)
        //    {
        //        var _users = await db.Users.Where(u => u.IsDataActive && u.IsEmailVerified && u.WalletAddress == null && u.SERTokenInvestments.Any()).Select(u => u.Email).ToListAsync();
        //        int _count = 0;

        //        foreach (string _user in _users)
        //        {
        //            try
        //            {
        //                string _body =
        //                    @"<p>Hello,</p><p>Thank you for participating in the Seratio Platform Fundraiser.</p><p>This is to remind you that our team has now activated the Seratio Wallets and has minted Seratio Tokens on 31st January. Your Seratio Tokens (SER) will be sent only to your Seratio Wallet - we will NOT send SER Tokens to any other digital wallets. Therefore, it is important that you log on and create your password for your Seratio Wallet as soon as possible to claim your SER Tokens.</p><p>For Security reasons, if you do not create your wallet password, the SER tokens will not be deposited to you.</p><p>Please follow the instructions below to create your own personal Seratio Wallet:</p><p>1. Follow the link: <a href='https://www.seratio-coins.world/wallet/'>https://www.seratio-coins.world/wallet/</a><br />2. Sign in using your Seratio account credentials<br />3. Create your wallet password.</p><p><br />We strongly recommend you keep your wallet password safe as you will not be able to change or recover it.</p><p>We recommend you use Two Factor Authentication for additional security (see p.17 of Instructions).</p><p>Do NOT share your private key.</p><p>Do quote your public key to receive funds.</p><p>Keep your account password safe and secure &ndash; you cannot be re-advised of this.</p><p>Keep your SER tokens in your Seratio Wallet to benefit from Microshares in April 2018.</p><p><br />Please see attached instructions document for the detailed guidance.</p><p>Please contact us at blockchain.lab@cceg.org.uk if you have any questions.</p><p>If you believe you received this email by mistake, please email us at blockchain.lab@cceg.org.uk .</p><p>Kindest regards,<br />CCEG Blockchain UN Lab team</p>";

        //                MailMessage _msg = new MailMessage();
        //               // _msg.To.Add(_user);
        //                _msg.From = new MailAddress("blockchain.lab@cceg.org.uk", "Seratio Platform");
        //                _msg.Subject = "Reminder: Action required - Important";
        //                _msg.AlternateViews.Add(
        //                    AlternateView.CreateAlternateViewFromString(_body, null, MediaTypeNames.Text.Html));

        //                _msg.Attachments.Add(new Attachment(Server.MapPath("/files/Seratio Wallet Instructions.pdf")));
        //                _msg.Attachments.Add(new Attachment(
        //                    Server.MapPath("/files/Seratio Wallet Instructions_Chinese.pdf")));

        //                using (SmtpClient _client = new SmtpClient("smtp.sendgrid.net", Convert.ToInt32(587)))
        //                {
        //                    _client.Credentials = new NetworkCredential("**************", "**************");
        //                    _client.Send(_msg);
        //                }
        //            }
        //            catch (Exception ex)
        //            {
        //                return $"{_users.Count}=>{_count}=>{ex.Message}";
        //            }
        //            finally
        //            {
        //                _count++;
        //                System.IO.File.WriteAllText(Server.MapPath("/email_status.txt"), $"{_users.Count}=>{_count}");
        //            }

        //            if (_count % 5 == 0)
        //            {
        //                await Task.Delay(5000);
        //            }
        //        }

        //        return $"{_users.Count}=>{_count}";
        //    }
        //}
    }
}