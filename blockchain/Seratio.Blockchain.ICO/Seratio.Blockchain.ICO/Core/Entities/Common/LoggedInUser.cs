using System;

namespace Seratio.Platform.ICO.Core.Entities.Common
{
    public class LoggedInUser
    {
        public string FirstName { get; set; }

        public string LastName { get; set; }

        public string Email { get; set; }

        public int ID { get; set; }

        public int SessionID { get; set; }

        public Guid Token { get; set; }

        public bool IsEmailverified { get; set; }

        public string ICOType { get; set; }

    }
}