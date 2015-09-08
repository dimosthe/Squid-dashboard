<?php

use yii\db\Schema;
use yii\db\Migration;

class m150908_063333_create_cachestatus_table extends Migration
{
     public function safeUp()
    {
        $this->createTable('cachestatus', [
            'id' => Schema::TYPE_PK,
            'enabled' => Schema::TYPE_BOOLEAN . ' NOT NULL',
        ],'ENGINE=InnoDB');

        $this->insert('cachestatus', array('id'=>'', 'enabled'=>0));
    }

    public function safeDown()
    {
        $this->dropTable('cachestatus');
    }
    
}
