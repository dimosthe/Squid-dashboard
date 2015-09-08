<?php

namespace app\controllers;

use Yii;
//use app\models\Cache;
//use app\models\CacheForm;
use app\models\Cachestatus;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AnonymousController applies anonymity to users.
 */
class CacheController extends Controller
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
                    ],
                ],
            ],
        ];
    }

    public function actionPreferences()
    {
        $cachestatus = Cachestatus::findOne(1);

        if($cachestatus->load(Yii::$app->getRequest()->post()) && $cachestatus->save())
        {
            Yii::$app->getSession()->setFlash('Csuccess', 'Caching status has been successfully updated');
            return $this->refresh();
        }

        return $this->render('preferences', [
            'cachestatus' => $cachestatus,
        ]);
    }

    /*public function actionPreferences()
    {
        $cacheform = new CacheForm();
        $patterns = Cache::find()->where(['type' => 0])->all();
        $patterns_enabled = Cache::find()->where(['type' => 0, 'enabled' => 1])->all();
        $options = Cache::find()->where(['type' => 1])->all();
        $options_enabled = Cache::find()->where(['type' => 1, 'enabled' => 1])->all();


        if($cacheform->load(Yii::$app->getRequest()->post()))
        {
            Cache::updateAll(['enabled' => 0]);

            if(!empty($cacheform->patterns))
                foreach ($cacheform->patterns as $pattern) {
                    $p = Cache::findOne((int)$pattern);
                    
                    if($p !== NULL)
                    {
                        $p->enabled = 1;
                        $p->save();
                    }
                }

            if(!empty($cacheform->options))
                foreach ($cacheform->options as $option) {
                    $o = Cache::findOne((int)$option);
                    
                    if($o !== NULL)
                    {
                        $o->enabled = 1;
                        $o->save();
                    }
                }
            Yii::$app->getSession()->setFlash('Csuccess', 'Caching preferences have been successfully updated');
            return $this->refresh();
        }

        return $this->render('preferences', [
            'patterns' => $patterns,
            'patterns_enabled' => $patterns_enabled,
            'options' => $options,
            'options_enabled' => $options_enabled,
            'cacheform' => $cacheform,
        ]);
    }*/
}