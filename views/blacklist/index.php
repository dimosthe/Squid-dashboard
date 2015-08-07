<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BlacklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blacklists';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= Html::encode($this->title); ?></li>
    </ol>
</section>
<br />
<section class="content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'pjax'=> true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
            'options' => ['enablePushState' => false],
        ],
        'responsive' => true,
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'toolbar'=> [
            '{toggleData}',
        ],
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
            'heading'=>$this->title
        ],

        'layout'  => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
// 			[
//                 'header' => 'Users',
//                 'value' => function ($model, $key, $index, $widget) {
//                     return $model->getUsersString();
//                 },
//             ],
//             [
//             'header' => 'Blocked Content',
//             'value' => function ($model, $key, $index, $widget) {
//             	return $model->getBlacklistsString();
//             },
//             ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                            'class' => 'btn btn-xs btn-success',
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax'=>0
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
</section>
