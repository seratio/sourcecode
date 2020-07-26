using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Entities.SAPI;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;
using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Drawing.Printing;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Net.Mail;
using System.Net.Mime;
using System.Security.Cryptography;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Web;
using System.Web.Hosting;
using TuesPechkin;

namespace Seratio.Blockchain.Sandbox.Core
{
    public class AppManager
    {
        public static bool IsTransactionStatusMonitorRunning;
        public static bool IsKeyCleanerRunning;

        public static PlatformDatabaseEntities db = new PlatformDatabaseEntities();

        #region Session

        public static AppUser User
        {
            get
            {
                return HttpContext.Current != null ? HttpContext.Current.Session["Blockchain_User"] as AppUser : null;
            }
        }

        #endregion

        public static async Task<AppUser> AuthenticateUserMobileAsync(int ID)
        {
            try
            {
                //   string _authString = Rijndael.Encrypt(string.Concat(username, Password));
                

                var _user = await (from u in db.Users
                                   where (u.ID.Equals(ID) && u.IsDataActive)
                                   select new
                                   {
                                       u.Email,
                                       u.ID,
                                       u.Phone,
                                       u.WalletAddress,
                                       u.Gender,
                                       u.IsSuperAdmin,
                                       u.NickName,
                                       u.IsSearchable,
                                       u.IsEmailVerified,
                                       u.ModuleAccessRequests,
                                       u.SaftyQuestion,
                                       u.SaftyAnswer,
                                       u.ShouldAllowSignInWithQR,
                                       u.AllowEmailNotifications,
                                       u.EnableTwoFactorAuthentication,
                                       u.IsBlockedWallet,
                                   }).FirstOrDefaultAsync();

                if (_user != null)
                {
                    bool flag = true;

                    if (_user.WalletAddress != null)
                    {
                        flag = false;
                    }
                    return new AppUser
                    {
                        NickName = _user.NickName,
                        ID = _user.ID,
                        Gender = _user.Gender,
                        Email = _user.Email,
                        //WalletAddress = _user.WalletAddress,
                        Phone = _user.Phone,
                        IsSuperAdmin = _user.IsSuperAdmin,
                        IsSearchable = _user.IsSearchable,
                        IsEmailverified = _user.IsEmailVerified,
                        CanAccessRewardingBody = _user.ModuleAccessRequests.Any(i => i.Module == "Rewarding Body" && i.IsApproved == true),
                        CanAccessRetailEnd = _user.ModuleAccessRequests.Any(i => i.Module == "Retail End" && i.IsApproved == true),
                        CanAccessProvinance = _user.ModuleAccessRequests.Any(i => i.Module == "Provenance" && i.IsApproved == true),
                        //SaftyQuestion = _user.SaftyQuestion,
                        //SaftyAnswer = _user.SaftyAnswer,
                        ShouldAllowSignInWithQR = _user.ShouldAllowSignInWithQR,
                        SessionID = await CreateUserSession(_user.ID, "Credential Login"),
                        AllowEmailNotifications = _user.AllowEmailNotifications,
                        RequiresTwoFactorAuthentication = _user.EnableTwoFactorAuthentication,
                        UsernameUsed = _user.Email,
                        PendingWalletCreation = flag,
                        IsBlockedWallet = _user.IsBlockedWallet
                    };
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                //////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static async Task<AppUser> AuthenticateUserAsync(string username, string Password)
        {
            try
            {
                //   string _authString = Rijndael.Encrypt(string.Concat(username, Password));
                byte[] _authString = GetAuthstring(username, Password);

                var _user = await (from u in db.Users
                                   where (u.Email.Equals(username)) && (u.AuthString.Equals(_authString)) && u.IsDataActive
                                   select new
                                   {
                                       u.Email,
                                       u.ID,
                                       u.Phone,
                                       u.WalletAddress,
                                       u.Gender,
                                       u.IsSuperAdmin,
                                       u.NickName,
                                       u.IsSearchable,
                                       u.IsEmailVerified,
                                       u.ModuleAccessRequests,
                                       u.SaftyQuestion,
                                       u.SaftyAnswer,
                                       u.ShouldAllowSignInWithQR,
                                       u.AllowEmailNotifications,
                                       u.EnableTwoFactorAuthentication,
                                       u.IsBlockedWallet,
                                   }).FirstOrDefaultAsync();

                if (_user != null)
                {
                    bool flag = true;

                    if (_user.WalletAddress != null)
                    {
                        flag = false;
                    }
                    return new AppUser
                    {
                        NickName = _user.NickName,
                        ID = _user.ID,
                        Gender = _user.Gender,
                        Email = _user.Email,
                        //WalletAddress = _user.WalletAddress,
                        Phone = _user.Phone,
                        IsSuperAdmin = _user.IsSuperAdmin,
                        IsSearchable = _user.IsSearchable,
                        IsEmailverified = _user.IsEmailVerified,
                        CanAccessRewardingBody = _user.ModuleAccessRequests.Any(i => i.Module == "Rewarding Body" && i.IsApproved == true),
                        CanAccessRetailEnd = _user.ModuleAccessRequests.Any(i => i.Module == "Retail End" && i.IsApproved == true),
                        CanAccessProvinance = _user.ModuleAccessRequests.Any(i => i.Module == "Provenance" && i.IsApproved == true),
                        //SaftyQuestion = _user.SaftyQuestion,
                        //SaftyAnswer = _user.SaftyAnswer,
                        ShouldAllowSignInWithQR = _user.ShouldAllowSignInWithQR,
                        SessionID = await CreateUserSession(_user.ID, "Credential Login"),
                        AllowEmailNotifications = _user.AllowEmailNotifications,
                        RequiresTwoFactorAuthentication = _user.EnableTwoFactorAuthentication,
                        UsernameUsed = username,
                        PendingWalletCreation = flag,
                        IsBlockedWallet = _user.IsBlockedWallet
                    };
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                //////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static async Task<AppUser> AuthenticateUserAsync(string id)
        {
            try
            {
                int ID = Convert.ToInt32(id);
                var _user = await (from u in db.Users
                                   where (u.ID == ID && u.IsDataActive)
                                   select new
                                   {
                                       u.Email,
                                       u.ID,
                                       u.Phone,
                                       u.WalletAddress,
                                       u.Gender,
                                       u.IsSuperAdmin,
                                       u.NickName,
                                       u.IsSearchable,
                                       u.IsEmailVerified,
                                       u.ModuleAccessRequests,
                                       u.SaftyQuestion,
                                       u.SaftyAnswer,
                                       u.ShouldAllowSignInWithQR,
                                       u.AllowEmailNotifications,
                                       u.EnableTwoFactorAuthentication,
                                       u.IsBlockedWallet,
                                   }).FirstOrDefaultAsync();

                if (_user != null)
                {
                    bool flag = true;

                    if (_user.WalletAddress != null)
                    {
                        flag = false;
                    }
                    return new AppUser
                    {
                        NickName = _user.NickName,
                        ID = _user.ID,
                        Gender = _user.Gender,
                        Email = _user.Email,
                        //WalletAddress = _user.WalletAddress,
                        Phone = _user.Phone,
                        IsSuperAdmin = _user.IsSuperAdmin,
                        IsSearchable = _user.IsSearchable,
                        IsEmailverified = _user.IsEmailVerified,
                        CanAccessRewardingBody = _user.ModuleAccessRequests.Any(i => i.Module == "Rewarding Body" && i.IsApproved == true),
                        CanAccessRetailEnd = _user.ModuleAccessRequests.Any(i => i.Module == "Retail End" && i.IsApproved == true),
                        CanAccessProvinance = _user.ModuleAccessRequests.Any(i => i.Module == "Provenance" && i.IsApproved == true),
                        //SaftyQuestion = _user.SaftyQuestion,
                        //SaftyAnswer = _user.SaftyAnswer,
                        ShouldAllowSignInWithQR = _user.ShouldAllowSignInWithQR,
                        SessionID = await CreateUserSession(_user.ID, "Credential Login"),
                        AllowEmailNotifications = _user.AllowEmailNotifications,
                        RequiresTwoFactorAuthentication = _user.EnableTwoFactorAuthentication,
                        UsernameUsed = _user.Email,
                        PendingWalletCreation = flag,
                        IsBlockedWallet = _user.IsBlockedWallet
                    };
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                //////ExceptionHandler.Handle(ex);
                return null;
            }
        }


        public static async Task<AppUser> AuthenticateAutologinUserAsync(Guid token)
        {
            try
            {
                var _user = await (from u in db.Users
                                   where u.AutoLoginToken == token && u.IsDataActive && u.ShouldAllowSignInWithQR &&
                                         u.WalletAddress != null
                                   select new
                                   {
                                       u.Email,
                                       u.ID,
                                       u.Phone,
                                       u.WalletAddress,
                                       u.Gender,
                                       u.IsSuperAdmin,
                                       u.NickName,
                                       u.IsSearchable,
                                       u.IsEmailVerified,
                                       u.ModuleAccessRequests,
                                       u.SaftyQuestion,
                                       u.SaftyAnswer,
                                       u.ShouldAllowSignInWithQR,
                                       u.AllowEmailNotifications,
                                       u.EnableTwoFactorAuthentication,
                                       u.IsBlockedWallet,
                                   }).FirstOrDefaultAsync();

                if (_user != null)
                {
                    bool flag = true;

                    if (_user.WalletAddress != null)
                    {
                        flag = false;
                    }
                    return new AppUser
                    {
                        NickName = _user.NickName,
                        ID = _user.ID,
                        Gender = _user.Gender,
                        Email = _user.Email,
                        //  WalletAddress = _user.WalletAddress,
                        Phone = _user.Phone,
                        IsSuperAdmin = _user.IsSuperAdmin,
                        IsSearchable = _user.IsSearchable,
                        IsEmailverified = _user.IsEmailVerified,
                        CanAccessRewardingBody =
                            _user.ModuleAccessRequests.Any(i => i.Module == "Rewarding Body" && i.IsApproved == true),
                        CanAccessRetailEnd =
                            _user.ModuleAccessRequests.Any(i => i.Module == "Retail End" && i.IsApproved == true),
                        CanAccessProvinance =
                            _user.ModuleAccessRequests.Any(i => i.Module == "Provenance" && i.IsApproved == true),
                        //SaftyQuestion = _user.SaftyQuestion,
                        //SaftyAnswer = _user.SaftyAnswer,
                        ShouldAllowSignInWithQR = _user.ShouldAllowSignInWithQR,
                        SessionID = await CreateUserSession(_user.ID, "QR Login"),
                        AllowEmailNotifications = _user.AllowEmailNotifications,
                        RequiresTwoFactorAuthentication = _user.EnableTwoFactorAuthentication,
                        PendingWalletCreation = flag,
                        IsBlockedWallet = _user.IsBlockedWallet,
                    };
                }
                else
                {
                    return null;

                }
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static AppUser AuthenticateUser(string Email, string Password)
        {
            try
            {
                byte[] _authString = GetAuthstring(Email, Password);

                var _user = (from u in db.Users
                             where (u.Email.Equals(Email)) && (u.AuthString.Equals(_authString)) && u.IsDataActive && u.WalletAddress != null
                             select new
                             {
                                 u.NickName,
                                 u.Phone,
                                 u.ID,
                                 u.Email,
                                 u.WalletAddress,
                                 u.Gender,
                                 u.IsSuperAdmin,
                                 u.IsSearchable,
                                 u.IsEmailVerified,
                                 u.ModuleAccessRequests,
                                 u.SaftyQuestion,
                                 u.SaftyAnswer,
                                 u.ShouldAllowSignInWithQR,
                                 u.AllowEmailNotifications,
                                 SessionID = u.UserSessions.Select(s => s.ID).OrderByDescending(s => s).FirstOrDefault(),
                                 u.IsBlockedWallet,
                             }).FirstOrDefault();

                if (_user != null)
                {
                    bool flag = true;

                    if (_user.WalletAddress != null)
                    {
                        flag = false;
                    }
                    return new AppUser
                    {
                        NickName = _user.NickName,
                        ID = _user.ID,
                        Gender = _user.Gender,
                        Email = _user.Email,
                        //  WalletAddress = _user.WalletAddress,
                        Phone = _user.Phone,
                        IsSuperAdmin = _user.IsSuperAdmin,
                        IsSearchable = _user.IsSearchable,
                        IsEmailverified = _user.IsEmailVerified,
                        CanAccessRewardingBody = _user.ModuleAccessRequests.Any(i => i.Module == "Rewarding Body" && i.IsApproved == true),
                        CanAccessRetailEnd = _user.ModuleAccessRequests.Any(i => i.Module == "Retail End" && i.IsApproved == true),
                        CanAccessProvinance = _user.ModuleAccessRequests.Any(i => i.Module == "Provenance" && i.IsApproved == true),
                        //     SaftyQuestion = _user.SaftyQuestion,
                        //   SaftyAnswer = _user.SaftyAnswer,
                        ShouldAllowSignInWithQR = _user.ShouldAllowSignInWithQR,
                        SessionID = _user.SessionID,
                        AllowEmailNotifications = _user.AllowEmailNotifications,
                        UsernameUsed = Email,
                        PendingWalletCreation = flag,
                        IsBlockedWallet = _user.IsBlockedWallet,
                    };
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static DateTime Now => DateTime.Now;

        public static void SendEmail(string subject, string to, string content, bool checkPermission = true, List<string> bcc = null)
        {
            if (checkPermission)
            {
                if (db.Users.Any(u => u.Email == to && u.AllowEmailNotifications && u.IsDataActive))
                {

                    MailMessage _msg = new MailMessage();

                    _msg.To.Add(to);

                    if (bcc != null && bcc.Any())
                    {
                        foreach (string _email in bcc)
                        {
                            _msg.Bcc.Add(_email);
                        }
                    }

                    _msg.From = new MailAddress("blockchain.lab@cceg.org.uk", "Seratio Platform");
                    _msg.Subject = subject;
                    string _template = File.ReadAllText(HostingEnvironment.MapPath("~/Views/Template.html"));
                    content = _template.Replace("{mail_body}", content);
                    _msg.AlternateViews.Add(
                        AlternateView.CreateAlternateViewFromString(content, null, MediaTypeNames.Text.Html));

                    //using (SmtpClient _client = new SmtpClient("smtpdm-ap-southeast-1.aliyun.com", Convert.ToInt32(465)))
                    //{

                    //    _client.Credentials = new NetworkCredential("no-reply@seratio.markuplab.net", "RzAQ47qGULjTAYWj");
                    //    _client.EnableSsl = true;
                    //    _client.Send(_msg);
                    //}

                    using (SmtpClient _client = new SmtpClient("smtp.sendgrid.net", Convert.ToInt32(587)))
                    {
                        _client.Credentials = new NetworkCredential("**************", "**************");
                        _client.Send(_msg);
                    }
                }
            }
            else
            {
                MailMessage _msg = new MailMessage();

                _msg.To.Add(to);

                if (bcc != null && bcc.Any())
                {
                    foreach (string _email in bcc)
                    {
                        _msg.Bcc.Add(_email);
                    }
                }

                _msg.From = new MailAddress("blockchain.lab@cceg.org.uk", "Seratio Platform");
                _msg.Subject = subject;
                string _template = File.ReadAllText(HostingEnvironment.MapPath("~/Views/Template.html"));
                content = _template.Replace("{mail_body}", content);

                _msg.AlternateViews.Add(
                    AlternateView.CreateAlternateViewFromString(content, null, MediaTypeNames.Text.Html));

                //using (SmtpClient _client = new SmtpClient("smtpdm-ap-southeast-1.aliyun.com", Convert.ToInt32(465)))
                //{
                //    _client.Credentials = new NetworkCredential("no-reply@seratio.markuplab.net", "RzAQ47qGULjTAYWj");
                //    _client.EnableSsl = true;
                //    _client.Send(_msg);
                //}

                using (SmtpClient _client = new SmtpClient("smtp.sendgrid.net", Convert.ToInt32(587)))
                {
                    _client.Credentials = new NetworkCredential("**************", "**************");
                    _client.Send(_msg);
                }
            }
        }

        public static string AppURL
        {
            get
            {
                return $"{HttpContext.Current.Request.Url.Scheme}://{HttpContext.Current.Request.Url.Authority}/";
            }
        }

        public static async Task<SAPIResponse> GetSE(string email)
        {

            using (HttpClient _client = new HttpClient())
            {
                string _responseString = await _client.GetStringAsync($"http://seratio.com/api?cmd=get&username=api@api.com&password=Zbj8Cm9gmNv3Ez56&email={email}");

                if (!string.IsNullOrEmpty(_responseString))
                {
                    return JsonConvert.DeserializeObject<SAPIResponse>(_responseString);
                }
                else
                {
                    return null;
                }
            }


        }

        public static async Task<SAPIResponse> CalculateSE(Data data)
        {
            using (HttpClient _client = new HttpClient())
            {
                try
                {
                    string url = "";
                    string _data = JsonConvert.SerializeObject(data);
                    byte[] _buffer = Encoding.UTF8.GetBytes(_data);
                    ByteArrayContent _byteContent = new ByteArrayContent(_buffer);

                    _byteContent.Headers.ContentType = new MediaTypeHeaderValue("application/json");
                    //HttpResponseMessage _response = await _client.PostAsync($"http://seratio.com/api?cmd=store&username=api@api.com&password=Zbj8Cm9gmNv3Ez56", _byteContent);        
                    url = url + "http://seratio.com/api?cmd=store&username=api@api.com&password=Zbj8Cm9gmNv3Ez56&email=" + data.email + "&family=" + (data.family==0?(decimal)(0.0000001):data.family) + "&worth=" + (data.worth == 0 ? (decimal)(0.0000001) : data.worth) + "&carbon_reduction=" + data.carbon_reduction + "&csr=" + (data.csr == 0 ? (decimal)(0.0000001) : data.csr) + "&people=" + (data.people == 0 ? (decimal)(0.0000001) : data.people) + "&money_leveraged=" + (data.money_leveraged == 0 ? (decimal)(0.0000001) : data.money_leveraged) + "&currency=" + data.currency;
                    HttpResponseMessage _response = await _client.GetAsync(url);
                    string _responseString = await _response.Content.ReadAsStringAsync();


                    if (_response.IsSuccessStatusCode)
                    {
                        return JsonConvert.DeserializeObject<SAPIResponse>(_responseString);
                    }
                    else
                    {
                        return null;
                    }
                }
                catch (Exception ex)
                {
                    return null;
                }

            }
        }

        private static IConverter PDFConverter = new ThreadSafeConverter(
        new RemotingToolset<PdfToolset>(
        new Win32EmbeddedDeployment(
        new TempFolderDeployment())));

        public static async Task<string> SavePDF(string url, string path)
        {
            if (File.Exists(path))
            {
                File.Delete(path);
            }

            string _path = path;
            Uri _url = new Uri(url);

            PDFConverter.Error += Converter_Error;

            var _document = new HtmlToPdfDocument
            {
                GlobalSettings =                    {
                        ProduceOutline = true,
                        PaperSize = PaperKind.A4,
                        Orientation = GlobalSettings.PaperOrientation.Portrait,
                        Margins = {
                    Top = 0,
                    Left = 0.00,
                    Right = 2.00,
                    Bottom = 0
                }
                    }
            };

            var _objectSettings = new ObjectSettings();
            _objectSettings.PageUrl = url;
            _objectSettings.LoadSettings.CustomHeaders.Add("X_RequesterUser", JsonConvert.SerializeObject(User));


            _document.Objects.Add(_objectSettings);

            byte[] _data = PDFConverter.Convert(_document);

            File.WriteAllBytes(path, _data);

            await Task.Delay(1000);
            return Path.GetFileName(_path);
        }

        public static async Task<string> SavePaperWallet(string url, string path, User user)
        {
            if (File.Exists(path))
            {
                File.Delete(path);
            }

            string _path = path;
            Uri _url = new Uri(url);

            PDFConverter.Error += Converter_Error;

            var _document = new HtmlToPdfDocument
            {
                GlobalSettings =                    {
                    ProduceOutline = true,
                    PaperSize = PaperKind.InviteEnvelope,
                    Orientation = GlobalSettings.PaperOrientation.Portrait,
                    Margins = {
                        Top = 0,
                        Left = 0,
                        Right = 0,
                        Bottom = 0
                    }
                }
            };

            var User = await AppManager.AuthenticateUserMobileAsync(user.ID);

            var _objectSettings = new ObjectSettings();
            _objectSettings.PageUrl = url;
            _objectSettings.LoadSettings.CustomHeaders.Add("X_RequesterUser", JsonConvert.SerializeObject(User));


            _document.Objects.Add(_objectSettings);

            byte[] _data = PDFConverter.Convert(_document);

            File.WriteAllBytes(path, _data);

            await Task.Delay(1000);
            return Path.GetFileName(_path);
        }


        private static void Converter_Error(object sender, TuesPechkin.ErrorEventArgs e)
        {

        }

        public static int GetAllWaitingDownloadRequests()
        {
            try
            {
                return db.Requests.Count(r => r.IsDataActive && (r.SenderID == User.ID) && !r.HasDownloaded && r.Status == "Approved");
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return 0;
            }
        }

        public static int GetAllRejectedRequests()
        {
            try
            {
                return db.Requests.Count(r => r.IsDataActive && (r.SenderID == User.ID) && !r.HasDownloaded && r.HasRejected);
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return 0;
            }
        }

        public static int GetAllPendingRequests()
        {
            try
            {
                return db.Requests.Count(r => r.IsDataActive && (r.Recipient == User.Email || r.Recipient == User.NickName) && r.Status == "Pending");
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return 0;
            }
        }

        public static List<ActivityNotification> GetAllNotification()
        {
            try
            {
                return db.ActivityNotifications.Where(i => i.IsRead == false && i.UserID == User.ID).OrderByDescending(i => i.Time).ToList();
                //  return db.ActivityNotifications.Where(i => i.UserID == User.ID).OrderByDescending(i => i.Time).ToList();
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static List<ActivityNotification> GetAllReadedNotification()
        {
            DateTime _date = DateTime.Now.AddDays(-30);
            try
            {
                return db.ActivityNotifications.Where(i => i.UserID == User.ID && (i.IsRead == false || i.CreatedOn >= _date)).OrderByDescending(i => i.Time).ToList();
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static byte[] GetAuthstring(string username, string password)
        {
            try
            {
                byte[] data = Encoding.ASCII.GetBytes(username.ToLower() + password);
                byte[] _hash;
                SHA256 shaM = new SHA256Managed();
                _hash = shaM.ComputeHash(data);
                return _hash;
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static byte[] GetEncriptedBytes(string value)
        {
            try
            {
                byte[] data = Encoding.ASCII.GetBytes(value.ToLower());
                byte[] _hash;
                SHA256 shaM = new SHA256Managed();
                _hash = shaM.ComputeHash(data);
                return _hash;
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static async Task<int> CreateUserSession(int UserID, string Type)
        {
            try
            {
                string _userAgent = HttpContext.Current.Request.UserAgent;

                var _session = new UserSession
                {
                    UserAgent = _userAgent,
                    IPAddress = GetUserIP(),
                    IsDataActive = true,
                    UserID = UserID,
                    StartTime = DateTime.Now,
                    EndTime = null,
                    IsActive = true,
                    HasTerminated = false,
                    SignInMethod = Type,
                    Token = Guid.NewGuid()
                };

                db.UserSessions.Add(_session);
                await db.SaveChangesAsync();

                return _session.ID;
            }
            catch
            {
                return 0;
            }
        }

        public static async Task<bool> EndUserSession(int userID, int sessionID)
        {
            try
            {
                UserSession _userSession = await db.UserSessions.FirstOrDefaultAsync(s => s.UserID == userID && s.ID == sessionID);
                if (_userSession != null)
                {
                    _userSession.EndTime = DateTime.Now;
                    _userSession.IsActive = false;

                    await db.SaveChangesAsync();
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception ex)
            {
                ////ExceptionHandler.Handle(ex);
                return false;
            }
        }

        public static string FormatJson(object json)
        {
            return JsonConvert.SerializeObject(json, Formatting.Indented);
        }

        public static string GetMd5Hash(MD5 md5Hash, string input)
        {
            byte[] data = md5Hash.ComputeHash(Encoding.UTF8.GetBytes(input));

            StringBuilder sBuilder = new StringBuilder();


            for (int i = 0; i < data.Length; i++)
            {
                sBuilder.Append(data[i].ToString("x2"));
            }

            return sBuilder.ToString();
        }

        public static string GetUserIP()
        {
            string _ip = HttpContext.Current.Request.UserHostAddress;
            string _maskedIP = HttpContext.Current.Request.ServerVariables["X_FORWARDED_FOR"];
            string _cfIP = HttpContext.Current.Request.ServerVariables["HTTP_CF_CONNECTING_IP"];
            string _actualIP = "";

            if (!string.IsNullOrEmpty(_cfIP))
            {
                _actualIP = _cfIP;
            }
            else if (_maskedIP == null)
            {
                _actualIP = _ip;
            }
            else
            {
                _actualIP = _maskedIP;

                if (_actualIP.IndexOf(",") > 0)
                {
                    string[] _temp = _actualIP.Split(',');

                    foreach (string _item in _temp)
                    {
                        return _item;
                    }
                }
            }

            return _actualIP;
        }

        public static bool IsValidEmail(string email)
        {
            try
            {
                var addr = new System.Net.Mail.MailAddress(email);
                return addr.Address == email;
            }
            catch
            {
                return false;
            }
        }

        public static bool IsValidAddress(string address)
        {
            if (string.IsNullOrEmpty(address))
            {
                return false;
            }

            return new Regex(@"^0x[a-fA-F0-9]{40}$").IsMatch(address);
        }
    }
}