using System;
using System.Numerics;
using System.Threading.Tasks;
using Nethereum.Geth;
using Nethereum.Hex.HexTypes;
using Nethereum.RPC.Eth.DTOs;
using Nethereum.StandardTokenEIP20;
using Nethereum.StandardTokenEIP20.Functions;
using Nethereum.Util;
using Nethereum.Web3.Accounts;
//using Nethereum.Web3.TransactionReceipts;
using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Utilities;

namespace Seratio.Blockchain.Sandbox.Core
{
    public class BlockChainManager : IDisposable
    {
        const int Multiplier = 10000000;

        protected Web3Geth Web3Instance { get; set; }

        public BlockChainManager(string endpoint, int gas = 40)
        {
            Web3Instance = new Web3Geth(endpoint);
            Web3Instance.TransactionManager.DefaultGasPrice = new UnitConversion().ToWei(gas, UnitConversion.EthUnit.Gwei);
        }

        public BlockChainManager(Account account, string endpoint, int gas = 40)
        {
            Web3Instance = new Web3Geth(account, endpoint);
            Web3Instance.TransactionManager.DefaultGasPrice = new UnitConversion().ToWei(gas, UnitConversion.EthUnit.Gwei);
        }

        public async Task<string> GetNodeInfo()
        {
            return JsonConvert.SerializeObject(await Web3Instance.Admin.NodeInfo.SendRequestAsync(), Formatting.Indented);
        }

        public async Task<string> GetPeers()
        {
            return JsonConvert.SerializeObject(await Web3Instance.Admin.Peers.SendRequestAsync(), Formatting.Indented);
        }

        public async Task<string[]> ListWallets()
        {
            return await Web3Instance.Personal.ListAccounts.SendRequestAsync();
        }

        public async Task<decimal> GetGasPriceAsync()
        {
            try
            {
                HexBigInteger _hexGasPrice = await Web3Instance.Eth.GasPrice.SendRequestAsync();
                decimal _result = new UnitConversion().FromWei(_hexGasPrice, UnitConversion.EthUnit.Gwei);

                return _result;
            }
            catch (Exception ex)
            {
                //ExceptionHandler.Handle(ex);
                return 0;
            }
        }

        public async Task<decimal> GetBalance(string address)
        {
            try
            {
                HexBigInteger _hexBalance = await Web3Instance.Eth.GetBalance.SendRequestAsync(address);
                decimal _balance = new UnitConversion().FromWei(_hexBalance.Value);

                return _balance;
            }
            catch (Exception ex)
            {
                //ExceptionHandler.Handle(ex);
                return 0;
            }
        }

        public async Task<decimal> GetBalance(string address, string coin, int decimals)
        {
            try
            {
                StandardTokenService _tokenService = new StandardTokenService(Web3Instance, coin);
                BigInteger _bigBalance = await _tokenService.GetBalanceOfAsync<BigInteger>(address);

                decimal _balance = new UnitConversion().FromWei(_bigBalance, decimals);

                return _balance;
            }
            catch (Exception ex)
            {
                //ExceptionHandler.Handle(ex);
            }

            return 0;
        }

        public decimal ToDecimal(BigInteger value)
        {
            return new UnitConversion().FromWei(value, 7);
        }

        public async Task<TransferResult> TransferCoinAsync(string from, string to, decimal amount)
        {
            TransferResult _result = new TransferResult();

            try
            {
                string _transactionHash = await Web3Instance.TransactionManager.SendTransactionAsync(from, to, new HexBigInteger(new UnitConversion().ToWei(amount)));
                _result.IsSuccess = true;
                _result.Receipt = _transactionHash;
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;

                if (ex.Message != "insufficient funds for gas * price + value")
                {
                    //ExceptionHandler.Handle(ex);
                }
            }

            return _result;
        }

        public async Task<TransferResult> TransferCoinAsync(string from, string recipient, decimal amount, int decimalPlaces, string coinAddress, int gas)
        {
            TransferResult _result = new TransferResult();

            try
            {
                StandardTokenService _standardTokenService = new StandardTokenService(Web3Instance, coinAddress);
                TransferFunction _transferFunction = new TransferFunction();
                _transferFunction.To = recipient;
                _transferFunction.FromAddress = from;

                decimal _multiplier = 10000000;

                if (decimalPlaces == 18)
                {
                    _multiplier = 1000000000000000000;
                }

                _transferFunction.TokenAmount = new BigInteger(amount * _multiplier);
                _transferFunction.Gas = new BigInteger(55000);
                _transferFunction.GasPrice = new UnitConversion().ToWei(gas, UnitConversion.EthUnit.Gwei);

                string _transactionHash = await _standardTokenService.TransferAsync(_transferFunction);

                _result.IsSuccess = true;
                _result.Receipt = _transactionHash;
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;

                if (ex.Message != "insufficient funds for gas * price + value")
                {
                    //ExceptionHandler.Handle(ex);
                }
            }

            return _result;
        }

        public async Task<TransactionReceipt> GetTransactionReceipt(string txHash)
        {
            TransactionReceipt _receipt = await Web3Instance.Eth.Transactions.GetTransactionReceipt.SendRequestAsync(txHash);
            return _receipt;
        }

        public void Dispose()
        {
            GC.SuppressFinalize(this);
        }
    }
}