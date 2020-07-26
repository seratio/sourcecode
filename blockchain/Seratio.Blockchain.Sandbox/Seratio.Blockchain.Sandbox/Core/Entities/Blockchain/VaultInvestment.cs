namespace Seratio.Blockchain.Sandbox.Core.Entities.Blockchain
{
    public class VaultInvestment
    {
        public string Token { get; set; }

        public double Timestamp { get; set; }

        public double LockPeriod { get; set; }

        public bool HasExpired { get; set; }

        public decimal Amount { get; set; }
    }
}