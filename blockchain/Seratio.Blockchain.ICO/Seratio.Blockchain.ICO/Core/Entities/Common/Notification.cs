namespace Seratio.Platform.ICO.Core.Entities.Common
{
    public class Notification
    {
        public string Type { get; set; }

        public string Text { get; set; }

        public Notification(string Type, string Text)
        {
            this.Text = Text;
            this.Type = Type;
        }
    }
}
