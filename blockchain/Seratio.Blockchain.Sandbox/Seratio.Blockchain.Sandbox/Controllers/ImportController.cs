using System;
using System.Data;
using System.Data.Entity;
using System.IO;
using System.Threading.Tasks;
using System.Web.Mvc;
using Excel;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Controllers
{
    public class ImportController : BaseController
    {

        [AllowAnonymous]
        public async Task<ActionResult> Index()
        {
            string path = Path.Combine(Server.MapPath("~/"), "SeratioBountyCampaign.xlsx");
            FileStream _stream = System.IO.File.Open(path, FileMode.Open, FileAccess.Read);
            Excel.IExcelDataReader reader = ExcelReaderFactory.CreateOpenXmlReader(_stream);
            DataSet result = reader.AsDataSet();
            reader.Close();

            int total = result.Tables[0].Rows.Count;
            int _processed = 0;

            for (int rowIndex = 0; rowIndex < total; rowIndex++)
            {
                System.Data.DataRow row = result.Tables[0].Rows[rowIndex];
                if ((row[0] != null &&
                     !string.IsNullOrEmpty(row[0].ToString())
                ))
                {
                    string email = row[0].ToString().Trim();

                    if (AppManager.IsValidEmail(email))
                    {
                        string _ranomstring = Path.GetRandomFileName();
                        _ranomstring = _ranomstring.Replace(".", "").ToUpper();

                        User _user = new User();

                        _user.Email = email;
                        _user.AuthString = AppManager.GetAuthstring(email, _ranomstring);
                        _user.CreatedOn = _user.LastUpdatedOn = DateTime.Now;
                        _user.IsDataActive = true;
                        _user.EmailVerificationToken = new Guid();
                        _user.EmailVerifiedOn = DateTime.Now;
                        _user.IsEmailVerified = true;

                        var user = await db.Users.FirstOrDefaultAsync(u => u.Email == email && u.IsDataActive);

                        if (user == null)
                        {
                            db.Users.Add(_user);
                            await db.SaveChangesAsync();

                            string _body =
                                $"Hello,<br /><br />Thank you for participating in the Seratio Bounty Campaign. This email is to confirm our team has created an account for you. We kindly ask you to follow the instructions below to claim your bounty rewards:<br />- Follow the link:  www.seratio-coins.world<br />- Sign in using the following credentials:<br /> User name: your Bitcointalk name<br /> Password: <br />-You will be asked to change your password after you first sign in the system.<br /><br />We strongly recommend you to keep your password safe as your account will be connected to your Seratio wallet. Instructions on how to access your Seratio Wallet will be sent to you by our team in the next few days.<br /><br />Please email us at blockchain.lab @cceg.org.uk should you have any questions.<br />If you believe you received this email by mistake, please email us at blockchain.lab @cceg.org.uk.<br /><br />Kindest regards,<br />CCEG Blockchain UN Lab team";
                            AppManager.SendEmail("Welcome to Seratio Blockchain", "developer@markuplab.com", _body, false);
                        }
                    }
                }
            }
            return RedirectToAction("Index", "default");
        }
    }
}

