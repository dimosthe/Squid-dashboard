<?php

namespace app\helpers;
use yii\helpers\Html;
use app\models\FilteringGroup;
use app\models\User;

class SquidGuard
{
	const SQUIDGUARD_CONF = '/etc/squidguard/squidGuard.conf';
	const SQUIDGUARD_DEFAULT_CONF = '/home/proxyvnf/dashboard/Squid-dashboard/SquidGuard/squidGuard.conf';
	const FILTERING_GROUP_SPECIFICATION_TEMPLATE = "src %s{\n\tuser %s \n}\n";
	const FILTERING_GROUP_ACL_TEMPLATE = "\t%s { \n\t\tpass %s all \n\t\tredirect http://localhost/squid/denied?\n\t}\n";
	
	public static function writeconfig()
	{
		$groups = FilteringGroup::find()->with('users')->all();
		$filtering_groups = [];
		$filtering_group_acls = [];
		
		foreach ($groups as $group)
		{
			if(!empty($group->users))
			{
				/*
				 * Preparing the filtering group definitions. 
				 */				
				array_push($filtering_groups, sprintf(SquidGuard::FILTERING_GROUP_SPECIFICATION_TEMPLATE, $group->name, $group->getUsersStringSpaced()));

				/*
				 * Preparing the blacklists for this filetring group
				 */
				$blacklists = '!'.implode(' !',explode(',',$group->getBlacklistsNames()));
				array_push($filtering_group_acls, sprintf(SquidGuard::FILTERING_GROUP_ACL_TEMPLATE,$group->name,$blacklists));
				
			}
		}
		
		if (SquidGuard::write("#SOURCE ADDRESSES", "#SOURCE ADDRESSES END", implode('',$filtering_groups), SquidGuard::SQUIDGUARD_DEFAULT_CONF,SquidGuard::SQUIDGUARD_CONF)===false){
			return false;
		}
		
		if (SquidGuard::write("#ACL RULES", "#ACL RULES END", implode('',$filtering_group_acls), SquidGuard::SQUIDGUARD_CONF,SquidGuard::SQUIDGUARD_CONF)===false){
			return false;
		}
			
		return true;
	}
	
	/**
	 * Starts SquidGurad server
	 * @return string
	 */
	public static function start()
	{
		$status = shell_exec('sudo service squidguard start');
	
		return $status;
	}
	
	/**
	 * Stops SquidGuard server
	 * @return string
	 */
	public static function stop()
	{
		$status = shell_exec('sudo service squidguard stop');
	
		return $status;
	}
	
	/**
	 * Restarts SquidGuard server
	 * @return string
	 */
	public static function restart()
	{
		$status = shell_exec('sudo service squidguard restart');
	
		return $status;
	}
	
	private static function write($start, $end, $conf, $infile = Squid::SQUID_CONF, $outfile = Squid::SQUID_CONF)
	{
		$file = @file_get_contents($infile); 
		
		if($file === false){
			return false;
		}
	
		$pos_start = strpos($file, $start);
		$pos_end = strpos($file, $end);
	
		if($pos_start === false || $pos_end === false){
			return false;
		}
	
		$a = substr($file, 0, $pos_start + strlen($start));
		$b = substr($file, $pos_end);
	
		if(file_put_contents($outfile, $a."\n". $conf . "\n" .$b) === false){
			return false;
		}
		return true;
	}
		
	
}