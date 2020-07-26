using System;
using System.Data.Entity;
using System.Data.Entity.Validation;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Core.Utilities;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Areas.Users.Controllers
{
    public class DefaultController : FrontendBaseController
    {

        [AllowAnonymous]
        public ActionResult Wizard()
        {
            return View();
        }

        [AllowAnonymous]
        public ActionResult Closed()
        {
            return View();
        }

        // GET: Users/Default
        [AllowAnonymous]
        public ActionResult Index(string type)
        {
            if (!string.IsNullOrEmpty(type))
            {
                if (AppManager.User != null && Session["ICOType"] != null && Session["ICOType"] != type)
                {
                    TempData["Notification"] = new Notification("Info", $"You are already Signed in to the {Session["ICOType"]} ICO. Please logout of that session to continue with new Investment.");
                }
                else
                {
                    Session["ICOType"] = type;
                }
            }

            if (AppManager.User != null)
            {
                if (Session["ICOType"] != null)
                {
                    return Redirect($"/users/investments/create?ICOType={Session["ICOType"]}");
                }

                return Redirect("/users/default/dashboard");
            }

            return View();
        }

        [HttpPost]
        [AllowAnonymous]
        public async Task<ActionResult> Index(string email, string password, string type)
        {
            if (string.IsNullOrEmpty(email) || string.IsNullOrEmpty(password))
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            LoggedInUser _loggedInUser = await AppManager.AuthenticateLoggedInUserAsync(email, password);

            if (_loggedInUser != null)
            {

                if (!_loggedInUser.IsEmailverified)
                {
                    TempData["Notification"] = new Notification("Error", "Your email address is not verified. Please verify.");
                    return View();
                }

                UserSession _session = await AppManager.CreateUserSession(_loggedInUser.ID);

                _loggedInUser.SessionID = _session.ID;

                Session["ICO_User"] = _loggedInUser;

                return Redirect("/users/default/dashboard");
            }
            else
            {
                if (type == "Womens Coin")
                {
                    if (!await db.Users.AnyAsync(u => u.Email == email && u.IsDataActive))
                    {
                        User _user = new User();

                        try
                        {
                            byte[] _authString = AppManager.GetAuthstring(email, password);
                            _user.AuthString = _authString;
                            _user.Email = email;
                            _user.EmailVerificationToken = Guid.NewGuid();
                            _user.IsEmailVerified = false;
                            _user.CreatedOn = AppManager.Now;
                            _user.LastUpdatedOn = AppManager.Now;
                            _user.IsDataActive = true;
                            _user.IsEmailVerified = true;
                            _user.EmailVerifiedOn = AppManager.Now;

                            if (string.IsNullOrEmpty(_user.FirstName))
                            {
                                _user.FirstName = string.Empty;
                            }

                            if (string.IsNullOrEmpty(_user.LastName))
                            {
                                _user.LastName = string.Empty;
                            }

                            if (string.IsNullOrEmpty(_user.Title))
                            {
                                _user.Title = string.Empty;
                            }

                            if (string.IsNullOrEmpty(_user.Gender))
                            {
                                _user.Gender = string.Empty;
                            }

                            db.Users.Add(_user);
                            await db.SaveChangesAsync();
                            string _body = string.Empty;
                            string _topImage = string.Empty;

                            if ((Session["ICOType"] != null))
                            {
                                _body = $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br /> Thank you for registering for your Seratio Platform account. Now, you may log in and continue with investment through our platform.<br /><br/>Regards,<br/>CCEG and {type}<br/>";

                                _topImage = "womenscoinlogov2.png";
                            }
                            else
                            {
                                _body = $"Hello {_user.Title} {_user.FirstName} {_user.LastName},<br /><br /> Thank you for registering for your {type ?? "Seratio Platform"} account. Now, you may log in and continue with investment through our platform.<br /><br/>Regards,<br/>CCEG<br/>";
                            }

                            AppManager.SendEmail($"Welcome to {type ?? "Seratio Platform"}", _user.Email, _body, _topImage);

                            TempData["Notification"] = new Notification("Success", $"Welcome to {type ?? "Seratio Platform"}, your account has been created successfully.");

                            LoggedInUser loggedInUser = await AppManager.AuthenticateLoggedInUserAsync(email, password);

                            if (loggedInUser != null)
                            {
                                if (!loggedInUser.IsEmailverified)
                                {
                                    TempData["Notification"] = new Notification("Error", "Your email address is not verified. Please verify.");
                                    return View();
                                }

                                UserSession _session = await AppManager.CreateUserSession(_loggedInUser.ID);

                                loggedInUser.SessionID = _session.ID;

                                Session["ICO_User"] = loggedInUser;

                                return Redirect("/users/default/dashboard");
                            }
                        }
                        catch (DbEntityValidationException ex)
                        {
                            string _errorMessages = string.Join("; ", ex.EntityValidationErrors.SelectMany(x => x.ValidationErrors).Select(x => x.ErrorMessage));
                            TempData["Notification"] = new Notification("Error", _errorMessages);
                        }
                    }
                }

                TempData["Notification"] = new Notification("Error", "Email or password do not match. Please try again later.");
                return View();
            }
        }

        //[AuthorizeAccess]
        public async Task<ActionResult> Dashboard()
        {
            if (Session["_showWelcomePopup"] == null)
            {
                ViewBag.SessionCount = await db.UserSessions.Where(i => i.UserID == AppManager.User.ID).CountAsync();
                Session["_showWelcomePopup"] = false;
            }
            else
            {
                ViewBag.SessionCount = -1;
            }

            ViewBag.Investments = await db.Investments.Where(i => i.UserID == AppManager.User.ID)
                .OrderByDescending(i => i.ID).Take(5).ToListAsync();

            return View();
        }

        [AllowAnonymous]
        public async Task<ActionResult> Emailverification(Guid token)
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.EmailVerificationToken == token);

            if (_user != null)
            {
                _user.IsEmailVerified = true;
                _user.EmailVerifiedOn = AppManager.Now;
                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Your email address has been successfully verified.");
                return RedirectToAction("Index");
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. Please try again later.");
                return RedirectToAction("Index");
            }
        }

        [AllowAnonymous]
        public ActionResult Signup(string type)
        {
            if (DateTime.UtcNow < new DateTime(2018, 01, 01))
            {
                TempData["Notification"] = new Notification("Info", "Registration for the new ICOs will start at 01/01/2018 12:00 AM (GMT).");
                return Redirect("/users?type=" + type);
            }

            if (!string.IsNullOrEmpty(type))
            {
                Session["ICOType"] = type;
            }

            return View();
        }

        [HttpPost]
        [AllowAnonymous]
        public async Task<ActionResult> Signup(User model)
        {
            if (ModelState.IsValid)
            {
                if (!await db.Users.AnyAsync(u => u.Email == model.Email && u.IsDataActive))
                {
                    try
                    {
                        byte[] _authString = AppManager.GetAuthstring(model.Email, model.Password);
                        model.AuthString = _authString;
                        model.EmailVerificationToken = Guid.NewGuid();
                        model.IsEmailVerified = false;
                        model.CreatedOn = AppManager.Now;
                        model.LastUpdatedOn = AppManager.Now;
                        model.IsDataActive = true;

                        model.IsEmailVerified = true;
                        model.EmailVerifiedOn = AppManager.Now;

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

                        db.Users.Add(model);
                        await db.SaveChangesAsync();
                        string _body = string.Empty;
                        string _topImage = string.Empty;

                        if ((Session["ICOType"] != null))
                        {
                            _body = $"Hello {model.Title} {model.FirstName} {model.LastName},<br /><br /> Thank you for registering for your Seratio Platform account. Now, you may log in and continue with investment through our platform.<br /><br/>Regards,<br/>CCEG and {Session["ICOType"]}<br/>";

                            switch (Session["ICOType"].ToString())
                            {
                                case "Seratio Coin":
                                    _topImage = "**************logo.jpg";
                                    break;
                                case "Womens Coin":
                                    _topImage = "womenscoinlogov2.png";
                                    break;
                                case "Student Coin":
                                    _topImage = "studentcoin.png";
                                    break;
                                case "Growth Token":
                                    _topImage = "10xaccountlogo.png";
                                    break;
                            }
                        }
                        else
                        {
                            _body = $"Hello {model.Title} {model.FirstName} {model.LastName},<br /><br /> Thank you for registering for your {Session["ICOType"] ?? "Seratio Platform"} account. Now, you may log in and continue with investment through our platform.<br /><br/>Regards,<br/>CCEG<br/>";
                        }

                        AppManager.SendEmail($"Welcome to {Session["ICOType"] ?? "Seratio Platform"}", model.Email, _body, _topImage);

                        TempData["Notification"] = new Notification("Success", $"Welcome to {Session["ICOType"] ?? "Seratio Platform"}, your account has been created successfully.");
                        return Redirect("/users?type=" + Session["ICOType"]);
                    }
                    catch (DbEntityValidationException ex)
                    {
                        string _errorMessages = string.Join("; ", ex.EntityValidationErrors.SelectMany(x => x.ValidationErrors).Select(x => x.ErrorMessage));
                        TempData["Notification"] = new Notification("Error", _errorMessages);
                    }
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "There is an existing account associated with this email or Username.");
                }
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "One or more fields are missing or contains invalid value. Please try again later.");
            }

            return View(model);
        }

        [AllowAnonymous]
        public ActionResult Forgot()
        {
            return View();
        }

        [AllowAnonymous]
        [HttpPost]
        public async Task<ActionResult> Forgot(string email)
        {
            User _user = await db.Users.FirstOrDefaultAsync(c => c.Email == email && c.IsDataActive && c.EmailVerifiedOn != null);

            if (_user != null)
            {
                string _hash = Rijndael.Encrypt(email);
                //  string _hash = Convert.ToBase64String(Encoding.UTF8.GetBytes(email));
                string _body = $"Hello,<br />You or someone else has requested to change the password for your Seratio Platform account.<br />Please <a href='{AppManager.AppURL}/users/default/resetpassword?email={_hash.Replace('+', '-').Replace('/', '_')}'>click here</a> to reset your password.<br /><br />You can ignore this message if you haven't requested to change the password.<br/><br/>Regards,<br/>CCEG<br/>";
                AppManager.SendEmail("Your Account Password - Seratio Platform", email, _body);

                TempData["Notification"] = new Notification("Success", "Please check your Email to Reset the Password.");
                return RedirectToAction("Index");
            }

            TempData["Notification"] = new Notification("Error", "Please check your Email ID.");
            return RedirectToAction("Index");
        }

        [AllowAnonymous]
        public ActionResult ResetPassword(string email)
        {
            return View();
        }

        [AllowAnonymous]
        [HttpPost]
        public async Task<ActionResult> ResetPassword(User model)
        {
            try
            {
                model.Email = Rijndael.Decrypt(model.Email.Replace('-', '+').Replace('_', '/'));

                User _user = await db.Users.FirstOrDefaultAsync(c => c.Email == model.Email && c.IsDataActive);

                if (_user != null)
                {
                    byte[] _authString = AppManager.GetAuthstring(model.Email, model.Password);

                    _user.AuthString = _authString;
                    _user.LastUpdatedOn = AppManager.Now;

                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Password has been changed successfully.");
                    return RedirectToAction("Index");
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                    return RedirectToAction("Index");
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                return RedirectToAction("Index");
            }
        }

        public async Task<ActionResult> Logout()
        {
            if (Session["ICO_User"] != null)
            {
                await AppManager.EndUserSession(AppManager.User.ID, AppManager.User.SessionID);

                Session.Contents.RemoveAll();
                Session.Clear();
                Session.Abandon();
            }
            return RedirectToAction("Index");
        }

        public async Task<ActionResult> ChangeICOType(string type)
        {
            AppManager.User.ICOType = type;
            return RedirectToAction("Dashboard", "Default");
        }
    }
}