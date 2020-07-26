using NBitcoin;

namespace Seratio.Blockchain.Sandbox.Core.Blockchain
{
    public class SecureRandom : IRandom
    {
        static readonly Org.BouncyCastle.Security.SecureRandom SecureRandomInstance = new Org.BouncyCastle.Security.SecureRandom();

        public void GetBytes(byte[] output)
        {
            SecureRandomInstance.NextBytes(output);
        }
    }
}