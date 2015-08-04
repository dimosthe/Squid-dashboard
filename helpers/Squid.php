<?php

namespace app\helpers;
use yii\helpers\Html; 

/**
 * Helper for editting Squid's configuration file
 *
 */

class Squid
{
	const SQUID_CONF = '/etc/squid/squid.conf.test';

	public static function network_access()
	{
	
		$file = file_get_contents(Squid::SQUID_CONF);

		$start = "# ACL LIST";
		$end = "# ACL LIST END";
		$pos_start = strpos($file, $start);
		$pos_end = strpos($file, $end);
		
		$a = substr($file, 0, $pos_start + strlen($start));
		$b = substr($file, $pos_end);

		$test = file_put_contents(Squid::SQUID_CONF, $a."\n"."acl users proxy_auth george REQUIRED" . "\n" ."acl admins proxy_auth admin ". "\n" .$b);

		return $test;
	}
}