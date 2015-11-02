#!/usr/bin/python
'''
    File: monitoring.py
    Description: Sends Squid metrics to T-NOVA VIM infrastructure. 
    Metrics:
    - Number of HTTP requests received by Squid
    - Cache hits percentage for the last 5 minutes
    - Memory hits percentage for the last 5 minutes (hits that are logged as TCP_MEM_HIT)
    - Disk hits percentage for the last 5 minutes (hits that are logged as TCP_HIT)
    - Cache disk utilization
    - Cache memory utilization
    - Number of users accessing the proxy
    - CPU usage for the last 5 minutes
'''
import argparse
from influxdb import InfluxDBClient
from parsesquid import Squidclient
import time
import sys

''' Sends metrics to influxdb at specified host and port '''
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
    #shell = Monitoring()

    squid = Squidclient()
   
    first = True
    while True:
        process = squid.execute()
        current_http = squid.parse(process, "Number of HTTP requests received:")
        hits_percentage = squid.parse(process, "Hits as % of all requests:", ",", False)
        memory_hits = squid.parse(process, "Memory hits as % of hit requests:", ",", False)
        disk_hits = squid.parse(process, "Disk hits as % of hit requests:", ",", False)
        cache_disk_utilization = squid.parse(process, "Storage Swap capacity:", ",")
        cache_memory_utilization = squid.parse(process, "Storage Mem capacity:", ",")
        number_of_users = squid.parse(process, "Number of clients accessing cache:")
        cpu_usage = squid.parse(process, "CPU Usage:")
        
        if all((current_http, hits_percentage, memory_hits, disk_hits, cache_disk_utilization, cache_memory_utilization, number_of_users, cpu_usage)):
            current_http = int(current_http)
            if first:
                previous_http = current_http
                first = False
        
            diff_http = current_http - previous_http # gets the number of HTTP requests since the previous measurement

            if diff_http < 0:
                diff_http = 0

            previous_http = current_http
            #shell.send_metric('httpnum', diff_http)
            #shell.send_metric('hits', hits_percentage[:-1])
            #shell.send_metric('memoryhits', memory_hits[:-1])
            #shell.send_metric('diskhits', disk_hits[:-1])
            #shell.send_metric('cachediskutilization', cache_disk_utilization[:-6])
            #shell.send_metric('cachememkutilization', cache_memory_utilization[:-6])
            #shell.send_metric('usernum', number_of_users)
            #shell.send_metric('cpuusage', cpu_usage[:-1])
            print "Number of HTTP requests received: "+str(diff_http)
            print "Hits as % of all requests: "+hits_percentage[:-1]
            print "Memory hits as % of hit requests: "+memory_hits[:-1]
            print "Disk hits as % of hit requests: "+disk_hits[:-1]
            print "Storage Swap capacity: "+cache_disk_utilization[:-6]
            print "Storage Mem capacity: "+cache_memory_utilization[:-6]
            print "Number of clients accessing cache:"+number_of_users
            print "CPU Usage: "+cpu_usage[:-1]+"\n"
        
        time.sleep(60)