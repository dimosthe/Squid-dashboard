<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\AnonymityForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AnonymousController applies anonymity to users.
 */
class AnonymousController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['preferences'],
                'rules' => [
                    [
                        'actions' => ['preferences'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->getIsAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionPreferences()
    {
    	$anonymityform = new AnonymityForm();

    	if ($anonymityform->load(Yii::$app->getRequest()->post())) //&& $anonymityform->validate()) 
        {
            if(!empty($anonymityform->users)) 
            {
                $array = explode(',', $anonymityform->users);
                foreach ($array as $user_id)
                {
                    $u = User::findOne((int)$user_id);

                    if($u !== NULL)
                    {
                        $u->anonymous = 0;
                        $u->scenario ='create';
                        $u->save();
                    }
                }
            }

            if(!empty($anonymityform->anonymous_users)) 
            {
                $array = explode(',', $anonymityform->anonymous_users);
                foreach ($array as $user_id)
                {
                    $u = User::findOne((int)$user_id);

                    if($u !== NULL)
                    {
                        $u->anonymous = 1;
                        $u->scenario ='create';
                        $u->save();
                    }
                }
            }
            

            Yii::$app->getSession()->setFlash('Asuccess', 'Anonymity preferences have been successfully updated');
            //return $this->redirect(['view', 'id' => $model->id]);
        } 

        $users = User::find()
    		->select(['id', 'username', 'anonymous'])
    		->where(['anonymous' => 0])
    		->all();

    	$users_anonymous = User::find()
    		->select(['id', 'username', 'anonymous'])
    		->where(['anonymous' => 1])
    		->all();
        
    	return $this->render('preferences', [
                'users' => $users,
                'users_anonymous' => $users_anonymous,
                'anonymityform' => $anonymityform
        ]);
    }
}