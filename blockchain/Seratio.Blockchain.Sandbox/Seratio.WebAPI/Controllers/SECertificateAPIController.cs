using Microsoft.Owin.Security;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Data.Entity;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Cors;

namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class SECertificateAPIController : BaseAPIController
    {

        [HttpPost]
        [Route("api/MySEScore")]
        public async Task<SEScoreResult> MySEScore()
        {
            SEScoreResult result = new SEScoreResult();

            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                result.SAPIResponse = await AppManager.GetSE(_user.Email);

                if (result.SAPIResponse != null && result.SAPIResponse.data != null)
                {
                    result.Status = true;
                    return result;
                }
                else
                {
                    result.Status = false;
                    result.Message = "Score Not Found";
                    return result;
                }
            }
            else
            {
                result.Status = false;
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/CalculateSEScore")]
        public async Task<SEScoreResult> CalculateSEScore(Data model)
        {
            SEScoreResult result = new SEScoreResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                if (model.country != null/* && model.worth != 0 && model.family != 0 && model.money_leveraged != 0 && model.people != 0 && model.csr != 0*/)
                {
                    //model.email = AppManager.User.Email;
                    model.currency = model.country;

                    SAPIResponse _response = await AppManager.CalculateSE(model);

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
                            result.SAPIResponse = _response;
                            result.Message = "Your S/E Score has been calculated successfully.";
                            result.Status = true;
                            return result;
                        }
                        else
                        {
                            result.Message = "Your S/E Score cannot be calculated now. Please try again later.";
                            return result;
                       
                        }
                    }
                    else
                    {
                        result.Message = "Your S/E Score cannot be calculated now. Please try again later.";
                        return result;
                    }
                }
                else
                {
                    result.Message = "One or more fields are missing or contains invalid value. Please try again later.";
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
        [Route("api/PDF")]
        public async Task<SEScoreResult> PDF(string email, int id)
        {

            SEScoreResult result = new SEScoreResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                SAPIResponse _result = await AppManager.GetSE(email);

                if (_result.data == null)
                {
                    result.Message = "Request not found.";
                    return result;
                }

                var _request = await db.Requests.FirstOrDefaultAsync(r => r.ID == id && r.SenderID == AppManager.User.ID && r.Status == "Approved" && r.HasDownloaded == false);

                if (_request == null)
                {
                    result.Message = "Request not found.";
                    return result;
                }

                var emailuser = (await db.Users.FirstOrDefaultAsync(u => u.Email == email));

                var Nickname = string.IsNullOrEmpty(emailuser.NickName) ? emailuser.Email : emailuser.NickName;

                if (_request != null)
                {
                    _request.HasDownloaded = true;

                    await db.SaveChangesAsync();
                }
                result.SAPIResponse = _result;
                result.Status = true;
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }



    }
}
