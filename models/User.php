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
       return [
            // username rules
            'usernameRequired' => ['username', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'usernameMatch' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            'usernameLength' => ['username', 'string', 'min' => 3, 'max' => 25],
            'usernameUnique' => ['username', 'unique'],
            'usernameTrim' => ['username', 'trim'],

            // email rules
            'emailRequired' => ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'emailPattern' => ['email', 'email'],
            'emailLength' => ['email', 'string', 'max' => 255],
            'emailUnique' => ['email', 'unique'],
            'emailTrim' => ['email', 'trim'],

            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register']],
            'passwordLength' => ['password', 'string', 'min' => 6, 'on' => ['register', 'create']],
            'anonymousSafe' => ['anonymous', 'integer', 'on' => ['create', 'update']]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['create'] = ['username', 'email', 'password', 'anonymous'];
        $scenarios['update'] = ['username', 'email', 'password', 'anonymous'];
        return $scenarios;
    }
}
