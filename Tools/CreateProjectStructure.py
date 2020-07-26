import os
import sys
import shutil
import logging
from subprocess import call

try:
    appName = sys.argv[1]
    try:
        # Create parent directory
        os.makedirs(appName)
        os.chdir(appName)
        os.system("truffle init")
        os.system("meteor create app")
        readmeFile = "README.md"
        fptr = open(readmeFile, "w")
        fptr.write("#"+appName)
        fptr.close()
    except OSError:
        _type, value, traceback = sys.exc_info()
        print('Error opening %s: %s' % (value.filename, value.strerror))
except IndexError:
     print("Provide name for folder as argument")
     logging.exception("missing argument")
