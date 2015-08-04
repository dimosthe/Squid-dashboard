<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "delay_group".
 *
 * @property integer $id
 * @property string $name
 * @property integer $rate
 *
 * @property User[] $users
 */
class DelayGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delay_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rate'], 'required'],
            [['rate'], 'integer'],
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
            'rate' => 'Rate',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['delay_group_id' => 'id']);
    }
}
