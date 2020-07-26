using Microsoft.Owin.Security;
using Newtonsoft.Json;
using QRCoder;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Entities.QR;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Data.Entity;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Web;
using System.Web.Http;
using System.Web.Http.Cors;
using System.Web.ModelBinding;

namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class SettingsAPIController : BaseAPIController
    {
        [HttpPost]
        [Route("api/ViewProfile")]
        public async Task<ViewProfileResult> ViewProfile()
        {
            ViewProfileResult result = new ViewProfileResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];

                if (_user == null)
                {
                    result.Message = "Request not found.";
                    return result;
                }

                QRData _qrObj = new QRData
                {
                    AuthToken = Rijndael.Encrypt(_user.AutoLoginToken.ToString())
                };

                string _qrData = Rijndael.Encrypt(JsonConvert.SerializeObject(_qrObj));

                if (_user.ShouldAllowSignInWithQR)
                {
                    using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
                    {
                        using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode(_qrData, QRCodeGenerator.ECCLevel.Q))
                        {
                            using (QRCode _qrCode = new QRCode(_qrCodeData))
                            {
                                Bitmap qrCodeImage = _qrCode.GetGraphic(20, "#0067a3", "#ffffff");

                                MemoryStream ms = new MemoryStream();
                                qrCodeImage.Save(ms, ImageFormat.Jpeg);
                                byte[] byteImage = ms.ToArray();
                                var SigBase64 = Convert.ToBase64String(byteImage);
                                //ViewBag.Base = SigBase64;
                            }
                        }
                    }
                }
                result.User = _user;
                result.Status = true;
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/EditProfile")]
        public async Task<EditProfileResult> EditProfile(User model)
        {
            EditProfileResult result = new EditProfileResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FindAsync(UserID);
                //model.ConfirmPassword = model.Password;
                ModelState.Clear();
                TryValidateModel(model);

                if (ModelState.IsValid)
                {

                    if (_user != null)
                    {
                        if (await db.Users.AnyAsync(u => u.IsDataActive && u.ID != _user.ID && u.NickName == model.NickName && !string.IsNullOrEmpty(model.NickName)))
                        {
                            result.Message = "Requested Nickname already exist. Please try another one.";
                            return result;
                        }

                        if (model.Answer != null && !string.IsNullOrEmpty(model.SaftyQuestion))
                        {
                            _user.SaftyAnswer = AppManager.GetEncriptedBytes(model.Answer);
                            _user.SaftyQuestion = model.SaftyQuestion;
                        }

                        _user.Phone = model.Phone;
                        _user.Gender = model.Gender ?? string.Empty;
                        _user.NickName = model.NickName;
                        _user.FirstName = model.FirstName;
                        _user.IsSearchable = model.IsSearchable;
                        _user.ShouldAllowSignInWithQR = model.ShouldAllowSignInWithQR;
                        _user.LastUpdatedOn = DateTime.Now;
                        _user.AssetTransactionCriteria = model.AssetTransactionCriteria;
                        _user.AllowEmailNotifications = model.AllowEmailNotifications;
                        
                        if (model.AssetTransactionCriteria != null)
                        {
                            _user.AssetTransactionCriteriaValue = model.AssetTransactionCriteriaValue;
                        }
                        else
                        {
                            _user.AssetTransactionCriteriaValue = null;
                        }
                        try
                        {

                            db.Entry(_user).State = EntityState.Modified;
                            await db.SaveChangesAsync();
                            result.Status = true;
                            result.User = model;
                            result.Message = "Requested User has been saved successfully.";
                            return result;

                        }
                        catch (Exception ex)
                        {
                            result.Status = false;
                            result.User = null;
                            result.Message = ex.Message;
                            return result;
                        }
                      
                    }
                    else
                    {
                        result.Message = "Bad request.";
                        return result;
                    }
                }

                result.Message = "One or more fields are missing or contains invalid value. Please try again later.";
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/ChangePassword")]
        public async Task<ResultSet> ChangePassword(ChangePasswordRequest model)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];

                if (!string.IsNullOrEmpty(_user.SaftyQuestion))
                {
                    if (string.IsNullOrEmpty(model.answer))
                    {
                        result.Message = "Sorry, we are unable to process your request. Please enter the current security answer first.";
                        return result;

                    }

                    if (!_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(model.answer)))
                    {
                        result.Message = "Sorry, we are unable to process your request. The safty answer is wrong.";
                        return result;
                    }

                }


                if (model.Password != null)
                {
                    if (model.Password == model.ConfirmPassword)
                    {
                        if (_user != null)
                        {
                            byte[] _authString = AppManager.GetAuthstring(_user.Email, model.Password);
                            _user.AuthString = _authString;
                            await db.SaveChangesAsync();
                            result.Status = true;
                            result.Message = "Password has been changed successfully.";
                            return result;
                        }
                        else
                        {
                            result.Message = "Sorry, we are unable to process your request. Please try again later.";
                            return result;
                        }
                    }
                    else
                    {
                        result.Message = "Passwords do not match. Please try again later.";
                        return result;
                    }
                }
                else
                {
                    result.Message = "Sorry, we are unable to process your request. Please try again later.";
                    return result;
                }
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/ChangeCredentials")]
        public async Task<ChangeCredentialResponse> ChangeCredentials(ChangeCredentialRequest model)
        {
            ChangeCredentialResponse result = new ChangeCredentialResponse();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
              if(_user!=null)
                {
                    DateTime _today = DateTime.Now.Date;
                    DateTime _tomorow = DateTime.Now.AddDays(1).Date;

                    _user = await db.Users.FirstOrDefaultAsync(u => u.Email == model.email && u.IsDataActive);

                    _user.ForgotPasswordToken = Guid.NewGuid();

                    await db.SaveChangesAsync();

                    if (model.SaftyQuestion == _user.SaftyQuestion &&
                    (_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(model.Answer))))
                    {
                        string _hash = Rijndael.Encrypt(model.email);
                        _hash = _hash.Replace('+', '-').Replace('/', '_');
                        result.token = _user.ForgotPasswordToken;
                        result._hash = _hash;
                        result.Status = true;
                        return result;
                    }
                    else
                    {
                        result.Message = "Safety question or answer is wrong.Please try again";
                        return result;
                    }
                }
                else
                {
                result.Message = "Entered user not Available.";
                return result;
                }
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

    

        [HttpPost]
        [Route("api/ChangeSafetyQuestion")]
        public async Task<ResultSet> ChangeSafetyQuestion(ChangeSafetyQuestionRequest model)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];
                if (string.IsNullOrEmpty(model.OldAnswer))
                {
                    result.Message = "Sorry, we are unable to process your request. Please enter the current security answer first.";
                    return result;
                }

                byte[] ch = AppManager.GetEncriptedBytes(model.OldAnswer);
                if (!_user.SaftyAnswer.SequenceEqual(ch))
                {
                    result.Message = "Sorry, we are unable to process your request. The safety answer is wrong.";
                    return result;
                }

                if (model.NewSaftyQuestion != null && model.NewAnswer != null)
                {
                    if (_user != null)
                    {
                        _user.SaftyQuestion = model.NewSaftyQuestion;
                        _user.SaftyAnswer = AppManager.GetEncriptedBytes(model.NewAnswer);
                        await db.SaveChangesAsync();

                        result.Status = true;
                        result.Message = "Safety Question and answer has been changed successfully.";
                        return result;
                    }
                    else
                    {
                        result.Message = "Sorry, we are unable to process your request. Please try again later.";
                        return result;
                    }

                }
                else
                {
                    result.Message = "Sorry, we are unable to process your request. Please try again later.";
                    return result;
                }
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }

        }

        [HttpPost]
        [Route("api/Logout")]
        public async Task<ResultSet> Logout()
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                //if (AppManager.User != null)
                //{

                //    //await AppManager.EndUserSession(_user.ID, AppManager.User.SessionID);
                //}
                result.Status = true;
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [AllowAnonymous]
        public async Task<GetUsersResult> GetUsers(string q, int i)
        {
            int _skip = i == 1 ? 0 : i * 20;

            var _query = from u in db.Users

                         where u.IsDataActive && (u.NickName.Contains(q) || u.Email.Contains(q) || u.Email.Contains(q))
                         orderby u.NickName
                         select new
                         {
                             u.NickName,
                             u.Email,
                         };

            Select2TextPagedResult _result = new Select2TextPagedResult
            {
                Total = await _query.OrderBy(t => t.NickName).CountAsync(),
                Results = (await _query.OrderBy(t => t.NickName).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2TextItem
                {
                    id = r.Email,
                    text = r.NickName != null ? r.NickName + " " + "(" + r.Email + ")" : r.Email
                }).ToList()
            };
            GetUsersResult result = new GetUsersResult();
            result.Select2TextPagedResult = _result;
            result.Status = true;
            return result;
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
