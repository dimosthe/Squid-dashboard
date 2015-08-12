<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blacklist".
 *
 * @property integer $id
 * @property string $name
 * @property string $comments
 *
 * @property BlacklistsFilteringGroup[] $blacklistsFilteringGroups
 */
class Blacklist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blacklist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'comments'], 'string', 'max' => 255]
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
            'comments' => 'Comments',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlacklistsFilteringGroups()
    {
        return $this->hasMany(BlacklistsFilteringGroup::className(), ['blacklist_id' => 'id']);
    }
    
    public function getBlacklistURL(){
    	$path = "/etc/squidguard/blacklists/".$this->name.'/urls';
    	$urls = file($path) or die("Unable to open file!");
//     	$urls =  fread($myfile,filesize($path));
//     	fclose($myfile);
    	return implode(', ',$urls);
    }
}
