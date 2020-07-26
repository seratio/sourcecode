
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using Seratio.Blockchain.Sandbox.Core.Security;
using System;
using System.Data.Entity;
using System.IO;
using System.Threading.Tasks;
using System.Web.Mvc;

namespace Seratio.Blockchain.Sandbox.Areas.SE.Controllers
{
    [AuthorizeAccess]
    public class CertificateController : BaseController
    {
        public async Task<ActionResult> Index()
        {
            SAPIResponse _response = await AppManager.GetSE(AppManager.User.Email);

            //    ViewBag.User = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.ID == AppManager.User.ID);


            if (_response != null && _response.data != null)
            {
                //     ViewBag.User = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.ID == AppManager.User.ID);

                //if (ViewBag.User != null)
                //{
                //    ViewBag.SE = ViewBag.User.SE;
                //}

                return View(_response.data);
            }
            else
            {
                return View();
            }
        }

        public ActionResult Calculate()
        {
            return View();
        }

        [HttpPost]
        public async Task<ActionResult> Calculate(Data model)
        {
            if (model.country != null/* && model.worth != 0 && model.family != 0 && model.money_leveraged != 0 && model.people != 0 && model.csr != 0*/)
            {
                model.email = AppManager.User.Email;
                model.currency = model.country;

                SAPIResponse _response = await AppManager.CalculateSE(model);

                var _user = await db.Users.FirstOrDefaultAsync(i => i.IsDataActive && i.ID == AppManager.User.ID);

                if (_user != null && _response != null)
                {
                    _user.SE = _response.data != null ? (decimal)_response.data.pv : 0;
                    _user.LastUpdatedOn = DateTime.Now;
                    await db.SaveChangesAsync();
                }

                if (_response != null && _response.status != null)
                {
                    if (_response.status.ToLower() == "success")
                    {
                        TempData["Notification"] = new Notification("Success", "Your S/E Score has been calculated successfully.");
                        return RedirectToAction("Index");
                    }
                    else
                    {
                        TempData["Notification"] = new Notification("Error", "Your S/E Score cannot be calculated now. Please try again later.");
                        return View();
                    }
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Your S/E Score cannot be calculated now. Please try again later.");
                    return RedirectToAction("Index");
                }
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
                return View(model);
            }
        }

        [AllowAnonymous]
        public async Task<ActionResult> PDF(string email, int id)
        {
            SAPIResponse _result = await AppManager.GetSE(email);

            if (_result.data == null)
            {
                return HttpNotFound();
            }

            var _request = await db.Requests.FirstOrDefaultAsync(r => r.ID == id && r.SenderID == AppManager.User.ID && r.Status == "Approved" && r.HasDownloaded == false);

            if (_request == null)
            {
                return HttpNotFound();
            }

            ViewBag.User = (await db.Users.FirstOrDefaultAsync(u => u.Email == email));

            ViewBag.Nickname = string.IsNullOrEmpty(ViewBag.User.NickName) ? ViewBag.User.Email : ViewBag.User.NickName;

            if (_request != null)
            {
                _request.HasDownloaded = true;

                await db.SaveChangesAsync();
            }

            return View(_result);
        }


        [AllowAnonymous]
        public async Task<ActionResult> PrintSE(string email, int id)
        {
            var _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.Email == email);

            if (_user == null)
            {
                return HttpNotFound();
            }

            string _url = AppManager.AppURL + "/wallet/se/certificate/PDF/?email=" + email + "&id=" + id;
            string _file = await AppManager.SavePDF(_url, Server.MapPath("~//Print//PrintSE-" + (string.IsNullOrEmpty(_user.NickName) ? _user.Email : _user.NickName) + ".pdf"));

            FileStream fs = new FileStream(Server.MapPath("~//Print//PrintSE-" + (string.IsNullOrEmpty(_user.NickName) ? _user.Email : _user.NickName) + ".pdf"), FileMode.Open, FileAccess.Read);
            MemoryStream ms = new MemoryStream();

            fs.CopyTo(ms);

            return File(ms.ToArray(), "application/x-pdf", "PrintSE - " + (string.IsNullOrEmpty(_user.NickName) ? _user.Email : _user.NickName) + ".pdf");

            //      return Redirect("/print/" + _file);
        }

    }
}