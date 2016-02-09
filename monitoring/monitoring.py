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
from datetime import datetime

''' Sends metrics to influxdb at specified host and port '''
class Monitoring(object):

    def __init__(self, host='emonitoring.sisyphus.mnl', port=8086, username='stats_user',
            password='tnova', db_name='statsdb'):
        self.client = InfluxDBClient(host, port, username, password, db_name)


    def send_metric(self, name, value) :
				instance_uuid = "03ed10fb-39d0-455e-bd5c-882552baaef0"  
				json_body = [
                {
                    "measurement": name,
										"tags": {
											"host": instance_uuid
										},
                    "fields": {
                        "value": value
                        }
                    }
                ]
				self.client.write_points(json_body)

if __name__ == '__main__':
    shell = Monitoring()

    squid = Squidclient()
   
    first = True
    f = open('/home/proxyvnf/dashboard/Squid-dashboard/monitoring/logs.txt', 'a')
    process = squid.execute()
    
    if process:
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
            
            file = open('/home/proxyvnf/dashboard/Squid-dashboard/monitoring/state.txt', 'r')
            previous_http = int(file.read())
            file.close()
            if previous_http == 0:
                previous_http = current_http

            file = open('/home/proxyvnf/dashboard/Squid-dashboard/monitoring/state.txt', 'w')
            file.write(str(current_http))
            file.close()
            
            diff_http = current_http - previous_http # gets the number of HTTP requests since the previous measurement
            if diff_http < 0:
                diff_http = 0

            shell.send_metric('httpnum', str(diff_http))
            shell.send_metric('hits', hits_percentage[:-1])
            shell.send_metric('memoryhits', memory_hits[:-1])
            shell.send_metric('diskhits', disk_hits[:-1])
            shell.send_metric('cachediskutilization', cache_disk_utilization[:-6])
            shell.send_metric('cachememkutilization', cache_memory_utilization[:-6])
            shell.send_metric('usernum', number_of_users)
            shell.send_metric('cpuusage', cpu_usage[:-1])
            f.write("time: "+datetime.now().strftime('%Y-%m-%d %H:%M:%S')+"\n")
            f.write("Number of HTTP requests received: "+str(diff_http)+"\n")
            f.write("Hits as % of all requests: "+hits_percentage[:-1]+"\n")
            f.write("Memory hits as % of hit requests: "+memory_hits[:-1]+"\n")
            f.write("Disk hits as % of hit requests: "+disk_hits[:-1]+"\n")
            f.write("Storage Swap capacity: "+cache_disk_utilization[:-6]+"\n")
            f.write("Storage Mem capacity: "+cache_memory_utilization[:-6]+"\n")
            f.write("Number of clients accessing cache:"+number_of_users+"\n")
            f.write("CPU Usage: "+cpu_usage[:-1]+"\n")
            f.write("----------------------\n")
        else:
            f.write("time: "+datetime.now().strftime('%Y-%m-%d %H:%M:%S')+"\n")
            f.write('Unable to send metrics\n')
            f.write("----------------------\n")
    else:
        f.write("time: "+datetime.now().strftime('%Y-%m-%d %H:%M:%S')+"\n")
        f.write('Unable to send metrics\n')
        f.write("----------------------\n")
    
    f.close()
