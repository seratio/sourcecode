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
    public class MCRTransferController : BaseController
    {
        public async Task<ActionResult> GetWalletsToTransfer(bool IsFirstRun)
        {
            var _query =
                        from i in db.MCRTokenTransfers
                        select new
                        {
                            i.ID,
                            i.Status,
                            i.WalletAddress,
                            i.Amount
                        };

            if (IsFirstRun)
            {
                _query = _query.Where(i => i.Status == "Pending" || i.Status == "TransferStarted" || i.Status == "Queued");
            }
            else
            {
                _query = _query.Where(i => i.Status == "Pending");
            }

            var _wallets = await _query.OrderBy(i => i.Amount).Take(10).ToListAsync();

            return Json(_wallets, JsonRequestBehavior.AllowGet);
        }

        public async Task<string> UpdateInvestment(int ID, string status, string tx)
        {
            MCRTokenTransfer _transfer = await db.MCRTokenTransfers.FirstOrDefaultAsync(i => i.ID == ID);

            if (_transfer != null)
            {
                _transfer.Status = status;

                switch (_transfer.Status)
                {
                    case "Queued":
                        _transfer.QueuedOn = DateTime.Now;
                        break;
                    case "TransferStarted":
                        _transfer.TransferStartedOn = DateTime.Now;
                        break;
                    case "Transferred":
                        _transfer.TxHash = tx;
                        _transfer.TransferredOn = DateTime.Now;
                        break;
                    default:
                        _transfer.Status = status;
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