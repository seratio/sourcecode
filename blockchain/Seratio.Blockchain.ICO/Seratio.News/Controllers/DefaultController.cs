using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Threading.Tasks;
using System.Web;
using System.Web.Mvc;
using Seratio.News.Models;

namespace Seratio.News.Controllers
{
    public class DefaultController : Controller
    {
        protected NewsDatabaseEntities db = new NewsDatabaseEntities();

        public async Task<ActionResult> Index(string handle)
        {
            var _query = from t in db.Tweets
                         select t;

            if (!string.IsNullOrEmpty(handle))
            {
                TwitterAccount _account = await db.TwitterAccounts.FirstOrDefaultAsync(a => a.Handle == handle);

                if (_account != null)
                {
                    ViewBag.Account = _account;
                    _query = _query.Where(t => t.AccountID == _account.ID);
                }
            }

            return View(await _query.OrderByDescending(t => t.Time).ToListAsync());
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }

            base.Dispose(disposing);
        }
    }
}