<?php

namespace app\controllers;

use Yii;
use app\models\Blacklist;
use app\models\BlacklistSearch;
use app\models\BlacklistDomainsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Object;
use yii\filters\AccessControl;

/**
 * BlacklistController implements the CRUD actions for Blacklist model.
 */
class BlacklistController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Blacklist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlacklistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blacklist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	$searchModel = new BlacklistDomainsSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$model->id);
        return $this->render('view', [
            'model' => $model,
        	'searchModel' => $searchModel,
        	'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Blacklist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blacklist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blacklist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
