<?php

use yii\db\Schema;
use yii\db\Migration;

class m150828_133033_add_blacklist_domains_to_audiovideo extends Migration
{
    public function safeUp()
    {
    	
    	$handle = fopen("/etc/squidguard/blacklists/audio-video/domains", "r");
    	if ($handle) {
    		while (($line = fgets($handle)) !== false) {
    			$this->insert('blacklist_domains', array('id'=>'', 'domain'=>$line, 'blacklist_id'=>'13'));
    		}
    		fclose($handle);
    	}

    }

    public function down()
    {
        echo "m150828_133033_add_blacklist_domains_to_audiovideo cannot be reverted.\n";

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
