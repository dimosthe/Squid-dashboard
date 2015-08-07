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
    public $bandwidth;
    public $users_input;

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
            [['name'], 'required'],
            [['name'], 'unique'],
            [['rate'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['bandwidth', 'users_input'], 'safe'],
            [['bandwidth'], function ($attr) {
                if($this->bandwidth == 1)
                    if(empty($this->rate))
                        $this->addError('rate', 'Rate cannot be blank or 0');
                    if($this->rate < 0)
                        $this->addError('rate', 'Rate must be greater than zero');
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Group Name',
            'rate' => 'Rate (KBits/s)',
            'bandwidth' => 'Bandwidth Rate'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['delay_group_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if($this->bandwidth == 0)
                $this->rate = -1;

            return true;
        }
        else
            return false;
    }

    /**
     * Returns the users for this group as a comma separated string
     */
    public function getUsersString()
    {
        $users = [];
        foreach ($this->users as $user) 
            array_push($users, $user->username);

        return implode(', ', $users);
    }
}
