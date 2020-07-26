using System.IO;
using System.Linq;
using System.Web.Hosting;
using NBitcoin;
using Nethereum.KeyStore;
using Nethereum.Signer;
using Seratio.Blockchain.Sandbox.Core.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;

namespace Seratio.Blockchain.Sandbox.Core
{
    public class WalletManager
    {
        static string Seed = "bewithme";

        public static Wallet CreateWallet()
        {
            return new Wallet(Wordlist.English, WordCount.Twelve, Seed);
        }

        public static Wallet RetrieveWallet(string words)
        {
            return new Wallet(words, Seed);
        }

        public static WalletInfo GetProtectedWalletInfo(Wallet wallet, string password)
        {
            EthECKey _ethEcKey = wallet.GetEthereumKey(0);
            KeyStoreService _service = new KeyStoreService();
            byte[] _privateKey = _ethEcKey.GetPrivateKeyAsBytes();
            string _address = _ethEcKey.GetPublicAddress();

            if (_privateKey.Length > 32)
            {
                _privateKey = _privateKey.Skip(1).ToArray();
            }

            KeyStorePbkdf2Service _pbkdf2Service = new KeyStorePbkdf2Service();
            string _pkbdf2Result = _pbkdf2Service.EncryptAndGenerateKeyStoreAsJson(password, _privateKey, _address);
            string _fileName = _service.GenerateUTCFileName(_address);
            using (StreamWriter _streamWriter = File.CreateText(HostingEnvironment.MapPath($"/wallet/keys/{_fileName}")))
            {
                _streamWriter.Write(_pkbdf2Result);
                _streamWriter.Flush();
            }

            return new WalletInfo
            {
                Address = _address,
                EncryptedPrivateKeyFile = _fileName,
                UnencryptedPrivateKey = _ethEcKey.GetPrivateKey()
            };
        }
    }
}