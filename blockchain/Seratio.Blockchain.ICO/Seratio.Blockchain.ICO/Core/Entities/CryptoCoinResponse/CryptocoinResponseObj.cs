namespace Seratio.Platform.ICO.Core.Entities.CryptoCoinResponse
{
    class CryptocoinResponseObj
    {
        public class Rootobject
        {
            public Ticker ticker { get; set; }
            public int timestamp { get; set; }
            public bool success { get; set; }
            public string error { get; set; }
        }

        public class Ticker
        {
            public string _base { get; set; }
            public string target { get; set; }
            public string price { get; set; }
            public string volume { get; set; }
            public string change { get; set; }
        }
    }
}