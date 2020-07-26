using Microsoft.Owin.Security;
using Nethereum.Web3.Accounts;
using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;
using Seratio.WebAPI.Core.Security;
using Seratio.WebAPI.Models.APIModels;
using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Web.Hosting;
using System.Web.Http;
using System.Web.Http.Cors;


namespace Seratio.WebAPI.Controllers
{
    [APIAuthorize]
    [EnableCors(origins: "*", headers: "*", methods: "*")]
    public class SeratioWalletAPIController : BaseAPIController
    {
        [HttpPost]
        [Route("api/ListCoins")]
        public async Task<ListCoinResult> ListCoins()
        {
            ListCoinResult result = new ListCoinResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                try
                {
                    int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                    User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                    string UserName = ticket.Properties.Dictionary["userName"];


                    if (_user == null)
                    {
                        result.Message = "Request not found.";
                        return result;
                    }
                    else
                    {
                        if (_user.WalletAddress == null)
                        {
                            result.Message = "You have not yet create the Seratio Wallet. Please navigate to the Change Credentials page to create one.";
                            return result;
                        }
                    }

                    if (_user.IsBlockedWallet)
                    {
                        if (_user.EnableTwoFactorAuthentication)
                        {
                            result.Message = "Unblock Your Wallet.";
                            return result;
                        }
                        else
                        {
                            result.Message = "You have not enable Twofactor Authentication.";
                            return result;
                        }
                    }

                    List<Coin> _coins = await db.Coins.Where(c => c.IsDataActive).ToListAsync();
                    foreach (Coin _coin in _coins)
                    {
                        using (BlockChainManager _manager = new BlockChainManager(_coin.Blockchain.Host))
                        {
                            if (string.IsNullOrEmpty(_coin.Address))
                            {
                                try
                                {
                                    _coin.Balance = await _manager.GetBalance(_user.WalletAddress);

                                }
                                catch (Exception ex)
                                {

                                    throw;
                                }
                            }
                            else
                            {
                                try
                                {
                                    _coin.Balance = await _manager.GetBalance(_user.WalletAddress, _coin.Address, _coin.NumberOfDecimals);

                                }
                                catch (Exception ex)
                                {
                                    throw;
                                }
                            }
                        }
                    }
                    result.Status = true;
                    result.Coins = _coins;
                    return result;
                }
                catch (Exception ex)
                {
                    throw;
                }
                

               
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        private bool IsValidAddress(string address)
        {
            if (string.IsNullOrEmpty(address))
            {
                return false;
            }

            return new Regex(@"^0x[a-fA-F0-9]{40}$").IsMatch(address);
        }

        [HttpPost]
        [Route("api/TransferCoin")]
        public async Task<ResultSet> TransferCoin(TransferCoinRequest request)
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);

                string UserName = ticket.Properties.Dictionary["userName"];

                List<FailedWalletTransactionAttempt> _failedAttempts = await db.FailedWalletTransactionAttempts.Where(a => a.UserID == _user.ID).ToListAsync();

                if (_failedAttempts.Count == 8)
                {
                    result.Message = "You have reached the maximum number of failed transaction attempts and your account has been permanently locked; please contact the Platform Administrator for further assistance.";
                }
                else if (_failedAttempts.Count == 7 && AppManager.Now.Subtract(_failedAttempts.LastOrDefault().Time)
                             .TotalHours < 1)
                {

                    result.Message = "You have reached the maximum number of failed transaction attempts. Your account has been locked for 1 hour.";

                }
                else if (_failedAttempts.Count == 4 && AppManager.Now.Subtract(_failedAttempts.LastOrDefault().Time)
                             .Minutes < 30)
                {

                    result.Message = "You have reached the maximum number of failed transaction attempts. Your account has been locked for 30 minutes.";

                }

                //if (await db.WalletTransactions.AnyAsync(t => t.TransactionID == request.transactionid))
                //{
                //    result.Message = "Invalid or Duplicate transaction detected. Please try again later.";
                //    return result;
                //}

                try
                {
                    bool _sendcriteria = false;
                    bool _receiveCriteria = false;

                    #region Confirm the Support for the coin

                    Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.ID == request.CoinID);

                    if (_coin == null)
                    {
                        result.Message = "The Coin you're trying to transfer is invalid. Please select a valid coin and try again later.";
                        return result;
                    }

                    #endregion

                    #region General Preparation

                    if (!IsValidAddress(request.recipient))
                    {
                        result.Message = "Please enter a valid wallet address.";
                        return result;
                    }

                    #endregion

                    #region Validate Sender and Mnemonic words

                    Wallet _wallet = WalletManager.RetrieveWallet(request.mnemonic);
                    Account _account = _wallet.GetAccount(0);
                    User _sender = await db.Users.FirstOrDefaultAsync(i => i.ID == _user.ID);

                    if (_sender == null || _account == null)
                    {
                        result.Message = "Sorry, an error occurred while processing your transaction. Please try again later.";
                        return result;
                    }

                    if (_sender.WalletAddress != _account.Address)
                    {
                        FailedWalletTransactionAttempt _attempt = new FailedWalletTransactionAttempt();
                        _attempt.UserID = _user.ID;
                        _attempt.Time = DateTime.Now;

                        db.FailedWalletTransactionAttempts.Add(_attempt);
                        await db.SaveChangesAsync();

                        List<FailedWalletTransactionAttempt> _failedWalletTransactionAttempts = await db.FailedWalletTransactionAttempts.Where(u => u.UserID == _user.ID)
                            .ToListAsync();

                        if (_failedWalletTransactionAttempts.Count == 4)
                        {
                            result.Message = "You have reached the maximum number of failed transaction attempts. Your account has been locked for 30 minutes.";
                        }
                        else if (_failedWalletTransactionAttempts.Count < 4)
                        {
                            if (_failedWalletTransactionAttempts.Count == 1)
                            {
                                string _body =
                                    $"Hello,<br /><br />There was a failed attempt to make transaction using your mnemonic phrase in the Seratio Wallet.<br />Your account will be locked for 30 minutes after {4 - _failedWalletTransactionAttempts.Count} attempts.<br /><br />If this wasn't you, we highly encourage you to change your password at the earliest.";
                                AppManager.SendEmail("Failed Transaction Attempt - Seratio Wallet", _user.Email, _body);
                            }


                            result.Message = $"The Mnemonic phrase didn't match your wallet. Your account will be locked for 30 minutes after {4 - _failedWalletTransactionAttempts.Count} attempts.";
                        }
                        else if (_failedWalletTransactionAttempts.Count == 7)
                        {
                            result.Message = "You have reached the maximum number of failed transaction attempts. Your account has been locked for 1 hour.";

                        }
                        else if (_failedWalletTransactionAttempts.Count < 7)
                        {
                            result.Message = $"The Mnemonic phrase didn't match your wallet. Your account will be locked for 1 hour after {7 - _failedWalletTransactionAttempts.Count} attempts.";
                        }
                        else
                        {
                            result.Message = "You have reached the maximum number of failed transaction attempts and your account has been permanently locked; please contact the Platform Administrator for further assistance.";

                        }

                        return result;
                    }

                    #endregion

                    foreach (FailedWalletTransactionAttempt _attempt in await db.FailedWalletTransactionAttempts.Where(u => u.UserID == _user.ID).ToListAsync())
                    {
                        db.FailedWalletTransactionAttempts.Remove(_attempt);
                        await db.SaveChangesAsync();
                    }

                    User _recipient =
                        await db.Users.FirstOrDefaultAsync(
                            u => u.IsDataActive && u.WalletAddress == request.recipient);

                    #region Validate Sender's Asset Transaction Criteria

                    if (_sender.AssetTransactionCriteria != null)
                    {
                        if (_recipient != null)
                        {
                            SAPIResponse _receiversSEData = await AppManager.GetSE(_recipient.Email);

                            if (_receiversSEData.data != null)
                            {
                                switch (_sender.AssetTransactionCriteria)
                                {
                                    case "<=":
                                        if (_receiversSEData.data.pv <=
                                            Convert.ToDouble(_sender.AssetTransactionCriteriaValue))
                                        {
                                            _sendcriteria = true;
                                        }
                                        break;

                                    case ">=":
                                        if (_receiversSEData.data.pv >=
                                            Convert.ToDouble(_sender.AssetTransactionCriteriaValue))
                                        {
                                            _sendcriteria = true;
                                        }
                                        break;

                                    case "==":
                                        if (_receiversSEData.data.pv ==
                                            Convert.ToDouble(_sender.AssetTransactionCriteriaValue))
                                        {
                                            _sendcriteria = true;
                                        }
                                        break;
                                }

                                if (!_sendcriteria)
                                {
                                    result.Message = "The recipient doesn't meet your Asset Transaction Criteria.";
                                    return result;
                                }
                            }
                            else
                            {
                                result.Message = "The recipient doesn't have a SE Score calculated as required by your Asset Transaction Criteria.";
                                return result;
                            }
                        }
                        else
                        {
                            result.Message = "The recipient doesn't have a Seratio Account to verify the SE Score as required by your Asset Transaction Criteria.";
                            return result;
                        }
                    }

                    #endregion

                    #region Validate Recipient's Asset Transaction Criteria

                    if (_recipient?.AssetTransactionCriteria != null)
                    {
                        SAPIResponse _sendersSEData = await AppManager.GetSE(_sender.Email);

                        if (_sendersSEData.data != null)
                        {
                            switch (_recipient.AssetTransactionCriteria)
                            {
                                case "<=":
                                    if (_sendersSEData.data.pv <=
                                        Convert.ToDouble(_sender.AssetTransactionCriteriaValue))
                                    {
                                        _receiveCriteria = true;
                                    }
                                    break;

                                case ">=":
                                    if (_sendersSEData.data.pv >=
                                        Convert.ToDouble(_sender.AssetTransactionCriteriaValue))
                                    {
                                        _receiveCriteria = true;
                                    }
                                    break;

                                case "==":
                                    if (_sendersSEData.data.pv ==
                                        Convert.ToDouble(_sender.AssetTransactionCriteriaValue))
                                    {
                                        _receiveCriteria = true;
                                    }
                                    break;
                            }

                            if (!_receiveCriteria)
                            {
                                result.Message = "Your SE Score doesn't meet the Recipient's Asset Transaction Criteria.";
                                return result;
                            }
                        }
                        else
                        {
                            result.Message = "You need to have your SE Score calculated to make this transaction as required by the Recipient's Asset Transaction Criteria.";
                            return result;
                        }
                    }

                    #endregion

                    using (BlockChainManager _blockChainManager =
                          new BlockChainManager(_account, _coin.Blockchain.Host, request.gas))
                    {
                        #region Make sure the sender has enough funds to make the requested transaction

                        decimal _availableBalance = 0;

                        if (string.IsNullOrEmpty(_coin.Address))
                        {
                            _availableBalance = await _blockChainManager.GetBalance(_sender.WalletAddress);
                        }
                        else
                        {
                            _availableBalance =
                                await _blockChainManager.GetBalance(_sender.WalletAddress, _coin.Address, _coin.NumberOfDecimals);
                        }

                        if (_availableBalance < request.amount)
                        {
                            result.Message = "You don't have sufficient balance in your Wallet to make this transaction. Please try again later.";
                            return result;
                        }

                        #endregion

                        #region Process the Transaction

                        TransferResult _result;

                        if (string.IsNullOrEmpty(_coin.Address))
                        {
                            _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress, request.recipient, request.amount);
                        }
                        else
                        {
                            _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress, request.recipient, request.amount, _coin.NumberOfDecimals, _coin.Address, request.gas);
                        }

                        if (_result != null && _result.IsSuccess && _result.Receipt != null)
                        {
                            WalletTransaction _walletTransaction = new WalletTransaction
                            {
                                UserID = _user.ID,
                                Recipient = request.recipient,
                                Amount = request.amount,
                                CoinID = request.CoinID,
                                TransactionHash = _result.Receipt,
                                TransactionIndex = string.Empty,
                                BlockHash = string.Empty,
                                BlockNumber = string.Empty,
                                CumulativeGasUsed = string.Empty,
                                GasUsed = string.Empty,
                                Logs = string.Empty,
                                Time = AppManager.Now,
                                SessionID = db.UserSessions.FirstOrDefault(p=>p.UserID==_user.ID).ID,
                                LastUpdatedOn = AppManager.Now,
                                TransactionID = request.transactionid

                            };

                            db.WalletTransactions.Add(_walletTransaction);
                            await db.SaveChangesAsync();

                            List<string> _pendingTxs = new List<string>();



                            _pendingTxs.Add(_result.Receipt);


                            if (_recipient != null)
                            {
                                ActivityNotification _activitynotification = new ActivityNotification();

                                _activitynotification.UserID = _recipient.ID;
                                _activitynotification.RelatedItemID = _walletTransaction.ID;
                                _activitynotification.Type = "Wallet Transaction";
                                _activitynotification.Message =
                                    "Wallet Credited with " + _walletTransaction.Amount + " " +
                                    _walletTransaction.Coin.Symbol;
                                _activitynotification.Time = AppManager.Now;
                                _activitynotification.IsRead = false;
                                _activitynotification.CreatedOn = AppManager.Now;

                                db.ActivityNotifications.Add(_activitynotification);
                                await db.SaveChangesAsync();
                            }

                            result.Status = true;
                            result.Message = $"Your transaction of {request.amount} {_coin.Symbol} has been submitted successfully.";

                        }
                        else
                        {
                            result.Message = _result.Message;
                            return result;
                        }

                        #endregion
                    }

                    return result;
                }
                catch (Exception ex)
                {
                    result.Message = $"{ex.Message}.";
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
        [Route("api/TransactionHistory")]
        public async Task<DataTableResponse_Wallet_Result> TransactionHistory(DataTableRequest request)
        {
            DataTableResponse_Wallet_Result result = new DataTableResponse_Wallet_Result();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];
                var _query = from w in db.WalletTransactions
                             select new
                             {
                                 w.ID,
                                 w.UserID,
                                 w.User,
                                 w.Recipient,
                                 w.Amount,
                                 w.Coin,
                                 w.TransactionHash,
                                 w.TransactionIndex,
                                 w.BlockHash,
                                 w.BlockNumber,
                                 w.CumulativeGasUsed,
                                 w.GasUsed,
                                 w.Logs,
                                 w.Time,

                             };

                User LoggedInUser = await db.Users.FirstOrDefaultAsync(u => u.ID == _user.ID);

                if (!_user.IsSuperAdmin)
                {
                    _query = _query.Where(i => i.UserID == _user.ID || i.Recipient == LoggedInUser.WalletAddress);
                }

                if (!string.IsNullOrEmpty(request.sSearch))
                {
                    _query = _query.Where(w => w.User.NickName.Contains(request.sSearch) || w.TransactionHash.Contains(request.sSearch) || w.User.Email.Contains(request.sSearch) || w.Recipient.Contains(request.sSearch) || w.Time.ToString().Contains(request.sSearch) || w.Coin.Name.Contains(request.sSearch) || w.Coin.Symbol.Contains(request.sSearch) || w.Amount.ToString().Contains(request.sSearch));
                }

                switch (request.iSortCol_0)
                {
                    case 0:
                        _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(w => w.TransactionHash) : _query.OrderBy(w => w.TransactionHash);
                        break;
                    case 1:
                        _query = request.sSortDir_0 == "asc" ? _query.OrderBy(w => (string.IsNullOrEmpty(w.User.NickName) ? w.User.Email : w.User.NickName)) : _query.OrderByDescending(r => (string.IsNullOrEmpty(r.User.NickName) ? r.User.Email : r.User.NickName));
                        break;
                    case 2:
                        _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(w => w.Recipient) : _query.OrderBy(w => w.Recipient);
                        break;
                    case 3:
                        _query = request.sSortDir_0 == "asc" ? _query.OrderBy(w => w.Amount) : _query.OrderByDescending(w => w.Amount);
                        break;
                    case 4:
                        _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(w => w.Time) : _query.OrderBy(w => w.Time);
                        break;
                }

                int _count = await _query.CountAsync();

                var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
                List<DataTableRowAPI_Wallet> _rows = new List<DataTableRowAPI_Wallet>();

                foreach (var _rowData in _data)
                {
                    DataTableRowAPI_Wallet _row = new DataTableRowAPI_Wallet();

                    if (string.IsNullOrEmpty(_rowData.BlockHash))
                    {
                        _row.ID = _rowData.ID;
                        _row.TransactionHash = _rowData.TransactionHash.Remove(10); 
                    }
                    else
                    {
                        _row.ID = _rowData.ID;
                        _row.TransactionHash = _rowData.TransactionHash.Remove(10);
                    }

                    _row.WalletAddress = _rowData.User.WalletAddress;
                    _row.Recipient = _rowData.Recipient ;
                    _row.Amount = _rowData.Amount;
                    _row.Symbol =  _rowData.Coin.Symbol;
                    _row.Time = _rowData.Time;

                    _row.ID = _rowData.ID;
                    _rows.Add(_row);
                }

                result.DataTableResponse = new DataTableResponse_Wallet
                {
                    sEcho = request.sEcho,
                    iDisplayLength = request.iDisplayLength,
                    iTotalRecords = _count,
                    iDisplayStart = request.iDisplayStart,
                    iTotalDisplayRecords = _count,
                    aaData = _rows
                };
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
        [Route("api/TransactionHistoryDetails")]
        public async Task<TransactionHistoryDetailsResult> TransactionHistoryDetails(int ID)
        {
            TransactionHistoryDetailsResult result = new TransactionHistoryDetailsResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];
                if (ID == 0)
                {
                    result.Message = "Request not found.";
                    return result;
                }


                WalletTransaction walletTransaction = await db.WalletTransactions.FirstOrDefaultAsync(w => w.ID == ID && (w.User.ID == _user.ID || w.Recipient == _user.WalletAddress));

                if (walletTransaction == null)
                {
                    result.Message = "Requested item not found.";
                    return result;
                }

                ActivityNotification _activityNotification =
                    await db.ActivityNotifications.FirstOrDefaultAsync(
                        n => n.RelatedItemID == ID && n.UserID == _user.ID && n.IsRead == false && n.Type == "Wallet Transaction");

                if (_activityNotification != null)
                {
                    _activityNotification.IsRead = true;
                    _activityNotification.ReadOn = AppManager.Now;

                    await db.SaveChangesAsync();
                }


                if (walletTransaction == null)
                {
                    result.Message = "Requested item not found.";
                    return result;
                }
                result.Status = true;
                result.WalletTransaction = walletTransaction;
                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/CoinInfo")]
        public async Task<CoinInfoResult> GetCoinInfo(int ID)
        {
            CoinInfoResult result = new CoinInfoResult();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];

                string _responseString = "";
                Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.ID == ID);

                if (_coin != null)
                {
                    try
                    {
                        if (_coin.Blockchain.IsPrimaryNode)
                        {
                            using (HttpClient _client = new HttpClient())
                            {
                                _responseString =
                                    await _client.GetStringAsync("https://www.etherchain.org/api/gasPriceOracle");
                                EtherChainApiresponse _response =
                                    JsonConvert.DeserializeObject<EtherChainApiresponse>(_responseString);

                                if (_response != null)
                                {

                                    CoinInfoResult _responseData = new CoinInfoResult
                                    {
                                        GasPrice = (int)Math.Round(Convert.ToDecimal(_response.standard), 0, MidpointRounding.AwayFromZero),
                                        SafeGasPrice = (int)Math.Round(Convert.ToDecimal(_response.safeLow), 0, MidpointRounding.AwayFromZero),
                                        FastGasPrice = (int)Math.Round(Convert.ToDecimal(_response.fast), 0, MidpointRounding.AwayFromZero),
                                        Icon = _coin.Image
                                    };
                                    _responseData.Status = true;
                                    return _responseData;
                                }
                                else
                                {
                                    CoinInfoResult _responseData = new CoinInfoResult
                                    {
                                        GasPrice = 20,
                                        SafeGasPrice = 10,
                                        FastGasPrice = 30,
                                        FastestGasPrice = 40,
                                        Icon = _coin.Image
                                    };

                                    _responseData.Status = true;
                                    return _responseData;
                                }
                            }
                        }
                        else
                        {
                            using (BlockChainManager _manager =
                                new BlockChainManager($"{_coin.Blockchain.Host}"))
                            {
                                decimal _gasPrice = await _manager.GetGasPriceAsync();
                                CoinInfoResult _responseData = new CoinInfoResult
                                {
                                    GasPrice = _gasPrice,
                                    SafeGasPrice = (int)(_gasPrice * (decimal).4),
                                    FastGasPrice = (int)(_gasPrice + (_gasPrice * (decimal)0.6667)),
                                    FastestGasPrice = (int)(_gasPrice + (_gasPrice * (decimal)0.8)),
                                    Icon = _coin.Image
                                };

                                _responseData.Status = true;
                                return _responseData;
                            }
                        }
                    }
                    catch (Exception ex)
                    {
                      //  ////ExceptionHandler.Handle(ex);
                       // //ExceptionHandler.Handle(new Exception(_responseString));

                        CoinInfoResult _responseData = new CoinInfoResult
                        {
                            GasPrice = 20,
                            SafeGasPrice = 10,
                            FastGasPrice = 30,
                            FastestGasPrice = 40,
                            Icon = _coin.Image
                        };

                        _responseData.Status = true;
                        return _responseData;
                    }
                }

                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/Block")]
        public async Task<ResultSet> Block()
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];

                if (_user.EnableTwoFactorAuthentication)
                {

                    if (_user != null)
                    {

                        _user.IsBlockedWallet = true;

                        await db.SaveChangesAsync();
                        result.Status = true;
                        result.Message = "Your Wallet Blocked.";


                    }
                    else
                    {
                        result.Message = "User Not Found.";
                    }
                    return result;
                }

                return result;
            }
            else
            {
                result.Message = "You are not authorized.";
                return result;
            }
        }

        [HttpPost]
        [Route("api/UnBlock")]
        public async Task<ResultSet> UnBlock()
        {
            ResultSet result = new ResultSet();
            AuthenticationTicket ticket = (AuthenticationTicket)Request.Properties["Ticket"];
            if (ticket != null)
            {
                int UserID = Convert.ToInt32(ticket.Properties.Dictionary["userID"]);
                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == UserID && u.IsDataActive);
                string UserName = ticket.Properties.Dictionary["userName"];

                if (_user.EnableTwoFactorAuthentication)
                {
                    if (_user != null)
                    {
                        _user.IsBlockedWallet = false;

                        await db.SaveChangesAsync();
                        result.Status = true;
                        result.Message = "Your Wallet  Unblocked.";
                    }
                    else
                    {
                        result.Message = "User Not Found.";
                    }

                    return result;
                }

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
