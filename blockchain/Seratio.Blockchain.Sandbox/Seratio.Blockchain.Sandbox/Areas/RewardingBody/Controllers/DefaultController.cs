using System;
using System.Collections.Generic;
using System.Linq;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Core;
using System.Threading.Tasks;
using System.Data.Entity;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Models;
using System.Globalization;
using Nethereum.Web3.Accounts;
using Seratio.Blockchain.Sandbox.Core.Blockchain;

namespace Seratio.Blockchain.Sandbox.Areas.RewardingBody.Controllers
{
    [AuthorizeAccess(RequiresRewardingBodyAccess = true)]
    public class DefaultController : BaseController
    {
        public async Task<ActionResult> Index()
        {
            ViewBag.TransactionID = Guid.NewGuid();
            ViewBag.Activities = await db.SocialActivities.Where(s => s.IsDataActive && s.UserID == AppManager.User.ID && s.IsApproved == true).ToListAsync();

            return View();
        }

        [HttpPost]
        public async Task<ActionResult> Index(AcceptedSocialActivity model, string mnemonic, Guid transactionid, int gas = 40)
        {
            if (ModelState.IsValid)
            {
                Models.User _user =
                    await db.Users.FirstOrDefaultAsync(u => u.WalletAddress == model.WalletAddress && u.IsDataActive);

                if (_user == null)
                {
                    TempData["Notification"] =
                        new Notification("Error",
                            "Transaction failed. Requested User doesn't have a Seratio Platform Account.");
                    return RedirectToAction("Index");
                }

                AcceptedSocialActivity _activity = new AcceptedSocialActivity();

                _activity.UserID = _user.ID;
                _activity.ActivityID = model.ActivityID;
                _activity.Description = model.Description;
                _activity.CreatedOn = _activity.LastUpdatedOn = DateTime.Now;
                _activity.IsDataActive = true;
                _activity.RewardedCoinID = model.RewardedCoinID;
                _activity.RewardedAmount = model.RewardedAmount;

                List<FailedWalletTransactionAttempt> _failedAttempts = await db.FailedWalletTransactionAttempts
                    .Where(a => a.UserID == AppManager.User.ID).ToListAsync();

                if (_failedAttempts.Count == 8)
                {
                    TempData["Notification"] = new Notification("Error",
                        "You have reached the maximum number of failed transaction attempts and your account has been permanently locked; please contact the Platform Administrator for further assistance.");
                }
                else if (_failedAttempts.Count == 7 && AppManager.Now.Subtract(_failedAttempts.LastOrDefault().Time)
                             .TotalHours < 1)
                {
                    TempData["Notification"] = new Notification("Error",
                        "You have reached the maximum number of failed transaction attempts. Your account has been locked for 1 hour.");
                }
                else if (_failedAttempts.Count == 4 && AppManager.Now.Subtract(_failedAttempts.LastOrDefault().Time)
                             .Minutes < 30)
                {
                    TempData["Notification"] = new Notification("Error",
                        "You have reached the maximum number of failed transaction attempts. Your account has been locked for 30 minutes.");
                }

                if (await db.WalletTransactions.AnyAsync(t => t.TransactionID == transactionid))
                {
                    TempData["Notification"] = new Notification("Error",
                        "Invalid or Duplicate transaction detected. Please try again later.");
                    return RedirectToAction("Index");
                }

                try
                {
                    #region Confirm the Support for the coin

                    Coin _coin =
                        await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.ID == model.RewardedCoinID);

                    if (_coin == null)
                    {
                        TempData["Notification"] = new Notification("Error",
                            "The Coin you're trying to transfer is invalid. Please select a valid coin and try again.");
                        return RedirectToAction("Index");
                    }

                    if (_coin.IsMCRCategory)
                    {
                        _coin =
                            await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.Symbol == "MCR");
                    }

                    #endregion

                    #region General Preparation

                    if (!IsValidAddress(model.WalletAddress))
                    {
                        TempData["Notification"] = new Notification("Error", "Please enter a valid wallet address.");
                        return RedirectToAction("Index");
                    }

                    #endregion

                    #region Validate Sender and Mnemonic words

                    Wallet _wallet = WalletManager.RetrieveWallet(mnemonic);
                    Account _account = _wallet.GetAccount(0);
                    User _sender = await db.Users.FirstOrDefaultAsync(i => i.ID == AppManager.User.ID);

                    if (_sender == null || _account == null)
                    {
                        TempData["Notification"] =
                            new Notification("Error",
                                "Sorry, an error occurred while processing your transaction. Please make sure you are inserting correct mnemonic phrase and try again.");
                        return RedirectToAction("Index");
                    }

                    if (_sender.WalletAddress != _account.Address)
                    {
                        FailedWalletTransactionAttempt _attempt = new FailedWalletTransactionAttempt();
                        _attempt.UserID = AppManager.User.ID;
                        _attempt.Time = DateTime.Now;

                        db.FailedWalletTransactionAttempts.Add(_attempt);
                        await db.SaveChangesAsync();

                        List<FailedWalletTransactionAttempt> _failedWalletTransactionAttempts = await db
                            .FailedWalletTransactionAttempts.Where(u => u.UserID == AppManager.User.ID)
                            .ToListAsync();

                        if (_failedWalletTransactionAttempts.Count == 4)
                        {
                            TempData["Notification"] = new Notification("Error",
                                "You have reached the maximum number of failed transaction attempts. Your account has been locked for 30 minutes.");
                        }
                        else if (_failedWalletTransactionAttempts.Count < 4)
                        {
                            if (_failedWalletTransactionAttempts.Count == 1)
                            {
                                string _body =
                                    $"Hello,<br /><br />There was a failed attempt to make transaction using your mnemonic phrase in the Seratio Wallet.<br />Your account will be locked for 30 minutes after {4 - _failedWalletTransactionAttempts.Count} attempts.<br /><br />If this wasn't you, we highly encourage you to change your password at the earliest.";
                                AppManager.SendEmail("Failed Transaction Attempt - Seratio Wallet",
                                    AppManager.User.Email, _body);
                            }

                            TempData["Notification"] = new Notification("Error",
                                $"The Mnemonic phrase didn't match your wallet. Your account will be locked for 30 minutes after {4 - _failedWalletTransactionAttempts.Count} attempts.");
                        }
                        else if (_failedWalletTransactionAttempts.Count == 7)
                        {
                            TempData["Notification"] = new Notification("Error",
                                "You have reached the maximum number of failed transaction attempts. Your account has been locked for 1 hour.");
                        }
                        else if (_failedWalletTransactionAttempts.Count < 7)
                        {
                            TempData["Notification"] = new Notification("Error",
                                $"The Mnemonic phrase didn't match your wallet. Your account will be locked for 1 hour after {7 - _failedWalletTransactionAttempts.Count} attempts.");
                        }
                        else
                        {
                            TempData["Notification"] = new Notification("Error",
                                "You have reached the maximum number of failed transaction attempts and your account has been permanently locked; please contact the Platform Administrator for further assistance.");
                        }

                        return RedirectToAction("Index");
                    }

                    #endregion

                    foreach (FailedWalletTransactionAttempt _attempt in await db.FailedWalletTransactionAttempts
                        .Where(u => u.UserID == AppManager.User.ID).ToListAsync())
                    {
                        db.FailedWalletTransactionAttempts.Remove(_attempt);
                        await db.SaveChangesAsync();
                    }

                    db.AcceptedSocialActivities.Add(_activity);
                    await db.SaveChangesAsync();

                    using (BlockChainManager _blockChainManager =
                        new BlockChainManager(_account, _coin.Blockchain.Host, gas))
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
                                await _blockChainManager.GetBalance(_sender.WalletAddress, _coin.Address,
                                    _coin.NumberOfDecimals);
                        }

                        if (_availableBalance < model.RewardedAmount)
                        {
                            TempData["Notification"] = new Notification("Error",
                                "You don't have sufficient balance in your Wallet to make this transaction. Please try again later.");
                            return RedirectToAction("Index");
                        }

                        #endregion

                        #region Process the Transaction

                        TransferResult _result;

                        if (string.IsNullOrEmpty(_coin.Address))
                        {
                            _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress,
                                model.WalletAddress, model.RewardedAmount);
                        }
                        else
                        {
                            _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress,
                                model.WalletAddress, model.RewardedAmount, _coin.NumberOfDecimals, _coin.Address, gas);
                        }

                        if (_result != null && _result.IsSuccess && _result.Receipt != null)
                        {
                            WalletTransaction _walletTransaction = new WalletTransaction
                            {
                                UserID = AppManager.User.ID,
                                Recipient = model.WalletAddress,
                                Amount = model.RewardedAmount,
                                CoinID = model.RewardedCoinID,
                                TransactionHash = _result.Receipt,
                                TransactionIndex = string.Empty,
                                BlockHash = string.Empty,
                                BlockNumber = string.Empty,
                                CumulativeGasUsed = string.Empty,
                                GasUsed = string.Empty,
                                Logs = string.Empty,
                                Time = AppManager.Now,
                                SessionID = AppManager.User.SessionID,
                                LastUpdatedOn = AppManager.Now,
                                TransactionID = transactionid,
                                Type = "Reward"
                            };

                            db.WalletTransactions.Add(_walletTransaction);
                            await db.SaveChangesAsync();

                            if (_coin.Symbol == "MCR")
                            {
                                MCRTransfer _mcrTransfer = new MCRTransfer();
                                _mcrTransfer.Amount = model.RewardedAmount;
                                _mcrTransfer.CoinID = model.RewardedCoinID;
                                _mcrTransfer.Time = AppManager.Now;
                                _mcrTransfer.SenderID = AppManager.User.ID;
                                _mcrTransfer.RecipientID = _user.ID;
                                _mcrTransfer.WalletTransactionID = _walletTransaction.ID;

                                db.MCRTransfers.Add(_mcrTransfer);
                                await db.SaveChangesAsync();
                            }

                            List<string> _pendingTxs = new List<string>();

                            if (Session["LastTxHash"] != null)
                            {
                                _pendingTxs = Session["LastTxHash"] as List<string>;
                            }

                            _pendingTxs.Add(_result.Receipt);

                            Session["LastTxHash"] = _pendingTxs;


                            ActivityNotification _activityNotification = new ActivityNotification();

                            _activityNotification.UserID = _user.ID;
                            _activityNotification.RelatedItemID = _walletTransaction.ID;
                            _activityNotification.Type = "Social Activity Reward";
                            _activityNotification.Message = "You've received a reward for your Social Activity.";
                            _activityNotification.Time = AppManager.Now;
                            _activityNotification.IsRead = false;
                            _activityNotification.CreatedOn = AppManager.Now;

                            db.ActivityNotifications.Add(_activityNotification);
                            await db.SaveChangesAsync();
                        }
                        else
                        {
                            TempData["Notification"] =
                                new Notification("Error", _result.Message);
                            return RedirectToAction("Index");
                        }

                        #endregion
                    }

                    TempData["Notification"] =
                        new Notification("Success", "The reward has been issued successfully.");
                }
                catch (Exception ex)
                {
                    TempData["Notification"] = new Notification("Error",
                        "Sorry, an error occurred while processing your request. Please try again later.");
                }
            }
            else
            {
                TempData["Notification"] = new Notification("Error",
                    "One or more fields are missing or contain invalid value. Please check and try again.");
            }

            return RedirectToAction("index");
        }

        public ActionResult AcceptedSocialActivities(string daterange)
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request, string daterange)
        {
            var _query = from s in db.AcceptedSocialActivities
                         join c in db.Coins on s.RewardedCoinID equals c.ID
                         where s.IsDataActive
                         select new
                         {
                             s.ID,
                             s.ActivityID,
                             s.SocialActivity,
                             Coin = c.Name,
                             CoinSymbol = c.Symbol,
                             s.RewardedAmount,
                             s.User,
                             s.UserID,
                             s.Description,
                             s.CreatedOn,
                         };

            _query = _query.Where(i => i.SocialActivity.UserID == AppManager.User.ID || i.UserID == AppManager.User.ID);

            if (!string.IsNullOrEmpty(daterange))
            {
                string[] _daterange = daterange.Split(new string[] { " " }, StringSplitOptions.RemoveEmptyEntries);
                DateTime? _start = Convert.ToDateTime(_daterange[0], new CultureInfo("en-CA"));
                DateTime? _end = Convert.ToDateTime(_daterange[2], new CultureInfo("en-CA"));
                _end = _end.Value.AddDays(1);
                _query = _query.Where(u => u.CreatedOn >= _start.Value && u.CreatedOn < _end.Value);
            }

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(s => s.User.Email.Contains(request.sSearch) || s.Description.Contains(request.sSearch) || s.RewardedAmount.ToString().Contains(request.sSearch) || s.CreatedOn.ToString().Contains(request.sSearch) || s.SocialActivity.Name.Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.User.Email) : _query.OrderByDescending(s => s.User.Email);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.SocialActivity.Name) : _query.OrderByDescending(s => s.SocialActivity.Name);
                    break;

                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(s => s.RewardedAmount) : _query.OrderBy(s => s.RewardedAmount);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(s => s.CreatedOn) : _query.OrderBy(s => s.CreatedOn);
                    break;
                case 5:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(s => s.Description) : _query.OrderByDescending(s => s.Description);
                    break;
                default:
                    _query = _query.OrderByDescending(s => s.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add(_rowData.User.Email);

                _row.Add(_rowData.SocialActivity.Name);

                _row.Add(_rowData.RewardedAmount + " " + _rowData.CoinSymbol);

                _row.Add(_rowData.CreatedOn.ToString());

                if (_rowData.Description != null)
                {
                    _row.Add(_rowData.Description);
                }
                else
                {
                    _row.Add("-");

                }

                _rows.Add(_row);
            }

            return Json(new DataTableResponse
            {
                sEcho = request.sEcho,
                iDisplayLength = request.iDisplayLength,
                iTotalRecords = _count,
                iDisplayStart = request.iDisplayStart,
                iTotalDisplayRecords = _count,
                aaData = _rows
            }, JsonRequestBehavior.AllowGet);
        }

        public JsonResult GetCoinDetails(int activityId)
        {
            SocialActivity _activity = db.SocialActivities.Where(a => a.ID == activityId).FirstOrDefault();


            return Json(new { coinID = _activity.RewardingCoinID, coinName = _activity.Coin.Name, Amount = _activity.RewardAmount });
        }
    }
}