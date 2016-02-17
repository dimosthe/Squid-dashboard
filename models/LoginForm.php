<?php
/** 
 * This model overrides the LoginForm model defined in yii2-user module
 * methods overrided:
 * -> rules(),
 *
 * @author George Dimosthenous
 * 
 **/
namespace app\models;

use dektrium\user\models\LoginForm as BaseLoginForm;
use dektrium\user\helpers\Password;

class LoginForm extends BaseLoginForm
{
    /** @inheritdoc */
    public function rules()
    {
        return [
            'requiredFields' => [['login', 'password'], 'required'],
            'loginTrim' => ['login', 'trim'],
            'passwordValidate' => ['password', function ($attribute) {
                if ($this->user === null || !Password::validate($this->password, $this->user->password_hash)) {
                    $this->addError($attribute, \Yii::t('user', 'Invalid login or password'));
                }
                elseif (!$this->user->isAdmin) {
                    $this->addError($attribute, \Yii::t('user', 'Only administrators are able to access this area'));
                }
            }],
            'confirmationValidate' => ['login', function ($attribute) {
                if ($this->user !== null) {
                    $confirmationRequired = $this->module->enableConfirmation && !$this->module->enableUnconfirmedLogin;
                    if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                        $this->addError($attribute, \Yii::t('user', 'You need to confirm your email address'));
                    }
                    if ($this->user->getIsBlocked()) {
                        $this->addError($attribute, \Yii::t('user', 'Your account has been blocked'));
                    }   
                }
            }],
            'rememberMe' => ['rememberMe', 'boolean'],
        ];
    }
}