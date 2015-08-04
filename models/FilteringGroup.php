<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filtering_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $comment
 *
 * @property BlacklistsFilteringGroup[] $blacklistsFilteringGroups
 * @property User[] $users
 */
class FilteringGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filtering_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'comment'], 'string', 'max' => 255]
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
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlacklistsFilteringGroups()
    {
        return $this->hasMany(BlacklistsFilteringGroup::className(), ['filtering_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['filtering_group_id' => 'id']);
    }
}
