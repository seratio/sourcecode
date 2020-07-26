using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using Quartz;
using Quartz.Impl;

namespace Seratio.News.Core.BackgroundWorkers
{
    [DisallowConcurrentExecution]
    public class BackgroundWorkManager
    {
        public static void Schedule()
        {
            try
            {
                if (Environment.MachineName.ToLower() == "vultr-guest")
                {
                    NameValueCollection _properties = new NameValueCollection();
                    _properties["quartz.scheduler.instanceName"] = "Seratio_Scheduler";
                    _properties["quartz.threadPool.threadCount"] = "1";

                    ISchedulerFactory _schedulerFactory = new StdSchedulerFactory(_properties);

                    IScheduler _scheduler = _schedulerFactory.GetScheduler();
                    _scheduler.Start();

                    IJobDetail _tweetSyncerJob = JobBuilder.Create<TweetSyncerJob>().Build();
                    ITrigger _tweetSyncerJobTrigger = TriggerBuilder.Create()
                        .WithDailyTimeIntervalSchedule(s => s.WithIntervalInMinutes(1).OnEveryDay()).Build();
                    _scheduler.ScheduleJob(_tweetSyncerJob, _tweetSyncerJobTrigger);

                    IJobDetail _profileSyncerJob = JobBuilder.Create<TwitterProfileSyncerJob>().Build();
                    ITrigger _profileSyncerJobTrigger = TriggerBuilder.Create()
                        .WithDailyTimeIntervalSchedule(s => s.WithIntervalInMinutes(2).OnEveryDay()).Build();
                    _scheduler.ScheduleJob(_profileSyncerJob, _profileSyncerJobTrigger);

                    IJobDetail _tweetCleanerJob = JobBuilder.Create<TweetCleanerJob>().Build();
                    ITrigger _tweetCleanerJobTrigger = TriggerBuilder.Create()
                        .WithDailyTimeIntervalSchedule(s => s.WithIntervalInHours(1).OnEveryDay()).Build();
                    _scheduler.ScheduleJob(_tweetCleanerJob, _tweetCleanerJobTrigger);
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }
        }
    }
}