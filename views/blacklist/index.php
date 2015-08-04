<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BlacklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blacklists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blacklist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Blacklist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'comments',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
