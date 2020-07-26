using Microsoft.Owin.Security;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Cors;

namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class DashboardAPIController : BaseAPIController
    {
        
        [HttpPost]
        [Route("api/RecentWalletTransactions")]
        public async Task<RecentWalletTransactionResult> RecentWalletTransactions()
        {
            RecentWalletTransactionResult result = new RecentWalletTransactionResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if(ticket!=null)
            {
                int ID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == ID);
                if (_user != null)
                {
                    result.Status = true;
                    result.Message = "Success";
                    result.WalletTransactions = await db.WalletTransactions.Where(i => i.UserID == ID || i.Recipient == _user.WalletAddress)
                   .OrderByDescending(i => i.ID).Take(5).ToListAsync();
                    return result;
                }
                else
                {
                    result.Status = false;
                    result.Message = "User not found.";
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
        [Route("api/RecentRequests")]
        public async Task<RequestResult> RecentRequests()
        {
            RequestResult result = new RequestResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
               
                string UserName = ticket.Properties.Dictionary["userName"];
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID);
                if (_user != null)
                {
                    result.Status = true;
                    result.Message = "Success";
                    result.Requests = await db.Requests.Include(r => r.User).Where(r => r.IsDataActive && r.SenderID == UserID || r.Recipient == _user.Email || r.Recipient == _user.NickName).Select(r => new Request_API { ID = r.ID, Sender = r.User.Email,Recipient = r.Recipient, Message = r.Message, Status = r.Status, HasDownloaded = r.HasDownloaded, HasRejected =r.HasRejected, IsDataActive = r.IsDataActive , RespondedOn =r.RespondedOn, SenderID = r.SenderID, SentOn = r.SentOn  }).OrderByDescending(r => r.ID).Take(10).ToListAsync();
                    return result;
                }
                else
                {
                    result.Status = false;
                    result.Message = "User not found.";
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
        [Route("api/CreateNewSerationWallet")]
        public async Task<WalletInfoResult> CreateNewSerationWallet(CreateNewSerationWalletRequest request)
        {
            WalletInfoResult result = new WalletInfoResult();
            try
            {
                AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
                if (ticket != null)
                {
                    int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                    string UserName = ticket.Properties.Dictionary["userName"];
                    if (request.password != request.confirmpassword)
                    {
                        result.Message = "Sorry, Password and confirm password not matched.Please try again.";
                        return result;
                    }

                    User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);

                    if (_user != null)
                    {

                        //if (_user.WalletAddress != null)
                        //{
                        //    result.Message = "Sorry, You already have your Seratio Wallet setup.";
                        //    return result;
                        //}

                        WalletInfo _info = new WalletInfo();
                        Wallet _wallet = WalletManager.CreateWallet();

                        if (_wallet != null)
                        {
                            _info = WalletManager.GetProtectedWalletInfo(_wallet, request.password);

                            if (_info != null)
                            {
                                UserWalletHistory _userWalletHistory = new UserWalletHistory();
                                _userWalletHistory.UserID = _user.ID;
                                _userWalletHistory.SessionID = db.UserSessions.Where(p=>p.UserID == _user.ID).OrderByDescending(p=>p.StartTime).FirstOrDefault().ID;
                                var oldwallethistory = db.UserWalletHistories.Where(p => p.UserID == UserID && p.OldWalletAddress != null).OrderByDescending(p => p.Time).FirstOrDefault();
                                string _oldwalletaddress = null;
                                if (oldwallethistory !=null)
                                {
                                    _oldwalletaddress = oldwallethistory.OldWalletAddress;
                                }
                                _userWalletHistory.OldWalletAddress = _oldwalletaddress;
                                _userWalletHistory.NewWalletAddress = _info.Address;
                                _userWalletHistory.Time = AppManager.Now;

                                db.UserWalletHistories.Add(_userWalletHistory);


                                _user.WalletAddress = _info.Address;

                                await db.SaveChangesAsync();

                               // AppManager.User.PendingWalletCreation = false;
                            }
                        }
                        else
                        {
                            result.Message = "Sorry, an error occurred while creating your wallet. Please try again later.";
                            return result;
                        }

                        string _url = AppManager.AppURL + "/wallet/keys/printwallet/?words=" + string.Join(" ", _wallet.Words) + "&address=" + _info.Address + "&privatekey=" + _info.UnencryptedPrivateKey;
                        string _filePath = System.Web.Hosting.HostingEnvironment.MapPath("~//keys//Seratio_Wallet_" + _info.Address + ".pdf");

                        result.PaperWallet = Path.GetFileName(await AppManager.SavePaperWallet(_url, _filePath,_user));
                        result.Mnemonic = string.Join(" ", _wallet.Words);
                        result.WalletInfo = _info;
                        result.Message = "Your Seratio Wallet has been created successfully.";
                        result.Status = true;

                        return result;
                    }
                    else
                    {
                        result.Message = "Unknown Account";
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
            catch (Exception ex)
            {
                //////////ExceptionHandler.Handle(ex);
                result.Message = ex.Message;
                //result.Message = "Sorry, an error occurred while creating your wallet. Please try again later.";
                return result;
            }
        }
    }
}
