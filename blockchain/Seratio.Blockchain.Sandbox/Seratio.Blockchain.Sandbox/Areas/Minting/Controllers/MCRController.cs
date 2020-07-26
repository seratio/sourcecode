using System;
using System.Data.Entity;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Minting.Controllers
{
    [AllowAnonymous]
    public class MCRController : BaseController
    {
        public async Task<ActionResult> GetWalletsToMint(bool IsFirstRun)
        {
            var _query = from u in db.Users
                         join i in db.MCRTokenInvestments on u.ID equals i.UserID
                         where u.IsDataActive && u.WalletAddress != null
                         select new
                         {
                             i.Status,
                             u.Email,
                             u.WalletAddress,
                             i.Amount,
                             i.UserID
                         };

            if (IsFirstRun)
            {
                _query = _query.Where(i => i.Status == "Pending" || i.Status == "MintingStarted" || i.Status == "Queued");
            }
            else
            {
                _query = _query.Where(i => i.Status == "Pending");
            }

            var _wallets = await _query.OrderBy(i => i.Amount).Take(10).ToListAsync();

            return Json(_wallets, JsonRequestBehavior.AllowGet);
        }

        public async Task<string> UpdateInvestment(int userID, string status, string tx)
        {
            MCRTokenInvestment _investment = await db.MCRTokenInvestments.FirstOrDefaultAsync(i => i.UserID == userID);

            if (_investment != null)
            {
                _investment.Status = status;

                switch (_investment.Status)
                {
                    case "Queued":
                        _investment.QueuedOn = DateTime.Now;
                        break;
                    case "MintingStarted":
                        _investment.MintingStartedOn = DateTime.Now;
                        break;
                    case "Minted":
                        _investment.TxHash = tx;
                        _investment.MintedOn = DateTime.Now;
                        break;
                    default:
                        _investment.Status = status;
                        break;
                }

                await db.SaveChangesAsync();
                return "OK";
            }

            return "404";
        }

        //public async Task<ActionResult> UpdateMintingList()
        //{
        //    List<int> _excludedUserIDs = new List<int>() {66,418,
        //        1292,
        //        1293,
        //        1294,
        //        1301,
        //        1303,
        //        1304,
        //        1413,
        //        1871,
        //        2283,
        //        2461,
        //        2509};

        //    var _query = from i in db.Investments
        //                 join u in db.Users on i.UserID equals u.ID
        //                 where i.Type != "Seratio Coin" &&
        //                       (i.Status == "Confirmed" || i.Status == "Waiting for Wallet to be ready") && !_excludedUserIDs.Contains(i.UserID)
        //                 select new
        //                 {
        //                     i.UserID,
        //                     i.TokenAmount
        //                 };

        //    var _investments = await _query.ToListAsync();

        //    foreach (var _investment in _investments)
        //    {
        //        MCRTokenInvestment investment =
        //            await db.MCRTokenInvestments.FirstOrDefaultAsync(i => i.UserID == _investment.UserID);

        //        decimal _amount = decimal.Parse(_investment.TokenAmount.Split(' ').FirstOrDefault());

        //        if (investment == null)
        //        {
        //            investment = new MCRTokenInvestment();
        //            investment.UserID = _investment.UserID;
        //            investment.Amount = _amount;
        //            investment.IsFromSERMintingList = false;
        //            investment.Status = "Pending";
        //            investment.CreatedOn = AppManager.Now;

        //            db.MCRTokenInvestments.Add(investment);
        //        }
        //        else
        //        {
        //            investment.Amount = investment.Amount + _amount;
        //        }

        //        await db.SaveChangesAsync();
        //    }

        //    Response.Write("Done");
        //    Response.End();

        //    return null;
        //}
    }
}