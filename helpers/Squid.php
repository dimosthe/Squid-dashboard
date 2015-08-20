<?php

namespace app\helpers;
use yii\helpers\Html; 
use app\models\DelayGroup;

/**
 * Helper for editting Squid's configuration file
 *
 */

class Squid
{
	const SQUID_CONF = '/etc/squid/squid.conf'; // Squid's configuration file path

	/**
	 * Reads configuration data from DB and writes it to Squid's configuration file
	 */
	public static function writeconfig()
	{
	
		$groups = DelayGroup::find()->with('users')->all();

		$acl_string = "";
		$access_string = "";
		$count = count($groups);

		if($count > 0)
			$delay_string = "delay_pools " . $count . "\n";
		
		$count = 1;
		foreach ($groups as $group)
		{
			if(!empty($group->users))
			{
				$acl_string .= "acl " . $group->name . " proxy_auth ";
				$access_string .= "http_access allow ". $group->name . "\n";
				
				$rate = $group->rate == -1 ? -1 : $group->rate*1000/8;
				$delay_string .= "delay_class " . $count . " 1 \n";
				$delay_string .= "delay_parameters " . $count . " " . $rate . "/" . $rate . "\n";
				$delay_string .= "delay_access " . $count . " allow " . $group->name . "\n";

				$users = [];
				foreach($group->users as $user)
					array_push($users, $user->username);	

				$acl_string .= implode(' ', $users);
				$acl_string .= " REQUIRED" . "\n";
				$count++;
			}
		}

		if(Squid::write("# ACL LIST", "# ACL LIST END", $acl_string) === false)
			return false;
		
		if(Squid::write("# ACCESS CONTROL", "# ACCESS CONTROL END", $access_string) === false)
			return false;

		if(Squid::write("# DELAY POOLS", "# DELAY POOLS END", $delay_string) === false)
			return false;

		
		return true;
	}

	/**
	 * Starts Squid server
	 * @return string
	 */
	public static function start()
	{
		$status = shell_exec('sudo service squid start');

		return $status;
	}

	/**
	 * Stops Squid server
	 * @return string
	 */
	public static function stop()
	{
		$status = shell_exec('sudo service squid stop');

		return $status;
	}

	/**
	 * Restarts Squid server
	 * @return string
	 */
	public static function restart()
	{
		$status = shell_exec('sudo service squid restart');

		return $status;
	}

	/**
	 * Writes configuration to Squid confifuration file. 
	 * @param string $start 
	 * @param string $end
	 * @param string $conf
	 * @return boolean
	 */
	private static function write($start, $end, $conf)
	{
		$file = @file_get_contents(Squid::SQUID_CONF);

		if($file === false)
			return false;

		$pos_start = strpos($file, $start);
		$pos_end = strpos($file, $end);

		if($pos_start === false || $pos_end === false)
			return false;
		
		$a = substr($file, 0, $pos_start + strlen($start));
		$b = substr($file, $pos_end);

		if(file_put_contents(Squid::SQUID_CONF, $a."\n". $conf . "\n" .$b) === false)
			return false;

		return true;
	}
}