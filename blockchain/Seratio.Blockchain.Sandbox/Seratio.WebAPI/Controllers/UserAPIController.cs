using Google.Authenticator;
using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Entities.QR;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Data.Entity;
using System.Data.Entity.Validation;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web;
using System.Web.Hosting;
using System.Web.Http;
using System.Web.Http.Cors;
using System.Web.ModelBinding;

namespace Seratio.WebAPI.Controllers
{
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class UserAPIController : BaseAPIController
    {
        [AllowAnonymous]
        [HttpPost]
        [Route("api/Login")]
        public async Task<LoginResult> Login(LoginRequest request)
        {
            LoginResult result = new LoginResult();
            if (!string.IsNullOrEmpty(request.username) && !string.IsNullOrEmpty(request.password))
            {
                DateTime _now = DateTime.Now;
                DateTime _previoushour = _now.AddHours(-1);

                User _userByUsername = await db.Users.FirstOrDefaultAsync(u => u.Email == request.username && u.IsDataActive);

                if (_userByUsername != null)
                {
                    #region Check if the account is already blocked

                    int _failedAttemptsSoFar = await db.FailedSignInAttempts
                        .CountAsync(u => u.UserID == _userByUsername.ID && u.Time <= _now && u.Time > _previoushour);

                    if (_failedAttemptsSoFar >= 3)
                    {
                        result.Status = false;
                        result.Message = "Your account is locked for the day. Please try again tomorrow.";
                        return result;
                    }

                    #endregion

                    AppUser _authenticatedUser = await AppManager.AuthenticateUserAsync(request.username.ToLower(), request.password);

                    if (_authenticatedUser != null)
                    {
                        #region Successful Login

                        if (!_authenticatedUser.IsEmailverified)
                        {
                            result.Status = false;
                            result.Message = "Your email is not verified. Please verify your email address and try again later.";
                            return result;
                        }

                        foreach (FailedSignInAttempt _failedSignInAttempt in await db.FailedSignInAttempts
                            .Where(u => u.UserID == _userByUsername.ID && u.Time <= _now && u.Time > _previoushour)
                            .ToListAsync())
                        {
                            db.FailedSignInAttempts.Remove(_failedSignInAttempt);
                            await db.SaveChangesAsync();
                        }

                        result.AppUser = _authenticatedUser;

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
                            result.Status = true;
                            result.Message = "Please secure your account by adding a Security question from the My Profile Area.";
                            result.AppUser = _authenticatedUser;
                            return result;
                        }

                        if (!string.IsNullOrEmpty(request.next))
                        {
                            if (string.IsNullOrEmpty(_userByUsername.WalletAddress))
                            {
                                result.Status = true;
                                result.Message = "WalletAddress Empty";
                                result.AppUser = _authenticatedUser;
                                return result;
                            }

                            if (_authenticatedUser.RequiresTwoFactorAuthentication)
                            {
                                _authenticatedUser.PendingTwoFactorAuthentication = true;
                                result.Status = true;
                                result.Message = "PendingTwoFactorAuthentication";
                                result.AppUser = _authenticatedUser;
                                return result;
                            }

                            return result;
                        }

                        if (_authenticatedUser.RequiresTwoFactorAuthentication)
                        {
                            _authenticatedUser.PendingTwoFactorAuthentication = true;
                            result.Status = true;
                            result.Message = "PendingTwoFactorAuthentication";
                            result.AppUser = _authenticatedUser;
                            return result;
                        }

                        if (string.IsNullOrEmpty(_userByUsername.WalletAddress))
                        {
                            result.Status = true;
                            result.Message = "WalletAddress Empty";
                            result.AppUser = _authenticatedUser;
                            return result;
                        }

                        return result;

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
                            result.Status = false;
                            result.Message = "You have reached the maximum failed sign-in attempts. Your account has been locked for the day. Please try again tomorrow.";
                            result.AppUser = null;
                        }
                        else
                        {
                            result.Status = false;
                            result.Message = "Username and password do not match. You have {3 - _attemts} attempts remaining.";
                            result.AppUser = null;
                        }
                    }
                }
                else
                {
                    result.Status = false;
                    result.Message = $"Username and password do not match. Please try again later.";
                    result.AppUser = null;
                }
            }
            else
            {
                result.Status = false;
                result.Message = "One or more required fields are missing. Please try again later.";
                result.AppUser = null;
            }
            return result;
        }

        [AllowAnonymous]
        [HttpPost]
        [Route("api/TwoFactorAuth")]
        public async Task<LoginResult> TwoFactorAuth(TwoFactorRequest model)
        {
            LoginResult result = new LoginResult();
            try
            {
                int id = Convert.ToInt32(model.id);

                User _user = await db.Users.FindAsync(id);

                if (_user == null)
                {
                    result.AppUser = null;
                    result.Status = false;
                    result.Message = "User not found.";
                    return result;
                }

                TwoFactorAuthenticator _authenticator = new TwoFactorAuthenticator();
                string _uniquekey = _user.TwoFAKey;
                if (_user.TwoFAKey != null)
                {
                    bool _isValid = _authenticator.ValidateTwoFactorPIN(_uniquekey, model.otp);

                    if (_isValid)
                    {
                        AppUser _loggedInUser = await AppManager.AuthenticateUserAsync(model.id);
                        _loggedInUser.PendingTwoFactorAuthentication = false;
                        result.Message = "success";
                        result.AppUser = _loggedInUser;
                        result.Status = true;
                        return result;
                    }
                    else
                    {
                        result.Message = "Your have entered an invalid code. Please try again.";
                        return result;
                    }
                }
                else
                {
                    //_uniquekey = Guid.NewGuid().ToString().Replace("-", "");
                    //SetupCode _setupCode = _authenticator.GenerateSetupCode("Seratio Platform", _user.Email, _uniquekey, 300, 300);
                    //_user.TwoFAKey = _uniquekey;
                    //await db.SaveChangesAsync();
                    result.Message = "Two Factory Key is missing.";
                    return result;
                }
                
            }
            catch (Exception ex)
            {
                result.Message = "Sorry, " + ex.Message;
                return result;
            }
        }

        [AllowAnonymous]
        [HttpGet]
        [Route("api/DownloadKeys")]
        public async Task<HttpResponseMessage> DownloadKeys(string file)
        {
            //AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            //if (ticket != null)
            //{
            //    int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
            //    User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
            try
            {
                string path = HostingEnvironment.MapPath($"~\\keys") + "\\" + file;
                byte[] _downloadBytes = System.IO.File.ReadAllBytes(path);
                var dataStream = new MemoryStream(_downloadBytes);

                HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.OK);
                httpResponseMessage.Content = new StreamContent(dataStream);
                httpResponseMessage.Content.Headers.ContentDisposition = new System.Net.Http.Headers.ContentDispositionHeaderValue("attachment");
                httpResponseMessage.Content.Headers.ContentDisposition.FileName = file;
                httpResponseMessage.Content.Headers.ContentType = new System.Net.Http.Headers.MediaTypeHeaderValue("application/octet-stream");
                return httpResponseMessage;
            }
            catch (Exception ex)
            {
                HttpResponseMessage httpResponseMessage1 = Request.CreateResponse(ex.Message);
                return httpResponseMessage1;
            }
            //}
            //else
            //{
            //    HttpResponseMessage httpResponseMessage = Request.CreateResponse(HttpStatusCode.Unauthorized);
            //    return httpResponseMessage;
            //}
        }




        [AllowAnonymous]
        [HttpPost]
        [Route("api/LoginQR")]
        public async Task<LoginResult> QR(QRLoginRequest model)
        {
            LoginResult result = new LoginResult();

            try
            {
                OperatingSystem os = Environment.OSVersion;

                QRData _obj = JsonConvert.DeserializeObject<QRData>(Rijndael.Decrypt(model.qr_data));
                string _authString = Rijndael.Decrypt(_obj.AuthToken);
                AppUser _user = await AppManager.AuthenticateAutologinUserAsync(Guid.Parse(_authString));

                if (_user != null)
                {
                    if (!_user.IsEmailverified)
                    {
                        result.Status = false;
                        result.Message = "Please verify your email address before sign into our Platform.";
                        result.AppUser = null;
                        return result;
                    }
                    UserSession _session =
                        await db.UserSessions.FirstOrDefaultAsync(u => u.ID == _user.SessionID && u.UserID == _user.ID && u.IsActive);

                    if (_session != null)
                    {
                        string _body = $"Hello {(_user.NickName != null ? _user.NickName : _user.Email.ToLower())} ,<br /><br /> QR loggin found on your account on {os}.If not you<br />Please <a href='{AppManager.AppURL}/default/TerminateSession?token={_session.Token}'>click here</a> to denay access your Account.";
                        AppManager.SendEmail("New sign in", _user.Email, _body);
                    }


                    if (_user.RequiresTwoFactorAuthentication)
                    {
                        result.Status = true;
                        result.Message = "Please verify your email address before sign into our Platform.";
                        _user.PendingTwoFactorAuthentication = true;
                        result.AppUser = _user;
                        return result;
                    }
                    result.Status = true;
                    result.AppUser = _user;
                    return result;
                }
                result.Status = false;
                result.Message = "Unknown User; Please try again later.";
                result.AppUser = null;
                return result;
            }
            catch (Exception ex)
            {
                result.Status = false;
                result.Message = "Sorry, "+ex.Message;
                result.AppUser = null;
                return result;
            }
        }

     


        [AllowAnonymous]
        [HttpPost]
        [Route("api/Signup")]
        public async Task<SignUpResult> Signup(SignUpRequest reuqest)
        {
            SignUpResult result = new SignUpResult();
            User model = new User();
            model.Email = reuqest.Email;
            model.Password = reuqest.Password;
            model.ConfirmPassword = reuqest.ConfirmPassword;
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

                        result.Status = true;
                        result.Message = "Welcome to  Seratio Platform, your account has been created successfully.";
                        result.User = model;
                        return result;
                    }
                    catch (DbEntityValidationException ex)
                    {
                        string _errorMessages = string.Join("; ", ex.EntityValidationErrors.SelectMany(x => x.ValidationErrors).Select(x => x.ErrorMessage));
                        result.Status = false;
                        result.Message = _errorMessages;
                        result.User = null;
                        return result;
                    }
                }
                else
                {
                    result.Status = false;
                    result.Message = "There is an existing account associated with this email or Username.";
                    result.User = null;
                }
            }
            else
            {
                result.Status = false;
                result.Message = "One or more required fields are missing. Please try again later.";
                result.User = null;
            }

            return result;
        }

        [AllowAnonymous]
        [HttpPost]
        [Route("api/ForgotPassword")]
        public async Task<ChangeCredentialResponse> ForgotPassword(ChangeCredentialRequest model)
        {
            ChangeCredentialResponse result = new ChangeCredentialResponse();
            User _user = await db.Users.FirstOrDefaultAsync(u => u.Email == model.email && u.IsDataActive);
            if (_user != null)
            {
                DateTime _now = DateTime.Now;
                DateTime _previoushour = DateTime.Now.AddHours(-1);

                _user.ForgotPasswordToken = Guid.NewGuid();

                await db.SaveChangesAsync();

                int _attemts = await db.FailedForgotPasswordAttempts
                    .Where(u => u.UserID == _user.ID && u.Time <= _now && u.Time > _previoushour)
                    .CountAsync();

                if (_attemts >= 3)
                {
                    result.Message = "You have reached the maximum failed  attempts. Your account has been locked for the day. Please try again tomorrow.";
                    return result;
                }
                else
                {
                    if (string.IsNullOrEmpty(model.SaftyQuestion) || string.IsNullOrEmpty(model.Answer))
                    {
                        if (!string.IsNullOrEmpty(_user.SaftyQuestion))
                        {
                            result.Message = "Please select and answer the security question you have saved in your profile.";
                            return result;
                        }
                        else
                        {
                            foreach (FailedForgotPasswordAttempt _attempt in await db.FailedForgotPasswordAttempts
                           .Where(u => u.UserID == _user.ID && u.Time <= _now && u.Time > _previoushour).ToListAsync())
                            {
                                db.FailedForgotPasswordAttempts.Remove(_attempt);
                                await db.SaveChangesAsync();
                            }
                            result.Status = true;
                            result.Message = "An email with instructions to change your password has been sent to your email account.";
                            string hash = Rijndael.Encrypt(model.email);
                            string body =
                                $"Hi there,<br />You or someone else has requested to change the password for your Seratio Platform Account.<br />Please <a href='{AppManager.AppURL}/wallet/default/resetpassword?email={hash.Replace('+', '-').Replace('/', '_')}&&token={_user.ForgotPasswordToken}'>click here</a> to reset your password.<br /><br />You can ignore this message if you haven't requested to change the password.";
                            AppManager.SendEmail("Your Account Password - Seratio Platform", model.email, body, false);
                            return result;
                        }



                    }
                    else
                    if (model.SaftyQuestion != _user.SaftyQuestion ||
               (!_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(model.Answer))))
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
                            result.Message = "You have reached the maximum failed attempts. Your account has been locked for the day. Please try again tomorrow.";
                        }
                        else
                        {
                            result.Message = $"Security Question and answer and email do not match. Please try again.{3 - _failedattemts} attempts more";
                        }
                        return result;
                    }
                    else
                    {
                        DateTime Now = DateTime.Now;

                        foreach (FailedForgotPasswordAttempt _attempt in await db.FailedForgotPasswordAttempts
                            .Where(u => u.UserID == _user.ID && u.Time >= Now && u.Time < _previoushour).ToListAsync())
                        {
                            db.FailedForgotPasswordAttempts.Remove(_attempt);
                            await db.SaveChangesAsync();
                        }

                        result.Status = true;
                        result.Message = "A link to change your password has been sent to your email account.";
                        string _hash = Rijndael.Encrypt(model.email);

                        string _body =
                            $"Hi there,<br />You or someone else has requested to change the password for your Seratio Platform Account.<br />Please <a href='{AppManager.AppURL}/wallet/default/resetpassword?email={_hash.Replace('+', '-').Replace('/', '_')}&&token={_user.ForgotPasswordToken}'>click here</a> to reset your password.<br /><br />You can ignore this message if you haven't requested to change the password.";
                        AppManager.SendEmail("Your Account Password - Seratio Platform", model.email, _body, false);
                        return result;
                    }
                }

            }
            else
            {
                result.Message = "Entered user not Available.";
                return result;
            }

        }



        protected internal bool TryValidateModel(object model)
        {
            return TryValidateModel(model, null /* prefix */);
        }

        protected internal bool TryValidateModel(object model, string prefix)
        {
            if (model == null)
            {
                throw new ArgumentNullException("model");
            }

            ModelMetadata metadata = ModelMetadataProviders.Current.GetMetadataForType(() => model, model.GetType());
            var t = new ModelBindingExecutionContext(new HttpContextWrapper(HttpContext.Current), new System.Web.ModelBinding.ModelStateDictionary());

            foreach (ModelValidationResult validationResult in ModelValidator.GetModelValidator(metadata, t).Validate(null))
            {
                ModelState.AddModelError(validationResult.MemberName, validationResult.Message);
            }

            return ModelState.IsValid;
        }

    }
}
