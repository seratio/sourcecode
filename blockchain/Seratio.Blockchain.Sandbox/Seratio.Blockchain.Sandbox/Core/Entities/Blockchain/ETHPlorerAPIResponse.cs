namespace Seratio.Blockchain.Sandbox.Core.Entities.Blockchain
{
    public class ETHPlorerAPIResponse
    {
        public bool isContract { get; set; }
        public Transfer[] transfers { get; set; }
        public Contract contract { get; set; }
        public Token token { get; set; }
        public Pager pager { get; set; }
        public Ethprice ethPrice { get; set; }
    }

    public class Contract
    {
        public string address { get; set; }
        public string creator { get; set; }
        public string hash { get; set; }
        public int timestamp { get; set; }
        public int blockNumber { get; set; }
        public int txsCount { get; set; }
    }

    public class Token
    {
        public string address { get; set; }
        public string name { get; set; }
        public string decimals { get; set; }
        public string symbol { get; set; }
        public string totalSupply { get; set; }
        public string owner { get; set; }
        public int txsCount { get; set; }
        public int transfersCount { get; set; }
        public int lastUpdated { get; set; }
        public int issuancesCount { get; set; }
        public int holdersCount { get; set; }
        public bool price { get; set; }
    }

    public class Pager
    {
        public int pageSize { get; set; }
        public Transfers transfers { get; set; }
    }

    public class Transfers
    {
        public int page { get; set; }
        public int records { get; set; }
        public int total { get; set; }
    }

    public class Ethprice
    {
        public string rate { get; set; }
        public float diff { get; set; }
        public float diff7d { get; set; }
        public string ts { get; set; }
        public string marketCapUsd { get; set; }
        public string availableSupply { get; set; }
        public string volume24h { get; set; }
        public float diff30d { get; set; }
    }

    public class Transfer
    {
        public int timestamp { get; set; }
        public string transactionHash { get; set; }
        public int blockNumber { get; set; }
        public string contract { get; set; }
        public string value { get; set; }
        public long intValue { get; set; }
        public string type { get; set; }
        public bool isEth { get; set; }
        public int priority { get; set; }
        public string from { get; set; }
        public string to { get; set; }
        public string[] addresses { get; set; }
    }
}