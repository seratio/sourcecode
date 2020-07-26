using System;
using System.Linq;

namespace Seratio.Blockchain.Sandbox.Core.Utilities
{
    public static class ExtensionMethods
    {
        public static string Ellipsisfy(this string value)
        {
            return value.Substring(0, 10) + "..." + value.Substring((value.Length - 10), 10);
        }

        public static string CarefullyTrim(this decimal value, int numberOfDecimals = 0)
        {
            if (value == 0)
            {
                return value.ToString();
            }

            string _formattedValue;

            if (numberOfDecimals > 0)
            {
                _formattedValue = Math.Round(value, numberOfDecimals).ToString();
            }
            else
            {
                _formattedValue = value.ToString();
            }

            if (_formattedValue.Contains("."))
            {
                var _temp = _formattedValue.Split('.');
                _formattedValue = $"{_temp.FirstOrDefault()}.{_temp.LastOrDefault().TrimEnd('0')}".TrimEnd('.');
            }

            return _formattedValue;
        }
    }
}