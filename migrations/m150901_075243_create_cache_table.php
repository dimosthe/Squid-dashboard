<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_075243_create_cache_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('cache', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'enabled' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
        ],'ENGINE=InnoDB');
    
        $this->insert('cache', array('id'=>'', 'name'=>'gif', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'png', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'jpg', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'jpeg', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'ico', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'eps', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'svg', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'css', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'js', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'swf', 'enabled'=>0, 'type'=>'0'));
        $this->insert('cache', array('id'=>'', 'name'=>'override-expire', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'override-lastmod', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'reload-into-ims', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'ignore-reload', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'ignore-no-store', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'ignore-must-revalidate', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'ignore-private', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'ignore-auth', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'refresh-ims', 'enabled'=>0, 'type'=>'1'));
        $this->insert('cache', array('id'=>'', 'name'=>'store-stale', 'enabled'=>0, 'type'=>'1'));
    }

    public function safeDown()
    {
        $this->dropTable('cache');
    }
}
