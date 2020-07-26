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

namespace Seratio.Blockchain.Sandbox.Areas.Wallets.Controllers
{
    [AuthorizeAccess]
    public class MicrosharesController_ : BaseController
    {
        // GET: Wallets/microshares
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

            decimal _currentMCRBalance = 0;
            decimal _totalTransfers = await db.MCRTransfers.Where(t => t.SenderID == AppManager.User.ID && t.HasProcessed).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);
            decimal _totalRecipts = await db.MCRTransfers.Where(t => t.RecipientID == AppManager.User.ID && t.HasProcessed).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);
            decimal _totalAllocation = await db.MCRAllocations.Where(t => t.UserID == AppManager.User.ID).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);

            List<Coin> _microshares = await db.Coins.Where(c => c.IsDataActive && c.IsMCRCategory).ToListAsync();

            foreach (Coin _coin in _microshares)
            {
                decimal _coinAllocations = (await db.MCRAllocations
                    .Where(a => a.UserID == AppManager.User.ID && a.CoinID == _coin.ID).Select(a => a.Amount)
                    .DefaultIfEmpty(0)
                    .SumAsync(a => a));

                decimal _coinTransfers = (await db.MCRTransfers
                    .Where(t => t.CoinID == _coin.ID && t.HasProcessed && (t.SenderID == AppManager.User.ID ||
                                                                           t.RecipientID == AppManager.User.ID)).Select(a => a.Amount).DefaultIfEmpty(0)
                    .SumAsync(t => t));

                _coin.Balance = _coinAllocations > 0 ? _coinAllocations : _coinTransfers;

                if (_coin.Balance == 0)
                {
                    _coin.Balance = 0;
                }
            }

            Coin _mcrCoin = await db.Coins.Where(c => c.IsDataActive && c.Symbol == "MCR").FirstOrDefaultAsync();

            if (_mcrCoin != null)
            {
                using (BlockChainManager _manager = new BlockChainManager(_mcrCoin.Blockchain.Host))
                {
                    _currentMCRBalance = await _manager.GetBalance(_user.WalletAddress, _mcrCoin.Address,
                           _mcrCoin.NumberOfDecimals);
                }

                if (_totalAllocation < _currentMCRBalance)
                {
                    ViewBag.UnAllocatedAmount = (_currentMCRBalance - _totalAllocation) - (_totalTransfers + _totalRecipts);
                }
                else
                {
                    ViewBag.UnAllocatedAmount = 0;
                }
            }

            ViewBag.WalletAddress = _user.WalletAddress;

            return View(_microshares);
        }

        public async Task<ActionResult> Allocate()
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

            decimal _currentMCRBalance = 0;
            decimal _totalTransfers = await db.MCRTransfers.Where(t => t.SenderID == AppManager.User.ID && t.HasProcessed).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);
            decimal _totalRecipts = await db.MCRTransfers.Where(t => t.RecipientID == AppManager.User.ID && t.HasProcessed).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);
            decimal _totalAllocation = await db.MCRAllocations.Where(t => t.UserID == AppManager.User.ID).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);

            List<Coin> _microshares = await db.Coins.Where(c => c.IsDataActive && c.IsMCRCategory).ToListAsync();

            foreach (Coin _coin in _microshares)
            {
                decimal _coinAllocations = (await db.MCRAllocations
                    .Where(a => a.UserID == AppManager.User.ID && a.CoinID == _coin.ID).Select(a => a.Amount)
                    .DefaultIfEmpty(0)
                    .SumAsync(a => a));

                decimal _coinTransfers = (await db.MCRTransfers
                    .Where(t => t.CoinID == _coin.ID && t.HasProcessed && (t.SenderID == AppManager.User.ID ||
                                                                           t.RecipientID == AppManager.User.ID)).Select(a => a.Amount).DefaultIfEmpty(0)
                    .SumAsync(t => t));

                _coin.Balance = _coinAllocations > 0 ? _coinAllocations : _coinTransfers;

                if (_coin.Balance == 0)
                {
                    _coin.Balance = 0;
                }
            }

            Coin _mcrCoin = await db.Coins.Where(c => c.IsDataActive && c.Symbol == "MCR").FirstOrDefaultAsync();

            if (_mcrCoin != null)
            {
                using (BlockChainManager _manager = new BlockChainManager(_mcrCoin.Blockchain.Host))
                {
                    _currentMCRBalance = await _manager.GetBalance(_user.WalletAddress, _mcrCoin.Address,
                           _mcrCoin.NumberOfDecimals);
                    ViewBag.MCRBalance = _currentMCRBalance;
                }

                if (_totalAllocation < _currentMCRBalance)
                {
                    ViewBag.UnAllocatedAmount = (_currentMCRBalance - _totalAllocation) - (_totalTransfers + _totalRecipts);
                }
                else
                {
                    ViewBag.UnAllocatedAmount = 0;
                }
            }

            ViewBag.WalletAddress = _user.WalletAddress;

            return View(_microshares);
        }

        [HttpPost]
        public async Task<ActionResult> Allocate(List<MCRAllocation> model)
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

            decimal _currentMCRBalance = 0;
            decimal _totalTransfers = await db.MCRTransfers.Where(t => t.SenderID == AppManager.User.ID && t.HasProcessed).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);
            decimal _totalRecipts = await db.MCRTransfers.Where(t => t.RecipientID == AppManager.User.ID && t.HasProcessed).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);
            decimal _totalAllocation = await db.MCRAllocations.Where(t => t.UserID == AppManager.User.ID).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t);

            List<Coin> _microshares = await db.Coins.Where(c => c.IsDataActive && c.IsMCRCategory).ToListAsync();

            foreach (Coin _coin in _microshares)
            {
                _coin.Balance = (await db.MCRAllocations
                                    .Where(a => a.UserID == AppManager.User.ID && a.CoinID == _coin.ID).Select(a => a.Amount).DefaultIfEmpty(0)
                                    .SumAsync(a => a)) - (await db.MCRTransfers.Where(t => t.CoinID == _coin.ID && t.HasProcessed &&
                                                                                           (t.SenderID ==
                                                                                            AppManager.User.ID ||
                                                                                            t.RecipientID ==
                                                                                            AppManager.User.ID)).Select(a => a.Amount).DefaultIfEmpty(0).SumAsync(t => t));

                if (_coin.Balance == 0)
                {
                    _coin.Balance = 0;
                }
            }

            Coin _mcrCoin = await db.Coins.Where(c => c.IsDataActive && c.Symbol == "MCR").FirstOrDefaultAsync();

            if (_mcrCoin != null)
            {
                using (BlockChainManager _manager = new BlockChainManager(_mcrCoin.Blockchain.Host))
                {
                    _currentMCRBalance = await _manager.GetBalance(_user.WalletAddress, _mcrCoin.Address,
                           _mcrCoin.NumberOfDecimals);
                }

                if (_totalAllocation < (_totalTransfers + _totalRecipts + _currentMCRBalance))
                {
                    ViewBag.UnAllocatedAmount = (_totalTransfers + _totalRecipts + _currentMCRBalance) - _totalAllocation;
                }
                else
                {
                    ViewBag.UnAllocatedAmount = 0;
                }
            }

            ViewBag.WalletAddress = _user.WalletAddress;

            foreach (MCRAllocation _allocation in model)
            {
                decimal _currentlyAllocatedAmount = await db.MCRAllocations
                    .Where(a => a.UserID == AppManager.User.ID && a.CoinID == _allocation.CoinID).Select(a => a.Amount)
                    .DefaultIfEmpty(0)
                    .SumAsync(a => a);

                _allocation.Amount = Math.Round(_allocation.Amount - _currentlyAllocatedAmount, 18);
                _allocation.Time = AppManager.Now;
                _allocation.UserID = AppManager.User.ID;

                if (_allocation.Amount == 0)
                {
                    continue;
                }

                db.MCRAllocations.Add(_allocation);
                await db.SaveChangesAsync();
            }

            TempData["Notification"] = new Notification("Success", "Your Microshares allocation has been saved successfully.");

            return RedirectToAction("Allocate");
        }
    }
}