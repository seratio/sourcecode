using System;

namespace Seratio.Platform.ICO.Core.Entities.Common
{
    public class AppUser
    {
        public string Username { get; set; }

        public string Name { get; set; }

        public string Email { get; set; }

        public int ID { get; set; }

        public int SessionID { get; set; }

        public Guid Token { get; set; }

        public bool IsSuperAdmin { get; set; }

        public string Photo { get; set; }

        public string UserAgent { get; set; }

        public string IPAddress { get; set; }

    }
}