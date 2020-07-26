using System;
using System.Threading.Tasks;
using System.Web.Mvc;
using Google.Authenticator;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Controllers
{
    public class TwoFAController : BaseController
    {
        [AllowAnonymous]
        public ActionResult Index(string url)
        {
            if (AppManager.User == null)
            {
                return Redirect("/wallet");
            }

            if (!AppManager.User.PendingTwoFactorAuthentication)
            {
                if (!string.IsNullOrEmpty(url))
                {
                    return Redirect(url);
                }

                return Redirect("/wallet/default/dashboard");
            }

            return View();
        }

        [AllowAnonymous]
        [HttpPost]
        public async Task<ActionResult> Index(string otp, string url)
        {
            try
            {
                if (AppManager.User == null)
                {
                    return Redirect("/wallet");
                }

                User _user = await db.Users.FindAsync(AppManager.User.ID);

                if (_user == null)
                {
                    return HttpNotFound();
                }

                TwoFactorAuthenticator _authenticator = new TwoFactorAuthenticator();
                string _uniquekey = _user.TwoFAKey;
                bool _isValid = _authenticator.ValidateTwoFactorPIN(_uniquekey, otp);

                if (_isValid)
                {
                    AppUser _loggedInUser = AppManager.User;
                    _loggedInUser.PendingTwoFactorAuthentication = false;
                    Session["Blockchain_User"] = _loggedInUser;

                    if (string.IsNullOrEmpty(url))
                    {
                        return Redirect("/wallet/default/dashboard");
                    }

                    return Redirect(url);
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Your have entered an invalid code. Please try again.");
                    return View("Index", new { url = url });
                }
            }
            catch (Exception ex)
            {
                TempData["Notification"] = new Notification("Error", "Sorry, an error occurred while processing your request. Please try again later.");
                return Redirect("/wallet/users/profile");
            }
        }

        public async Task<ActionResult> Activate()
        {
            try
            {
                User _user = await db.Users.FindAsync(AppManager.User.ID);

                if (_user == null)
                {
                    return HttpNotFound();
                }

                if (!_user.EnableTwoFactorAuthentication)
                {
                    TwoFactorAuthenticator _authenticator = new TwoFactorAuthenticator();
                    string _uniquekey = Guid.NewGuid().ToString().Replace("-", "");
                    SetupCode _setupCode = _authenticator.GenerateSetupCode("Seratio Platform", _user.Email, _uniquekey, 300, 300);

                    ViewBag.BarcodeImageUrl = _setupCode.QrCodeSetupImageUrl;
                    ViewBag.Userkey = _setupCode.ManualEntryKey;

                    _user.TwoFAKey = _uniquekey;
                    await db.SaveChangesAsync();

                    AppManager.User.RequiresTwoFactorAuthentication = true;
                    Session["Blockchain_User"] = AppManager.User;
                    return View();
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Two Factor Authentication is already activated.");
                    return Redirect("/wallet/users/profile");
                }
            }
            catch (Exception ex)
            {
                TempData["Notification"] = new Notification("Error", "Sorry, an error occurred while processing your request. Please try again later.");
                return null;
            }
        }

        public async Task<ActionResult> Deactivate()
        {
            try
            {
                User _user = await db.Users.FindAsync(AppManager.User.ID);

                if (_user == null)
                {
                    return HttpNotFound();
                }

                _user.TwoFAKey = null;
                _user.EnableTwoFactorAuthentication = false;
                await db.SaveChangesAsync();

                AppManager.User.RequiresTwoFactorAuthentication = false;
                Session["Blockchain_User"] = AppManager.User;

                TempData["Notification"] = new Notification("Success", "Two Factor Authentication has been deactivated successfully.");
                return Redirect("/wallet/users/profile");
            }
            catch (Exception ex)
            {
                TempData["Notification"] = new Notification("Error", "Sorry, an error occurred while processing your request. Please try again later.");
                return Redirect("/wallet/users/profile");
            }
        }

        public async Task<ActionResult> Verify(string code)
        {
            try
            {
                User _user = await db.Users.FindAsync(AppManager.User.ID);

                if (_user == null)
                {
                    return HttpNotFound();
                }

                TwoFactorAuthenticator _authenticator = new TwoFactorAuthenticator();
                string _uniquekey = _user.TwoFAKey;
                bool _isValid = _authenticator.ValidateTwoFactorPIN(_uniquekey, code);

                if (_isValid)
                {
                    AppUser _loggedInUser = AppManager.User;
                    _loggedInUser.PendingTwoFactorAuthentication = false;
                    Session["Blockchain_User"] = _loggedInUser;

                    _user.EnableTwoFactorAuthentication = true;
                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Two Factor Authentication has been activated successfully.");
                    return Redirect("/wallet/users/profile");
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Your have entered an invalid code. Please try again.");
                    return RedirectToAction("Activate");
                }
            }
            catch (Exception ex)
            {
                TempData["Notification"] = new Notification("Error", "Sorry, an error occurred while processing your request. Please try again later.");
                return Redirect("/wallet/users/profile");
            }
        }
    }
}