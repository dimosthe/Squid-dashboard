<?php

use yii\db\Schema;
use yii\db\Migration;

class m150805_133741_insert_blacklists extends Migration
{
    public function safeUp()
    {
		$this->insert('blacklist', array('id'=>'', 'name'=>'malware', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'social_networks', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'adult', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'aggressive', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'socialnetworking', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'drugs', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'mixed_adult', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'violence', 'comments'=>''));
		$this->insert('blacklist', array('id'=>'', 'name'=>'porn', 'comments'=>''));
    }

    public function safeDown()
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
