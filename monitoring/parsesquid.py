''' 
    File: parsesquid.py
    Description: Collects Squid statistics using the squidclient tool
''' 

import subprocess
import string
import time
import sys

class Squidclient(object):

    def __init__(self, command='squidclient', params='mgr:info'):
        self.command = command
        self.params = params

    # runs the squidclient tool
    def execute(self):
        try:
            output = subprocess.check_output("squidclient mgr:info", shell=True)

        except subprocess.CalledProcessError as e:
            return False

        return output

    # parses the output of squidclient and returns a specific metric
    def parse(self, process, start_string, end_string="\n", first=True):
        if process == False:
            return False
        
        start = string.find(process, start_string)
        end = string.find(process, end_string, start)
        
        if start == -1 or end == -1:
            return False
        
        line = process[start:end]
        lis = string.split(line, ":")
    
        if not lis:
            return False
        
        if first:
            return string.strip(lis[1])
        else:
            return string.strip(lis[2])