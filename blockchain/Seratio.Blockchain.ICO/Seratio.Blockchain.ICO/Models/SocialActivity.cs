//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace Seratio.Platform.ICO.Models
{
    using System;
    using System.Collections.Generic;
    
    public partial class SocialActivity
    {
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2214:DoNotCallOverridableMethodsInConstructors")]
        public SocialActivity()
        {
            this.AcceptedSocialActivities = new HashSet<AcceptedSocialActivity>();
        }
    
        public int ID { get; set; }
        public int UserID { get; set; }
        public int RewardingCoinID { get; set; }
        public Nullable<int> ProcessedBy { get; set; }
        public string Name { get; set; }
        public string Description { get; set; }
        public decimal RewardAmount { get; set; }
        public Nullable<bool> IsApproved { get; set; }
        public Nullable<System.DateTime> ApprovedOn { get; set; }
        public Nullable<System.DateTime> RejectedOn { get; set; }
        public System.DateTime CreatedOn { get; set; }
        public System.DateTime LastUpdatedOn { get; set; }
        public Nullable<System.DateTime> DeletedOn { get; set; }
        public bool IsDataActive { get; set; }
    
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<AcceptedSocialActivity> AcceptedSocialActivities { get; set; }
        public virtual Coin Coin { get; set; }
        public virtual User User { get; set; }
        public virtual User User1 { get; set; }
    }
}