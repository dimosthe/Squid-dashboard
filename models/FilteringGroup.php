<?php

namespace app\models;

use Yii;
use yii\base\Object;
use app\models\Blacklist;
use app\models\Blacklistsfilteringgroup;
use yii\helpers\Html;

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
	public $users_input;
	public $users_input_bl;
	
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
            [['name', 'users_input_bl'], 'required'],
            [['name', 'comment'], 'string', 'max' => 255],
        	[['users_input'], 'safe'],
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
        	'users_input_bl' => 'Content Categories'
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
    
    /**
     * Returns the users for this group as a comma separated string
     */
    public function getUsersStringSpaced()
    {
    	$users = [];
    	foreach ($this->users as $user)
    		array_push($users, $user->username);
    
    	return implode(' ', $users);
    }
    
    /**
     * Returns the blacklists for this group as a comma separated string
     */
    public function getBlacklistsString()
    {
    	$bl_names = [];
    	foreach ($this->blacklistsFilteringGroups as $blid){
    		$result = Blacklist::find()->where(['id' => (int)$blid->blacklist_id])->one();
    		array_push($bl_names,Html::a($result->name,['/blacklist/view', 'id' => (int)$blid->blacklist_id],['data-pjax'=>0,]));
    	}
    	return implode(', ', $bl_names);
    }
    
    /**
     * Returns the blacklists for this group as a comma separated string
     */
    public function getBlacklistsNames()
    {
    	$bl_names = [];
    	foreach ($this->blacklistsFilteringGroups as $blid){
    		$result = Blacklist::find()->where(['id' => (int)$blid->blacklist_id])->one();
    		array_push($bl_names,$result->name);
    	}
    	return implode(',', $bl_names);
    }
}
