using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class AccountListResult : ResultSet
    {
        public List<AccountModel> AccountModels { get; set; }
    }
}