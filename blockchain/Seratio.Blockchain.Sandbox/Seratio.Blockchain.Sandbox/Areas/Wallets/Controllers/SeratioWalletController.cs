using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;
using System.Net;
using System.Net.Http;
using Nethereum.Web3.Accounts;
using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using Seratio.Blockchain.Sandbox.Core.Utilities;

namespace Seratio.Blockchain.Sandbox.Areas.Wallets.Controllers
{
    [AuthorizeAccess]
    public class SeratioWalletController : BaseController
    {
        // GET: Wallets/seratiowallet
        public async Task<ActionResult> Index()
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.ID == AppManager.User.ID);

            if (_user == null)
            {
                return HttpNotFound();
            }
            else
            {
                if (_user.WalletAddress == null)
                {
                    TempData["Notification"] = new Notification("Error", "You have not yet create the Seratio Wallet. Please navigate to the Change Credentials page to create one.");
                    return Redirect("/wallet/default/dashboard");
                }
            }

            if (_user.IsBlockedWallet)
            {
                if (_user.EnableTwoFactorAuthentication)
                {
                    AppManager.User.PendingTwoFactorAuthentication = true;
                    Session["Blockchain_User"] = AppManager.User;

                    TempData["Notification"] = new Notification("Info",
                        "Unblock Your Wallet.");
                    return Redirect($"/wallet/twofa?url=/wallet/wallets/seratiowallet/unblock");
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "You have not enable Two factor Authentication.");
                    return Redirect("/wallet/default/dashboard");
                }
            }


            ViewBag.WalletAddress = _user.WalletAddress;

            List<Coin> _coins = await db.Coins.Where(c => c.IsDataActive && !c.IsMCRCategory).ToListAsync();
            foreach (Coin _coin in _coins)
            {
                using (BlockChainManager _manager = new BlockChainManager(_coin.Blockchain.Host))
                {
                    if (string.IsNullOrEmpty(_coin.Address))
                    {
                        _coin.Balance = await _manager.GetBalance(_user.WalletAddress);
                    }
                    else
                    {
                        _coin.Balance = await _manager.GetBalance(_user.WalletAddress, _coin.Address, _coin.NumberOfDecimals);
                    }
                }
            }

            return View(_coins);
        }

        public async Task<ActionResult> Transfer()
        {
            ViewBag.TransactionID = Guid.NewGuid();
            return View(await db.Coins.Where(c => c.IsDataActive && !c.IsMCRCategory).ToListAsync());
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Transfer(string recipient, decimal amount, int CoinID, string mnemonic, Guid transactionid, List<MCRTransfer> splits, int gas = 40)
        {
            List<FailedWalletTransactionAttempt> _failedAttempts = await db.FailedWalletTransactionAttempts.Where(a => a.UserID == AppManager.User.ID).ToListAsync();

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
                TempData["Notification"] = new Notification("Error", "Invalid or Duplicate transaction detected. Please try again later.");
                return RedirectToAction("Transfer");
            }

            try
            {
                bool _sendcriteria = false;
                bool _receiveCriteria = false;

                #region Confirm the Support for the coin

                Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.ID == CoinID);

                if (_coin == null)
                {
                    TempData["Notification"] = new Notification("Error",
                        "The Coin you're trying to transfer is invalid. Please select a valid coin and try again.");
                    return RedirectToAction("Transfer");
                }

                #endregion

                #region General Preparation

                if (!IsValidAddress(recipient))
                {
                    TempData["Notification"] = new Notification("Error", "Please enter a valid wallet address.");
                    return RedirectToAction("Transfer");
                }

                #endregion

                #region Validate Sender and Mnemonic words

                Wallet _wallet = WalletManager.RetrieveWallet(mnemonic);
                Account _account = _wallet.GetAccount(0);
                User _sender = await db.Users.FirstOrDefaultAsync(i => i.ID == AppManager.User.ID);

                if (_sender == null || _account == null)
                {
                    TempData["Notification"] =
                        new Notification("Error", "Sorry, an error occurred while processing your transaction. Please try again later.");
                    return RedirectToAction("Transfer");
                }

                if (_sender.WalletAddress != _account.Address)
                {
                    FailedWalletTransactionAttempt _attempt = new FailedWalletTransactionAttempt();
                    _attempt.UserID = AppManager.User.ID;
                    _attempt.Time = DateTime.Now;

                    db.FailedWalletTransactionAttempts.Add(_attempt);
                    await db.SaveChangesAsync();

                    List<FailedWalletTransactionAttempt> _failedWalletTransactionAttempts = await db.FailedWalletTransactionAttempts.Where(u => u.UserID == AppManager.User.ID)
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
                            AppManager.SendEmail("Failed Transaction Attempt - Seratio Wallet", AppManager.User.Email, _body);
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

                    return RedirectToAction("Transfer");
                }

                #endregion

                foreach (FailedWalletTransactionAttempt _attempt in await db.FailedWalletTransactionAttempts.Where(u => u.UserID == AppManager.User.ID).ToListAsync())
                {
                    db.FailedWalletTransactionAttempts.Remove(_attempt);
                    await db.SaveChangesAsync();
                }

                User _recipient =
                    await db.Users.FirstOrDefaultAsync(
                        u => u.IsDataActive && u.WalletAddress == recipient);

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
                                TempData["Notification"] =
                                    new Notification("Error",
                                        "The recipient doesn't meet your Asset Transaction Criteria.");
                                return RedirectToAction("Transfer");
                            }
                        }
                        else
                        {
                            TempData["Notification"] =
                                new Notification("Error",
                                    "The recipient doesn't have a SE Score calculated as required by your Asset Transaction Criteria.");
                            return RedirectToAction("Transfer");
                        }
                    }
                    else
                    {
                        TempData["Notification"] =
                                new Notification("Error",
                                    "The recipient doesn't have a Seratio Account to verify the SE Score as required by your Asset Transaction Criteria.");
                        return RedirectToAction("Transfer");
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
                            TempData["Notification"] =
                                new Notification("Error",
                                    "Your SE Score doesn't meet the Recipient's Asset Transaction Criteria.");
                            return RedirectToAction("Transfer");
                        }
                    }
                    else
                    {
                        TempData["Notification"] =
                            new Notification("Error",
                                "You need to have your SE Score calculated to make this transaction as required by the Recipient's Asset Transaction Criteria.");
                        return RedirectToAction("Transfer");
                    }
                }

                #endregion

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
                            await _blockChainManager.GetBalance(_sender.WalletAddress, _coin.Address, _coin.NumberOfDecimals);
                    }

                    if (_availableBalance < amount)
                    {
                        TempData["Notification"] = new Notification("Error",
                            "You don't have sufficient balance in your Wallet to make this transaction. Please try again later.");
                        return RedirectToAction("Transfer");
                    }

                    #endregion

                    #region Process the Transaction

                    TransferResult _result;

                    if (string.IsNullOrEmpty(_coin.Address))
                    {
                        _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress, recipient, amount);
                    }
                    else
                    {
                        _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress, recipient, amount, _coin.NumberOfDecimals, _coin.Address, gas);
                    }

                    if (_result != null && _result.IsSuccess && _result.Receipt != null)
                    {
                        WalletTransaction _walletTransaction = new WalletTransaction
                        {
                            UserID = AppManager.User.ID,
                            Recipient = recipient,
                            Amount = amount,
                            CoinID = CoinID,
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
                            Type = "Transfer"
                        };

                        db.WalletTransactions.Add(_walletTransaction);
                        await db.SaveChangesAsync();

                        if (splits != null)
                        {
                            if (_recipient != null)
                            {
                                foreach (MCRTransfer _mcrTransfer in splits)
                                {
                                    _mcrTransfer.Time = AppManager.Now;
                                    _mcrTransfer.SenderID = AppManager.User.ID;
                                    _mcrTransfer.RecipientID = _recipient.ID;
                                    _mcrTransfer.WalletTransactionID = _walletTransaction.ID;

                                    db.MCRTransfers.Add(_mcrTransfer);
                                    await db.SaveChangesAsync();
                                }
                            }
                        }

                        List<string> _pendingTxs = new List<string>();

                        if (Session["LastTxHash"] != null)
                        {
                            _pendingTxs = Session["LastTxHash"] as List<string>;
                        }

                        _pendingTxs.Add(_result.Receipt);

                        Session["LastTxHash"] = _pendingTxs;

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

                        TempData["Notification"] =
                            new Notification("Success", $"Your transaction of {amount} {_coin.Symbol} has been submitted successfully.");
                    }
                    else
                    {
                        TempData["Notification"] =
                            new Notification("Error", _result.Message);
                        return RedirectToAction("Transfer");
                    }

                    #endregion
                }

                return RedirectToAction("Index");
            }
            catch (Exception ex)
            {
                TempData["Notification"] =
                    new Notification("Error", $"{ex.Message}.");
                return RedirectToAction("Transfer");
            }
        }

        public async Task<ActionResult> Pay(int ID)
        {
            ViewBag.TransactionID = Guid.NewGuid();
            return View(await db.PaymentRequests.FirstOrDefaultAsync(r => r.ID == ID && r.PayerID == AppManager.User.ID));
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Pay(int ID, string mnemonic, Guid transactionid, int gas = 40)
        {
            PaymentRequest _paymentRequest = await db.PaymentRequests.FirstOrDefaultAsync(r => r.ID == ID);

            if (_paymentRequest == null)
            {
                return HttpNotFound();
            }

            List<FailedWalletTransactionAttempt> _failedAttempts = await db.FailedWalletTransactionAttempts.Where(a => a.UserID == AppManager.User.ID).ToListAsync();

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
                TempData["Notification"] = new Notification("Error", "Invalid or Duplicate transaction detected. Please try again later.");
                return Redirect("/wallet/retailend/paymentrequests");
            }

            try
            {
                bool _sendcriteria = false;
                bool _receiveCriteria = false;

                #region Confirm the Support for the coin

                Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.ID == _paymentRequest.CoinID);

                if (_coin == null)
                {
                    TempData["Notification"] = new Notification("Error",
                        "The Coin you're trying to transfer is invalid. Please select a valid coin and try again.");
                    return Redirect("/wallet/retailend/paymentrequests");
                }

                #endregion

                #region Validate Sender and Mnemonic words

                Wallet _wallet = WalletManager.RetrieveWallet(mnemonic);
                Account _account = _wallet.GetAccount(0);
                User _sender = await db.Users.FirstOrDefaultAsync(i => i.ID == AppManager.User.ID);

                if (_sender == null || _account == null)
                {
                    TempData["Notification"] =
                        new Notification("Error", "Sorry, an error occurred while processing your transaction. Please try again later.");
                    return Redirect("/wallet/retailend/paymentrequests");
                }

                if (_sender.WalletAddress != _account.Address)
                {
                    FailedWalletTransactionAttempt _attempt = new FailedWalletTransactionAttempt();
                    _attempt.UserID = AppManager.User.ID;
                    _attempt.Time = DateTime.Now;

                    db.FailedWalletTransactionAttempts.Add(_attempt);
                    await db.SaveChangesAsync();

                    List<FailedWalletTransactionAttempt> _failedWalletTransactionAttempts = await db.FailedWalletTransactionAttempts.Where(u => u.UserID == AppManager.User.ID)
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
                            AppManager.SendEmail("Failed Transaction Attempt - Seratio Wallet", AppManager.User.Email, _body);
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

                    return Redirect("/wallet/retailend/paymentrequests");
                }

                #endregion

                foreach (FailedWalletTransactionAttempt _attempt in await db.FailedWalletTransactionAttempts.Where(u => u.UserID == AppManager.User.ID).ToListAsync())
                {
                    db.FailedWalletTransactionAttempts.Remove(_attempt);
                    await db.SaveChangesAsync();
                }

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
                            await _blockChainManager.GetBalance(_sender.WalletAddress, _coin.Address, _coin.NumberOfDecimals);
                    }

                    if (_availableBalance < _paymentRequest.Amount)
                    {
                        TempData["Notification"] = new Notification("Error",
                            "You don't have sufficient balance in your Wallet to make this transaction. Please try again later.");
                        return Redirect("/wallet/retailend/paymentrequests");
                    }

                    #endregion

                    #region Process the Transaction

                    TransferResult _result;

                    if (string.IsNullOrEmpty(_coin.Address))
                    {
                        _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress, _paymentRequest.User.WalletAddress, _paymentRequest.Amount);
                    }
                    else
                    {
                        _result = await _blockChainManager.TransferCoinAsync(_sender.WalletAddress, _paymentRequest.User.WalletAddress, _paymentRequest.Amount, _coin.NumberOfDecimals, _coin.Address, gas);
                    }

                    if (_result != null && _result.IsSuccess && _result.Receipt != null)
                    {
                        WalletTransaction _walletTransaction = new WalletTransaction
                        {
                            UserID = AppManager.User.ID,
                            Recipient = _paymentRequest.User.WalletAddress,
                            Amount = _paymentRequest.Amount,
                            CoinID = _paymentRequest.CoinID,
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
                            Type = "Transfer"
                        };

                        db.WalletTransactions.Add(_walletTransaction);
                        await db.SaveChangesAsync();

                        _paymentRequest.Status = "Paid";
                        _paymentRequest.WalletTransactionID = _walletTransaction.ID;

                        await db.SaveChangesAsync();

                        if (_paymentRequest.Type == "Voucher")
                        {
                            CollectedVoucher _collectedVoucher = new CollectedVoucher();
                            _collectedVoucher.UserID = AppManager.User.ID;
                            _collectedVoucher.PolicyID = _paymentRequest.RelatedItemID.Value;
                            _collectedVoucher.WalletTransactionID = null;
                            _collectedVoucher.Time = AppManager.Now;

                            db.CollectedVouchers.Add(_collectedVoucher);
                            await db.SaveChangesAsync();
                        }

                        List<string> _pendingTxs = new List<string>();

                        if (Session["LastTxHash"] != null)
                        {
                            _pendingTxs = Session["LastTxHash"] as List<string>;
                        }

                        _pendingTxs.Add(_result.Receipt);

                        Session["LastTxHash"] = _pendingTxs;

                        ActivityNotification _activitynotification = new ActivityNotification();

                        _activitynotification.UserID = _paymentRequest.RequestedByID;
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

                        TempData["Notification"] =
                            new Notification("Success", $"Your transaction of {_paymentRequest.Amount} {_coin.Symbol} has been submitted successfully.");
                    }
                    else
                    {
                        TempData["Notification"] =
                            new Notification("Error", _result.Message);
                        return Redirect("/wallet/retailend/paymentrequests");
                    }

                    #endregion
                }

                return Redirect("/wallet/retailend/paymentrequests");
            }
            catch (Exception ex)
            {
                TempData["Notification"] =
                    new Notification("Error", $"{ex.Message}.");
                return Redirect("/wallet/retailend/paymentrequests");
            }
        }

        public ActionResult History()
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request)
        {
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

            User LoggedInUser = await db.Users.FirstOrDefaultAsync(u => u.ID == AppManager.User.ID);

            if (!AppManager.User.IsSuperAdmin)
            {
                _query = _query.Where(i => i.UserID == AppManager.User.ID || i.Recipient == LoggedInUser.WalletAddress);
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
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                if (string.IsNullOrEmpty(_rowData.BlockHash))
                {
                    _row.Add("<a class='tooltipster' title='" + _rowData.TransactionHash + "' href='/wallet/wallets/seratiowallet/details/" + _rowData.ID + "'>" +
                             _rowData.TransactionHash.Ellipsisfy() +
                             "</a><br/><span class='label bg-grey-300'>Pending</span>");

                }
                else if (_rowData.BlockHash == "Failed")
                {
                    _row.Add("<a class='tooltipster' title='" + _rowData.TransactionHash + "' href='/wallet/wallets/seratiowallet/details/" + _rowData.ID + "'>" +
                             _rowData.TransactionHash.Ellipsisfy() +
                             "</a><br/><span class='label bg-danger tooltipster' title='This transaction has failed due to congestion in the Ethereum Network.'>Failed</span>");
                }
                else
                {
                    _row.Add("<a class='tooltipster' title='" + _rowData.TransactionHash + "' href='/wallet/wallets/seratiowallet/details/" + _rowData.ID + "'>" +
                             _rowData.TransactionHash.Ellipsisfy() +
                             "</a><br/><span class='label bg-success'>Confirmed</span>");
                }

                _row.Add(_rowData.User.WalletAddress);
                _row.Add(_rowData.Recipient);
                _row.Add(_rowData.Amount.CarefullyTrim(_rowData.Coin.NumberOfDecimals) + " " + _rowData.Coin.Symbol);
                _row.Add(_rowData.Time.ToString());

                _row.Add(@"<a title='Details' href='/wallet/wallets/seratiowallet/details/" + _rowData.ID + "'><i class='os-icon os-icon-agenda-1 text-primary'></i></a>");
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

        public async Task<ActionResult> Details(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            User LoggedInUser = await db.Users.FirstOrDefaultAsync(u => u.ID == AppManager.User.ID);

            WalletTransaction walletTransaction = await db.WalletTransactions.FirstOrDefaultAsync(w => w.ID == ID && (w.User.ID == AppManager.User.ID || w.Recipient == LoggedInUser.WalletAddress));

            if (walletTransaction == null)
            {
                return HttpNotFound();
            }

            ActivityNotification _activityNotification =
                await db.ActivityNotifications.FirstOrDefaultAsync(
                    n => n.RelatedItemID == ID && n.UserID == AppManager.User.ID && n.IsRead == false && n.Type == "Wallet Transaction");

            if (_activityNotification != null)
            {
                _activityNotification.IsRead = true;
                _activityNotification.ReadOn = AppManager.Now;

                await db.SaveChangesAsync();
            }


            if (walletTransaction == null)
            {
                return HttpNotFound();
            }

            return View(walletTransaction);
        }

        [AllowAnonymous]
        public async Task<string> GetStatus()
        {
            if (Session["LastTxHash"] != null)
            {
                List<string> _pendingTxs = Session["LastTxHash"] as List<string>;

                foreach (string _txId in _pendingTxs)
                {
                    WalletTransaction _transaction =
                        await db.WalletTransactions.FirstOrDefaultAsync(
                            t => t.TransactionHash == _txId && t.BlockHash != "");

                    if (_transaction != null)
                    {
                        _pendingTxs.Remove(_txId);
                        Session["LastTxHash"] = _pendingTxs;

                        return
                            $"Your transaction of {_transaction.Amount} {_transaction.Coin.Symbol} has been confirmed successfully.";
                    }
                }
            }

            return "";
        }

        public ActionResult Loading()
        {
            return View();
        }

        public async Task<JsonResult> GetCoinInfo(int ID)
        {
            string _responseString = "";
            Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.ID == ID);
            dynamic _microshareCategories = null;

            if (_coin != null)
            {
                if (_coin.Symbol == "MCR")
                {
                    var _coins = await db.Coins.Where(c => c.IsDataActive && c.IsMCRCategory).ToListAsync();

                    foreach (Coin _category in _coins)
                    {
                        _category.Balance = (await db.MCRAllocations
                                                .Where(a => a.UserID == AppManager.User.ID && a.CoinID == _category.ID).Select(a => a.Amount).DefaultIfEmpty(0)
                                                .SumAsync(a => a)) - (await db.MCRTransfers.Where(t => t.CoinID == _category.ID && t.SenderID == AppManager.User.ID || t.RecipientID == AppManager.User.ID).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t));

                        if (_category.Balance == 0)
                        {
                            _category.Balance = 0;
                        }
                    }

                    _microshareCategories = _coins.Where(c => c.Balance > 0).Select(c => new
                    {
                        c.ID,
                        c.Balance,
                        c.Name,
                        c.Symbol
                    }).ToList();
                }

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
                                object _responseData = new
                                {
                                    GasPrice = (int)Math.Round(_response.standard, 0, MidpointRounding.AwayFromZero),
                                    SafeGasPrice = (int)Math.Round(_response.safeLow, 0, MidpointRounding.AwayFromZero),
                                    FastGasPrice = (int)Math.Round(_response.fast, 0, MidpointRounding.AwayFromZero),
                                    Icon = _coin.Image,
                                    Allocation = _microshareCategories
                                };

                                return Json(_responseData, JsonRequestBehavior.AllowGet);
                            }
                            else
                            {
                                object _responseData = new
                                {
                                    GasPrice = 20,
                                    SafeGasPrice = 10,
                                    FastGasPrice = 30,
                                    FastestGasPrice = 40,
                                    Icon = _coin.Image,
                                    Allocation = _microshareCategories
                                };

                                return Json(_responseData, JsonRequestBehavior.AllowGet);
                            }
                        }
                    }
                    else
                    {
                        using (BlockChainManager _manager =
                            new BlockChainManager($"{_coin.Blockchain.Host}"))
                        {
                            decimal _gasPrice = await _manager.GetGasPriceAsync();
                            object _responseData = new
                            {
                                GasPrice = _gasPrice,
                                SafeGasPrice = (int)(_gasPrice * (decimal).4),
                                FastGasPrice = (int)(_gasPrice + (_gasPrice * (decimal)0.6667)),
                                FastestGasPrice = (int)(_gasPrice + (_gasPrice * (decimal)0.8)),
                                Icon = _coin.Image,
                                Allocation = _microshareCategories
                            };

                            return Json(_responseData, JsonRequestBehavior.AllowGet);
                        }
                    }
                }
                catch (Exception ex)
                {
                    ExceptionHandler.Handle(ex);
                    ExceptionHandler.Handle(new Exception(_responseString));

                    object _responseData = new
                    {
                        GasPrice = 20,
                        SafeGasPrice = 10,
                        FastGasPrice = 30,
                        FastestGasPrice = 40,
                        Icon = _coin.Image,
                        Allocation = _microshareCategories
                    };

                    return Json(_responseData, JsonRequestBehavior.AllowGet);
                }
            }

            return null;
        }
    }
}