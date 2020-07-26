using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Web;
using Quartz;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Core.BackgroundJobs
{
    [DisallowConcurrentExecution]
    public class ExchangeRateCleaner : IJob
    {
        public async void Execute(IJobExecutionContext context)
        {
            try
            {
                using (PlatformDatabaseEntities db = new PlatformDatabaseEntities())
                {
                    DateTime _fiveDaysAgo = DateTime.Today.AddDays(-5);

                    List<ExchangeRate> _exchangeRates =
                        await db.ExchangeRates.Where(e => e.Time <= _fiveDaysAgo).ToListAsync();

                    foreach (ExchangeRate _exchangeRate in _exchangeRates)
                    {
                        db.ExchangeRates.Remove(_exchangeRate);
                        await db.SaveChangesAsync();
                    }
                }
            }
            catch (Exception ex)
            {
                //ExceptionHandler.Handle(ex);
            }
        }
    }
}