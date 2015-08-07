<?php

namespace app\controllers;

use Yii;
use app\models\DelayGroup;
use app\models\DelayGroupSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DelayGroupController implements the CRUD actions for DelayGroup model.
 */
class DelaygroupController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all DelayGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DelayGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DelayGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new DelayGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DelayGroup();

        $users = User::find()->select(['id', 'username', 'delay_group_id'])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            if(!empty($model->users_input)) 
            {
                $array = explode(',', $model->users_input);
                foreach ($array as $user_id)
                {
                    $u = User::findOne((int)$user_id);

                    if($u !== NULL)
                    {
                        $u->delay_group_id = $model->id;
                        $u->scenario ='create';
                        $u->save();
                    }
                }
            }

            Yii::$app->getSession()->setFlash('success', 'Group has been successfully created');
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('create', [
                'model' => $model,
                'users' => $users
            ]);
        }
    }

    /**
     * Updates an existing DelayGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // get selected users
        $selected_users = $model->users; 
        $sel_users_array = [];
        foreach ($selected_users as $user) {
            array_push($sel_users_array, $user->id);
        }

        // get un-selected users
        $users = User::find() 
            ->where(['not in', 'id', $sel_users_array])
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            $array = explode(',', $model->users_input);
            foreach ($array as $user_id)
            {
                $key = array_search($user_id, $sel_users_array);
                if($key !== false)
                    unset($sel_users_array[$key]);
                else
                {
                    $u = User::findOne((int)$user_id);

                    if($u !== NULL)
                    {
                        $u->delay_group_id = $model->id;
                        $u->scenario ='create';
                        $u->save();
                    }
                }
            }
            foreach ($sel_users_array as $id)
            {
                $u = User::findOne((int)$id);

                if($u !== NULL)
                {
                    $u->delay_group_id = NULL;
                    $u->scenario ='create';
                    $u->save();
                }
            }

            Yii::$app->getSession()->setFlash('success', 'Group has been successfully updated');
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
                'users' => $users,
                'selected_users' => $selected_users
            ]);
        }
    }

    /**
     * Deletes an existing DelayGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', 'Group has been successfully deleted');

        return $this->redirect(['index']);
    }

    /**
     * Finds the DelayGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DelayGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DelayGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
