namespace Seratio.Blockchain.Sandbox.Core.Entities.Common
{
    public class TransferResult
    {
        public bool IsSuccess { get; set; }

        // public TransactionReceipt Receipt { get; set; }

        public string Receipt { get; set; }

        public string Message { get; set; }
    }
}