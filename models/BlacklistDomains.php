<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blacklist_domains".
 *
 * @property integer $id
 * @property string $domain
 * @property integer $blacklist_id
 *
 * @property Blacklist $blacklist
 */
class BlacklistDomains extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blacklist_domains';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['domain', 'blacklist_id'], 'required'],
            [['blacklist_id'], 'integer'],
            [['domain'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'blacklist_id' => 'Blacklist ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlacklist()
    {
        return $this->hasOne(Blacklist::className(), ['id' => 'blacklist_id']);
    }
}
