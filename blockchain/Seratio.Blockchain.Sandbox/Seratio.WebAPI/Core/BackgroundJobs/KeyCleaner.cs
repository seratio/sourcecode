using System;
using System.IO;
using System.Web.Hosting;
using Quartz;
using Seratio.Blockchain.Sandbox.Core.Utilities;

namespace Seratio.Blockchain.Sandbox.Core.BackgroundJobs
{
    [DisallowConcurrentExecution]
    public class KeyCleaner : IJob
    {
        public void Execute(IJobExecutionContext context)
        {
            if (!AppManager.IsKeyCleanerRunning)
            {
                AppManager.IsKeyCleanerRunning = true;

                try
                {
                    string[] _files = Directory.GetFiles(HostingEnvironment.MapPath($"~//keys"));

                    foreach (string _file in _files)
                    {
                        try
                        {
                            FileInfo _fileInfo = new FileInfo(_file);
                            TimeSpan _fileAge = DateTime.Now.Subtract(_fileInfo.CreationTime);
                            if (_fileAge.TotalMinutes >= 20)
                            {
                                File.Delete(_file);
                            }
                        }
                        catch (Exception ex)
                        {
                            //ExceptionHandler.Handle(ex);
                        }
                    }
                }
                catch (Exception ex)
                {
                    //ExceptionHandler.Handle(ex);
                }
                finally
                {
                    AppManager.IsKeyCleanerRunning = false;
                }
            }
        }
    }
}