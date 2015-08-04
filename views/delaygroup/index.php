<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DealyGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delay Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delay-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Delay Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'rate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
