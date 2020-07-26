using System;
using System.IO;
using System.Numerics;
using Nethereum.Contracts;
using Nethereum.Hex.HexTypes;
using Nethereum.KeyStore;
using Nethereum.Util;
using Nethereum.Web3;
using Nethereum.Web3.Accounts;

namespace Seratio.Blockchain.Sandbox.Core
{
    public sealed class MintingManager
    {
        private string ABI = File.ReadAllText("abi.json");
        private string Contract = "0x48EB12C0DDc5163E8693F3029A14440442Df2710";
        private int Multiplier = 10000000;

        public async void Mint()
        {
            try
            {
                string _encryptedJson =
                    File.ReadAllText("UTC--2017-08-26T15-24-18.837084800Z--d1900da6020324e24327c7b5b16526f201929fe3");
                byte[] _privateKeyBytes =
                    new KeyStoreService().DecryptKeyStoreFromJson("DeploymentForSeratio", _encryptedJson);
                Account _account = new Account(_privateKeyBytes);
                Web3 _web3 = new Web3(_account, "http://35.205.45.88/eth-api/");
                Contract _contract = _web3.Eth.GetContract(ABI, Contract);
                Function _mintFunction = _contract.GetFunction("mint");

                if (_mintFunction != null)
                {
                    string _receipient = "0xEAabdfD8E348488EF02215b03888a10d5cDb2635";
                    HexBigInteger _hexBalance = await _web3.Eth.GetBalance.SendRequestAsync(_account.Address);
                    decimal _balance = new UnitConversion().FromWei(_hexBalance.Value);
                    // HexBigInteger gas = await _mintFunction.EstimateGasAsync(_receipient, 100);
                    // TransactionReceipt _receipt = await _mintFunction.SendTransactionAndWaitForReceiptAsync(_receipient, null, 100);
                    string _txHash = await _mintFunction.SendTransactionAsync(_account.Address, new HexBigInteger(new BigInteger(39000)), null, _receipient, 100 * Multiplier);
                }
            }
            catch (Exception ex)
            {

            }
        }
    }
}