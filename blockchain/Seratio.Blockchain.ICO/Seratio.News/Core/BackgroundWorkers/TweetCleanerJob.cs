using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.IO;
using System.Linq;
using System.Web;
using System.Web.Hosting;
using Quartz;
using Seratio.News.Models;

namespace Seratio.News.Core.BackgroundWorkers
{
    [DisallowConcurrentExecution]
    public class TweetCleanerJob : IJob
    {
        public async void Execute(IJobExecutionContext context)
        {
            try
            {
                using (NewsDatabaseEntities db = new NewsDatabaseEntities())
                {
                    foreach (TwitterAccount _twitterAccount in await db.TwitterAccounts.ToListAsync())
                    {
                        List<Tweet> _tweetsToPurge = await db.Tweets.Where(t => t.AccountID == _twitterAccount.ID)
                            .OrderByDescending(t => t.Time).Skip(100).ToListAsync();

                        foreach (Tweet _tweet in _tweetsToPurge)
                        {
                            try
                            {
                                string _imageFile =
                                    $"{HostingEnvironment.MapPath("/news/assets/images/tweets/")}\\{_tweet.Image}";

                                if (File.Exists(_imageFile))
                                {
                                    File.Delete(_imageFile);
                                }

                                db.Tweets.Remove(_tweet);
                                await db.SaveChangesAsync();
                            }
                            catch
                            {

                            }
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