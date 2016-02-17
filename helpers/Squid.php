<?php
/**
 * Helper for editting Squid's configuration file
 *
 * @author George Dimosthenous, Savvas Charalambides
 */

namespace app\helpers;

use yii\helpers\Html; 
use app\models\DelayGroup;
use app\models\User;
use app\models\Cachestatus;

class Squid
{
	const SQUID_CONF = '/etc/squid/squid.conf'; // Squid's configuration file path
	const SQUID_DEFAULT_CONF = '/home/proxyvnf/dashboard/Squid-dashboard/squid/squid.conf'; // Squid's default configuration template
	
	/**
	 * Reads configuration data from DB and writes it to Squid's configuration file
	 *
	 * @return bool
	 */
	public static function writeconfig()
	{
		$groups = DelayGroup::find()->with('users')->all();

		$acl_string = "";
		$access_string = "";
		$delay_string = "";
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

		return true;
	}

	/**
	 * Starts Squid server
	 * @return string
	 */
	public static function start()
	{
		$status = shell_exec('sudo service squid start');

		if($status)
		{
			$now = time();
			$next = $now + 10;
			while(1)
			{
				$squid_status = Squid::status();
				if($squid_status === true)
					break;
				if(time() == $next)
					break;
			}
		}
		return $status;
	}

	/**
	 * Force stops Squid server
	 * @return string
	 */
	public static function forceStop()
	{
		$a = array();
		$code = '';
		exec('sudo killall -9 squid', $a, $code);

		return $code;
	}

	/**
	 * Stops Squid server
	 * @return string
	 */
	public static function Stop()
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
		$status = Squid::forceStop();
		if($status === 0)
            $status = '* Stopping Squid HTTP Proxy 3.x squid ...done.';
        else
        	$status = 'Unable to stop Squid HTTP Proxy 3.x';
		$status .= Squid::start();

		return $status;
	}

	/**
	 * Returns Squid's status
	 * @return bool
	 */
	public static function status()
	{
		$status = shell_exec('sudo service squid status');

		if($status !== NULL)
        {
            if(stripos($status, 'is not') === false)
                $squid_status = true;
            else
                $squid_status = false;
        }
        else
            $squid_status = false;

		return $squid_status;
	}

	/**
	 * Writes configuration to Squid confifuration file. 
	 * @param string $start
	 * @param string $end
	 * @param string $conf the configuration directives to be written
	 * @param string $infile the configuration file path to read the configuration
	 * @param string $outfile the configuration file path to write the configuration 
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