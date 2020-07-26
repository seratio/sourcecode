using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Data.Entity.Validation;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Controllers
{
    public class DefaultController : BaseController
    {
        public ActionResult Notifications()
        {
            DateTime _date = DateTime.Now.AddDays(-30);
            try
            {
                var data = db.ActivityNotifications.Where(i => i.UserID == AppManager.User.ID && (i.IsRead == false || i.CreatedOn >= _date)).OrderByDescending(i => i.Time).ToList();
                return View(data);
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return null;
            }

        }

        [AllowAnonymous]
        public ActionResult Index()
        {
            if (AppManager.User != null)
            {
                if (AppManager.User.PendingWalletCreation)
                {
                    return Redirect("/wallet/keys/index");
                }

                if (AppManager.User.RequiresTwoFactorAuthentication && AppManager.User.PendingTwoFactorAuthentication)
                {
                    return Redirect($"/wallet/twofa?url=/default/dashboard");
                }

                return RedirectToAction("dashboard");
            }

            return View();
        }

        [AllowAnonymous]
        [HttpPost]
        public async Task<ActionResult> Index(string username, string password, string next, bool remindme = false)
        {
            if (!string.IsNullOrEmpty(username) && !string.IsNullOrEmpty(password))
            {
                DateTime _now = DateTime.Now;
                DateTime _previoushour = _now.AddHours(-1);

                User _userByUsername = await db.Users.FirstOrDefaultAsync(u => u.Email == username && u.IsDataActive);

                if (_userByUsername != null)
                {
                    #region Check if the account is already blocked

                    int _failedAttemptsSoFar = await db.FailedSignInAttempts
                        .CountAsync(u => u.UserID == _userByUsername.ID && u.Time <= _now && u.Time > _previoushour);

                    if (_failedAttemptsSoFar >= 3)
                    {
                        TempData["Notification"] = new Notification("Error",
                            "Your account is locked for the day. Please try again tomorrow.");
                        return RedirectToAction("Index");
                    }

                    #endregion

                    AppUser _authenticatedUser = await AppManager.AuthenticateUserAsync(username.ToLower(), password);

                    if (_authenticatedUser != null)
                    {
                        #region Successful Login

                        if (!_authenticatedUser.IsEmailverified)
                        {
                            TempData["Notification"] =
                                new Notification("Error",
                                    "Your email is not verified. Please verify your email address and try again.");
                            return RedirectToAction("Index");
                        }

                        foreach (FailedSignInAttempt _failedSignInAttempt in await db.FailedSignInAttempts
                            .Where(u => u.UserID == _userByUsername.ID && u.Time <= _now && u.Time > _previoushour)
                            .ToListAsync())
                        {
                            db.FailedSignInAttempts.Remove(_failedSignInAttempt);
                            await db.SaveChangesAsync();
                        }

                        Session["Blockchain_User"] = _authenticatedUser;

                        if (_authenticatedUser.IsSuperAdmin)
                        {
                            string _body =
                                $"Hello {_authenticatedUser.NickName ?? _authenticatedUser.Email.ToLower()} ,<br /><br /> New Sign in From {Environment.OSVersion}. If this was not you, please change your password";
                            AppManager.SendEmail("New Sign in", _authenticatedUser.Email, _body);
                        }

                        if ((string.IsNullOrEmpty(_userByUsername.SaftyQuestion) ||
                             _userByUsername.SaftyAnswer == null) &&
                            !string.IsNullOrEmpty(_userByUsername.WalletAddress))
                        {
                            TempData["Notification"] = new Notification("Info",
                                "Please secure your account by adding a Security question from the My Profile Area.");
                        }

                        if (!string.IsNullOrEmpty(next))
                        {
                            if (string.IsNullOrEmpty(_userByUsername.WalletAddress))
                            {
                                return Redirect("/wallet/keys/index");
                            }

                            if (_authenticatedUser.RequiresTwoFactorAuthentication)
                            {
                                _authenticatedUser.PendingTwoFactorAuthentication = true;
                                Session["Blockchain_User"] = _authenticatedUser;

                                return Redirect($"/wallet/twofa?url={next}");
                            }

                            return Redirect(next);
                        }

                        if (_authenticatedUser.RequiresTwoFactorAuthentication)
                        {
                            _authenticatedUser.PendingTwoFactorAuthentication = true;
                            Session["Blockchain_User"] = _authenticatedUser;

                            return Redirect($"/wallet/twofa?url=/wallet/default/dashboard");
                        }

                        if (string.IsNullOrEmpty(_userByUsername.WalletAddress))
                        {
                            return Redirect("/wallet/keys/index");
                        }

                        return RedirectToAction("dashboard");

                        #endregion
                    }
                    else
                    {
                        FailedSignInAttempt _attempt = new FailedSignInAttempt();
                        _attempt.UserID = _userByUsername.ID;
                        _attempt.Time = DateTime.Now;

                        db.FailedSignInAttempts.Add(_attempt);
                        await db.SaveChangesAsync();

                        DateTime now = DateTime.Now;
                        DateTime previoushour = _now.AddHours(-1);

                        int _attemts = await db.FailedSignInAttempts
                            .Where(u => u.UserID == _userByUsername.ID && u.Time <= now && u.Time > previoushour)
                            .CountAsync();

                        if (_attemts == 3)
                        {
                            TempData["Notification"] = new Notification("Error",
                                "You have reached the maximum failed sign-in attempts. Your account has been locked for the day. Please try again tomorrow.");
                        }
                        else
                        {
                            TempData["Notification"] = new Notification("Error",
                                $"Username and password do not match. You have {3 - _attemts} attempts remaining.");
                        }
                    }
                }
                else
                {
                    TempData["Notification"] = new Notification("Error",
                        $"Username and password do not match. Please try again later.");
                }
            }
            else
            {
                TempData["Notification"] = new Notification("Error",
                    "One or more required fields are missing. Please try again later.");
            }

            return RedirectToAction("Index");
        }

        [AllowAnonymous]
        public ActionResult Signup()
        {
            return View();
        }

        [AllowAnonymous]
        [HttpPost]
        public async Task<ActionResult> Signup(User model)
        {
            model.ConfirmPassword = model.Password;

            model.Title = string.Empty;
            model.FirstName = string.Empty;
            model.LastName = string.Empty;
            model.Gender = string.Empty;
            ModelState.Clear();
            TryValidateModel(model);

            if (ModelState.IsValid)
            {
                if (!await db.Users.AnyAsync(u => u.Email == model.Email && u.IsDataActive))
                {
                    try
                    {
                        model.AuthString = AppManager.GetAuthstring(model.Email, model.Password);
                        model.CreatedOn = model.LastUpdatedOn = DateTime.Now;
                        model.IsDataActive = true;
                        model.Email = model.Email;
                        model.IsSearchable = false;
                        model.AutoLoginToken = Guid.NewGuid();
                        model.AllowEmailNotifications = true;
                        model.ShouldAllowSignInWithQR = true;
                        model.EmailVerificationToken = Guid.NewGuid();
                        model.IsEmailVerified = true;
                        model.EmailVerifiedOn = DateTime.Now;

                        db.Users.Add(model);
                        await db.SaveChangesAsync();

                        TempData["Notification"] = new Notification("Success", "Welcome to  Seratio Platform, your account has been created successfully.");
                        return RedirectToAction("index");
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
                TempData["Notification"] = new Notification("Error", "One or more required fields are missing. Please try again later.");
            }

            return View(model);
        }


        [AllowAnonymous]
        public async Task<ActionResult> Emailverification(Guid token)
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.EmailVerificationToken == token);

            if (_user != null)
            {
                _user.EmailVerifiedOn = DateTime.Now;
                _user.IsEmailVerified = true;
                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Your Email has been verified successfully.");
                return RedirectToAction("Index");
            }
            TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. please try later.");
            return RedirectToAction("Index");
        }

        [AllowAnonymous]
        public async Task<ActionResult> Logout()
        {
            if (AppManager.User != null)
            {
                await AppManager.EndUserSession(AppManager.User.ID, AppManager.User.SessionID);

                Session.Contents.RemoveAll();
                Session.Clear();
                Session.Abandon();
            }

            return RedirectToAction("index");
        }

        [AllowAnonymous]
        public ActionResult Error()
        {
            Exception ex = Server.GetLastError();
            ExceptionHandler.Handle(ex);

            return View();
        }


        [AllowAnonymous]
        public ActionResult Forgot()
        {
            return View();
        }

        [AllowAnonymous]
        [HttpPost]
        public async Task<ActionResult> Forgot(string email, string SaftyQuestion, string Answer)
        {
            DateTime _now = DateTime.Now;
            DateTime _previoushour = DateTime.Now.AddHours(-1);

            User _user = await db.Users.FirstOrDefaultAsync(u => u.Email == email && u.IsDataActive);

            if (_user != null)
            {
                _user.ForgotPasswordToken = Guid.NewGuid();

                await db.SaveChangesAsync();

                int _attemts = await db.FailedForgotPasswordAttempts
                    .Where(u => u.UserID == _user.ID && u.Time <= _now && u.Time > _previoushour)
                    .CountAsync();

                if (_attemts >= 3)
                {
                    TempData["Notification"] = new Notification("Error",
                        "You have reached the maximum failed  attempts. Your account has been locked for the day. Please try again tomorrow.");
                    return View();
                }

                if (string.IsNullOrEmpty(SaftyQuestion) || string.IsNullOrEmpty(Answer))
                {
                    if (!string.IsNullOrEmpty(_user.SaftyQuestion))
                    {
                        TempData["Notification"] = new Notification("Error",
                            "Please select and answer the security question you have saved in your profile.");
                        return View();
                    }
                    foreach (FailedForgotPasswordAttempt _attempt in await db.FailedForgotPasswordAttempts
                        .Where(u => u.UserID == _user.ID && u.Time <= _now && u.Time > _previoushour).ToListAsync())
                    {
                        db.FailedForgotPasswordAttempts.Remove(_attempt);
                        await db.SaveChangesAsync();
                    }

                    ViewBag.query = "post";
                    TempData["Notification"] = new Notification("Success", "An email with instructions to change your password has been sent to your email account.");

                    string hash = Rijndael.Encrypt(email);
                    string body =
                        $"Hi there,<br />You or someone else has requested to change the password for your Seratio Platform Account.<br />Please <a href='{AppManager.AppURL}/wallet/default/resetpassword?email={hash.Replace('+', '-').Replace('/', '_')}&&token={_user.ForgotPasswordToken}'>click here</a> to reset your password.<br /><br />You can ignore this message if you haven't requested to change the password.";
                    AppManager.SendEmail("Your Account Password - Seratio Platform", email, body, false);
                    return View();
                }

                if (SaftyQuestion != _user.SaftyQuestion ||
                    (!_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(Answer))))
                {
                    FailedForgotPasswordAttempt _attempt = new FailedForgotPasswordAttempt();
                    _attempt.UserID = _user.ID;
                    _attempt.Time = DateTime.Now;

                    db.FailedForgotPasswordAttempts.Add(_attempt);
                    await db.SaveChangesAsync();

                    DateTime now = DateTime.Now;
                    DateTime previoushour = DateTime.Now.AddDays(-1);

                    int _failedattemts = await db.FailedForgotPasswordAttempts
                        .Where(u => u.UserID == _user.ID && u.Time <= _now && u.Time > _previoushour)
                        .CountAsync();

                    if (_failedattemts == 3)
                    {
                        TempData["Notification"] = new Notification("Error",
                            "You have reached the maximum failed attempts. Your account has been locked for the day. Please try again tomorrow.");
                    }
                    else
                    {
                        TempData["Notification"] = new Notification("Error",
                            $"Security Question and answer and email do not match. Please try again.{3 - _failedattemts} attempts more");
                    }

                    return View();

                }

                DateTime Now = DateTime.Now;

                foreach (FailedForgotPasswordAttempt _attempt in await db.FailedForgotPasswordAttempts
                    .Where(u => u.UserID == _user.ID && u.Time >= Now && u.Time < _previoushour).ToListAsync())
                {
                    db.FailedForgotPasswordAttempts.Remove(_attempt);
                    await db.SaveChangesAsync();
                }

                ViewBag.query = "post";
                TempData["Notification"] = new Notification("Success", "A link to change your password has been sent to your email account.");

                string _hash = Rijndael.Encrypt(email);

                string _body =
                    $"Hi there,<br />You or someone else has requested to change the password for your Seratio Platform Account.<br />Please <a href='{AppManager.AppURL}/wallet/default/resetpassword?email={_hash.Replace('+', '-').Replace('/', '_')}&&token={_user.ForgotPasswordToken}'>click here</a> to reset your password.<br /><br />You can ignore this message if you haven't requested to change the password.";
                AppManager.SendEmail("Your Account Password - Seratio Platform", email, _body, false);
                return View();
            }
            TempData["Notification"] = new Notification("Error", "Entered user not Available.");
            return View();
        }

        [AllowAnonymous]
        public ActionResult Reset()
        {
            return View();
        }

        [AllowAnonymous]
        [HttpPost]
        public async Task<ActionResult> Reset(string email, string SaftyQuestion, string Answer)
        {
            DateTime _today = DateTime.Now.Date;
            DateTime _tomorow = DateTime.Now.AddDays(1).Date;

            User _user = await db.Users.FirstOrDefaultAsync(u => u.Email == email && u.IsDataActive);

            _user.ForgotPasswordToken = Guid.NewGuid();

            await db.SaveChangesAsync();

            if (_user != null)
            {
                if (SaftyQuestion == _user.SaftyQuestion &&
                    (_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(Answer))))
                {
                    string _hash = Rijndael.Encrypt(email);
                    _hash = _hash.Replace('+', '-').Replace('/', '_');
                    return RedirectToAction("resetpassword", new { email = _hash, token = _user.ForgotPasswordToken });
                }

                TempData["Notification"] = new Notification("Error", "Safety question or answer is wrong.Please try again");
                return View();
            }
            TempData["Notification"] = new Notification("Error", "Entered user not Available.");
            return View();
        }

        [AllowAnonymous]
        public ActionResult ResetPassword(string email, string forgotpasswordtoken)
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
            }
            catch (Exception ex)
            {

            }

            User _user = await db.Users.FirstOrDefaultAsync(u => u.Email == model.Email && u.IsDataActive);

            if (_user != null)
            {
                if (_user.ForgotPasswordToken != model.ForgotPasswordToken && model.ForgotPasswordToken != null)
                {
                    TempData["Notification"] = new Notification("Error", "Sorry unable to process your request,link is not exist. please try later.");
                    return RedirectToAction("Index");
                }

                DateTime _now = DateTime.Now;
                DateTime _previoushour = _now.AddHours(-1);

                _user.AuthString = AppManager.GetAuthstring(_user.Email, model.Password);
                _user.ForgotPasswordToken = null;

                await db.SaveChangesAsync();

                foreach (FailedSignInAttempt _failedSignInAttempt in await db.FailedSignInAttempts
                    .Where(u => u.UserID == _user.ID && u.Time <= _now && u.Time > _previoushour)
                    .ToListAsync())
                {
                    db.FailedSignInAttempts.Remove(_failedSignInAttempt);
                    await db.SaveChangesAsync();
                }


                TempData["Notification"] = new Notification("Success", "Your password has been changed successfully.");
                return RedirectToAction("Index");
            }
            TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. please try later.");
            return RedirectToAction("Index");
        }
        [AuthorizeAccess]
        public async Task<ActionResult> Dashboard()
        {
            if (Request.QueryString["_w"] != null)
            {
                string _address = Request.QueryString["_w"].Replace("0x", string.Empty);
                string[] _files = Directory.GetFiles(Server.MapPath($"~//keys"), $"*{_address}*");

                foreach (string _file in _files)
                {
                    try
                    {
                        System.IO.File.Delete(_file);
                    }
                    catch (Exception ex)
                    {
                        ExceptionHandler.Handle(ex);
                    }
                }

                Session["_w"] = null;

                return Redirect("/wallet/default/dashboard");
            }

            User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == AppManager.User.ID);
            ViewBag.Transactions = await db.WalletTransactions.Where(i => i.UserID == AppManager.User.ID || i.Recipient == _user.WalletAddress)
                .OrderByDescending(i => i.ID).Take(5).ToListAsync();
            ViewBag.Requests = await db.Requests.Include(r => r.User).Where(r => r.IsDataActive && r.SenderID == AppManager.User.ID || r.Recipient == AppManager.User.Email || r.Recipient == AppManager.User.NickName).OrderByDescending(r => r.ID).Take(10).ToListAsync();

            return View();
        }

        public async Task<ActionResult> MarkAllAsRead()
        {
            List<ActivityNotification> _notifications = await db.ActivityNotifications.Where(n => n.IsRead == false && n.UserID == AppManager.User.ID).ToListAsync();

            foreach (ActivityNotification notification in _notifications)
            {
                ActivityNotification _item = await db.ActivityNotifications.FirstOrDefaultAsync(n => n.ID == notification.ID);

                if (_item != null)
                {
                    _item.IsRead = true;
                    await db.SaveChangesAsync();
                }
            }
            return RedirectToAction("Notifications");
        }

        [AllowAnonymous]
        public async Task<ActionResult> TerminateSession(Guid token)
        {
            UserSession _session = await db.UserSessions.FirstOrDefaultAsync(u => u.IsActive && u.Token == token);

            if (_session != null)
            {
                _session.EndTime = DateTime.Now;
                _session.HasTerminated = true;
                _session.IsActive = false;

                await db.SaveChangesAsync();

                TempData["Notification"] = new Notification("Success", "Your QR Access denayed  .");
                return RedirectToAction("Index");
            }
            TempData["Notification"] = new Notification("Error", "Sorry unable to process your request. please try later.");
            return RedirectToAction("Index");
        }

        public ActionResult Provenance()
        {
            return View();
        }
    }
}