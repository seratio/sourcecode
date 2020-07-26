using Microsoft.Owin.Security;
using Microsoft.Owin.Security.DataHandler;
using Microsoft.Owin.Security.DataProtection;
using Microsoft.Owin.Security.OAuth;
using System;
using System.Collections.Generic;
using System.Diagnostics.Contracts;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Web;
using System.Web.Http;
using System.Web.Http.Controllers;

namespace Seratio.WebAPI.Core.Security
{
    public class APIAuthorize : AuthorizeAttribute
    {
        public override void OnAuthorization(HttpActionContext actionContext)
        {
            if (SkipAuthorization(actionContext)) return;

            string token = string.Empty;
            AuthenticationTicket ticket;

            token = (actionContext.Request.Headers.Any(x => x.Key == "Authorization")) ? actionContext.Request.Headers.Where(x => x.Key == "Authorization").FirstOrDefault().Value.SingleOrDefault().Replace("Bearer ", "") : "";

            if (token == string.Empty)
            {
                actionContext.Response = actionContext.Request.CreateResponse(HttpStatusCode.Unauthorized, "Missing 'Authorization' header. Access denied.");
                return;
            }
            var secureDataFormat = new TicketDataFormat(new MachineKeyProtector());
            ticket = secureDataFormat.Unprotect(token);

            if (ticket == null)
            {
                actionContext.Response = actionContext.Request.CreateResponse(HttpStatusCode.BadRequest, "Invalid token decrypted.");
                return;
            }

            // you could perform some logic on the ticket here...

            // you will be able to retrieve the ticket in all controllers by querying properties and looking for "Ticket"... 
            
                if (!actionContext.Request.Properties.ContainsKey("Ticket"))
                    actionContext.Request.Properties.Add(new KeyValuePair<string, object>("Ticket", ticket));

        }

        private static bool SkipAuthorization(HttpActionContext actionContext)
        {
            Contract.Assert(actionContext != null);

            return actionContext.ActionDescriptor.GetCustomAttributes<AllowAnonymousAttribute>().Any()
                       || actionContext.ControllerContext.ControllerDescriptor.GetCustomAttributes<AllowAnonymousAttribute>().Any();
        }

    }


    public class MachineKeyProtector : IDataProtector
    {
        private readonly string[] _purpose =
        {
        typeof(OAuthAuthorizationServerMiddleware).Namespace,
        "Access_Token",
        "v1"
    };

        public byte[] Protect(byte[] userData)
        {
            throw new NotImplementedException();
        }

        public byte[] Unprotect(byte[] protectedData)

        {
            try
            {
                return System.Web.Security.MachineKey.Unprotect(protectedData, _purpose);
            }
            catch (Exception)
            {

                return null;
            }
            
        }
    }
}