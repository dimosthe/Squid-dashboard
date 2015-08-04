<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DealyGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delay Groups';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= Html::encode($this->title); ?></li>
    </ol>
</section>
<br />
<!-- Main content -->
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
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['data-pjax'=>0, 'class' => 'btn btn-success']).' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'Reset Table'])
            ],
            '{toggleData}',
        ],
        'panel'=>[
            'type'=>GridView::TYPE_SUCCESS,
            'heading'=>$this->title
        ],

        'layout'  => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'rate',

             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', Url::to(['/user/profile/show', 'id'=>$model->id]), [
                            'class' => 'btn btn-xs btn-success',
                            'title' => Yii::t('yii', 'View'),
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-wrench"></i>', $url, [
                            'class' => 'btn btn-xs btn-info',
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, [
                            'class' => 'btn btn-xs btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('user', 'Are you sure to delete this user?'),
                            'title' => Yii::t('yii', 'Delete'),
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</section>
