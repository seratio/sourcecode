using System;
using System.Data;
using System.Data.Entity;
using System.Diagnostics;
using System.IO;
using System.Threading.Tasks;
using System.Web.Mvc;
using Excel;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Admin.Controllers
{
    [AuthorizeAccess(RequireSuperAdmin = true)]

    public class SeratioInvestmentsController : BaseController
    {

        [AllowAnonymous]
        public async Task<ActionResult> Check()
        {
            string path = Path.Combine(Server.MapPath("~/Files"), "list.xlsx");
            FileStream _stream = System.IO.File.Open(path, FileMode.Open, FileAccess.Read);
            Excel.IExcelDataReader reader = ExcelReaderFactory.CreateOpenXmlReader(_stream);
            DataSet result = reader.AsDataSet();
            reader.Close();

            int total = result.Tables[0].Rows.Count;

            using (BlockChainManager _blockChainManager = new BlockChainManager("http://35.205.45.88/eth-api"))
            {
                for (int rowIndex = 0; rowIndex < total; rowIndex++)
                {
                    System.Data.DataRow row = result.Tables[0].Rows[rowIndex];

                    decimal _balance = await _blockChainManager.GetBalance(row[10].ToString(), "0xb561fef0d624c0826ff869946f6076b7c4f2ba42", 7);
                    decimal _actualBalance = decimal.Parse(row[2].ToString());

                    Debug.WriteLine($"{row[10].ToString()}=>{_actualBalance}=>{_balance}");
                }
            }

            return null;

        }

        [AllowAnonymous]
        public async Task<ActionResult> Index()
        {
            string path = Path.Combine(Server.MapPath("~/Files"), "Investments.xlsx");
            FileStream _stream = System.IO.File.Open(path, FileMode.Open, FileAccess.Read);
            Excel.IExcelDataReader reader = ExcelReaderFactory.CreateOpenXmlReader(_stream);
            DataSet result = reader.AsDataSet();
            reader.Close();

            int total = result.Tables[0].Rows.Count;
            int _processed = 0;

            for (int rowIndex = 1; rowIndex < total; rowIndex++)
            {
                System.Data.DataRow row = result.Tables[0].Rows[rowIndex];
                if ((row[0] != null &&
                     !string.IsNullOrEmpty(row[0].ToString())
                ))
                {
                    string email = row[0].ToString().Trim();
                    decimal amount = decimal.Parse(row[1].ToString());

                    User _user = await db.Users.FirstOrDefaultAsync(u => u.Email == email && u.IsDataActive);

                    if (_user != null)
                    {
                        SERTokenInvestment _seratioInvestment = await db.SERTokenInvestments.FirstOrDefaultAsync(u => u.UserID == _user.ID);

                        if (_seratioInvestment != null)
                        {
                            _seratioInvestment.Amount = _seratioInvestment.Amount + amount;
                            await db.SaveChangesAsync();
                        }
                        else
                        {
                            SERTokenInvestment _inverstmet = new SERTokenInvestment();

                            _inverstmet.UserID = _user.ID;
                            _inverstmet.Amount = amount;
                            _inverstmet.CreatedOn = DateTime.Now;
                            _inverstmet.Status = "Pending";

                            db.SERTokenInvestments.Add(_inverstmet);
                            await db.SaveChangesAsync();
                        }
                    }
                    else
                    {
                        Debug.WriteLine($"User Not Found: {email}");
                    }
                }
            }

            TempData["Notification"] = new Notification("Success", "Investments Imported.");
            return Redirect("/wallet/default/dashboard");
        }
    }
}