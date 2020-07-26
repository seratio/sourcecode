using Seratio.Platform.ICO.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.Platform.ICO.Core.Entities.Common
{
    public class DatabaseContextManager
    {
        public static DatabaseEntities Current
        {
            get
            {
                try
                {
                    string _key = "DATABSE@" + HttpContext.Current.GetHashCode().ToString("x") + System.Threading.Thread.CurrentContext.ContextID.ToString();
                    DatabaseEntities _context = HttpContext.Current.Items[_key] as DatabaseEntities;

                    if (_context == null)
                    {
                        _context = new DatabaseEntities();
                        HttpContext.Current.Items[_key] = _context;
                    }

                    return _context;
                }
                catch
                {
                    return new DatabaseEntities();
                }
            }
        }
    }
}