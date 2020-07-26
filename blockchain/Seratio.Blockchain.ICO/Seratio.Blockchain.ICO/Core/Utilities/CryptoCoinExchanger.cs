using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net.Http;
using Newtonsoft.Json;
using Quartz;
using Seratio.Platform.ICO.Core.Entities.CryptoCoinResponse;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Core.Utilities
{
    public class CryptoCoinExchanger : IJob
    {
        public async void Execute(IJobExecutionContext context)
        {
            try
            {
                using (var db = new DatabaseEntities())
                {
                    bool _allowAutomaticSync = !await db.Settings.AnyAsync() || await db.Settings
                                                   .Select(i => i.AllowAutomaticExchangeRateSyncing).FirstOrDefaultAsync();

                    List<string> _coins = new List<string>();
                    _coins.Add("etc");
                    _coins.Add("btc");
                    _coins.Add("eth");
                    _coins.Add("ltc");

                    if (_allowAutomaticSync)
                    {
                        foreach (string _coin in _coins)
                        {
                            try
                            {
                                ExchangeRate _rate = new ExchangeRate();

                                string _responseString =
                                    await new HttpClient().GetStringAsync(
                                        $"https://api.cryptonator.com/api/ticker/{_coin}-gbp");
                                CryptocoinResponseObj.Rootobject _responseObject = JsonConvert.DeserializeObject<CryptocoinResponseObj.Rootobject>(_responseString);

                                if (_responseObject != null)
                                {
                                    _rate.From = _coin.ToUpper();
                                    _rate.To = _responseObject.ticker.target;
                                    _rate.ExchangePrice = Math.Round(decimal.Parse(_responseObject.ticker.price), 7,
                                        MidpointRounding.AwayFromZero).ToString();
                                    _rate.Time = DateTime.Now;

                                    db.ExchangeRates.Add(_rate);
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
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }
        }
    }
}