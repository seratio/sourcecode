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
    public class DefaultController : BaseController
    {
        public async Task<ActionResult> GetWalletsToMint(bool IsFirstRun)
        {
            var _query = from u in db.Users
                         join i in db.SERTokenInvestments on u.ID equals i.UserID
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
            SERTokenInvestment _investment = await db.SERTokenInvestments.FirstOrDefaultAsync(i => i.UserID == userID);

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
    }
}