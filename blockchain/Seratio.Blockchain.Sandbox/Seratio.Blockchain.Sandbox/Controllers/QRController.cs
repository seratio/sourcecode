using System;
using System.Data.Entity;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using QRCoder;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Controllers
{
    [AllowAnonymous]
    public class QRController : BaseController
    {
        [AllowAnonymous]
        public async Task<ActionResult> Index()
        {
            QRLogin _login = new QRLogin();
            _login.Token = Guid.NewGuid();
            _login.Status = "Pending";
            _login.CreatedOn = AppManager.Now;

            db.QRLogins.Add(_login);
            await db.SaveChangesAsync();

            string _token = $"{_login.ID}|{_login.Token.ToString()}";
            string _qrData = Rijndael.Encrypt(_token);

            using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
            {
                using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode(_qrData, QRCodeGenerator.ECCLevel.Q))
                {
                    using (QRCode _qrCode = new QRCode(_qrCodeData))
                    {
                        MemoryStream _ms;
                        using (Bitmap _image = _qrCode.GetGraphic(20, "#0067a3", "#ffffff"))
                        {
                            _ms = new MemoryStream();
                            _image.Save(_ms, ImageFormat.Jpeg);
                        }

                        byte[] _bytes = _ms.ToArray();
                        var _base64String = Convert.ToBase64String(_bytes);
                        ViewBag.Base = _base64String;
                    }
                }
            }

            return View(_login);
        }

        public async Task<string> c(Guid t)
        {
            string _response = "";
            QRLogin _login = await db.QRLogins.FirstOrDefaultAsync(l => l.Token == t);

            if (_login != null)
            {
                if (_login.Status == "Verified")
                {
                    DateTime _now = DateTime.Now;
                    DateTime _previoushour = _now.AddHours(-1);

                    User _userByID = await db.Users.FirstOrDefaultAsync(u => u.ID == _login.UserID && u.IsDataActive);

                    if (_userByID != null)
                    {
                        int _failedAttemptsSoFar = await db.FailedSignInAttempts
                                       .CountAsync(u => u.UserID == _userByID.ID && u.Time <= _now && u.Time > _previoushour);

                        if (_failedAttemptsSoFar >= 3)
                        {
                            return "";
                        }

                        AppUser _authenticatedUser = await AppManager.AuthenticateUserAsync(_login.UserID.Value);

                        if (_authenticatedUser != null)
                        {
                            #region Successful Login

                            if (!_authenticatedUser.IsEmailverified)
                            {
                                return "";
                            }

                            foreach (FailedSignInAttempt _failedSignInAttempt in await db.FailedSignInAttempts
                                .Where(u => u.UserID == _userByID.ID && u.Time <= _now && u.Time > _previoushour)
                                .ToListAsync())
                            {
                                db.FailedSignInAttempts.Remove(_failedSignInAttempt);
                                await db.SaveChangesAsync();
                            }

                            Session["Blockchain_User"] = _authenticatedUser;

                            _login.Status = "Logged In";
                            _login.LoggedInOn = AppManager.Now;
                            await db.SaveChangesAsync();

                            if (_authenticatedUser.IsSuperAdmin)
                            {
                                string _body =
                                    $"Hello {_authenticatedUser.NickName ?? _authenticatedUser.Email.ToLower()} ,<br /><br /> New Sign in From {Environment.OSVersion}. If this was not you, please change your password";
                                AppManager.SendEmail("New Sign in", _authenticatedUser.Email, _body);
                            }

                            if (_authenticatedUser.RequiresTwoFactorAuthentication)
                            {
                                _authenticatedUser.PendingTwoFactorAuthentication = true;
                                Session["Blockchain_User"] = _authenticatedUser;

                                return ($"/wallet/twofa?url=/wallet/default/dashboard");
                            }

                            if (string.IsNullOrEmpty(_userByID.WalletAddress))
                            {
                                return ("/wallet/keys/index");
                            }

                            return ("/wallet/default/dashboard");

                            #endregion
                        }
                    }
                    else
                    {
                        return "";
                    }
                }
                else if (_login.Status == "Pending")
                {
                    _response = "Keep trying...";
                }
            }

            return "";
        }

        [HttpPost]
        public async Task<string> u(string d, int i)
        {
            try
            {
                d = Rijndael.Decrypt(d);
            }
            catch
            {

            }

            int ID = int.Parse(d.Split('|').FirstOrDefault());
            Guid _token = Guid.Parse(d.Split('|').LastOrDefault());

            QRLogin _login = await db.QRLogins.FirstOrDefaultAsync(l => l.Token == _token && l.ID == ID && l.Status == "Pending");

            if (_login != null)
            {
                _login.UserID = i;
                _login.Status = "Verified";
                _login.ConfirmedOn = AppManager.Now;

                await db.SaveChangesAsync();
            }

            return "OK";
        }
    }
}