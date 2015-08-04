<?php

use yii\db\Schema;
use yii\db\Migration;

class m150803_143410_create_user_group_table extends Migration
{
    public function safeUp()
    {
	$this->createTable('delay_group', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'rate' => Schema::TYPE_INTEGER . ' NOT NULL',
        ],'ENGINE=InnoDB');

	$this->createTable('filtering_group', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'comment' => Schema::TYPE_STRING,
        ],'ENGINE=InnoDB');

	$this->addColumn('user', 'delay_group_id', Schema::TYPE_INTEGER);
	$this->addColumn('user', 'filtering_group_id', Schema::TYPE_INTEGER);

	$this->addForeignKey('FK_USER_FILTERING_GROUP','user','delay_group_id','delay_group','id','CASCADE','CASCADE');
	$this->addForeignKey('FK_USER_DELAY_GROUP','user','filtering_group_id','filtering_group','id','CASCADE','CASCADE');

	$this->createTable('blacklist', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'comments' => Schema::TYPE_STRING,
        ],'ENGINE=InnoDB');

	$this->createTable('blacklists_filtering_group', [
	    'id' => Schema::TYPE_PK,
            'filtering_group_id' => Schema::TYPE_INTEGER . ' NOT NULL',
	    'blacklist_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'comments' => Schema::TYPE_STRING,
        ],'ENGINE=InnoDB');
	$this->addForeignKey('FK_GROUP_PERMISSION_filtering_group','blacklists_filtering_group','filtering_group_id','filtering_group','id','CASCADE','CASCADE');
        $this->addForeignKey('FK_GROUP_PERMISSION_blacklist','blacklists_filtering_group','blacklist_id','blacklist','id','CASCADE','CASCADE');


    }

    public function safeDown()
    {
        echo "m150803_143410_create_user_group_table being reverted.\n";
	$this->dropTable('user_category');
	$this->dropTable('permission_category');
	$this->dropTable('category');
	$this->dropTable('permission');
        return true;
    }
}
