using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.IO;
using System.Linq;
using System.Web;

namespace Seratio.Platform.ICO.Core.Utilities
{
    public class ValidateFileAttribute : ValidationAttribute
    {
        public string[] AllowedExtensions { get; set; }

        public int MaxFileSize { get; set; }

        public bool HasMultiple { get; set; }

        public ValidateFileAttribute()
        {

        }

        protected override ValidationResult IsValid(object value, ValidationContext validationContext)
        {
            List<HttpPostedFileBase> _files = new List<HttpPostedFileBase>();

            if (HasMultiple)
            {
                _files.AddRange(value as List<HttpPostedFileBase>);
            }
            else
            {
                _files.Add(value as HttpPostedFileBase);
            }

            foreach (HttpPostedFileBase _file in _files)
            {
                if (_file != null)
                {
                    if (AllowedExtensions.Contains(Path.GetExtension(_file.FileName.ToLower())))
                    {
                        if (MaxFileSize >= ((_file.InputStream.Length / 1024f) / 1024f))
                        {
                            return null;
                        }
                        else
                        {
                            return new ValidationResult(string.Format("Invalid file. File should be less than {0} Mb", MaxFileSize));
                        }
                    }
                    else
                    {
                        return new ValidationResult(string.Format("Invalid file. Only {0} are supported", string.Join(", ", AllowedExtensions)));
                    }
                }
                else
                {
                    return null;
                }
            }
            return null;
        }
    }
}
