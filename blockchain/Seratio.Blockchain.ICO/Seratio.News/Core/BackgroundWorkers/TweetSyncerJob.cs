using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.IO;
using System.Linq;
using System.Net;
using System.Reflection;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Web;
using System.Web.Hosting;
using HtmlAgilityPack;
using log4net;
using log4net.Config;
using Quartz;
using ReadSharp;
using Seratio.News.Models;
using Telegram.Bot;
using Telegram.Bot.Exceptions;
using Telegram.Bot.Types;
using Telegram.Bot.Types.Enums;
using Tweetinvi;
using Tweetinvi.Models;
using Tweetinvi.Models.Entities;
using Tweetinvi.Parameters;

namespace Seratio.News.Core.BackgroundWorkers
{
    [DisallowConcurrentExecution]
    public class TweetSyncerJob : IJob
    {
        static bool IsLive = true;
        Reader Reader = new Reader();
        ITwitterCredentials Credentials;
        TelegramBotClient Bot = new TelegramBotClient(IsLive ? "463322076:AAG72aVRpd8CelDxcLMBoiGOXGuLr1dAyoU" : "540693542:AAFOZzslErCjm0xxzFMi4ci99g5rYDS7RKg");

        private static readonly ILog _log = LogManager.GetLogger(MethodBase.GetCurrentMethod().DeclaringType);

        public TweetSyncerJob()
        {
            XmlConfigurator.Configure();

            _log.Info("Starting BG Worker");

            Credentials = Auth.CreateCredentials("FutuqK9WqxNhFBvultBi6q2O1", "f5AAAi1O1moYAcGAXmjc4ltIT5OGeBkNciYg9VfpRSEedHj6vv", "964043282891399168-iyrLSwnoRqchyFZbsKmvJsykqlyyymL", "pEvDt6PCzvbZy6ByddIEKtPpOkYsv5TBnBE1dblcF2irp");
            Auth.SetCredentials(Credentials);
            RateLimit.RateLimitTrackerMode = RateLimitTrackerMode.TrackAndAwait;
        }

        public async void Execute(IJobExecutionContext context)
        {
            if (!AppManager.IsSyncingTweets)
            {
                AppManager.IsSyncingTweets = true;

                try
                {
                    using (NewsDatabaseEntities db = new NewsDatabaseEntities())
                    {
                        //_log.Info("Database connection established");

                        foreach (TwitterAccount _twitterAccount in await db.TwitterAccounts.ToListAsync())
                        {
                            IEnumerable<ITweet> _tweets = Timeline.GetUserTimeline(_twitterAccount.Handle, new UserTimelineParameters()
                            {
                                MaximumNumberOfTweetsToRetrieve = 100
                            });

                            if (_tweets == null || !_tweets.Any())
                            {
                                continue;
                            }

                            DateTime _oldestTweetTime = _tweets.Min(t => t.CreatedAt);
                            DateTime _newestTweetTime = _tweets.Max(t => t.CreatedAt);

                            List<long> _storedTweetIDs = await db.Tweets
                                .Where(t => t.AccountID == _twitterAccount.ID && t.Time >= _oldestTweetTime &&
                                            t.Time <= _newestTweetTime).Select(t => t.TweetID).ToListAsync();

                            List<long> _deletedTweets = _storedTweetIDs.Where(i => !_tweets.Any(t => t.Id == i)).ToList();

                            foreach (int _deletedTweet in _deletedTweets)
                            {
                                Models.Tweet _entity = await db.Tweets.FirstOrDefaultAsync(t => t.TweetID == _deletedTweet);

                                if (_entity != null)
                                {
                                    db.Tweets.Remove(_entity);
                                    await db.SaveChangesAsync();
                                }
                            }

                            _log.Info($"Deleted {_deletedTweets.Count} tweets");

                            if (_tweets != null)
                            {
                                _log.Info($"Attempting to process {_tweets.Count()} tweets");

                                foreach (ITweet _tweet in _tweets)
                                {
                                    if (_tweet.Id == 979387918006484992)
                                    {
                                        continue;
                                    }

                                    try
                                    {
                                        if (!await db.Tweets.AnyAsync(t => t.TweetID == _tweet.Id))
                                        {
                                            //_log.Info($"New Tweet");

                                            string _content = HttpUtility.HtmlDecode(_tweet.Text);

                                            if (_tweet.Truncated)
                                            {
                                                Article _article =
                                                    await Reader.Read(new Uri(
                                                        _tweet.Url));

                                                if (_article != null)
                                                {
                                                    HtmlDocument _doc = new HtmlDocument();
                                                    _doc.LoadHtml(_article.Raw);
                                                    HtmlNode _contentNode = _doc.DocumentNode
                                                        .SelectNodes("//div[contains(@class, 'tweet-text')]")
                                                        .Descendants("div").FirstOrDefault();
                                                    if (_contentNode != null)
                                                    {
                                                        _content = HttpUtility.HtmlDecode(_contentNode.InnerText);
                                                    }
                                                }
                                            }

                                            Models.Tweet _entity = new Models.Tweet();

                                            #region URLs

                                            if (_tweet.Urls.Any())
                                            {
                                                foreach (IUrlEntity _url in _tweet.Urls)
                                                {
                                                    if (_content.Contains($"{_url.URL}"))
                                                    {
                                                        _content = _content.Replace($"{_url.URL}",
                                                            $"<a class='wall-item--tweet__hashtag-link' href='{_url.URL}' rel='noopener' target='_blank'>{_url.URL}</a>");
                                                    }
                                                }
                                            }

                                            #endregion

                                            #region User Mentions

                                            Regex _mentionRegex = new Regex(@"(?<=@)\w+");
                                            MatchCollection _mentionRegExMatches = _mentionRegex.Matches(_content);

                                            foreach (Match _mentionMatch in _mentionRegExMatches)
                                            {
                                                _mentionRegex = new Regex(Regex.Escape($"@{_mentionMatch.Value}"));
                                                _content = _mentionRegex.Replace(_content,
                                                    $"<a class='wall-item--tweet__hashtag-link' href='https://twitter.com/{_mentionMatch.Value}' rel='noopener' target='_blank'>@{_mentionMatch.Value}</a>");
                                            }

                                            #endregion

                                            #region Process HashTags

                                            Regex _hashTagregEx = new Regex(@"(?<=#)\w+");
                                            MatchCollection _matchedHashTags = _hashTagregEx.Matches(_content);

                                            foreach (Match _hashTagMatch in _matchedHashTags)
                                            {
                                                _hashTagregEx = new Regex(Regex.Escape($"#{_hashTagMatch.Value}"));
                                                _content = _hashTagregEx.Replace(_content,
                                                    $"<a class='wall-item--tweet__hashtag-link' href='https://twitter.com/search?q=%23{_hashTagMatch.Value}' rel='noopener' target='_blank'>#{_hashTagMatch.Value}</a>",
                                                    1);
                                            }

                                            #endregion

                                            #region Download Image

                                            string _imageURLToDownload = "";

                                            if (_tweet.Entities.Medias.Any(m => m.MediaType == "photo"))
                                            {
                                                _imageURLToDownload = _tweet.Entities.Medias
                                                    .FirstOrDefault(m => m.MediaType == "photo")
                                                    ?.MediaURL;
                                            }
                                            //else if (_tweet.Entities.Urls.Any())
                                            //{
                                            //    Article _article =
                                            //        await Reader.Read(new Uri(
                                            //            _tweet.Entities.Urls.FirstOrDefault()?.ExpandedURL));

                                            //    if (_article != null && _article.FrontImage != null)
                                            //    {
                                            //        _imageURLToDownload = _article.FrontImage.ToString();
                                            //    }
                                            //}
                                            else if (_tweet.RetweetedTweet != null)
                                            {
                                                try
                                                {
                                                    Article _article =
                                                        await Reader.Read(new Uri(
                                                            _tweet.RetweetedTweet.Url));

                                                    if (_article != null)
                                                    {
                                                        if (_article.FrontImage != null)
                                                        {
                                                            _imageURLToDownload = _article.FrontImage.ToString();
                                                        }
                                                        else
                                                        {
                                                            HtmlDocument _doc = new HtmlDocument();
                                                            _doc.LoadHtml(_article.Raw);
                                                            HtmlNodeCollection _mediaHolder = _doc.DocumentNode
                                                                .SelectNodes("//div[contains(@class, 'media')]");
                                                            if (_mediaHolder != null)
                                                            {
                                                                IEnumerable<HtmlNode> _images = _mediaHolder.Descendants("img");

                                                                if (_images != null)
                                                                {
                                                                    HtmlNode _imageNode = _images.FirstOrDefault();
                                                                    if (_imageNode != null)
                                                                    {
                                                                        _imageURLToDownload = _imageNode.Attributes["src"]
                                                                            .Value
                                                                            .Replace(":small", String.Empty);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                catch (Exception ex)
                                                {
                                                    ExceptionHandler.Handle(new Exception($"{_tweet.RetweetedTweet.Url}: {ex.Message}"));
                                                }
                                            }
                                            else
                                            {
                                                try
                                                {
                                                    Article _article =
                                                        await Reader.Read(new Uri(
                                                            _tweet.Url));

                                                    if (_article != null)
                                                    {
                                                        if (_article.FrontImage != null)
                                                        {
                                                            _imageURLToDownload = _article.FrontImage.ToString();
                                                        }
                                                        else
                                                        {
                                                            HtmlDocument _doc = new HtmlDocument();
                                                            _doc.LoadHtml(_article.Raw);
                                                            HtmlNodeCollection _mediaHolder = _doc.DocumentNode
                                                                .SelectNodes("//div[contains(@class, 'media')]");
                                                            if (_mediaHolder != null)
                                                            {
                                                                IEnumerable<HtmlNode> _images = _mediaHolder.Descendants("img");

                                                                if (_images != null)
                                                                {
                                                                    HtmlNode _imageNode = _images.FirstOrDefault();
                                                                    if (_imageNode != null)
                                                                    {
                                                                        _imageURLToDownload = _imageNode.Attributes["src"]
                                                                            .Value
                                                                            .Replace(":small", String.Empty);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                catch (Exception ex)
                                                {
                                                    ExceptionHandler.Handle(new Exception($"{_tweet.Url}: {ex.Message}"));
                                                }
                                            }

                                            if (string.IsNullOrEmpty(_imageURLToDownload) && _tweet.Urls.Any())
                                            {
                                                try
                                                {
                                                    Article _article =
                                                        await Reader.Read(new Uri(
                                                            _tweet.Urls.FirstOrDefault().ExpandedURL));

                                                    if (_article != null)
                                                    {
                                                        if (_article.FrontImage != null)
                                                        {
                                                            _imageURLToDownload = _article.FrontImage.ToString();
                                                        }
                                                    }
                                                }
                                                catch (Exception ex)
                                                {
                                                    ExceptionHandler.Handle(
                                                        new Exception($"{_tweet.Url}: {ex.Message}"));
                                                }
                                            }

                                            if (!string.IsNullOrEmpty(_imageURLToDownload))
                                            {
                                                string _image =
                                                    $"{DateTime.Now:MMddyyyyHHmmss}_{Path.GetFileName(_imageURLToDownload)}".Split('?').FirstOrDefault();
                                                using (WebClient _webClient = new WebClient())
                                                {
                                                    try
                                                    {
                                                        _log.Info($"Downloading Tweet Image {_imageURLToDownload}");

                                                        _webClient.DownloadFile(_imageURLToDownload,
                                                            $"{HostingEnvironment.MapPath($"{(Environment.MachineName.ToLower() == "vultr-guest" ? "/news" : string.Empty)}/assets/images/tweets/")}\\{_image}");
                                                    }
                                                    catch
                                                    {
                                                        _image = _imageURLToDownload;
                                                    }
                                                }

                                                _entity.Image = _image;
                                            }

                                            #endregion

                                            _entity.TweetID = _tweet.Id;
                                            _entity.AccountID = _twitterAccount.ID;
                                            _entity.Text = _content;
                                            _entity.Time = _tweet.CreatedAt;

                                            db.Tweets.Add(_entity);
                                            await db.SaveChangesAsync();

                                            _content = $"{_twitterAccount.Handle}: {_content}\n<a href=\"https://twitter.com/{_twitterAccount.Handle}/status/{_entity.TweetID}\">View in Twitter</a>";

                                            if (_entity.Time > new DateTime(2018, 3, 28))
                                            {
                                                if (_entity.AccountID != 1)
                                                {
                                                    await Bot.SendTextMessageAsync(
                                                        new ChatId(IsLive ? -1001082933814 : -283614533), _content,
                                                        ParseMode.Html);
                                                }
                                            }



                                            await Task.Delay(10000);
                                        }
                                        else
                                        {
                                            //_log.Info($"Tweet already exists");
                                        }
                                    }
                                    catch (Exception ex)
                                    {
                                        if (!(ex is ApiRequestException))
                                        {
                                            ExceptionHandler.Handle(ex);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                catch (Exception ex)
                {
                    ExceptionHandler.Handle(ex);
                }
                finally
                {
                    AppManager.IsSyncingTweets = false;
                }
            }
        }
    }
}