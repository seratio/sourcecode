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
    
    public partial class Offer
    {
        public int ID { get; set; }
        public int CreatedByID { get; set; }
        public int LastUpdatedByID { get; set; }
        public string Title { get; set; }
        public int Discount { get; set; }
        public System.DateTime LastDate { get; set; }
        public System.DateTime CreatedOn { get; set; }
        public System.DateTime LastUpdatedOn { get; set; }
        public Nullable<System.DateTime> DeletedOn { get; set; }
        public bool IsDataActive { get; set; }
    
        public virtual Administrator Administrator { get; set; }
        public virtual Administrator Administrator1 { get; set; }
    }
}