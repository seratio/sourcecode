using Seratio.Platform.ICO.Core;
using Seratio.Platform.ICO.Core.Entities.API;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Models;
using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Data.Entity.Validation;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web.Http;

namespace Seratio.Platform.ICO.API
{
    public class UsersController : BaseAPIController
    {
        [AllowAnonymous]
        [HttpPost]
        [Route("api/users/signup")]
        public async Task<IHttpActionResult> Signup(User model)
        {
            APIResponse _response = new APIResponse();

            if (string.IsNullOrEmpty(model.Gender))
            {
                model.Gender = "Male";
            }

            ModelState.Clear();

            model.ConfirmPassword = model.Password;

            try
            {
                if (ModelState.IsValid)
                {
                    if (!await db.Users.AnyAsync(u => u.Email == model.Email && u.IsDataActive))
                    {
                        try
                        {
                            model.AuthString = AppManager.GetAuthstring(model.Email, model.Password);
                            model.EmailVerificationToken = null;
                            model.IsEmailVerified = true;
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

                            _response.WasSuccess = true;
                            _response.Message = $"Welcome to the Seratio Platform, your account has been created successfully.";
                            return Ok(_response);
                        }
                        catch (DbEntityValidationException ex)
                        {
                            string _errorMessages = string.Join("; ", ex.EntityValidationErrors.SelectMany(x => x.ValidationErrors).Select(x => x.ErrorMessage));
                            _response.Message = _errorMessages;
                        }
                    }
                    else
                    {
                        _response.Message = "There is an existing account associated with this email or Username.";
                    }
                }
                else
                {
                    _response.Message = "One or more fields are missing or contains invalid value. Please try again later.";
                }
            }
            catch (Exception ex)
            {
                _response.Message = ex.Message;
            }

            return Ok(_response);
        }

        [HttpPost]
        [AllowAnonymous]
        [Route("api/users/signin")]
        public async Task<IHttpActionResult> SignIn(UserLoginParams model)
        {
            APIResponse _response = new APIResponse();

            if (string.IsNullOrEmpty(model.Email) || string.IsNullOrEmpty(model.Password))
            {
                _response.Message = "Username or password is empty";
                _response.WasSuccess = false;

                return Ok(_response);
            }

            LoggedInUser _loggedInUser = await AppManager.AuthenticateLoggedInUserAsync(model.Email, model.Password);

            if (_loggedInUser != null)
            {
                UserSession _session = await AppManager.CreateUserSession(_loggedInUser.ID, "API");

                _loggedInUser.SessionID = _session.ID;
                _loggedInUser.Token = _session.Token;

                _response.Data = _loggedInUser;
                _response.WasSuccess = true;
                _response.Message = "Successfully logged-in";

                return Ok(_response);
            }
            else
            {
                _response.Message = "Email or password do not match. Please try again later.";

                return Ok(_response);
            }
        }

        [HttpPost]
        [AllowAnonymous]
        [Route("api/users/signout")]
        public async Task<IHttpActionResult> SignOut(LoggedInUser model)
        {
            APIResponse _response = new APIResponse();

            if (model.ID == 0 || model.SessionID == 0)
            {
                _response.Message = "Username or password is empty";
                _response.WasSuccess = false;

                return BadRequest("Invalid Parameters");
            }

            await AppManager.EndUserSession(model.ID, model.SessionID, model.Token);

            _response.WasSuccess = true;
            _response.Message = "Successfully logged-out";

            return Ok(_response);
        }

        [HttpGet]
        [Route("api/users/profile")]
        public async Task<IHttpActionResult> Profile(int ID)
        {
            APIResponse _response = new APIResponse();

            User _user = await db.Users.FindAsync(ID);

            if (_user == null)
            {
                _response.Message = "Requested user is not available.";
                _response.WasSuccess = false;

                return Ok(_response);
            }

            _response.Message = "Requested user available.";
            _response.WasSuccess = true;
            _response.Data = _user;

            return Ok(_response);
        }
    }
}
