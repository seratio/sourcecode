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
    
    public partial class AcceptedSocialActivity
    {
        public int ID { get; set; }
        public int UserID { get; set; }
        public int ActivityID { get; set; }
        public int RewardedCoinID { get; set; }
        public decimal RewardedAmount { get; set; }
        public string Description { get; set; }
        public System.DateTime CreatedOn { get; set; }
        public System.DateTime LastUpdatedOn { get; set; }
        public Nullable<System.DateTime> DeletedOn { get; set; }
        public bool IsDataActive { get; set; }
    
        public virtual SocialActivity SocialActivity { get; set; }
        public virtual User User { get; set; }
        public virtual Coin Coin { get; set; }
    }
}