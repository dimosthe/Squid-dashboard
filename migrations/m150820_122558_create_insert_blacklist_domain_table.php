<?php

use yii\db\Schema;
use yii\db\Migration;

class m150820_122558_create_insert_blacklist_domain_table extends Migration
{
    public function safeUp()
    {
    	$this->createTable('blacklist_domains', [
    			'id' => Schema::TYPE_PK,
    			'domain' => Schema::TYPE_STRING . ' NOT NULL',
    			'blacklist_id' => Schema::TYPE_INTEGER . ' NOT NULL',
    	],'ENGINE=InnoDB');
    	
    	$this->addForeignKey('FK_BL_DOMAIN_BL_ID','blacklist_domains','blacklist_id','blacklist','id','CASCADE','CASCADE');
    	
    	
    	$handle = fopen("/etc/squidguard/blacklists/malware/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'1'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/social_networks/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'2'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/adult/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'3'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/aggressive/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'4'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/socialnetworking/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'5'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/drugs/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'6'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/mixed_adult/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'7'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/violence/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'8'));
    		}
    		fclose($handle);
    	}
    	
    	$handle = fopen("/etc/squidguard/blacklists/porn/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'9'));
    		}
    		fclose($handle);
    	}
    		
    	
    	
    		return true;
    	
    }

    public function down()
    {
    	echo "m150805_133741_insert_blacklists cannot be reverted.\n";
    	
    	return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
