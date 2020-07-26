namespace Seratio.Blockchain.Sandbox.Core.Entities.Blockchain
{
    public class WalletInfo
    {
        public string Address { get; set; }

        public string UnencryptedPrivateKey { get; set; }

        public string EncryptedPrivateKeyFile { get; set; }
    }
}