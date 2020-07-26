using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Threading.Tasks;
using System.Web;
using System.Web.Mvc;
using Seratio.Platform.ICO.Controllers;
using Seratio.Platform.ICO.Core.Entities.Common;
using Seratio.Platform.ICO.Models;

namespace Seratio.Platform.ICO.Areas.L0C5A3E8915871B710C2CC98073748424.Controllers
{
    public class SettingsController : BackendBaseController
    {
        public async Task<ActionResult> Index()
        {
            var model = await db.Settings.FirstOrDefaultAsync();

            return View(model);
        }

        [HttpPost]
        [ValidateInput(false)]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Index(Setting model, HttpPostedFileBase General_SiteLogo)
        {
            if (ModelState.IsValid)
            {
                string _fileName = null;

                Setting _setting = await db.Settings.FirstOrDefaultAsync();

                if (_setting != null)
                {
                    _setting.AllowAutomaticExchangeRateSyncing = model.AllowAutomaticExchangeRateSyncing;
                    await db.SaveChangesAsync();
                }
                else
                {
                    _setting = new Setting();
                    _setting.AllowAutomaticExchangeRateSyncing = model.AllowAutomaticExchangeRateSyncing;

                    db.Settings.Add(_setting);
                    await db.SaveChangesAsync();
                }

                TempData["Notification"] = new Notification("Success", "Settings has been saved successfully.");
                return RedirectToAction("Index");
            }
            TempData["Notification"] = new Notification("Error", "One or more fields are missing or contains invalid value. Please try again later.");
            return View(model);
        }

        public async Task<ActionResult> Update()
        {
            string[] _coinArray = new String[24] { "ETC", "BTC", "ETH", "LTC", "EUR", "USD", "GBP", "JPY", "AUD", "CAD", "CHF", "CNY", "SEK", "NZD", "MXN", "SGD", "HKD", "NOK", "KRW", "TRY", "RUB", "INR", "BRL", "ZAR" };
            ViewBag.Coins = _coinArray.ToList();
            return View();
        }

        [HttpPost]
        [ValidateInput(false)]
        [ValidateAntiForgeryToken]
        public async Task<ActionResult> Update(List<ExchangeRate> model)
        {
            try
            {
                foreach (ExchangeRate _item in model)
                {
                    ExchangeRate _exchangeRate = new ExchangeRate();

                    _exchangeRate.From = _item.From;
                    _exchangeRate.To = "GBP";
                    _exchangeRate.ExchangePrice = _item.ExchangePrice;
                    _exchangeRate.Time = DateTime.Now;

                    db.ExchangeRates.Add(_exchangeRate);
                    await db.SaveChangesAsync();
                }

                TempData["Notification"] = new Notification("Success", "Currency Exchange Rates has been updated successfully.");
                return RedirectToAction("dashboard", "default");
            }
            catch (Exception ex)
            {
                TempData["Notification"] = new Notification("Error", "One or more fields are missing or contains invalid value. Please try again later.");
                return RedirectToAction("Update");
            }

        }
    }
}

