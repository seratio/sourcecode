using System;
using System.Data.Entity;
using System.Linq;
using System.Net.Http;
using System.Numerics;
using System.Threading.Tasks;
using Nethereum.RPC.Eth.DTOs;
using Nethereum.Util;
using Newtonsoft.Json;
using Quartz;
using Seratio.Blockchain.Sandbox.Core.Entities.Blockchain;
using Seratio.Blockchain.Sandbox.Core.Utilities;
using Seratio.Blockchain.Sandbox.Models;

namespace Seratio.Blockchain.Sandbox.Core.BackgroundJobs
{
    [DisallowConcurrentExecution]
    public class ETHExplorerTxSyncer : IJob
    {
        public async void Execute(IJobExecutionContext context)
        {
            if (!AppManager.IsETHSyncing)
            {
                AppManager.IsETHSyncing = true;

                try
                {
                    HttpClient _httpClient = new HttpClient();
                    _httpClient.DefaultRequestHeaders.UserAgent.ParseAdd(
                        "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0");

                    using (BlockChainManager _manager =
                        new BlockChainManager("http://35.205.45.88/eth-api/"))
                    {
                        int _page = 1;
                        int _maxPages = 1;

                        FetchTransactions:
                        string _responseString =
                            await _httpClient.GetStringAsync(
                                $"https://ethplorer.io/service/service.php?refresh=transfers&data=0xB561fEF0d624C0826ff869946f6076B7c4f2ba42&page=transfers={_page}");

                        ETHPlorerAPIResponse _response =
                            JsonConvert.DeserializeObject<ETHPlorerAPIResponse>(_responseString);

                        if (_response != null)
                        {
                            if (_response.transfers.Any())
                            {
                                using (PlatformDatabaseEntities db = new PlatformDatabaseEntities())
                                {
                                    foreach (Transfer _transfer in _response.transfers)
                                    {
                                        int _sendingUserID =
                                            await db.Users.Where(u => u.WalletAddress == _transfer.from)
                                                .Select(u => u.ID)
                                                .FirstOrDefaultAsync();

                                        if (_sendingUserID == 0)
                                        {
                                            _sendingUserID =
                                                await db.UserWalletHistories
                                                    .Where(h => h.NewWalletAddress == _transfer.from ||
                                                                h.OldWalletAddress == _transfer.from)
                                                    .Select(h => h.UserID)
                                                    .FirstOrDefaultAsync();
                                        }

                                        if (_sendingUserID != 0)
                                        {
                                            try
                                            {
                                                if (!await db.WalletTransactions.AnyAsync(
                                                    t => t.TransactionHash == _transfer.transactionHash))
                                                {
                                                    TransactionReceipt _receipt =
                                                        await _manager.GetTransactionReceipt(_transfer.transactionHash);

                                                    if (_receipt != null)
                                                    {
                                                        decimal _amount =
                                                            new UnitConversion().FromWei(
                                                                new BigInteger(_transfer.intValue), 7);

                                                        WalletTransaction _tx = new WalletTransaction
                                                        {
                                                            UserID = _sendingUserID,
                                                            Recipient = _transfer.to,
                                                            Amount = _amount,
                                                            CoinID = 18,
                                                            TransactionHash = _transfer.transactionHash,
                                                            TransactionIndex =
                                                                _receipt.TransactionIndex.Value.ToString(),
                                                            BlockHash = _receipt.BlockHash,
                                                            BlockNumber = _receipt.BlockNumber.Value.ToString(),
                                                            CumulativeGasUsed = _receipt.CumulativeGasUsed.Value
                                                                .ToString(),
                                                            GasUsed = _receipt.GasUsed.Value.ToString(),
                                                            Logs = JsonConvert.SerializeObject(_receipt.Logs,
                                                                Formatting.Indented),
                                                            Time = UnixTimeStampToDateTime(_transfer.timestamp),
                                                            IsSyncedFromEthplorer = true,
                                                            LastUpdatedOn = AppManager.Now
                                                        };

                                                        db.WalletTransactions.Add(_tx);
                                                        await db.SaveChangesAsync();
                                                    }
                                                }
                                            }
                                            catch (Exception ex)
                                            {
                                                ExceptionHandler.Handle(ex);
                                            }


                                        }
                                    }
                                }
                            }

                            if (_maxPages == 1)
                            {
                                _maxPages = (int)Math.Round(
                                    (double)(_response.pager.transfers.total / _response.pager.pageSize),
                                    MidpointRounding.AwayFromZero);
                            }
                        }

                        if (_page < _maxPages)
                        {
                            _page++;
                            await Task.Delay(TimeSpan.FromSeconds(5));
                            goto FetchTransactions;
                        }
                    }
                }
                catch (Exception ex)
                {
                    ExceptionHandler.Handle(ex);
                }
                finally
                {
                    AppManager.IsETHSyncing = false;
                }
            }
        }

        public static DateTime UnixTimeStampToDateTime(double unixTimeStamp)
        {
            System.DateTime dtDateTime = new DateTime(1970, 1, 1, 0, 0, 0, 0, System.DateTimeKind.Utc);
            dtDateTime = dtDateTime.AddSeconds(unixTimeStamp).ToLocalTime();
            return dtDateTime;
        }
    }
}