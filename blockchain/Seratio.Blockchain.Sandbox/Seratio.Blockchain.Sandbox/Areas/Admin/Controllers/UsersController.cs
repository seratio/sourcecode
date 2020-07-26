using System.Collections.Generic;
using System.Data.Entity;
using System.IO;
using System.Linq;
using System.Net;
using System.Threading.Tasks;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Controllers;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Areas.Admin.Controllers
{
    [AuthorizeAccess(RequireSuperAdmin = true)]
    public class UsersController : BaseController
    {
        public ActionResult Index()
        {
            return View();
        }

        public async Task<JsonResult> List(DataTableRequest request)
        {
            var _query = from u in db.Users
                         where u.IsDataActive
                         select new
                         {
                             u.ID,
                             u.EmailVerifiedOn,
                             u.Email,
                             u.SE,
                             u.LastUpdatedOn,
                             u.WalletAddress
                         };

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(a => a.Email.Contains(request.sSearch) || a.EmailVerifiedOn.ToString().Contains(request.sSearch) || a.LastUpdatedOn.ToString().Contains(request.sSearch));
            }

            switch (request.iSortCol_0)
            {
                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.Email) : _query.OrderByDescending(u => u.Email);
                    break;

                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.EmailVerifiedOn) : _query.OrderByDescending(u => u.EmailVerifiedOn);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(u => u.LastUpdatedOn) : _query.OrderByDescending(u => u.LastUpdatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(u => u.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                if (!string.IsNullOrEmpty(_rowData.WalletAddress))
                {
                    _row.Add(_rowData.Email + "<br/><span>(<a href='https://etherscan.io/address/" + _rowData.WalletAddress + "' >" + _rowData.WalletAddress + "</a>)</span>");
                }
                else
                {
                    _row.Add(_rowData.Email);
                }

                if (_rowData.EmailVerifiedOn != null)
                {
                    _row.Add(_rowData.EmailVerifiedOn.ToString());
                }
                else
                {
                    _row.Add("-");
                }

                _row.Add(_rowData.LastUpdatedOn.ToString());

                if (AppManager.User.ID != _rowData.ID)
                {
                    if (await db.FailedWalletTransactionAttempts.AnyAsync(i => i.UserID == _rowData.ID))
                    {
                        _row.Add(@"<a class='confirm' data-confirm='Are you sure you want to delete this User?' href='/wallet/users/delete/" + _rowData.ID + "' title='Delete'><i class='fa fa-trash'></i></a>  <a class='confirm' data-confirm='Are you sure you want to reset password this User?' href='/wallet/admin/users/resetpassword/" + _rowData.ID + "' title='Reset Password'><i class='fa fa-envelope-open-o'></i></a> <a href='/wallet/admin/users/updatewallet/" + _rowData.ID + "' title='Update Wallet'><i class='fa fa-google-wallet'></i></a> <a href='/wallet/admin/users/unblock/" + _rowData.ID + "' title='Unblock this User'><i class='fa fa-user-times'></i></a>");
                    }
                    else
                    {
                        _row.Add(@"<a class='confirm' data-confirm='Are you sure you want to cancel this User?' href='/wallet/users/delete/" + _rowData.ID + "' title='Delete'><i class='fa fa-trash'></i></a>  <a class='confirm' data-confirm='Are you sure you want to reset password this User?' href='/wallet/admin/users/resetpassword/" + _rowData.ID + "' title='Reset Password'><i class='fa fa-envelope-open-o'></i></a> <a href='/wallet/admin/users/updatewallet/" + _rowData.ID + "' title='Update Wallet'><i class='fa fa-google-wallet'></i></a> ");
                    }
                }
                else
                {
                    _row.Add("");
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

        public async Task<ActionResult> ResetPassword(int ID)
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == ID && u.IsDataActive);

            if (_user != null)
            {
                string _randomPassword = Path.GetRandomFileName().Replace(".", "").ToUpper();

                _user.AuthString = AppManager.GetAuthstring(_user.Email, _randomPassword);
                await db.SaveChangesAsync();

                List<string> _administrators = await db.Users.Where(u => u.IsDataActive && u.IsSuperAdmin).Select(u => u.Email).ToListAsync();

                string _body =
                    $"Dear {(_user.NickName != null ? _user.NickName : _user.Email.ToLower())},<br /><br /> The Administrator has reset your password.<br />Your new password to  access the Seratio Wallet is {_randomPassword}";

                AppManager.SendEmail("Your Seratio Wallet Password", _user.Email, _body, false, _administrators);
                TempData["Notification"] = new Notification("Success", "Password has been changed successfully.");

            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry you entered user is not exist.");
            }

            return RedirectToAction("index");
        }


        public async Task<ActionResult> UpdateWallet(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == ID && u.IsDataActive);

            if (_user == null)
            {
                return HttpNotFound();
            }

            return View(_user);
        }

        public async Task<ActionResult> UnBlock(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            foreach (FailedWalletTransactionAttempt _attempt in await db.FailedWalletTransactionAttempts.Where(a => a.UserID == ID).ToListAsync())
            {
                db.FailedWalletTransactionAttempts.Remove(_attempt);
                await db.SaveChangesAsync();
            }

            TempData["Notification"] = new Notification("Success", "The requested user has been unblocked successfully.");

            return RedirectToAction("index", "users");
        }


        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> UpdateWallet(User model)
        {
            if (model != null && model.ID != 0)
            {
                User _user = await db.Users.FindAsync(model.ID);

                if (_user != null)
                {
                    if (!AppManager.IsValidAddress(model.WalletAddress))
                    {
                        TempData["Notification"] = new Notification("Error",
                            "You entered wallet Address not valid.");
                        return RedirectToAction("Index");
                    }

                    _user.WalletAddress = model.WalletAddress;

                    await db.SaveChangesAsync();

                    TempData["Notification"] =
                        new Notification("Success", "Wallet Address has been saved successfully.");
                    return RedirectToAction("Index");
                }
                else
                {
                    return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
                }
            }
            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
            return View(model);
        }


    }
}