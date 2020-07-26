using System;
using System.Data.Entity;
using System.Net;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Areas.Users.Controllers
{
    public class UsersController : FrontendBaseController
    {
        // GET: Users/Users
        public ActionResult Index()
        {
            return View();
        }

        public ActionResult ChangePassword()
        {
            return View();
        }

        [HttpPost]
        public async Task<ActionResult> ChangePassword(User model)
        {
            if (model.Password != null)
            {
                if (model.Password == model.ConfirmPassword)
                {
                    User _user = await db.Users.FirstOrDefaultAsync(c => c.ID == AppManager.User.ID && c.IsDataActive);

                    if (_user != null)
                    {
                        byte[] _authString = AppManager.GetAuthstring(_user.Email, model.Password);

                        _user.AuthString = _authString;
                        await db.SaveChangesAsync();

                        string _body = $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br />Your Seratio Platform account password has been successfully changed.<br /><br />We are sending this notice to ensure the privacy and security of your account. If you authorized this change, no further action is necessary.<br /><br />If you did not authorize this change, then please change your password, and consider changing your email password as well to ensure your account security.<br/><br/>Regards,<br/>CCEG<br/>";
                        AppManager.SendEmail("Change password", _user.Email, _body);

                        TempData["Notification"] = new Notification("Success", "Password has been changed successfully.");
                        return Redirect("/users/default/dashboard");
                    }
                    else
                    {
                        TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                        return RedirectToAction("changepassword");
                    }
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Passwords do not match. Please try again later.");
                    return RedirectToAction("changepassword");
                }
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                return RedirectToAction("changepassword");
            }


        }

        public async Task<ActionResult> Profile()
        {
            User _user = await db.Users.FindAsync(AppManager.User.ID);

            if (_user == null)
            {
                return HttpNotFound();
            }


            return View(_user);
        }

        public async Task<ActionResult> Edit(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            User _user = await db.Users.FindAsync(AppManager.User.ID);
            if (_user == null)
            {
                return HttpNotFound();
            }

            return View(_user);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(User model)
        {
            model.ConfirmPassword = model.Password;

            if (string.IsNullOrEmpty(model.FirstName))
            {
                model.FirstName = string.Empty;
            }

            if (string.IsNullOrEmpty(model.LastName))
            {
                model.LastName = string.Empty;
            }

            if (string.IsNullOrEmpty(model.Title))
            {
                model.Title = string.Empty;
            }

            if (string.IsNullOrEmpty(model.Gender))
            {
                model.Gender = string.Empty;
            }

            ModelState.Clear();
            TryValidateModel(model);

            if (ModelState.IsValid)
            {
                User _user = await db.Users.FindAsync(AppManager.User.ID);

                if (_user != null)
                {
                    _user.Phone = model.Phone;
                    _user.Gender = model.Gender;
                    _user.PostalCode = model.PostalCode;
                    _user.FirstName = model.FirstName;
                    _user.LastName = model.LastName;
                    _user.Position = model.Position;
                    _user.LastUpdatedOn = DateTime.Now;
                    _user.Organization = model.Organization;
                    _user.Title = model.Title;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Profile data has been updated successfully.");
                    return RedirectToAction("dashboard", "default");
                }
                else
                {
                    return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
                }
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contains invalid value. Please try again later.");
            return View(model);
        }
    }
}