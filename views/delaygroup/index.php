<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DealyGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Web Access Groups';
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
     <?php if (Yii::$app->getSession()->hasFlash('DGsuccess')): ?>
        <div class="alert alert-success">
            <p><?= Yii::$app->getSession()->getFlash('DGsuccess') ?></p>
        </div>
    <?php endif; ?>
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
            'type'=>GridView::TYPE_PRIMARY,
            'heading'=>$this->title
        ],

        'layout'  => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'rate',
                'value' => function ($model, $key, $index, $widget) {
                    return ($model->rate == -1)? "unlimited" : $model->rate;
                }
            ],
            [
                'header' => 'Users',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->getUsersString();
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $url, [
                            'class' => 'btn btn-xs btn-success',
                            'title' => Yii::t('yii', 'View'),
                            'data-pjax'=>0
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-wrench"></i>', $url, [
                            'class' => 'btn btn-xs btn-info',
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, [
                            'class' => 'btn btn-xs btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('user', 'Are you sure to delete this group?'),
                            'title' => Yii::t('yii', 'Delete'),
                            'data-pjax'=>0
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</section>
