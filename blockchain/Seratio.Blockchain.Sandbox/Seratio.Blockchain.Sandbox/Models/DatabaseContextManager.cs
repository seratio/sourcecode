using System.Threading;
using System.Web;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class DatabaseContextManager
    {
        public static PlatformDatabaseEntities Current
        {
            get
            {
                try
                {
                    string _key = "DATABSE@" + HttpContext.Current.GetHashCode().ToString("x") + Thread.CurrentContext.ContextID.ToString();
                    PlatformDatabaseEntities _context = HttpContext.Current.Items[_key] as PlatformDatabaseEntities;

                    if (_context == null)
                    {
                        _context = new PlatformDatabaseEntities();
                        HttpContext.Current.Items[_key] = _context;
                    }

                    return _context;
                }
                catch
                {
                    return new PlatformDatabaseEntities();
                }
            }
        }
    }
}