using System;
using System.Diagnostics;
using System.Web.Hosting;
using Seratio.Blockchain.Sandbox.Core.Utilities;

namespace Seratio.Blockchain.Sandbox.Core
{
    public class ETHEncryption
    {
        public static string Execute(string action, string mnemonic, string input)
        {
            try
            {
                Process _nodeJsProcess = new Process();
                _nodeJsProcess.StartInfo.UseShellExecute = false;
                _nodeJsProcess.StartInfo.RedirectStandardOutput = true;
                _nodeJsProcess.StartInfo.RedirectStandardError = true;
                _nodeJsProcess.StartInfo.RedirectStandardInput = true;
                _nodeJsProcess.StartInfo.FileName = @"C:\\Program Files\\nodejs\\node.exe";
                _nodeJsProcess.StartInfo.Arguments = $"{HostingEnvironment.MapPath("/encryption/script.js")} \"{action}\" \"{mnemonic}\" \"{input}\"";
                _nodeJsProcess.Start();

                string _processOutput = _nodeJsProcess.StandardOutput.ReadToEnd();
                _nodeJsProcess.WaitForExit();

                return _processOutput;
            }
            catch (Exception ex)
            {
                ExceptionHandler.Handle(ex);
                return null;
            }
        }
    }
}