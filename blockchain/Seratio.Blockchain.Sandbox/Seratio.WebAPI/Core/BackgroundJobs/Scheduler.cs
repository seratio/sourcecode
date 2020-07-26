using System;
using Quartz;
using Quartz.Impl;
using Seratio.Blockchain.Sandbox.Core.Utilities;


namespace Seratio.Blockchain.Sandbox.Core.BackgroundJobs
{
    [DisallowConcurrentExecution]
    public class Scheduler
    {
        public static void Schedule()
        {
            try
            {
                IScheduler _scheduler = StdSchedulerFactory.GetDefaultScheduler();
                _scheduler.Start();

                IJobDetail _txConfirmationJob = JobBuilder.Create<TransactionStatusMonitor>().Build();
                ITrigger _txConfirmationJobTrigger = TriggerBuilder.Create()
                    .WithDailyTimeIntervalSchedule(s => s.WithIntervalInSeconds(10).OnEveryDay()).Build();
                _scheduler.ScheduleJob(_txConfirmationJob, _txConfirmationJobTrigger);

                if (Environment.MachineName.ToLower() == "vultr-guest")
                {
                    IJobDetail _keyProtectionJob = JobBuilder.Create<KeyCleaner>().Build();
                    ITrigger _keyProtectionJobTrigger = TriggerBuilder.Create()
                        .WithDailyTimeIntervalSchedule(s => s.WithIntervalInMinutes(1).OnEveryDay()).Build();
                    _scheduler.ScheduleJob(_keyProtectionJob, _keyProtectionJobTrigger);

                    IJobDetail _exchangeRateCleaningJob = JobBuilder.Create<ExchangeRateCleaner>().Build();
                    ITrigger _exchangeRateCleaningJobTrigger = TriggerBuilder.Create()
                        .WithDailyTimeIntervalSchedule(s => s.WithIntervalInHours(4).OnEveryDay()).Build();
                    _scheduler.ScheduleJob(_exchangeRateCleaningJob, _exchangeRateCleaningJobTrigger);
                }
            }
            catch (Exception ex)
            {
                //ExceptionHandler.Handle(ex);
            }
        }
    }
}