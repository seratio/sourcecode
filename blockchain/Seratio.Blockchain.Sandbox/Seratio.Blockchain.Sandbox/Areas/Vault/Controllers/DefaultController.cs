using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Web.Mvc;
using Nethereum.Web3.Accounts;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Vault.Controllers
{
    public class DefaultController : BaseController
    {
        // GET: Wallets/Vault
        public async Task<ActionResult> Index()
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.ID == AppManager.User.ID);
            ViewBag.WalletAddress = await db.Users.Where(u => u.ID == AppManager.User.ID).Select(u => u.WalletAddress)
                .FirstOrDefaultAsync();

            List<Coin> _coins = await db.Coins.Where(c => c.IsDataActive && c.Blockchain.IsPrimaryNode).ToListAsync();
            List<VaultInvestment> _investments = new List<VaultInvestment>();

            foreach (Models.Blockchain _blockchain in db.Blockchains.Where(b => b.IsActive))
            {
                using (BlockChainManager _manager = new BlockChainManager(_blockchain.Host))
                {
                    var _tempInvestments = await _manager.GetPendingInvestmentsFromVault(_user.WalletAddress,
                             _blockchain.VaultContractAddress, _blockchain.VaultContractABI);

                    if (_tempInvestments != null) _investments.AddRange(_tempInvestments);
                }
            }

            ViewBag.Investments = _investments;

            return View(_coins);
        }

        public async Task<ActionResult> Limits()
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.ID == AppManager.User.ID);

            List<Coin> _coins = await db.Coins.Where(c => c.IsDataActive && c.Blockchain.IsPrimaryNode).ToListAsync();
            foreach (Coin _coin in _coins)
            {
                if (!string.IsNullOrEmpty(_coin.Blockchain.VaultContractAddress))
                {
                    using (BlockChainManager _manager = new BlockChainManager(_coin.Blockchain.Host))
                    {
                        if (!string.IsNullOrEmpty(_coin.Address))
                        {
                            _coin.Balance = await _manager.GetAllowance(_coin.Address, _user.WalletAddress,
                                       _coin.Blockchain.VaultContractAddress, _coin.NumberOfDecimals);
                        }
                    }
                }
            }

            return View(_coins);
        }

        public async Task<ActionResult> Update()
        {
            ViewBag.TransactionID = Guid.NewGuid();
            return View(await db.Coins.Where(c => c.IsDataActive && c.Address != null && c.Blockchain.IsPrimaryNode).ToListAsync());
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Update(decimal amount, int CoinID, string mnemonic, Guid transactionid, int gas = 40)
        {
            try
            {
                #region Confirm the Support for the coin

                Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.ID == CoinID && c.Blockchain.IsPrimaryNode);

                if (_coin == null)
                {
                    TempData["Notification"] = new Notification("Error",
                        "The Coin you're trying to transfer is invalid. Please select a valid coin and try again.");
                    return RedirectToAction("Update");
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
                    return RedirectToAction("Update");
                }

                #endregion

                using (BlockChainManager _blockChainManager =
                      new BlockChainManager(_account, _coin.Blockchain.Host, gas))
                {
                    #region Process the Transaction

                    TransferResult _result = null;

                    if (!string.IsNullOrEmpty(_coin.Address))
                    {
                        _result = await _blockChainManager.Approve(_sender.WalletAddress, _coin.Blockchain.VaultContractAddress, _coin.Address, _coin.ABI, amount, _coin.NumberOfDecimals, gas);
                    }

                    if (_result != null && _result.IsSuccess && _result.Receipt != null)
                    {
                        WalletTransaction _walletTransaction = new WalletTransaction
                        {
                            UserID = AppManager.User.ID,
                            Recipient = _coin.Blockchain.VaultContractAddress,
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
                            Type = "Approve"
                        };

                        db.WalletTransactions.Add(_walletTransaction);
                        await db.SaveChangesAsync();

                        List<string> _pendingTxs = new List<string>();

                        if (Session["LastTxHash"] != null)
                        {
                            _pendingTxs = Session["LastTxHash"] as List<string>;
                        }

                        _pendingTxs.Add(_result.Receipt);

                        Session["LastTxHash"] = _pendingTxs;

                        TempData["Notification"] =
                            new Notification("Success", $"Your transaction has been submitted successfully.");
                    }
                    else
                    {
                        TempData["Notification"] =
                            new Notification("Error", _result.Message);
                        return RedirectToAction("Update");
                    }

                    #endregion
                }

                return Redirect("/wallet/vault/default/limits");
            }
            catch (Exception ex)
            {
                TempData["Notification"] =
                    new Notification("Error", $"{ex.Message}.");
                return RedirectToAction("Update");
            }
        }

        public async Task<ActionResult> Deposit()
        {
            ViewBag.TransactionID = Guid.NewGuid();
            return View(await db.Coins.Where(c => c.IsDataActive && c.Blockchain.IsPrimaryNode).ToListAsync());
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Deposit(decimal amount, int CoinID, string mnemonic, Guid transactionid, int duration, int? seconds, int gas = 40, int gasLimit = 300000)
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
                return RedirectToAction("Deposit");
            }

            try
            {
                #region Confirm the Support for the coin

                Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.ID == CoinID);

                if (_coin == null)
                {
                    TempData["Notification"] = new Notification("Error",
                        "The Coin you're trying to deposit is invalid. Please select a valid coin and try again.");
                    return RedirectToAction("Deposit");
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
                    return RedirectToAction("Deposit");
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
                                $"Hello,<br /><br />There was a failed attempt to deposit {_coin.Symbol} into Safe Vault using your mnemonic phrase in the Seratio Wallet.<br />Your account will be locked for 30 minutes after {4 - _failedWalletTransactionAttempts.Count} attempts.<br /><br />If this wasn't you, we highly encourage you to change your password at the earliest.";
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

                    return RedirectToAction("Deposit");
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

                    if (_availableBalance < amount)
                    {
                        TempData["Notification"] = new Notification("Error",
                            "You don't have sufficient balance in your Wallet to make this transaction. Please try again later.");
                        return RedirectToAction("Deposit");
                    }

                    #endregion

                    #region Process the Transaction

                    TransferResult _result = null;

                    if (duration != 0 || (duration == 0 && seconds != null && seconds > 0))
                    {
                        double _duration = DateTime.Now.AddMonths(duration).Subtract(DateTime.Now).TotalSeconds;

                        if (seconds > 0)
                        {
                            _duration = (double)seconds;
                        }

                        if (string.IsNullOrEmpty(_coin.Address))
                        {
                            _result = await _blockChainManager.DepositEtherToVault(_sender.WalletAddress,
                               _coin.Blockchain.VaultContractAddress, _coin.Blockchain.VaultContractABI, amount,
                                _duration, gas, gasLimit);
                        }
                        else
                        {
                            _result = await _blockChainManager.DepositTokenWithTime(_sender.WalletAddress,
                                _coin.Address,
                                _coin.Blockchain.VaultContractAddress, _coin.Blockchain.VaultContractABI, amount,
                                _coin.NumberOfDecimals, _duration, gas, gasLimit);
                        }
                    }
                    else
                    {
                        if (string.IsNullOrEmpty(_coin.Address))
                        {
                            _result = await _blockChainManager.DepositEtherToVault(_sender.WalletAddress,
                                _coin.Blockchain.VaultContractAddress, _coin.Blockchain.VaultContractABI, amount,
                                1, gas, gasLimit);
                        }
                        else
                        {
                            _result = await _blockChainManager.DepositToken(_sender.WalletAddress, _coin.Address,
                                _coin.Blockchain.VaultContractAddress, _coin.Blockchain.VaultContractABI, amount,
                                _coin.NumberOfDecimals, gas, gasLimit);
                        }
                    }

                    if (_result != null && _result.IsSuccess && _result.Receipt != null)
                    {
                        WalletTransaction _walletTransaction = new WalletTransaction
                        {
                            UserID = AppManager.User.ID,
                            Recipient = _coin.Blockchain.VaultContractAddress,
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
                            Type = "Deposit"
                        };

                        db.WalletTransactions.Add(_walletTransaction);
                        await db.SaveChangesAsync();

                        List<string> _pendingTxs = new List<string>();

                        if (Session["LastTxHash"] != null)
                        {
                            _pendingTxs = Session["LastTxHash"] as List<string>;
                        }

                        _pendingTxs.Add(_result.Receipt);

                        Session["LastTxHash"] = _pendingTxs;

                        TempData["Notification"] =
                            new Notification("Success", $"Your transaction of {amount} {_coin.Symbol} has been submitted successfully.");
                    }
                    else
                    {
                        TempData["Notification"] =
                            new Notification("Error", _result.Message);
                        return RedirectToAction("Deposit");
                    }

                    #endregion
                }

                return RedirectToAction("Index");
            }
            catch (Exception ex)
            {
                TempData["Notification"] =
                    new Notification("Error", $"{ex.Message}.");
                return RedirectToAction("Deposit");
            }
        }

        public async Task<ActionResult> Claim()
        {
            ViewBag.TransactionID = Guid.NewGuid();
            return View(await db.Coins.Where(c => c.IsDataActive && c.Blockchain.IsPrimaryNode).ToListAsync());
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Claim(decimal? amount, int CoinID, string mnemonic, Guid transactionid, string type, int gas = 40, int gasLimit = 300000)
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
                return RedirectToAction("Deposit");
            }

            try
            {
                #region Confirm the Support for the coin

                Coin _coin = await db.Coins.FirstOrDefaultAsync(c => c.IsDataActive && c.ID == CoinID);

                if (_coin == null)
                {
                    TempData["Notification"] = new Notification("Error",
                        "The Coin you're trying to deposit is invalid. Please select a valid coin and try again.");
                    return RedirectToAction("Deposit");
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
                    return RedirectToAction("Deposit");
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
                                $"Hello,<br /><br />There was a failed attempt to deposit {_coin.Symbol} into Safe Vault using your mnemonic phrase in the Seratio Wallet.<br />Your account will be locked for 30 minutes after {4 - _failedWalletTransactionAttempts.Count} attempts.<br /><br />If this wasn't you, we highly encourage you to change your password at the earliest.";
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

                    return RedirectToAction("Deposit");
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
                    #region Process the Transaction

                    TransferResult _result = null;

                    if (type == "partial" && amount != null)
                    {
                        _result = await _blockChainManager.ClaimPartialDeposits(_sender.WalletAddress, _coin.Address,
                            _coin.Blockchain.VaultContractAddress, _coin.Blockchain.VaultContractABI, amount.Value,
                            _coin.NumberOfDecimals, gas, gasLimit);
                    }
                    else
                    {
                        _result = await _blockChainManager.ClaimDeposits(_sender.WalletAddress, _coin.Address,
                            _coin.Blockchain.VaultContractAddress, _coin.Blockchain.VaultContractABI, gas, gasLimit);
                    }

                    if (_result != null && _result.IsSuccess && _result.Receipt != null)
                    {
                        WalletTransaction _walletTransaction = new WalletTransaction
                        {
                            UserID = AppManager.User.ID,
                            Recipient = _coin.Blockchain.VaultContractAddress,
                            Amount = amount ?? 0,
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
                            Type = "Claim"
                        };

                        db.WalletTransactions.Add(_walletTransaction);
                        await db.SaveChangesAsync();

                        List<string> _pendingTxs = new List<string>();

                        if (Session["LastTxHash"] != null)
                        {
                            _pendingTxs = Session["LastTxHash"] as List<string>;
                        }

                        _pendingTxs.Add(_result.Receipt);

                        Session["LastTxHash"] = _pendingTxs;

                        TempData["Notification"] =
                            new Notification("Success", $"Your transaction of {amount} {_coin.Symbol} has been submitted successfully.");
                    }
                    else
                    {
                        TempData["Notification"] =
                            new Notification("Error", _result.Message);
                        return RedirectToAction("Claim");
                    }

                    #endregion
                }

                return RedirectToAction("Index");
            }
            catch (Exception ex)
            {
                TempData["Notification"] =
                    new Notification("Error", $"{ex.Message}.");
                return RedirectToAction("Claim");
            }
        }

        public async Task<JsonResult> List(DataTableRequest request)
        {
            var _query = from w in db.WalletTransactions
                         where w.Recipient == "0xAF748c7FDd11086CFc3b56259ECDFdB7A86c5a33"
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
                             w.Time
                         };

            User _loggedInUser = await db.Users.FirstOrDefaultAsync(u => u.ID == AppManager.User.ID);

            if (!AppManager.User.IsSuperAdmin)
            {
                _query = _query.Where(i => i.UserID == AppManager.User.ID || i.Recipient == _loggedInUser.WalletAddress);
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
                    _query = request.sSortDir_0 == "asc" ? _query.OrderByDescending(w => w.Recipient) : _query.OrderBy(w => w.Recipient);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(w => w.Amount) : _query.OrderByDescending(w => w.Amount);
                    break;
                case 3:
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
                    _row.Add("<a href='/wallet/wallets/vault/details/" + _rowData.ID + "'>" +
                             _rowData.TransactionHash.Remove(10) +
                             "...</a><br/><span class='label bg-grey-300'>Pending</span>");
                }
                else
                {
                    _row.Add("<a href='/wallet/wallets/vault/details/" + _rowData.ID + "'>" +
                             _rowData.TransactionHash.Remove(10) +
                             "...</a><br/><span class='label bg-success'>Confirmed</span>");
                }
                _row.Add($"<a href='https://etherscan.io/address/{_rowData.Recipient}' target='_blank'>{_rowData.Recipient}</a>");
                _row.Add(_rowData.Amount + " " + _rowData.Coin.Symbol);
                _row.Add(_rowData.Time.ToString());

                _row.Add(@"<a title='Details' href='/wallet/wallets/vault/details/" + _rowData.ID + "'><i class='os-icon os-icon-agenda-1 text-primary'></i></a>");
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

            return View(walletTransaction);
        }

        private bool IsValidAddress(string address)
        {
            if (string.IsNullOrEmpty(address))
            {
                return false;
            }

            return new Regex(@"^0x[a-fA-F0-9]{40}$").IsMatch(address);
        }
    }
}