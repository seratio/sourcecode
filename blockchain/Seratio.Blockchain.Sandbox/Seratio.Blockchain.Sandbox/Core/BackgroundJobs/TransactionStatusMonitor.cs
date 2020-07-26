using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Net.Http;
using Nethereum.JsonRpc.Client;
using Nethereum.RPC.Eth.DTOs;
using Newtonsoft.Json;
using Quartz;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Core.BackgroundJobs
{
    [DisallowConcurrentExecution]
    public class TransactionStatusMonitor : IJob
    {
        readonly List<string> IgnoreExceptionMessages = new List<string>() { "unknown transaction" };

        public async void Execute(IJobExecutionContext context)
        {
            if (!AppManager.IsTransactionStatusMonitorRunning)
            {
                AppManager.IsTransactionStatusMonitorRunning = true;

                try
                {
                    using (PlatformDatabaseEntities db = new PlatformDatabaseEntities())
                    {
                        List<WalletTransaction> _pendingTxs =
                            await db.WalletTransactions.Where(t => t.BlockHash == "" || t.BlockHash == null).OrderBy(t => t.ID).ToListAsync();

                        foreach (WalletTransaction _tx in _pendingTxs)
                        {
                            using (BlockChainManager _manager =
                                new BlockChainManager(_tx.Coin.Blockchain.Host))
                            {
                                try
                                {
                                    TransactionReceipt _receipt =
                                        await _manager.GetTransactionReceipt(_tx.TransactionHash);

                                    if (_receipt != null)
                                    {
                                        _tx.TransactionIndex = _receipt.TransactionIndex.Value.ToString();
                                        _tx.BlockHash = _receipt.BlockHash;
                                        _tx.BlockNumber = _receipt.BlockNumber.Value.ToString();
                                        _tx.CumulativeGasUsed = _receipt.CumulativeGasUsed.Value.ToString();
                                        _tx.GasUsed = _receipt.GasUsed.Value.ToString();
                                        _tx.Logs = JsonConvert.SerializeObject(_receipt.Logs, Formatting.Indented);
                                        _tx.LastUpdatedOn = AppManager.Now;
                                        await db.SaveChangesAsync();

                                        List<MCRTransfer> _transfers = await db.MCRTransfers
                                            .Where(t => t.WalletTransactionID == _tx.ID).ToListAsync();

                                        foreach (var _transfer in _transfers)
                                        {
                                            _transfer.HasProcessed = true;
                                            await db.SaveChangesAsync();
                                        }
                                    }
                                    else
                                    {
                                        if (AppManager.Now.Subtract(_tx.Time).TotalMinutes > 30)
                                        {
                                            using (HttpClient _httpClient = new HttpClient())
                                            {
                                                _httpClient.DefaultRequestHeaders.UserAgent.ParseAdd(
                                                    "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0");

                                                string _etherScanResponseString = await _httpClient.GetStringAsync(
                                                    $"https://etherscan.io/tx/{_tx.TransactionHash}");

                                                if (!string.IsNullOrEmpty(_etherScanResponseString))
                                                {
                                                    if (_etherScanResponseString.ToLower()
                                                        .Contains("Sorry, we are unable to locate this Transaction Hash"
                                                            .ToLower()))
                                                    {
                                                        _tx.BlockHash = "Failed";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                catch (Exception ex)
                                {
                                    if (ex is RpcResponseException && IgnoreExceptionMessages.Contains(ex.Message))
                                    {
                                        continue;
                                    }

                                    ExceptionHandler.Handle(ex);
                                }
                            }

                            _tx.LastUpdatedOn = AppManager.Now;
                            await db.SaveChangesAsync();
                        }
                    }
                }
                catch (Exception ex)
                {
                    ExceptionHandler.Handle(ex);
                }
                finally
                {
                    AppManager.IsTransactionStatusMonitorRunning = false;
                }
            }
        }
    }
}