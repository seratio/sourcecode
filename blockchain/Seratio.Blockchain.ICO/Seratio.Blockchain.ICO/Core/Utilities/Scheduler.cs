using System.Collections.Specialized;
using Quartz;
using Quartz.Impl;

namespace Seratio.Platform.ICO.Core.Utilities
{
    public class Scheduler
    {
        public static void Schedule()
        {
            NameValueCollection _properties = new NameValueCollection();
            _properties["quartz.scheduler.instanceName"] = "SeratioBGWorker";
            _properties["quartz.threadPool.threadCount"] = "5";

            ISchedulerFactory _schedulerFactory = new StdSchedulerFactory(_properties);

            IScheduler _scheduler = _schedulerFactory.GetScheduler();
            _scheduler.Start();

            IJobDetail _cryptoCoinpriceUpdator = JobBuilder.Create<CryptoCoinExchanger>()
                    .WithIdentity("_cryptoCoinpriceUpdator", "group1")
                    .Build();


            ITrigger _cryptoCoinpriceUpdatorTrigger = TriggerBuilder.Create()
                .WithIdentity("_cryptoCoinpriceUpdatorTrigger", "group1")
                .StartNow()
                .WithSimpleSchedule(x => x.WithIntervalInMinutes(1).RepeatForever())
                //.WithSimpleSchedule(x => x
                //    .WithIntervalInHours(1)
                //                        .RepeatForever())
                .Build();



            _scheduler.ScheduleJob(_cryptoCoinpriceUpdator, _cryptoCoinpriceUpdatorTrigger);

            IJobDetail _fiatFXUpdater = JobBuilder.Create<FIATFxRateUpdater>()
                .WithIdentity("_fiatFXUpdater", "group1")
                .Build();

            ITrigger _fiatFXUpdaterTrigger = TriggerBuilder.Create()
                .WithIdentity("_fiatFXUpdaterTrigger", "group1")
                .StartNow()
                .WithSimpleSchedule(x => x.WithIntervalInHours(1).RepeatForever())
                .Build();

            _scheduler.ScheduleJob(_fiatFXUpdater, _fiatFXUpdaterTrigger);
        }
    }
}