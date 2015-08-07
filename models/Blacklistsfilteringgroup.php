<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blacklists_filtering_group".
 *
 * @property integer $id
 * @property integer $filtering_group_id
 * @property integer $blacklist_id
 * @property string $comments
 *
 * @property Blacklist $blacklist
 * @property FilteringGroup $filteringGroup
 */
class Blacklistsfilteringgroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blacklists_filtering_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filtering_group_id', 'blacklist_id'], 'required'],
            [['filtering_group_id', 'blacklist_id'], 'integer'],
            [['comments'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filtering_group_id' => 'Filtering Group ID',
            'blacklist_id' => 'Blacklist ID',
            'comments' => 'Comments',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlacklist()
    {
        return $this->hasOne(Blacklist::className(), ['id' => 'blacklist_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilteringGroup()
    {
        return $this->hasOne(FilteringGroup::className(), ['id' => 'filtering_group_id']);
    }
}
