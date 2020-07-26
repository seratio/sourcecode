using System;
using System.Collections.Generic;
using System.IO;
using System.Numerics;
using System.Threading.Tasks;
using System.Web.Hosting;
using Nethereum.Contracts;
using Nethereum.Geth;
using Nethereum.Hex.HexTypes;
using Nethereum.RPC.Eth.DTOs;
using Nethereum.StandardTokenEIP20;
using Nethereum.StandardTokenEIP20.Functions;
using Nethereum.Util;
using Nethereum.Web3.Accounts;
//using Nethereum.Web3.TransactionReceipts;
using Newtonsoft.Json;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Entities.Common;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Contract = Nethereum.Contracts.Contract;

namespace Seratio.Blockchain.Sandbox.Core
{
    public class BlockChainManager : IDisposable
    {
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
                ExceptionHandler.Handle(ex);
                return 0;
            }
        }

        public async Task<decimal> GetBalance(string owner)
        {
            try
            {
                HexBigInteger _hexBalance = await Web3Instance.Eth.GetBalance.SendRequestAsync(owner);
                decimal _balance = new UnitConversion().FromWei(_hexBalance.Value);

                return _balance;
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return 0;
            }
        }

        public async Task<decimal> GetBalance(string owner, string spender, int decimals)
        {
            try
            {
                StandardTokenService _tokenService = new StandardTokenService(Web3Instance, spender);
                BigInteger _bigBalance = await _tokenService.GetBalanceOfAsync<BigInteger>(owner);

                decimal _balance = new UnitConversion().FromWei(_bigBalance, decimals);

                return _balance;
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
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

                if (ex.Message != "insufficient funds for gasPrice * price + value")
                {
                    ExceptionHandler.Handle(ex);
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

                if (ex.Message != "insufficient funds for gasPrice * price + value")
                {
                    ExceptionHandler.Handle(ex);
                }
            }

            return _result;
        }

        public async Task<TransactionReceipt> GetTransactionReceipt(string txHash)
        {
            TransactionReceipt _receipt = await Web3Instance.Eth.Transactions.GetTransactionReceipt.SendRequestAsync(txHash);
            return _receipt;
        }

        public async Task<TransferResult> Approve(string owner, string spender, string coin, string abi, decimal amount, int decimalPlaces, int gas)
        {
            TransferResult _result = new TransferResult();

            try
            {
                decimal _multiplier = 10000000;

                if (decimalPlaces == 18)
                {
                    _multiplier = 1000000000000000000;
                }

                Contract _contract = Web3Instance.Eth.GetContract(abi, coin);
                Function _approveFunction = _contract.GetFunction("approve");

                if (_approveFunction != null)
                {
                    TransactionInput _transactionInput = new TransactionInput();
                    _transactionInput.From = owner;
                    _transactionInput.Gas = new HexBigInteger(new BigInteger(300000));
                    _transactionInput.GasPrice =
                        new HexBigInteger(new UnitConversion().ToWei(gas, UnitConversion.EthUnit.Gwei));
                    BigInteger _amount = new BigInteger(amount * _multiplier);

                    string _txHash = await _approveFunction.SendTransactionAsync(_transactionInput, spender, _amount);
                    _result.IsSuccess = true;
                    _result.Receipt = _txHash;
                }
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;
                ExceptionHandler.Handle(ex);
            }

            return _result;
        }

        public async Task<decimal> GetAllowance(string coin, string owner, string spender, int decimals)
        {
            try
            {
                StandardTokenService _tokenService = new StandardTokenService(Web3Instance, coin);
                BigInteger _bigBalance = await _tokenService.GetAllowanceAsync<BigInteger>(owner, spender);

                decimal _balance = new UnitConversion().FromWei(_bigBalance, decimals);

                return _balance;
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }

            return 0;
        }

        public async Task<TransferResult> DepositEtherToVault(string sender, string vaultAddress, string vaultABI, decimal tokenAmount, double seconds, int gasPrice, int gasLimit)
        {
            TransferResult _result = new TransferResult();

            try
            {
                decimal _multiplier = 10000000;

                Contract _contract = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
                Function _depositEthFunction = _contract.GetFunction("depositEtherToVault");

                if (_depositEthFunction != null)
                {
                    TransactionInput _transactionInput = new TransactionInput();
                    _transactionInput.From = sender;
                    _transactionInput.Gas = new HexBigInteger(new BigInteger(gasLimit));
                    _transactionInput.GasPrice = new HexBigInteger(new UnitConversion().ToWei(gasPrice, UnitConversion.EthUnit.Gwei));
                    _transactionInput.Value = new HexBigInteger(new BigInteger(tokenAmount * _multiplier));

                    string _txHash = await _depositEthFunction.SendTransactionAsync(_transactionInput, new BigInteger(seconds));
                    _result.IsSuccess = true;
                    _result.Receipt = _txHash;
                }
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;
                ExceptionHandler.Handle(ex);
            }

            return _result;
        }

        public async Task<TransferResult> DepositToken(string sender, string coin, string vaultAddress, string vaultABI, decimal tokenAmount, int decimalPlaces, int gasPrice, int gasLimit)
        {
            TransferResult _result = new TransferResult();

            try
            {
                decimal _multiplier = 10000000;

                if (decimalPlaces == 18)
                {
                    _multiplier = 1000000000000000000;
                }

                Contract _contract = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
                Function _depositTokenFunction = _contract.GetFunction("depositToken");

                if (_depositTokenFunction != null)
                {
                    TransactionInput _transactionInput = new TransactionInput();
                    _transactionInput.From = sender;
                    _transactionInput.Gas = new HexBigInteger(new BigInteger(gasLimit));
                    _transactionInput.GasPrice = new HexBigInteger(new UnitConversion().ToWei(gasPrice, UnitConversion.EthUnit.Gwei));
                    BigInteger _amount = new BigInteger(tokenAmount * _multiplier);

                    string _txHash = await _depositTokenFunction.SendTransactionAsync(_transactionInput, coin, _amount);
                    _result.IsSuccess = true;
                    _result.Receipt = _txHash;
                }
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;
                ExceptionHandler.Handle(ex);
            }

            return _result;
        }

        public async Task<TransferResult> DepositTokenWithTime(string sender, string coin, string vaultAddress, string vaultABI, decimal tokenAmount, int decimalPlaces, double seconds, int gasPrice, int gasLimit)
        {
            TransferResult _result = new TransferResult();

            try
            {
                decimal _multiplier = 10000000;

                if (decimalPlaces == 18)
                {
                    _multiplier = 1000000000000000000;
                }

                Contract _contract = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
                Function _depositTokenFunction = _contract.GetFunction("depositTokenToVault");

                if (_depositTokenFunction != null)
                {
                    TransactionInput _transactionInput = new TransactionInput();
                    _transactionInput.From = sender;
                    _transactionInput.Gas = new HexBigInteger(new BigInteger(gasLimit));
                    _transactionInput.GasPrice = new HexBigInteger(new UnitConversion().ToWei(gasPrice, UnitConversion.EthUnit.Gwei));
                    BigInteger _amount = new BigInteger(tokenAmount * _multiplier);
                    BigInteger _seconds = new BigInteger(seconds);

                    HexBigInteger _nonce = _transactionInput.Nonce;
                    //   _transactionInput.Gas = await _depositTokenFunction.EstimateGasAsync(coin, _amount, _seconds);

                    string _txHash = await _depositTokenFunction.SendTransactionAsync(_transactionInput, coin, _amount, _seconds);
                    _result.IsSuccess = true;
                    _result.Receipt = _txHash;
                }
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;
                ExceptionHandler.Handle(ex);
            }

            return _result;
        }

        //public async Task<decimal> GetLockedDepositValue(string sender, string coin, string vaultAddress, string vaultABI, int decimals)
        //{
        //    TransferResult _result = new TransferResult();

        //    try
        //    {
        //        Contract _contract = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
        //        Function _tokenFunction = _contract.GetFunction("getLockedValue");

        //        if (_tokenFunction != null)
        //        {
        //            BigInteger _lockedValue = await _tokenFunction.CallAsync<BigInteger>(sender, null, null, string.IsNullOrEmpty(coin) ? "0" : coin);
        //            decimal _amount = new UnitConversion().FromWei(_lockedValue, decimals);
        //            return _amount;
        //        }
        //    }
        //    catch (Exception ex)
        //    {
        //        _result.Message = ex.Message;
        //        ExceptionHandler.Handle(ex);
        //    }

        //    return 0;
        //}

        //public async Task<decimal> GetTotalDepositValue(string sender, string coin, string vaultAddress, string vaultABI, int decimals)
        //{
        //    TransferResult _result = new TransferResult();

        //    try
        //    {
        //        Contract _contract = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
        //        Function _balanceOfFunction = _contract.GetFunction("balanceOf");

        //        if (_balanceOfFunction != null)
        //        {
        //            BigInteger _balance = await _balanceOfFunction.CallAsync<BigInteger>(string.IsNullOrEmpty(coin) ? "0" : coin, sender);
        //            decimal _amount = new UnitConversion().FromWei(_balance, decimals);
        //            return _amount;
        //        }
        //    }
        //    catch (Exception ex)
        //    {
        //        _result.Message = ex.Message;
        //        ExceptionHandler.Handle(ex);
        //    }

        //    return 0;
        //}

        public async Task<TransferResult> ClaimPartialDeposits(string sender, string coin, string vaultAddress, string vaultABI, decimal tokenAmount, int decimalPlaces, int gasPrice, int gasLimit)
        {
            TransferResult _result = new TransferResult();

            try
            {
                decimal _multiplier = 10000000;

                if (decimalPlaces == 18)
                {
                    _multiplier = 1000000000000000000;
                }

                Contract _contract = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
                Function _partialClaimFunction = _contract.GetFunction("partialClaim");

                if (_partialClaimFunction != null)
                {
                    TransactionInput _transactionInput = new TransactionInput();
                    _transactionInput.From = sender;
                    _transactionInput.Gas = new HexBigInteger(new BigInteger(gasLimit));
                    _transactionInput.GasPrice = new HexBigInteger(new UnitConversion().ToWei(gasPrice, UnitConversion.EthUnit.Gwei));
                    BigInteger _amount = new BigInteger(tokenAmount * _multiplier);

                    string _txHash = await _partialClaimFunction.SendTransactionAsync(_transactionInput, string.IsNullOrEmpty(coin) ? "0" : coin, _amount);
                    _result.IsSuccess = true;
                    _result.Receipt = _txHash;
                }
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;
                ExceptionHandler.Handle(ex);
            }

            return _result;
        }

        public async Task<TransferResult> ClaimDeposits(string sender, string coin, string vaultAddress, string vaultABI, int gasPrice, int gasLimit)
        {
            TransferResult _result = new TransferResult();

            try
            {
                Contract _contract = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
                Function _partialClaimFunction = _contract.GetFunction("claim");

                if (_partialClaimFunction != null)
                {
                    TransactionInput _transactionInput = new TransactionInput();
                    _transactionInput.From = sender;
                    _transactionInput.Gas = new HexBigInteger(new BigInteger(gasLimit));
                    _transactionInput.GasPrice = new HexBigInteger(new UnitConversion().ToWei(gasPrice, UnitConversion.EthUnit.Gwei));

                    string _txHash = await _partialClaimFunction.SendTransactionAsync(_transactionInput, string.IsNullOrEmpty(coin) ? "0" : coin);
                    _result.IsSuccess = true;
                    _result.Receipt = _txHash;
                }
            }
            catch (Exception ex)
            {
                _result.Message = ex.Message;
                ExceptionHandler.Handle(ex);
            }

            return _result;
        }

        public async Task<List<VaultInvestment>> GetPendingInvestmentsFromVault(string sender, string vaultAddress, string vaultABI)
        {
            try
            {
                Contract _vaultContractAddress = Web3Instance.Eth.GetContract(vaultABI, vaultAddress);
                Function _getInvestmentRecordsListAddressFunction = _vaultContractAddress.GetFunction("pendingInvestments");

                if (_getInvestmentRecordsListAddressFunction != null)
                {
                    string _investmentRecordsListAddress = await _getInvestmentRecordsListAddressFunction.CallAsync<string>(sender);
                    string _investmentRecordListContractABI = File.ReadAllText(HostingEnvironment.MapPath("/wallet/abi/InvestmentRecordListABI.json"));
                    string _investmentRecordABI = File.ReadAllText(HostingEnvironment.MapPath("/wallet/abi/InvestmentRecordABI.json"));

                    Contract _investmentRecordListContract = Web3Instance.Eth.GetContract(_investmentRecordListContractABI, _investmentRecordsListAddress);

                    if (_investmentRecordListContract != null)
                    {
                        Function _getInvestmentRecordListLengthFunction = _investmentRecordListContract.GetFunction("getInvestmentRecordListLength");
                        Function _getInvestmentRecordFunction = _investmentRecordListContract.GetFunction("getInvestmentRecord");

                        if (_getInvestmentRecordListLengthFunction != null)
                        {
                            BigInteger _investmentsCount =
                                await _getInvestmentRecordListLengthFunction.CallAsync<BigInteger>();

                            BigInteger i = 0;

                            List<VaultInvestment> _investments = new List<VaultInvestment>();

                            while (i < _investmentsCount)
                            {
                                string _investmentRecordContractAddress = await _getInvestmentRecordFunction.CallAsync<string>(i);
                                Contract _investmentRecordContract = Web3Instance.Eth.GetContract(_investmentRecordABI, _investmentRecordContractAddress);

                                Function _tokenFunction = _investmentRecordContract.GetFunction("token");
                                Function _timeStampFunction = _investmentRecordContract.GetFunction("timeStamp");
                                Function _lockPeriodFunction = _investmentRecordContract.GetFunction("lockPeriod");
                                Function _valueFunction = _investmentRecordContract.GetFunction("value");
                                Function _expiredLockPeriodFunction = _investmentRecordContract.GetFunction("expiredLockPeriod");

                                VaultInvestment _investment = new VaultInvestment();

                                Task<string> _tokenTask = _tokenFunction.CallAsync<string>();
                                Task<BigInteger> _timeStampTask = _timeStampFunction.CallAsync<BigInteger>();
                                Task<BigInteger> _lockPeriodTask = _lockPeriodFunction.CallAsync<BigInteger>();
                                Task<BigInteger> _valueTask = _valueFunction.CallAsync<BigInteger>();
                                Task<bool> _hasExpiredTask = _expiredLockPeriodFunction.CallAsync<bool>();

                                await Task.WhenAll(_tokenTask, _timeStampTask, _lockPeriodTask, _valueTask, _hasExpiredTask);

                                _investment.Token = await _tokenTask;
                                _investment.Timestamp = (double)await _timeStampTask;
                                _investment.LockPeriod = (double)await _lockPeriodTask;
                                _investment.Amount = new UnitConversion().FromWei(await _valueTask, 7);
                                _investment.HasExpired = await _hasExpiredTask;

                                _investments.Add(_investment);

                                i++;
                            }

                            return _investments;
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
            }

            return new List<VaultInvestment>();
        }

        public void Dispose()
        {
            GC.SuppressFinalize(this);
        }
    }
}