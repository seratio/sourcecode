using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net.Http;
using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using Quartz;
using Seratio.Platform.ICO.Core.Entities.API;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Core.Utilities
{
    public class FIATFxRateUpdater : IJob
    {
        public async void Execute(IJobExecutionContext context)
        {
            try
            {
                using (var db = new DatabaseEntities())
                {
                    bool _allowAutomaticSync = !await db.Settings.AnyAsync() || await db.Settings.Select(i => i.AllowAutomaticExchangeRateSyncing).FirstOrDefaultAsync();

                    if (_allowAutomaticSync)
                    {
                        List<string> _coinArray = new List<string> { "EUR", "USD", "JPY", "AUD", "CAD", "CHF", "CNY", "SEK", "NZD", "MXN", "SGD", "HKD", "NOK", "KRW", "TRY", "RUB", "INR", "BRL", "ZAR" };

                        foreach (string _fiat in _coinArray)
                        {
                            try
                            {
                                string _apiUrl = $"http://apilayer.net/api/live?access_key=1677e583a0225849c9cf9ea1e823af3f&currencies=GBP&source={_fiat}&format=1";
                                string _responseString = await new HttpClient().GetStringAsync(_apiUrl);

                                if (!string.IsNullOrEmpty(_responseString))
                                {
                                    JObject _response = JObject.Parse(_responseString);

                                    if ((bool)_response["success"])
                                    {
                                        if (_response["quotes"] != null)
                                        {
                                            float _value =
                                                float.Parse((string)_response["quotes"][$"{_fiat}GBP"]);

                                            ExchangeRate _exchangeRate = new ExchangeRate();

                                            _exchangeRate.From = _fiat;
                                            _exchangeRate.To = "GBP";
                                            _exchangeRate.ExchangePrice = Math.Round(_value, 7,
                                                MidpointRounding.AwayFromZero).ToString();
                                            _exchangeRate.Time = DateTime.Now;

                                            db.ExchangeRates.Add(_exchangeRate);
                                            await db.SaveChangesAsync();
                                        }
                                    }
                                }
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

        public static object GetPropValue(object src, string propName)
        {
            return src.GetType().GetProperty(propName).GetValue(src, null);
        }
    }
}