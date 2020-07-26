using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Identity.EntityFramework;
using Microsoft.AspNet.Identity.Owin;
using Microsoft.Owin.Security;
using Microsoft.Owin.Security.Cookies;
using Microsoft.Owin.Security.OAuth;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Models;

namespace Seratio.WebAPI.Providers
{
    public class ApplicationOAuthProvider : OAuthAuthorizationServerProvider
    {
        private readonly string _publicClientId;
        protected PlatformDatabaseEntities db = DatabaseContextManager.Current;


        public ApplicationOAuthProvider(string publicClientId)
        {
            if (publicClientId == null)
            {
                throw new ArgumentNullException("publicClientId");
            }

            _publicClientId = publicClientId;
        }

        public override Task ValidateClientAuthentication(OAuthValidateClientAuthenticationContext context)
        {
          
            string clientId = string.Empty;
            string clientSecret = string.Empty;
            //Client client = null;

            //if (!context.TryGetBasicCredentials(out clientId, out clientSecret))
            //{
            //    context.TryGetFormCredentials(out clientId, out clientSecret);
            //}

            if (context.ClientId == null)
            {
                //Remove the comments from the below line context.SetError, and invalidate context 
                //if you want to force sending clientId/secrects once obtain access tokens. 
                context.Validated();
                //context.SetError("invalid_clientId", "ClientId should be sent.");
                return Task.FromResult<object>(null);
            }

            

            //if (client == null)
            //{
            //    context.SetError("invalid_clientId", string.Format("Client '{0}' is not registered in the system.", context.ClientId));
            //    return Task.FromResult<object>(null);
            //}

            //if (client.ApplicationType == Models.ApplicationTypes.NativeConfidential)
            //{
            //    if (string.IsNullOrWhiteSpace(clientSecret))
            //    {
            //        context.SetError("invalid_clientId", "Client secret should be sent.");
            //        return Task.FromResult<object>(null);
            //    }
            //    else
            //    {
            //        if (client.Secret != Helper.GetHash(clientSecret))
            //        {
            //            context.SetError("invalid_clientId", "Client secret is invalid.");
            //            return Task.FromResult<object>(null);
            //        }
            //    }
            //}

            //if (!client.Active)
            //{
            //    context.SetError("invalid_clientId", "Client is inactive.");
            //    return Task.FromResult<object>(null);
            //}

            context.OwinContext.Set<string>("as:clientAllowedOrigin", "*");
            context.OwinContext.Set<string>("as:clientRefreshTokenLifeTime", "30000");

            context.Validated();
            return Task.FromResult<object>(null);
        }

        public override async Task GrantResourceOwnerCredentials(OAuthGrantResourceOwnerCredentialsContext context)
        {
            var userManager = context.OwinContext.GetUserManager<ApplicationUserManager>();

            //**Replace below user authentication code as per your Entity Framework Model ***
            DateTime _now = DateTime.Now;
            DateTime _previoushour = _now.AddHours(-1);

            User _userByUsername = await db.Users.FirstOrDefaultAsync(u => u.Email == context.UserName && u.IsDataActive);

            if (_userByUsername != null)
            {
                #region Check if the account is already blocked

                int _failedAttemptsSoFar = await db.FailedSignInAttempts
                    .CountAsync(u => u.UserID == _userByUsername.ID && u.Time <= _now && u.Time > _previoushour);

                if (_failedAttemptsSoFar >= 3)
                {
                    context.SetError("invalid_grant", "Your account is locked for the day. Please try again tomorrow.");
                }

                #endregion
                

                AppUser _authenticatedUser = await AppManager.AuthenticateUserAsync(context.UserName.ToLower(), context.Password);

                if (_authenticatedUser != null)
                {
                    #region Successful Login

                    if (!_authenticatedUser.IsEmailverified)
                    {
                        context.SetError("invalid_grant", "Your email is not verified. Please verify your email address and try again later.");
                    }

                    foreach (FailedSignInAttempt _failedSignInAttempt in await db.FailedSignInAttempts
                        .Where(u => u.UserID == _userByUsername.ID && u.Time <= _now && u.Time > _previoushour)
                        .ToListAsync())
                    {
                        db.FailedSignInAttempts.Remove(_failedSignInAttempt);
                        await db.SaveChangesAsync();
                    }

                    if (_authenticatedUser.IsSuperAdmin)
                    {
                        string _body =
                            $"Hello {_authenticatedUser.NickName ?? _authenticatedUser.Email.ToLower()} ,<br /><br /> New Sign in From {Environment.OSVersion}. If this was not you, please change your password";
                        AppManager.SendEmail("New Sign in", _authenticatedUser.Email, _body);
                    }


                    ClaimsIdentity oAuthIdentity =
               new ClaimsIdentity(context.Options.AuthenticationType);
                    ClaimsIdentity cookiesIdentity =
                    new ClaimsIdentity(context.Options.AuthenticationType);


                    AuthenticationProperties properties = CreateProperties(_userByUsername.Email, _userByUsername.ID.ToString(), "SEApp");
                    AuthenticationTicket ticket = new AuthenticationTicket(oAuthIdentity, properties);
                    context.Validated(ticket);
                    context.Request.Context.Authentication.SignIn(cookiesIdentity);


                    #endregion
                }
                else
                {
                    context.SetError("invalid_grant",
                  "The user name or password is incorrect.");
                    return;
                }
            }

        }

        public override Task GrantRefreshToken(OAuthGrantRefreshTokenContext context)
        {
            //validate your client  
            //var currentClient = context.ClientId;  

            //if (Client does not match)  
            //{  
            //    context.SetError("invalid_clientId", "Refresh token is issued to a different clientId.");  
            //    return Task.FromResult<object>(null);  
            //}  

            // Change authentication ticket for refresh token requests  

            var originalClient = context.Ticket.Properties.Dictionary["as:client_id"];

          //  var currentClient = context.ClientId;
            var currentClient = "SEApp";

            if (originalClient != currentClient)

            {
                context.Rejected();
                return null;
            }

            var newIdentity = new ClaimsIdentity(context.Ticket.Identity);
            newIdentity.AddClaim(new Claim("newClaim", "refreshToken"));


            var newTicket = new AuthenticationTicket(newIdentity, context.Ticket.Properties);
            context.Validated(newTicket);

            return Task.FromResult<object>(null);
        }

        public override Task TokenEndpoint(OAuthTokenEndpointContext context)
        {
            foreach (KeyValuePair<string, string> property in context.Properties.Dictionary)
            {
                context.AdditionalResponseParameters.Add(property.Key, property.Value);
            }

            return Task.FromResult<object>(null);
        }

       

        public override Task ValidateClientRedirectUri(OAuthValidateClientRedirectUriContext context)
        {
            if (context.ClientId == _publicClientId)
            {
                Uri expectedRootUri = new Uri(context.Request.Uri, "/");

                if (expectedRootUri.AbsoluteUri == context.RedirectUri)
                {
                    context.Validated();
                }
            }

            return Task.FromResult<object>(null);
        }

        public static AuthenticationProperties CreateProperties(string userName,string userID, string clientId)
        {
            IDictionary<string, string> data = new Dictionary<string, string>
            {
                { "userName", userName },
                { "userID", userID },
                { "as:client_id", (clientId == null) ? string.Empty :clientId },
                {"Status", true.ToString() }
            };
            return new AuthenticationProperties(data);
        }
    }
}