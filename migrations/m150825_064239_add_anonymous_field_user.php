<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\User;

class m150825_064239_add_anonymous_field_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'anonymous', Schema::TYPE_BOOLEAN.' NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'anonymous');
    }
}
