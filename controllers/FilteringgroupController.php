<?php

namespace app\controllers;

use Yii;
use app\models\FilteringGroup;
use app\models\FilteringGroupSearch;
use app\models\Blacklist;
use app\models\Blacklistsfilteringgroup;
use app\models\User;
use app\models\BlacklistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Object;
use yii\filters\AccessControl;

/**
 * FilteringGroupController implements the CRUD actions for FilteringGroup model.
 */
class FilteringgroupController extends Controller
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
     * Lists all FilteringGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilteringGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FilteringGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FilteringGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FilteringGroup();
        $users = User::find()->select(['id', 'username', 'delay_group_id'])->all();
        $blists = Blacklist::find()->select(['id', 'name'])->all();
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	
        	$selected_blists = $model->users_input_bl;
        	foreach ($selected_blists as $b_id){
        		$blistFGmodel = new Blacklistsfilteringgroup();
        		$blistFGmodel->filtering_group_id = $model->id;
        		$blistFGmodel->blacklist_id = (int)$b_id;
        		$blistFGmodel->save();
        	}
        	
        	if(!empty($model->users_input))
        	{
        		$array = explode(',', $model->users_input);
        		foreach ($array as $user_id)
        		{
        			$u = User::findOne((int)$user_id);
        			if($u !== NULL)
        			{
        				$u->filtering_group_id = $model->id;
        				$u->scenario ='create';
        				$u->save();
        			}
        		}
        	}
        	
        	Yii::$app->getSession()->setFlash('FGsuccess', 'Website Filtwering Group has been successfully created');
        	
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model, 'blists' => $blists, 'users' => $users
            ]);
        }
    }

    /**
     * Updates an existing FilteringGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $users = User::find()->select(['id', 'username', 'delay_group_id'])->all();
        $blists = Blacklist::find()->select(['id', 'name'])->all();
        
        $selected_bls = [];
        foreach ($model->blacklistsFilteringGroups as $blid){
        	array_push($selected_bls, (int)$blid->blacklist_id);
        }
        
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
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	
        	/*
        	 * If the user made changes to the group's blacklists:
        	 * 1. Deleting all entries in the blacklists_filtering_group table for the specific group.
        	 * 2. Update the blacklists_filtering_group table with the user's new selections.
        	 * 
        	 */
        	$selected_blists = $model->users_input_bl;
        	print_r($selected_blists);
        	if ($selected_bls != $selected_blists){
	        	Blacklistsfilteringgroup::deleteAll(['filtering_group_id' => $model->id]);
	        	foreach ($selected_blists as $b_id){
	        		$blistFGmodel = new Blacklistsfilteringgroup();
	        		$blistFGmodel->filtering_group_id = $model->id;
	        		$blistFGmodel->blacklist_id = (int)$b_id;
	        		$blistFGmodel->save();
	        	}
        	}
        	
        	/*
        	 * Updating the users that are assigned to this filtering group
        	 */
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
                        $u->filtering_group_id = $model->id;
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
                    $u->filtering_group_id = NULL;
                    $u->scenario ='create';
                    $u->save();
                }
            }

            Yii::$app->getSession()->setFlash('FGsuccess', 'Website Filtering Group has been successfully updated');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model, 'blists' => $blists, 'users' => $users,'selected_users' => $selected_users, 'selected_bls' => $selected_bls      
            ]);
        }
    }

    /**
     * Deletes an existing FilteringGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FilteringGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FilteringGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FilteringGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
