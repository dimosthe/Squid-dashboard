<?php

use yii\db\Schema;
use yii\db\Migration;

class m150731_070309_add_squid_password_to_user extends Migration
{
     public function up()
    {
        $this->addColumn('user', 'squid_password', Schema::TYPE_STRING . '(60) NOT NULL');
    }
    
    public function down()
    {
        $this->dropColumn('user', 'squid_password');
    }
}
