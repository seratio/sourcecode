using System;
using System.ComponentModel.DataAnnotations;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;

namespace Seratio.Blockchain.Sandbox.Models
{
    public class BlockchainMetaData
    {
        [Display(Name = "Name")]
        [Required(ErrorMessage = "Please enter a value for Name")]
        [MaxLength(100, ErrorMessage = "Name should not have more than 100 characters")]
        public string Name { get; set; }

        [Display(Name = "Host")]
        [Required(ErrorMessage = "Please enter a value for Host")]
        [MaxLength(100, ErrorMessage = "Host should not have more than 100 characters")]
        public string Host { get; set; }

        //[Display(Name = "RPC Port")]
        //[Required(ErrorMessage = "Please enter a value for R P C Port")]
        //[MaxLength(100, ErrorMessage = "R P C Port should not have more than 100 characters")]
        //public string RPCPort { get; set; }

        [Display(Name = "Is Active?")]
        public bool IsActive { get; set; }

        [Display(Name = "Comments")]
        [MaxLength(4000, ErrorMessage = "Comments should not have more than 4000 characters")]
        public string Comments { get; set; }

        [Display(Name = "Is Primary Node?")]
        public bool IsPrimaryNode { get; set; }

        [Display(Name = "Created On")]
        public DateTime CreatedOn { get; set; }

        [Display(Name = "Last Updated On")]
        public DateTime LastUpdatedOn { get; set; }

        [Display(Name = "Deleted On")]
        public DateTime? DeletedOn { get; set; }
    }

    [MetadataType(typeof(BlockchainMetaData))]
    public partial class Blockchain
    {
        public Select2Item SelectedUser { get; set; }
    }
}
