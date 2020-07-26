using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Drawing.Printing;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Mail;
using System.Net.Mime;
using System.Security.Cryptography;
using System.Text;
using System.Threading.Tasks;
using System.Web;
using System.Web.Hosting;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Core.Utilities;
using Seratio.Platform.ICO.Models;
using TuesPechkin;
using Newtonsoft.Json;

namespace Seratio.Platform.ICO.Core
{
    public class AppManager
    {
        public static DatabaseEntities db = new DatabaseEntities();

        public static AppUser Administrator
        {
            get
            {
                return HttpContext.Current.Session["ICO_Administrator"] as AppUser;
            }
        }

        public static LoggedInUser User
        {
            get
            {
                return HttpContext.Current.Session["ICO_User"] as LoggedInUser;
            }
        }

        public static DateTime Now
        {
            get
            {
                return DateTime.Now;
            }
        }

        public static string AppURL
        {
            get
            {
                return $"http://{HttpContext.Current.Request.Url.Authority}/";
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
                ExceptionHandler.Handle(ex);
                return null;
            }
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

        public static async Task<int> CreateAdminSession(int AdminID)
        {
            string _userAgent = HttpContext.Current.Request.UserAgent;

            try
            {
                AdministratorSession _session = new AdministratorSession
                {
                    AdministratorID = AdminID,
                    StartTime = AppManager.Now,
                    EndTime = null,
                    UserAgent = _userAgent,
                    IPAddress = GetUserIP(),
                    IsDataActive = true,
                    HasTerminated = false,
                    IsActive = true,
                    Token = Guid.NewGuid(),

                };

                db.AdministratorSessions.Add(_session);

                await db.SaveChangesAsync();
                return _session.ID;
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return 0;
            }

        }

        public static async Task<bool> EndAdminSession(int adminID, int sessionID)
        {
            try
            {
                AdministratorSession _adminsession = await db.AdministratorSessions.FirstOrDefaultAsync(s => s.AdministratorID == adminID && s.ID == sessionID);
                if (_adminsession != null)
                {
                    _adminsession.EndTime = AppManager.Now;

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
                ExceptionHandler.Handle(ex);
                return false;
            }
        }

        public static async Task<AppUser> AuthenticateUserAsync(string Email, string Password)
        {
            try
            {
                byte[] _authString = GetAuthstring(Email, Password);

                var _administrator = await (from a in db.Administrators
                                            where a.Email.Equals(Email) && a.AuthString.Equals(_authString) && a.IsDataActive
                                            select new
                                            {
                                                a.IsSuperAdmin,
                                                a.Name,
                                                a.ID,
                                                a.Email,
                                                a.AuthString,
                                            }).FirstOrDefaultAsync();


                if (_administrator != null)
                {
                    return new AppUser
                    {
                        Name = _administrator.Name,
                        ID = _administrator.ID,
                        Email = _administrator.Email,
                        IsSuperAdmin = _administrator.IsSuperAdmin,
                        SessionID = await CreateAdminSession(_administrator.ID),
                    };
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return null;
            }
        }

        #region LoggedInUser

        public static async Task<UserSession> CreateUserSession(int userID, string method = "Credential Login")
        {
            string _userAgent = HttpContext.Current.Request.UserAgent;

            try
            {
                UserSession _session = new UserSession
                {
                    IsActive = true,
                    HasTerminated = false,
                    SignInMethod = method,
                    Token = Guid.NewGuid(),
                    UserID = userID,
                    StartTime = AppManager.Now,
                    EndTime = null,
                    UserAgent = _userAgent,
                    IPAddress = GetUserIP(),
                    IsDataActive = true
                };

                db.UserSessions.Add(_session);

                await db.SaveChangesAsync();
                return _session;
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return null;
            }

        }

        public static async Task<bool> EndUserSession(int userID, int sessionID, Guid? token = null)
        {
            try
            {
                UserSession _usersession = null;

                if (token != null)
                {
                    _usersession =
                       await db.UserSessions.FirstOrDefaultAsync(s => s.UserID == userID && s.ID == sessionID && s.Token == token);
                }
                else
                {
                    _usersession =
                       await db.UserSessions.FirstOrDefaultAsync(s => s.UserID == userID && s.ID == sessionID);
                }

                if (_usersession != null)
                {
                    _usersession.EndTime = AppManager.Now;

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
                ExceptionHandler.Handle(ex);
                return false;
            }
        }

        public static async Task<LoggedInUser> AuthenticateLoggedInUserAsync(string Email, string Password)
        {
            try
            {
                byte[] _authString = GetAuthstring(Email, Password);

                var _user = await (from u in db.Users
                                   where u.Email.Equals(Email) && u.AuthString.Equals(_authString) && u.IsDataActive
                                   select new
                                   {
                                       u.ID,
                                       u.FirstName,
                                       u.LastName,
                                       u.AuthString,
                                       u.Email,
                                       u.Phone,
                                       u.LastUpdatedOn,
                                       u.IsEmailVerified
                                   }).FirstOrDefaultAsync();

                if (_user != null)
                {
                    return new LoggedInUser
                    {
                        FirstName = _user.FirstName,
                        LastName = _user.LastName,
                        Email = _user.Email,
                        ID = _user.ID,
                        IsEmailverified = _user.IsEmailVerified
                    };
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return null;
            }
        }

        public static LoggedInUser AuthenticateLoggedInUser(string Email, string Password)
        {
            try
            {
                byte[] _authString = GetAuthstring(Email, Password);

                var _user = (from u in db.Users
                             where u.Email.Equals(Email) && u.AuthString.Equals(_authString) && u.IsDataActive
                             select new
                             {
                                 u.ID,
                                 u.FirstName,
                                 u.LastName,
                                 u.AuthString,
                                 u.Email,
                                 u.Phone,
                                 u.LastUpdatedOn,
                                 u.IsEmailVerified
                             }).FirstOrDefault();

                if (_user != null)
                {
                    return new LoggedInUser
                    {
                        FirstName = _user.FirstName,
                        LastName = _user.LastName,
                        Email = _user.Email,
                        ID = _user.ID,
                        IsEmailverified = _user.IsEmailVerified,
                        SessionID = 0,
                    };
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return null;
            }
        }

        #endregion

        public static void SendEmail(string subject, string to, string content, string topImage = "logo.png", string cc = null, List<string> attachments = null, string footerImage = "logo.png", string template = "template.html")
        {
            if (topImage == footerImage)
            {
                footerImage = "blank.png";
            }

            MailMessage _msg = new MailMessage();

            _msg.To.Add(to);

            if (!string.IsNullOrEmpty(cc))
            {
                _msg.CC.Add(cc);
            }

            if (attachments != null && attachments.Any())
            {
                foreach (string _attachment in attachments)
                {
                    _msg.Attachments.Add(new Attachment(_attachment));
                }
            }

            _msg.From = new MailAddress("blockchain.lab@cceg.org.uk", "Seratio Platform");
            _msg.Subject = subject;

            string _template = File.ReadAllText(HostingEnvironment.MapPath($"~/Views/{template}"));

            content = _template.Replace("{mail_body}", content).Replace("{image}", topImage).Replace("{logo}", footerImage);

            _msg.AlternateViews.Add(AlternateView.CreateAlternateViewFromString(content, null, MediaTypeNames.Text.Html));

            using (SmtpClient _client = new SmtpClient("smtp.sendgrid.net", Convert.ToInt32(587)))
            {
                _client.Credentials = new NetworkCredential("**************", "**************");
                _client.Send(_msg);
            }
        }

        public static string FormattedDuration(TimeSpan span)
        {
            if (span.Days > 0)
                return String.Format("{0} {1}",
                span.Days, span.Days == 1 ? "day" : "days");
            if (span.Hours > 0)
                return String.Format("{0} {1}",
                span.Hours, span.Hours == 1 ? "hour" : "hours");
            if (span.Minutes > 0)
                return String.Format("{0} {1}",
                span.Minutes, span.Minutes == 1 ? "minute" : "minutes");
            if (span.Seconds > 5)
                return String.Format("{0} seconds", span.Seconds);
            if (span.Seconds <= 5)
                return "a few seconds";
            return string.Empty;
        }

        #region Dashboard
        public static async Task<Dashboard> GetDashboardData(DateTime start, DateTime end)
        {
            Dashboard _result = new Dashboard();
            DateTime _CurrentDate = Now.Date;
            try
            {
                #region Chart Common Items

                double _bitcoinvalue = 0;
                double _ethereumvalue = 0;
                double _ethereumclassicvalue = 0;
                double _litecoinvalue = 0;
                //       double _usdvalue = 0;
                double _gbpvalue = 0;
                double _eurovalue = 0;
                double _fiatvalue = 0;

                double _bitcoinsum = 0;
                double _ethereumsum = 0;
                double _ethereumclassicsum = 0;
                double _litecoinsum = 0;
                //       double _usdsum = 0;
                double _gbpsum = 0;
                double _eurosum = 0;
                double _fiatsum = 0;

                var _ch_art = Enumerable.Range(0, end.Subtract(start).Days).Select(o => new ChartItem { x = start.AddDays(o).Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds }).ToList();
                var _query = from q in db.Investments
                             where /*q.Mode == "Bitcoin" && */q.InitializedOn >= start && q.InitializedOn < end && q.TxReferenceNumber != null && q.TxRefNoUpdatedOn != null
                             select new
                             {
                                 q.InitializedOn,
                                 q.ID,
                                 q.Mode,
                                 q.Amount
                             };

                #endregion

                #region Line Chart Items with count

                var _lineChartDataBitCoin = (await _query.Where(b => b.Mode == "Bitcoin").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    bitcoinYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Bitcoin").Select(c => c.ID).Count()
                }).ToList();


                var _lineChartDataEthereum = (await _query.Where(b => b.Mode == "Ethereum").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    ethereumYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Ethereum").Select(c => c.ID).Count()
                }).ToList();

                var _lineChartDataEthereumClassic = (await _query.Where(b => b.Mode == "Ethereum Classic").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    ethereumClassicYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Ethereum Classic").Select(c => c.ID).Count()
                }).ToList();

                var _lineChartDataLiteCoin = (await _query.Where(b => b.Mode == "Litecoin").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    litecoinYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Litecoin").Select(c => c.ID).Count()
                }).ToList();

                var _lineChartDataFiats = (await _query.Where(b => b.Mode != "Ethereum" && b.Mode != "Ethereum Classic" && b.Mode != "Litecoin" && b.Mode != "Bitcoin").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    fiatsYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode != "Ethereum" && c.Mode != "Ethereum Classic" && c.Mode != "Litecoin" && c.Mode != "Bitcoin").Select(c => c.ID).Count()
                }).ToList();

                //var _lineChartDataUSD = (await _query.Where(b => b.Mode == "USD").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                //{
                //    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                //    usdYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "USD").Select(c => c.ID).Count()
                //}).ToList();

                //var _lineChartDataGBP = (await _query.Where(b => b.Mode == "GBP").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                //{
                //    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                //    gbpYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "GBP").Select(c => c.ID).Count()
                //}).ToList();

                //var _lineChartDataEUR = (await _query.Where(b => b.Mode == "EUR").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                //{
                //    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                //    gbpYAxis = g.Count() + _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "EUR").Select(c => c.ID).Count()
                //}).ToList();

                var _chartCountItems = _ch_art.Select(i => new ChartItem
                {
                    x = i.x,
                    bitcoinYAxis = _bitcoinvalue = _lineChartDataBitCoin.Any(a => a.x == i.x) ? _lineChartDataBitCoin.FirstOrDefault(a => a.x == i.x).bitcoinYAxis : _bitcoinvalue,
                    ethereumYAxis = _ethereumvalue = _lineChartDataEthereum.Any(e => e.x == i.x) ? _lineChartDataEthereum.FirstOrDefault(e => e.x == i.x).ethereumYAxis : _ethereumvalue,
                    ethereumClassicYAxis = _ethereumclassicvalue = _lineChartDataEthereumClassic.Any(e => e.x == i.x) ? _lineChartDataEthereumClassic.FirstOrDefault(e => e.x == i.x).ethereumClassicYAxis : _ethereumclassicvalue,
                    litecoinYAxis = _litecoinvalue = _lineChartDataLiteCoin.Any(e => e.x == i.x) ? _lineChartDataLiteCoin.FirstOrDefault(e => e.x == i.x).litecoinYAxis : _litecoinvalue,
                    fiatsYAxis = _fiatvalue = _lineChartDataFiats.Any(e => e.x == i.x) ? _lineChartDataFiats.FirstOrDefault(e => e.x == i.x).fiatsYAxis : _fiatvalue,
                    //euroYAxis = _eurovalue = _lineChartDataEUR.Any(e => e.x == i.x) ? _lineChartDataEUR.FirstOrDefault(e => e.x == i.x).euroYAxis : _eurovalue,
                    //gbpYAxis = _gbpvalue = _lineChartDataGBP.Any(e => e.x == i.x) ? _lineChartDataGBP.FirstOrDefault(e => e.x == i.x).gbpYAxis : _gbpvalue,
                }).ToList();

                #endregion

                #region Line Chart Items With sum Amount

                //var _lineChartSumBitCoin = (await _query.Where(b => b.Mode == "Bitcoin").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                //{
                //    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                //    bitcoinYAxis =(double)g.Sum(i => i.Amount)??0 + (double)_query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Bitcoin").Sum(c => c.Amount) ??0
                //}).ToList();

                var _lineChartSumBitCoin = (await _query.Where(b => b.Mode == "Bitcoin").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    bitcoinYAxis = (double)g.Sum(i => i.Amount) + (double)(_query.Any(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Bitcoin") ? _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Bitcoin").Sum(c => c.Amount) : 0)
                }).ToList();

                var _lineChartSumEthereum = (await _query.Where(b => b.Mode == "Ethereum").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    ethereumYAxis = (double)g.Sum(i => i.Amount) + (double)(_query.Any(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Ethereum") ? _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Ethereum").Sum(c => c.Amount) : 0)
                }).ToList();

                var _lineChartSumEthereumClassic = (await _query.Where(b => b.Mode == "Ethereum Classic").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    ethereumClassicYAxis = (double)g.Sum(i => i.Amount) + (double)(_query.Any(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Ethereum Classic") ? _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Ethereum Classic").Sum(c => c.Amount) : 0)
                }).ToList();

                var _lineChartSumLiteCoin = (await _query.Where(b => b.Mode == "Litecoin").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    litecoinYAxis = (double)g.Sum(i => i.Amount) + (double)(_query.Any(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Litecoin") ? _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "Litecoin").Sum(c => c.Amount) : 0)
                }).ToList();

                var _lineChartSumFiats = (await _query.Where(b => b.Mode != "Ethereum" && b.Mode != "Ethereum Classic" && b.Mode != "Litecoin" && b.Mode != "Bitcoin").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                {
                    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                    fiatsYAxis = (double)g.Sum(i => i.Amount) + (double)(_query.Any(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode != "Ethereum" && c.Mode != "Ethereum Classic" && c.Mode != "Litecoin" && c.Mode != "Bitcoin") ? _query.Where(c => c.InitializedOn <= g.Key && c.Mode != "Ethereum" && c.Mode != "Ethereum Classic" && c.Mode != "Litecoin" && c.Mode != "Bitcoin").Sum(c => c.Amount) : 0)
                }).ToList();

                //var _lineChartSumGBP = (await _query.Where(b => b.Mode == "GBP").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                //{
                //    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                //    gbpYAxis = (double)g.Sum(i => i.Amount) + (double)(_query.Any(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "GBP") ? _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "GBP").Sum(c => c.Amount) : 0)

                //}).ToList();

                //var _lineChartSumEUR = (await _query.Where(b => b.Mode == "EUR").ToListAsync()).GroupBy(i => i.InitializedOn.Date).Select(g => new ChartItem
                //{
                //    x = g.Key.Subtract(new DateTime(1970, 1, 1)).TotalMilliseconds,
                //    gbpYAxis = (double)g.Sum(i => i.Amount) + (double)(_query.Any(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "EUR") ? _query.Where(c => c.InitializedOn <= g.Key && c.InitializedOn >= start && c.Mode == "EUR").Sum(c => c.Amount) : 0)
                //}).ToList();

                var _chartSumtItems = _ch_art.Select(i => new ChartItem
                {
                    x = i.x,
                    bitcoinYAxis = _bitcoinsum = _lineChartSumBitCoin.Any(a => a.x == i.x) ? _lineChartSumBitCoin.FirstOrDefault(a => a.x == i.x).bitcoinYAxis : _bitcoinsum,
                    ethereumYAxis = _ethereumsum = _lineChartSumEthereum.Any(e => e.x == i.x) ? _lineChartSumEthereum.FirstOrDefault(e => e.x == i.x).ethereumYAxis : _ethereumsum,
                    ethereumClassicYAxis = _ethereumclassicsum = _lineChartSumEthereumClassic.Any(e => e.x == i.x) ? _lineChartSumEthereumClassic.FirstOrDefault(e => e.x == i.x).ethereumClassicYAxis : _ethereumclassicsum,
                    litecoinYAxis = _litecoinsum = _lineChartSumLiteCoin.Any(e => e.x == i.x) ? _lineChartSumLiteCoin.FirstOrDefault(e => e.x == i.x).litecoinYAxis : _litecoinsum,
                    fiatsYAxis = _fiatsum = _lineChartSumFiats.Any(e => e.x == i.x) ? _lineChartSumFiats.FirstOrDefault(e => e.x == i.x).fiatsYAxis : _fiatsum,
                    //euroYAxis = _eurosum = _lineChartSumEUR.Any(e => e.x == i.x) ? _lineChartSumEUR.FirstOrDefault(e => e.x == i.x).euroYAxis : _eurosum,
                    //gbpYAxis = _gbpsum = _lineChartSumGBP.Any(e => e.x == i.x) ? _lineChartSumGBP.FirstOrDefault(e => e.x == i.x).gbpYAxis : _gbpsum,
                }).ToList();

                #endregion

                #region TotalInvestmenst

                List<InvestmentDetail> _investmentdetail = (await _query.Where(i => i.InitializedOn >= start && i.InitializedOn < end).ToListAsync()).GroupBy(i => i.Mode).Select(g => new InvestmentDetail
                {
                    Mode = g.Key,
                    Total = g.Sum(i => i.Amount)
                }).ToList();
                #endregion

                #region Donut Chart Items

                _result.TopModes = (await _query.Where(i => i.InitializedOn >= start && i.InitializedOn < end).ToListAsync()).GroupBy(t => t.Mode).Select(i => new DonutChartItem
                {
                    label = i.Key,
                    value = i.Sum(k => k.Amount)
                }).ToList();


                _result.TopModes = _result.TopModes.OrderByDescending(t => t.value).Take(5).ToList();
                #endregion

                #region Results

                _result.Summary = _chartCountItems;
                _result.SummaryWithSum = _chartSumtItems;
                _result.Investments = _investmentdetail;

                #endregion

            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }

            return _result;
        }

        #endregion


        private static void Converter_Error(object sender, TuesPechkin.ErrorEventArgs e)
        {

        }

        #region Save as PDF

        private static IConverter PDFConverter = new ThreadSafeConverter(new RemotingToolset<PdfToolset>(new Win32EmbeddedDeployment(new TempFolderDeployment())));

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
            _objectSettings.LoadSettings.CustomHeaders.Add("X_RequesterAdministrator", JsonConvert.SerializeObject(Administrator));

            _document.Objects.Add(_objectSettings);

            byte[] _data = PDFConverter.Convert(_document);

            File.WriteAllBytes(path, _data);

            await Task.Delay(1000);
            return Path.GetFileName(_path);
        }

        #endregion
    }
}