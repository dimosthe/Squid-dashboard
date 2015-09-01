<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cache".
 *
 * @property integer $id
 * @property string $name
 * @property integer $enabled
 * @property integer $type
 */
class Cache extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cache';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'enabled', 'type'], 'required'],
            [['enabled', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'enabled' => 'Enabled',
            'type' => 'Type',
        ];
    }
}
