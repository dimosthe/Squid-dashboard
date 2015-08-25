<?php
/**
* Overrides the dektrium\user\models\User model
**/
namespace app\models;

use dektrium\user\models\User as BaseUser;
use dektrium\user\helpers\Password;

class User extends BaseUser
{
    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            if (\Yii::$app instanceof \yii\web\Application) {
                $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', Password::hash($this->password));
            $this->setAttribute('squid_password', md5($this->password));
        }

        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return $labels['anonymous'] = 'Anonymous Access';
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();

        $rules["anonymousSafe"] = ['anonymous', 'integer', 'on' => ['create', 'update']];
        return $rules;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['create'] = ['username', 'email', 'password', 'anonymous'];
        $scenarios['update'] = ['username', 'email', 'password', 'anonymous'];
        return $scenarios;
    }
}
