using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.IO;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Hosting;
using Quartz;
using Seratio.News.Models;
using Tweetinvi;
using Tweetinvi.Models;

namespace Seratio.News.Core.BackgroundWorkers
{
    [DisallowConcurrentExecution]
    public class TwitterProfileSyncerJob : IJob
    {
        private ITwitterCredentials Credentials;

        public TwitterProfileSyncerJob()
        {
            Credentials = Auth.CreateCredentials("FutuqK9WqxNhFBvultBi6q2O1", "f5AAAi1O1moYAcGAXmjc4ltIT5OGeBkNciYg9VfpRSEedHj6vv", "964043282891399168-iyrLSwnoRqchyFZbsKmvJsykqlyyymL", "pEvDt6PCzvbZy6ByddIEKtPpOkYsv5TBnBE1dblcF2irp");
            Auth.SetCredentials(Credentials);
        }

        public async void Execute(IJobExecutionContext context)
        {
            try
            {
                using (NewsDatabaseEntities db = new NewsDatabaseEntities())
                {
                    foreach (TwitterAccount _twitterAccount in await db.TwitterAccounts.ToListAsync())
                    {
                        try
                        {
                            IUser _userProfile = User.GetUserFromScreenName(_twitterAccount.Handle);

                            if (_userProfile != null)
                            {
                                if (!string.IsNullOrEmpty(_userProfile.ProfileImageUrl))
                                {
                                    string _image =
                                        $"{Path.GetFileName(_userProfile.ProfileImageUrl)}";
                                    using (WebClient _webClient = new WebClient())
                                    {
                                        _webClient.DownloadFile(_userProfile.ProfileImageUrl,
                                            $"{HostingEnvironment.MapPath("/news/assets/images/profile/")}\\{_image}");
                                        _twitterAccount.ProfilePic = _image;
                                    }

                                    _twitterAccount.Name = _userProfile.Name;
                                }

                                await db.SaveChangesAsync();

                            }
                        }
                        catch (Exception ex)
                        {
                            ExceptionHandler.Handle(ex);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }
        }
    }
}