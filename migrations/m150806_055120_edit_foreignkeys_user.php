<?php

use yii\db\Schema;
use yii\db\Migration;

class m150806_055120_edit_foreignkeys_user extends Migration
{
    public function up()
    {
        $this->dropForeignKey('FK_USER_FILTERING_GROUP', 'user');
        $this->dropForeignKey('FK_USER_DELAY_GROUP', 'user');

        $this->addForeignKey('FK_USER_FILTERING_GROUP','user','delay_group_id','delay_group','id','SET NULL','CASCADE');
        $this->addForeignKey('FK_USER_DELAY_GROUP','user','filtering_group_id','filtering_group','id','SET NULL','CASCADE');
    }

    public function down()
    {
        echo "m150806_055120_edit_foreignkeys_user being reverted.\n";

        $this->dropForeignKey('FK_USER_FILTERING_GROUP', 'user');
        $this->dropForeignKey('FK_USER_DELAY_GROUP', 'user');

        $this->addForeignKey('FK_USER_FILTERING_GROUP','user','delay_group_id','delay_group','id','CASCADE','CASCADE');
        $this->addForeignKey('FK_USER_DELAY_GROUP','user','filtering_group_id','filtering_group','id','CASCADE','CASCADE');

        return true;
    }
}
