using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web.Mvc;
using Seratio.Blockchain.Sandbox.Models;
using System.Threading.Tasks;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;

namespace Seratio.Blockchain.Sandbox.Controllers
{
    [AuthorizeAccess]
    public class UsersController : BaseController
    {
        public async Task<ActionResult> Profile()
        {
            User _user = await db.Users.FindAsync(AppManager.User.ID);

            if (_user == null)
            {
                return HttpNotFound();
            }

            //string _qrData = $"{_user.ID}|{_user.AutoLoginToken}|{_user.CreatedOn.Ticks}";

            //if (_user.ShouldAllowSignInWithQR)
            //{
            //    using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
            //    {
            //        using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode(_qrData, QRCodeGenerator.ECCLevel.Q))
            //        {
            //            using (QRCode _qrCode = new QRCode(_qrCodeData))
            //            {
            //                Bitmap qrCodeImage = _qrCode.GetGraphic(20, "#0067a3", "#ffffff");

            //                MemoryStream ms = new MemoryStream();
            //                qrCodeImage.Save(ms, ImageFormat.Jpeg);
            //                byte[] byteImage = ms.ToArray();
            //                var SigBase64 = Convert.ToBase64String(byteImage);
            //                ViewBag.Base = SigBase64;
            //            }
            //        }
            //    }
            //}
            return View(_user);
        }

        [AllowAnonymous]
        public async Task<ActionResult> GetUsers(string q, int i)
        {
            int _skip = i == 1 ? 0 : i * 20;

            var _query = from u in db.Users

                         where u.IsDataActive && (u.NickName.Contains(q) || u.Email.Contains(q) || u.Email.Contains(q))
                         orderby u.NickName
                         select new
                         {
                             u.NickName,
                             u.Email,
                         };

            Select2TextPagedResult _result = new Select2TextPagedResult
            {
                Total = await _query.OrderBy(t => t.NickName).CountAsync(),
                Results = (await _query.OrderBy(t => t.NickName).Skip(_skip).Take(20).ToListAsync()).Select(r => new Select2TextItem
                {
                    id = r.Email,
                    text = r.NickName != null ? r.NickName + " " + "(" + r.Email + ")" : r.Email
                }).ToList()
            };

            return Json(_result, JsonRequestBehavior.AllowGet);
        }

        public async Task<ActionResult> Edit(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            User _user = await db.Users.FindAsync(AppManager.User.ID);
            if (_user == null)
            {
                return HttpNotFound();
            }

            return View(_user);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Edit(User model)
        {
            model.ConfirmPassword = model.Password;
            ModelState.Clear();
            TryValidateModel(model);

            if (ModelState.IsValid)
            {
                User _user = await db.Users.FindAsync(AppManager.User.ID);

                if (_user != null)
                {
                    if (await db.Users.AnyAsync(u => u.IsDataActive && u.ID != AppManager.User.ID && u.NickName == model.NickName && !string.IsNullOrEmpty(model.NickName)))
                    {
                        TempData["Notification"] = new Notification("Error", "Requested Nickname already exist. Please try another one.");
                        return Redirect("/wallet/users/edit/" + AppManager.User.ID);
                    }

                    if (model.Answer != null && !string.IsNullOrEmpty(model.SaftyQuestion))
                    {
                        _user.SaftyAnswer = AppManager.GetEncriptedBytes(model.Answer);
                        _user.SaftyQuestion = model.SaftyQuestion;
                    }

                    _user.Phone = model.Phone;
                    _user.Gender = model.Gender ?? string.Empty;
                    _user.NickName = model.NickName;
                    _user.IsSearchable = model.IsSearchable;
                    _user.ShouldAllowSignInWithQR = model.ShouldAllowSignInWithQR;
                    _user.LastUpdatedOn = DateTime.Now;
                    _user.AssetTransactionCriteria = model.AssetTransactionCriteria;
                    _user.AllowEmailNotifications = model.AllowEmailNotifications;

                    if (model.AssetTransactionCriteria != null)
                    {
                        _user.AssetTransactionCriteriaValue = model.AssetTransactionCriteriaValue;
                    }
                    else
                    {
                        _user.AssetTransactionCriteriaValue = null;
                    }
                    try
                    {
                        await db.SaveChangesAsync();

                    }
                    catch (Exception ex)
                    {

                    }


                    TempData["Notification"] = new Notification("Success", "Requested User has been saved successfully.");
                    return RedirectToAction("dashboard", "default");
                }
                else
                {
                    return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
                }
            }

            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contain invalid value. Please check and try again.");
            return View(model);
        }

        public async Task<ActionResult> changecredential()
        {
            var _user = await db.Users.FirstOrDefaultAsync(c => c.ID == AppManager.User.ID && c.IsDataActive);

            //if (string.IsNullOrEmpty(_user.SaftyQuestion))
            //{
            //    TempData["Notification"] = new Notification("Error", "You have not secured your account with a Safety Question. Please add a Safety Question and answer first.");
            //    return RedirectToAction("dashboard", "default");
            //}

            ViewBag.question = _user.SaftyQuestion;
            return View();
        }

        [HttpPost]
        public async Task<ActionResult> ChangePassword(User model, string answer)
        {
            var _user = await db.Users.FirstOrDefaultAsync(c => c.ID == AppManager.User.ID && c.IsDataActive);

            if (!string.IsNullOrEmpty(_user.SaftyQuestion))
            {
                if (string.IsNullOrEmpty(answer))
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please enter the current security answer first.");
                    return RedirectToAction("changecredential");
                }

                if (!_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(answer)))
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. The safty answer is wrong.");
                    return RedirectToAction("changecredential");
                }

            }


            if (model.Password != null)
            {
                if (model.Password == model.ConfirmPassword)
                {
                    if (_user != null)
                    {
                        byte[] _authString = AppManager.GetAuthstring(_user.Email, model.Password);
                        _user.AuthString = _authString;
                        await db.SaveChangesAsync();

                        TempData["Notification"] = new Notification("Success", "Password has been changed successfully.");
                        return Redirect("/wallet/default/dashboard");
                    }
                    else
                    {
                        TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                        return RedirectToAction("changecredential");
                    }
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Passwords do not match. Please try again later.");
                    return RedirectToAction("changecredential");
                }
            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                return RedirectToAction("changecredential");
            }


        }

        [HttpPost]
        public async Task<ActionResult> ChangeSafetyQuestion(User model, string answer)
        {
            if (string.IsNullOrEmpty(answer))
            {
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please enter the current security answer first.");
                return RedirectToAction("changecredential");
            }
            var _user = await db.Users.FirstOrDefaultAsync(c => c.ID == AppManager.User.ID && c.IsDataActive);

            if (!_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(answer)))
            {
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. The safety answer is wrong.");
                return RedirectToAction("changecredential");
            }

            if (model.SaftyQuestion != null && model.Answer != null)
            {
                if (_user != null)
                {
                    _user.SaftyQuestion = model.SaftyQuestion;
                    _user.SaftyAnswer = AppManager.GetEncriptedBytes(model.Answer);
                    await db.SaveChangesAsync();

                    TempData["Notification"] = new Notification("Success", "Safety Question and answer has been changed successfully.");
                    return Redirect("/wallet/default/dashboard");
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                    return RedirectToAction("changecredential");
                }

            }
            else
            {
                TempData["Notification"] = new Notification("Error", "Sorry, we are unable to process your request. Please try again later.");
                return RedirectToAction("changecredential");
            }

        }

        public async Task<ActionResult> Delete(int ID)
        {
            User _user = await db.Users.FindAsync(ID);

            if (_user != null)
            {
                _user.DeletedOn = DateTime.Now;
                _user.IsDataActive = false;

                TempData["Notification"] = new Notification("Success", "Requested User has been deleted successfully.");
                await db.SaveChangesAsync();
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            return Redirect("~/admin/users/index");
        }

        public async Task<ActionResult> RequestAccess(string module)
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.ID == AppManager.User.ID);

            if (string.IsNullOrEmpty(_user.NickName))
            {
                TempData["Notification"] = new Notification("Error", "Your profile is missing important information required by this service. Please update your preferred name in your profile.");
                return Redirect("/wallet/default/dashboard");
            }

            return View();
        }

        [HttpPost]
        public async Task<ActionResult> RequestAccess(ModuleAccessRequest model)
        {
            string _module = null;

            switch (model.Module)
            {
                case "retail":
                    _module = "Retail End";
                    break;
                case "rb":
                    _module = "Rewarding Body";
                    break;
                case "provenance":
                    _module = "Provenance";
                    break;
                default:
                    break;
            }

            if (!string.IsNullOrEmpty(_module))
            {
                if (await db.ModuleAccessRequests.AnyAsync(m => m.Module == _module && m.UserID == AppManager.User.ID && m.IsApproved == null))
                {
                    TempData["Notification"] = new Notification("Error", "Your request to access this Service is already in process. We will notify you when successful.");
                    return Redirect("/wallet/default/dashboard");
                }

                model.Module = _module;
                model.UserID = AppManager.User.ID;
                model.CreatedOn = DateTime.Now;

                db.ModuleAccessRequests.Add(model);
                await db.SaveChangesAsync();

                var _administrators = await db.Users.Where(u => u.IsDataActive && u.IsSuperAdmin && u.IsEmailVerified).ToListAsync();

                foreach (User _admin in _administrators)
                {
                    ActivityNotification _activitynotification = new ActivityNotification();

                    _activitynotification.UserID = _admin.ID;
                    _activitynotification.RelatedItemID = model.ID;
                    _activitynotification.Type = "Module Access Request";
                    _activitynotification.Message = "Access Request for " + model.Module;
                    _activitynotification.Time = AppManager.Now;
                    _activitynotification.IsRead = false;
                    _activitynotification.CreatedOn = AppManager.Now;

                    db.ActivityNotifications.Add(_activitynotification);
                    await db.SaveChangesAsync();

                    string _body = $"Hello {_admin.NickName ?? _admin.Email.ToLower()} ,<br /><br /> You have a new request from {(AppManager.User.NickName != null ? AppManager.User.NickName : AppManager.User.Email.ToLower())} for authorizing the access to {model.Module}.<br/>Please login to your account to review this request.";
                    AppManager.SendEmail($"A User has requested access to {model.Module}", _admin.Email, _body);
                }

                TempData["Notification"] = new Notification("Success", $"Your request to access {model.Module} Service has been submitted.");

                return RedirectToAction("Profile");
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
        }

        public async Task<JsonResult> AccessRequestList(DataTableRequest request)
        {
            var _query = from r in db.ModuleAccessRequests
                         select new
                         {
                             r.ID,
                             r.ProcessedBy,
                             r.Message,
                             r.UserID,
                             r.IsApproved,
                             r.ApprovedOn,
                             r.RejectedOn,
                             r.CreatedOn,
                             r.User,
                             r.User1,
                             r.Module
                         };

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(m => m.User.Email.Contains(request.sSearch) || m.Message.Contains(request.sSearch) || m.CreatedOn.ToString().Contains(request.sSearch) || m.Module.Contains(request.sSearch) || m.User1.Email.Contains(request.sSearch));
            }

            _query = _query.Where(i => i.UserID == AppManager.User.ID);

            switch (request.iSortCol_0)
            {

                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.Module) : _query.OrderByDescending(m => m.Module);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.Message) : _query.OrderByDescending(m => m.Message);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.IsApproved) : _query.OrderByDescending(m => m.IsApproved);
                    break;
                case 4:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.CreatedOn) : _query.OrderByDescending(m => m.CreatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(m => m.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add(_rowData.Module);

                if (_rowData.Message != null)
                {
                    _row.Add(_rowData.Message);
                }
                else
                {
                    _row.Add("-");
                }

                string _statusHtml = string.Empty;
                string _processedby = string.Empty;
                string _respondedDate = "-";

                switch (_rowData.IsApproved)
                {
                    case null:
                        _statusHtml = "<span class=\"label bg-grey-300\">Pending</span>";
                        break;
                    case true:
                        _statusHtml = "<span class=\"label bg-success\">Approved</span>";
                        _respondedDate = _rowData.ApprovedOn.ToString();
                        break;
                    case false:
                        _statusHtml = "<span class=\"label bg-danger\">Rejected</span>";
                        _respondedDate = _rowData.RejectedOn.ToString();
                        break;
                    default:
                        break;
                }

                _row.Add("<div class=\"text-muted text-size-small\">" + _statusHtml + "</div>");
                _row.Add(_respondedDate);
                _row.Add(_rowData.CreatedOn.ToString());

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

        public async Task<JsonResult> SentSocialActivityList(DataTableRequest request)
        {
            var _query = from r in db.AcceptedSocialActivities
                         join c in db.Coins on r.RewardedCoinID equals c.ID
                         select new
                         {
                             r.ID,
                             r.ActivityID,
                             r.SocialActivity,
                             RewardingBody = r.SocialActivity.User.Email,
                             CoinSymbol = c.Symbol,
                             r.RewardedAmount,
                             r.User,
                             r.UserID,
                             r.CreatedOn,
                         };

            if (!string.IsNullOrEmpty(request.sSearch))
            {
                _query = _query.Where(a => a.RewardingBody.Contains(request.sSearch) || a.SocialActivity.Name.Contains(request.sSearch) || a.RewardedAmount.ToString().Contains(request.sSearch) || a.CreatedOn.ToString().Contains(request.sSearch));
            }

            _query = _query.Where(i => i.UserID == AppManager.User.ID);



            switch (request.iSortCol_0)
            {

                case 0:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.SocialActivity.Name) : _query.OrderByDescending(m => m.SocialActivity.Name);
                    break;
                case 1:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.RewardingBody) : _query.OrderByDescending(m => m.RewardingBody);
                    break;
                case 2:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.RewardedAmount) : _query.OrderByDescending(m => m.RewardedAmount);
                    break;
                case 3:
                    _query = request.sSortDir_0 == "asc" ? _query.OrderBy(m => m.CreatedOn) : _query.OrderByDescending(m => m.CreatedOn);
                    break;
                default:
                    _query = _query.OrderByDescending(m => m.ID);
                    break;
            }

            var _count = await _query.CountAsync();

            var _data = await _query.Skip(request.iDisplayStart).Take(request.iDisplayLength).ToListAsync();
            List<DataTableRow> _rows = new List<DataTableRow>();

            foreach (var _rowData in _data)
            {
                DataTableRow _row = new DataTableRow();

                _row.Add(_rowData.SocialActivity.Name);
                _row.Add(_rowData.RewardingBody);
                _row.Add(_rowData.RewardedAmount + " " + _rowData.CoinSymbol);
                _row.Add(_rowData.CreatedOn.ToString());
                _row.Add(@"<a href='/users/socialactivitydetails/" + _rowData.ID + "' title='Details'><i class='os-icon os-icon-agenda-1 text-primary'></i></a>");

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

        public async Task<ActionResult> GetUser(string token)
        {
            try
            {
                string[] _qrData = token.Split('|');
                Guid _token = Guid.Parse(_qrData[1]);
                int _ID = int.Parse(_qrData[0]);
                DateTime _createdOn = new DateTime(long.Parse(_qrData[2]));

                User _user = await db.Users.Where(u => u.IsDataActive && u.AutoLoginToken == _token && u.ID == _ID && u.CreatedOn == _createdOn).FirstOrDefaultAsync();

                if (_user != null)
                {
                    return Json(new
                    {
                        _user.WalletAddress,
                        _user.ID
                    }, JsonRequestBehavior.AllowGet);
                }
                else
                {
                    return null;
                }

            }
            catch (Exception ex)
            {
                TempData["Notification"] = new Notification("Error", "Sorry, an error occurred while processing your request. Please try again later.");
                return null;
            }


        }

        public async Task<ActionResult> SocialActivityDetails(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            AcceptedSocialActivity _AcceptedSocialActivities = await db.AcceptedSocialActivities.FindAsync(ID);

            if (_AcceptedSocialActivities == null)
            {
                return HttpNotFound();
            }
            return View(_AcceptedSocialActivities);
        }

        public async Task<ActionResult> ReGenerateQR(int ID)
        {
            if (ID == 0)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            User _user = await db.Users.FindAsync(AppManager.User.ID);
            if (_user == null)
            {
                return HttpNotFound();
            }

            return View(_user);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> ReGenerateQR(User model, string Answer)
        {
            model.ConfirmPassword = model.Password;
            ModelState.Clear();
            TryValidateModel(model);

            User _user = await db.Users.FindAsync(AppManager.User.ID);

            if (_user != null)
            {
                if ((_user.SaftyQuestion != null && (model.SaftyQuestion == _user.SaftyQuestion && (_user.SaftyAnswer.SequenceEqual(AppManager.GetEncriptedBytes(Answer))))) || (_user.SaftyQuestion == null && _user.SaftyAnswer == null))
                {
                    _user.AutoLoginToken = Guid.NewGuid();

                    await db.SaveChangesAsync();
                    TempData["Notification"] = new Notification("Success", "Your QR code has been changed successfully.");
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "The Safety question or answer doesn't match.");

                }

                return RedirectToAction("Profile");
            }
            else
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
        }
    }
}



