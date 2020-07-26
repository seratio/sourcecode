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
    
    public partial class WalletTransaction
    {
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2214:DoNotCallOverridableMethodsInConstructors")]
        public WalletTransaction()
        {
            this.CollectedVouchers = new HashSet<CollectedVoucher>();
            this.PaymentRequests = new HashSet<PaymentRequest>();
            this.MCRTransfers = new HashSet<MCRTransfer>();
        }
    
        public int ID { get; set; }
        public int UserID { get; set; }
        public int CoinID { get; set; }
        public Nullable<System.Guid> TransactionID { get; set; }
        public string Recipient { get; set; }
        public decimal Amount { get; set; }
        public string Type { get; set; }
        public string TransactionHash { get; set; }
        public Nullable<int> SessionID { get; set; }
        public string TransactionIndex { get; set; }
        public string BlockHash { get; set; }
        public string BlockNumber { get; set; }
        public string CumulativeGasUsed { get; set; }
        public string GasUsed { get; set; }
        public string Logs { get; set; }
        public System.DateTime Time { get; set; }
        public Nullable<bool> IsSyncedFromEthplorer { get; set; }
        public System.DateTime LastUpdatedOn { get; set; }
    
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<CollectedVoucher> CollectedVouchers { get; set; }
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<PaymentRequest> PaymentRequests { get; set; }
        public virtual User User { get; set; }
        public virtual Coin Coin { get; set; }
        [System.Diagnostics.CodeAnalysis.SuppressMessage("Microsoft.Usage", "CA2227:CollectionPropertiesShouldBeReadOnly")]
        public virtual ICollection<MCRTransfer> MCRTransfers { get; set; }
    }
}