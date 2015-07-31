<?php
namespace app\controllers;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;
use dektrium\user\Finder;
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
            $finder = new Finder;
            $user = User::findOne($user_id);
            //$profile = //$finder->findProfileById($user_id);
            //if($profile !== null)
            //    $name = is_null($profile->name) || !(trim($profile->name))?\Yii::$app->user->identity->username:$profile->name;
            //else
                $name = $user->username;//\Yii::$app->user->identity->username;
            \Yii::$app->session->set('user.name', $name);
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
	}
}