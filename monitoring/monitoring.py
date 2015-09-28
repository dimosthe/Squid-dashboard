#!/usr/bin/python

import argparse
from influxdb import InfluxDBClient
from parsesquid import Squidclient
import time
import sys

class Monitoring(object):

    def __init__(self, host='143.233.127.12', port=8086, username='stats_user',
            password='tnova', db_name='statsdb'):
        self.client = InfluxDBClient(host, port, username, password, db_name)


    def send_metric(self, name, value) :
        json_body = [
                {
                    "measurement": name,
                    "fields": {
                        "value": value
                        }
                    }
                ]
        self.client.write_points(json_body);

if __name__ == '__main__':
    '''parser = argparse.ArgumentParser(
        description='Send metrics to T-NOVA VIM infrastructure.')
    parser.add_argument('name', action="store")
    parser.add_argument('value', action="store")
    opts = parser.parse_args()
    shell = Monitoring()
    shell.send_metric(opts.name, opts.value)'''

    squid = Squidclient()
   
    first = True
    while True:
        f = open('test.txt', 'a')
        current_http = squid.parse("Number of HTTP requests received:")
        hits_percentage = squid.parse("Hits as % of all requests:", ",", False)
        
        if current_http == False or hits_percentage == False:
            f.write("problem")
        else:
            current_http = int(current_http)
            if first:
                previous_http = current_http
                first = False
        
            diff_http = current_http - previous_http

            if diff_http < 0:
                diff_http = 0

            previous_http = current_http

            f.write(str(diff_http)+"\n")
            f.write(hits_percentage+"\n")
        
        f.close()

        time.sleep(10)
