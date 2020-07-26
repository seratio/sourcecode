using System.Data.Entity;
using System.Web.Mvc;
using Nethereum.Web3.Accounts;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Wallets.Controllers
{
    public class TestController : Controller
    {
        // GET: Wallets/Test
        public async System.Threading.Tasks.Task<ActionResult> IndexAsync()
        {
            PlatformDatabaseEntities db = new PlatformDatabaseEntities();

            int gas = 40;
            string mnemonic = "faith limb young voyage govern purchase bus fit real unhappy crater planet";
            Coin coin = await db.Coins.FirstOrDefaultAsync(c => c.Address == "0x48EB12C0DDc5163E8693F3029A14440442Df2710");

            Wallet _wallet = WalletManager.RetrieveWallet(mnemonic);
            Account _account = _wallet.GetAccount(0);
            using (BlockChainManager _blockChainManager =
                new BlockChainManager(_account, "https://api.myetherapi.com/eth", gas))
            {
                #region Make sure the sender has enough funds to make the requested transaction

                decimal _availableBalance = await _blockChainManager.GetBalance(_account.Address,
                    coin.Address, coin.NumberOfDecimals);

                if (_availableBalance < 10)
                {
                    TempData["Notification"] = new Notification("Error",
                        "You don't have sufficient balance in your Wallet to make this transaction. Please try again later.");
                }

                string _erc20ABI = System.IO.File.ReadAllText(Server.MapPath("/wallet/abi/dummySERContractABI.json"));

                //var _approveResult = await _blockChainManager.ApproveDeposit(_account.Address, coin.Address, _erc20ABI, 10, gas);
                //var _result = await _blockChainManager.DepositWithTimeToken(_account.Address, coin.Address, 10, gas);
                //decimal _lockedValue = await _blockChainManager.GetLockedDepositValue(_account.Address, coin.Address, coin.NumberOfDecimals, gas);

                #endregion



                return null;
            }
        }
    }
}