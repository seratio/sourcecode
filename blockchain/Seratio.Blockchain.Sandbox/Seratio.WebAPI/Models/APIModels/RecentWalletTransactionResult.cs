﻿using Seratio.Blockchain.Sandbox.Models;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Seratio.WebAPI.Models.APIModels
{
    public class RecentWalletTransactionResult : ResultSet
    {
        public List<WalletTransaction> WalletTransactions { get; set; }
    }
}