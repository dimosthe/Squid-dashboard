<?php

use yii\db\Schema;
use yii\db\Migration;

class m150828_131209_update_blacklists extends Migration
{
    public function safeUp()
    {
    	$this->insert('blacklist', array('id'=>'', 'name'=>'audio-video', 'comments'=>''));

    }

    public function safeDown()
    {
        echo "m150828_131209_update_blacklists cannot be reverted.\n";

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
