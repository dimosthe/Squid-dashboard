<?php

namespace app\helpers;
use yii\helpers\Html; 
use app\models\DelayGroup;
use app\models\User;
//use app\models\Cache;
use app\models\Cachestatus;
/**
 * Helper for editting Squid's configuration file
 *
 */

class Squid
{
	const SQUID_CONF = '/etc/squid/squid.conf'; // Squid's configuration file path
	const SQUID_DEFAULT_CONF = '/home/proxyvnf/dashboard/Squid-dashboard/squid/squid.conf';
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
				foreach($group->users as $user){
					if($user->blocked_at === NULL)
						array_push($users, $user->username);	
				}

				$acl_string .= implode(' ', $users);
				$acl_string .= " REQUIRED" . "\n";
				$count++;
			}
		}

		$users = User::find()->where(['anonymous' => 0])->all();

		$users_list = "";
		foreach ($users as $user) 
		{
			$users_list .= $user->username . " ";
		}

		//$all_enabled = Cache::find()->where(['enabled' => 1])->all();

		// caching configuration
		/*$patterns = [];
		$options = [];
		foreach ($all_enabled as $setting) {
			if($setting->type === 0)
				array_push($patterns, $setting->name);
			elseif($setting->type === 1)
				array_push($options, $setting->name);
		}

		$patterns_str = implode('|', $patterns);
		$options_str = implode(' ', $options);*/

		if(!empty($users_list))
			$acl_string .= "acl named proxy_auth " . $users_list;

		if(Squid::write("# ACL LIST", "# ACL LIST END", $acl_string, Squid::SQUID_DEFAULT_CONF) === false)
			return false;
		
		if(Squid::write("# ACCESS CONTROL", "# ACCESS CONTROL END", $access_string) === false)
			return false;

		if(Squid::write("# DELAY POOLS", "# DELAY POOLS END", $delay_string) === false)
			return false;

		$cachestatus = Cachestatus::findOne(1);	
		if($cachestatus !== NULL)
		{
			if($cachestatus->enabled === 0)
			{
				if(Squid::write("# CACHE CONTROL", "# CACHE CONTROL END", "cache deny all") === false)
					return false;
			}
		}
		else
			return false;

		/*if(!empty($patterns_str))
		{
			$cache_string = "refresh_pattern -i \.(".$patterns_str.")$ 220000 100% 300000 ".$options_str;
			
			if(Squid::write("# CACHE CONTROL", "# CACHE CONTROL END", $cache_string) === false)
				return false;
		}
		else
			if(Squid::write("# CACHE CONTROL", "# CACHE CONTROL END", "") === false)
				return false;
		*/
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
		$status = shell_exec('sudo service squid reload');

		return $status;
	}

	/**
	 * Writes configuration to Squid confifuration file. 
	 * @param string $start 
	 * @param string $end
	 * @param string $conf
	 * @return boolean
	 */
	private static function write($start, $end, $conf, $infile = Squid::SQUID_CONF, $outfile = Squid::SQUID_CONF)
	{
		$file = @file_get_contents($infile);

		if($file === false)
			return false;

		$pos_start = strpos($file, $start);
		$pos_end = strpos($file, $end);

		if($pos_start === false || $pos_end === false)
			return false;
		
		$a = substr($file, 0, $pos_start + strlen($start));
		$b = substr($file, $pos_end);

		if(file_put_contents($outfile, $a."\n". $conf . "\n" .$b) === false)
			return false;

		return true;
	}
}