<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cachestatus".
 *
 * @property integer $id
 * @property integer $enabled
 */
class Cachestatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cachestatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enabled'], 'required'],
            [['enabled'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enabled' => 'Enabled',
        ];
    }
}
