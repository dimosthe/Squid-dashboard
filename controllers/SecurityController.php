<?php
/** 
 * This controller overrides the SecurityController defined in yii2-user module
 * methods overrided:
 * -> login(), gets user profile after succesfully logged in
 *
 * @author George Dimosthenous
 * 
 **/

namespace app\controllers;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;
use dektrium\user\models\Profile;
use Yii;
use app\models\User;

class SecurityController extends BaseSecurityController
{
    public function actionLogin()
	{
		$this->layout = '@app/views/layouts/noheader';

		if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = \Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);
      
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) 
        {   
            $user_id = \Yii::$app->user->identity->id;
            $profile = Profile::findOne(['user_id' => $user_id]);
            $name = is_null($profile->name) || !(trim($profile->name))?\Yii::$app->user->identity->username:$profile->name;

            \Yii::$app->session->set('user.name', $name);
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
	}
}