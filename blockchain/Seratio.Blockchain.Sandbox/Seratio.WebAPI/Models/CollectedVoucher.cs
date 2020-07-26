//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace Seratio.Blockchain.Sandbox.Models
{
    using System;
    using System.Collections.Generic;
    
    public partial class CollectedVoucher
    {
        public int ID { get; set; }
        public int UserID { get; set; }
        public int PolicyID { get; set; }
        public Nullable<int> WalletTransactionID { get; set; }
        public System.DateTime Time { get; set; }
        public bool HasRedeemed { get; set; }
        public Nullable<System.DateTime> RedeemedOn { get; set; }
        public string Feedback { get; set; }
        public Nullable<System.DateTime> FeedbackDate { get; set; }
    
        public virtual RetailPolicy RetailPolicy { get; set; }
        public virtual User User { get; set; }
        public virtual WalletTransaction WalletTransaction { get; set; }
    }
}