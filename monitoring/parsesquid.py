import subprocess
import string
import time
import sys

class Squidclient(object):

    def __init__(self, command='squidclient', params='mgr:info'):
        self.command = command
        self.params = params

    def execute(self):
        try:
            #output = subprocess.check_output([self.command, self.params])
            output = subprocess.check_output("squidclient mgr:info", shell=True)

        except subprocess.CalledProcessError as e:
            return False

        return output

    def parse(self, start_string, end_string="\n", first=True):
        process = self.execute()

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
            return string.strip(lis[2])[:-1]

if __name__ == '__main__':

    squid = Squidclient()

    first = True
    while True:
        current_http = squid.parse("Number of HTTP requests received:")
        hits_percentage = squid.parse("Hits as % of all requests:", ",", False)
        
        if current_http == False or hits_percentage == False:
            print "problem"
        else:
            current_http = int(current_http)
            if first:
                previous_http = current_http
                first = False
        
            diff_http = current_http - previous_http

            if diff_http < 0:
                diff_http = 0

            previous_http = current_http
            print diff_http
            print hits_percentage
        time.sleep(10)
