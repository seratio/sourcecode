using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Web.Mvc;
using QRCoder;
using Seratio.Blockchain.Sandbox.Core;
using Seratio.Blockchain.Sandbox.Core.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Security;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Controllers
{
    [AuthorizeAccess(AllowPendingWalletCreation = true)]
    public class KeysController : BaseController
    {
        public async Task<ActionResult> Index()
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == AppManager.User.ID && u.IsDataActive);

            if (_user != null)
            {
                if (_user.WalletAddress != null)
                {
                    AppManager.User.PendingWalletCreation = false;
                    Session["Blockchain_User"] = AppManager.User;

                    TempData["Notification"] = new Notification("Error", "Sorry, You already have your Seratio Wallet setup.");
                    return RedirectToAction("index", "default");
                }
            }

            return View();
        }

        [HttpPost]
        public async Task<ActionResult> Index(string password, string confirmpassword)
        {
            try
            {
                if (password != confirmpassword)
                {
                    TempData["Notification"] = new Notification("Error", "Sorry, Password and confirm password not matched.Please try again.");
                    return RedirectToAction("index", "default");
                }

                User _user = await db.Users.FirstOrDefaultAsync(u => u.ID == AppManager.User.ID && u.IsDataActive);

                if (_user != null)
                {

                    if (_user.WalletAddress != null)
                    {
                        TempData["Notification"] = new Notification("Error", "Sorry, You already have your Seratio Wallet setup.");
                        return View();
                    }

                    WalletInfo _info = new WalletInfo();
                    Wallet _wallet = WalletManager.CreateWallet();

                    if (_wallet != null)
                    {
                        _info = WalletManager.GetProtectedWalletInfo(_wallet, password);

                        if (_info != null)
                        {
                            UserWalletHistory _userWalletHistory = new UserWalletHistory();
                            _userWalletHistory.UserID = _user.ID;
                            _userWalletHistory.SessionID = AppManager.User.SessionID;
                            _userWalletHistory.OldWalletAddress = Session["_old"]?.ToString();
                            _userWalletHistory.NewWalletAddress = _info.Address;
                            _userWalletHistory.Time = AppManager.Now;

                            db.UserWalletHistories.Add(_userWalletHistory);


                            _user.WalletAddress = _info.Address;

                            await db.SaveChangesAsync();

                            Session["_old"] = null;
                            Session["_w"] = _info.Address;

                            AppManager.User.PendingWalletCreation = false;
                            Session["Blockchain_User"] = AppManager.User;
                        }
                    }
                    else
                    {
                        TempData["Notification"] = new Notification("Error", "Sorry, an error occurred while creating your wallet. Please try again later.");
                        return View();
                    }

                    string _url = AppManager.AppURL + "/wallet/keys/printwallet/?words=" + string.Join(" ", _wallet.Words) + "&address=" + _info.Address + "&privatekey=" + _info.UnencryptedPrivateKey;
                    string _filePath = Server.MapPath("~//keys//Seratio_Wallet_" + _info.Address + ".pdf");
                    ViewBag.PaperWallet = Path.GetFileName(await AppManager.SavePaperWallet(_url, _filePath));
                    ViewBag.Mnemonic = string.Join(" ", _wallet.Words);

                    //using (Stream input = new FileStream(_filePath, FileMode.Open, FileAccess.Read, FileShare.Read))
                    //{
                    //    PdfReader reader = new PdfReader(input);

                    //    input.Close();

                    //    using (Stream output = new FileStream(_filePath, FileMode.Create, FileAccess.Write, FileShare.None))
                    //    {
                    //        PdfEncryptor.Encrypt(reader, output, true, password, "bewithme", PdfWriter.ALLOW_SCREENREADERS);
                    //    }
                    //}

                    TempData["Notification"] =
                          new Notification("Success", "Your Seratio Wallet has been created successfully.");

                    return View(_info);
                }
                else
                {
                    TempData["Notification"] = new Notification("Error", "Unknown Account");
                    return View();
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                TempData["Notification"] = new Notification("Error", "Sorry, an error occurred while creating your wallet. Please try again later.");
                return View();
            }
        }

        public ActionResult Download(string file)
        {
            byte[] _downloadBytes = System.IO.File.ReadAllBytes(Server.MapPath($"~//keys//{file}"));
            return File(_downloadBytes, file.ToLower().EndsWith(".pdf") ? "application/pdf" : "text/plain", Server.UrlEncode(Path.GetFileName(file)));
        }

        [AllowAnonymous]
        public async Task<ActionResult> PrintWallet(string words, string address, string privatekey)
        {
            if (words == null || address == null || privatekey == null)
            {
                return HttpNotFound();
            }

            ViewBag.address = address;
            ViewBag.words = words;
            ViewBag.privatekey = privatekey;

            using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
            {
                using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode(address, QRCodeGenerator.ECCLevel.Q))
                {
                    using (QRCode _qrCode = new QRCode(_qrCodeData))
                    {
                        using (Bitmap _qrCodeImage = _qrCode.GetGraphic(20, "#0067a3", "#ffffff"))
                        {
                            using (MemoryStream _ms = new MemoryStream())
                            {
                                _qrCodeImage.Save(_ms, ImageFormat.Jpeg);
                                byte[] _imageData = _ms.ToArray();
                                string _sigBase64 = Convert.ToBase64String(_imageData);
                                ViewBag.AddressBase = _sigBase64;
                            }
                        }
                    }
                }
            }

            using (QRCodeGenerator _qrGenerator = new QRCodeGenerator())
            {
                using (QRCodeData _qrCodeData = _qrGenerator.CreateQrCode(privatekey, QRCodeGenerator.ECCLevel.Q))
                {
                    using (QRCode _qrCode = new QRCode(_qrCodeData))
                    {
                        using (Bitmap _qrCodeImage = _qrCode.GetGraphic(20, "#0067a3", "#ffffff"))
                        {
                            using (MemoryStream _ms = new MemoryStream())
                            {
                                _qrCodeImage.Save(_ms, ImageFormat.Jpeg);
                                byte[] _imageData = _ms.ToArray();
                                string _sigBase64 = Convert.ToBase64String(_imageData);
                                ViewBag.PrivateKeyBase = _sigBase64;
                            }
                        }
                    }
                }
            }

            return View();
        }

        public async Task<ActionResult> ResetWallet()
        {
            User _user = await db.Users.FirstOrDefaultAsync(u => u.IsDataActive && u.ID == AppManager.User.ID);


            List<Coin> _coins = await db.Coins.Where(c => c.IsDataActive).ToListAsync();
            foreach (Coin _coin in _coins)
            {
                using (BlockChainManager _manager = new BlockChainManager(_coin.Blockchain.Host))
                {
                    if (string.IsNullOrEmpty(_coin.Address))
                    {
                        _coin.Balance = await _manager.GetBalance(_user.WalletAddress);

                        if (_coin.Balance > 0)
                        {
                            TempData["Notification"] = new Notification("Error", "You already have coin on existing Wallet.So will not able to change existing Wallet Address");
                            return Redirect("~/default/index");
                        }
                    }
                    else
                    {
                        _coin.Balance = await _manager.GetBalance(_user.WalletAddress, _coin.Address, _coin.NumberOfDecimals);

                        if (_coin.Balance > 0)
                        {
                            TempData["Notification"] = new Notification("Error", "You already have coin on existing Wallet.So will not able to change existing Wallet Address");
                            return Redirect("~/default/index");
                        }
                    }
                }
            }

            if (_user != null)
            {
                Session["_old"] = _user.WalletAddress;

                _user.WalletAddress = null;
                await db.SaveChangesAsync();
            }

            AppManager.User.PendingWalletCreation = true;
            Session["Blockchain_User"] = AppManager.User;

            return Redirect("~/keys/index");
        }
    }
}