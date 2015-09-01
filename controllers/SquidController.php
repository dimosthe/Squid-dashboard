<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SquidController extends Controller
{
	public function actionDenied()
    {
        $this->layout = 'noheader';
        return $this->render('denied');
    }

}