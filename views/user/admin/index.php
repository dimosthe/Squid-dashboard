<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\UserSearch;
use yii\data\ActiveDataProvider;
//use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= Html::encode($this->title); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
	<?= $this->render('@dektrium/user/views/_alert', [
    	'module' => Yii::$app->getModule('user'),
	]) ?>

	<?= $this->render('@dektrium/user/views/admin/_menu') ?>
	
	<?php //Pjax::begin() ?>

	<?= GridView::widget([
	    'dataProvider' => $dataProvider,
	    'filterModel'  => $searchModel,
	    'export' => false,
		'pjax'=> true,
		'pjaxSettings'=>[
			'neverTimeout'=>true,
			'options' => ['enablePushState' => false],
		],
		'responsive' => true,
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],

	    'layout'  => "{items}\n{pager}",
	    'columns' => [
	        'username',
	        'email:email',
	        [
	            'attribute' => 'registration_ip',
	            'value' => function ($model) {
	                    return $model->registration_ip == null
	                        ? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>'
	                        : $model->registration_ip;
	                },
	            'format' => 'html',
	        ],
	        [
	            'attribute' => 'created_at',
	            'value' => function ($model) {
	                return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
	            },
	            'filter' => DatePicker::widget([
	                'model'      => $searchModel,
	                'attribute'  => 'created_at',
	                'dateFormat' => 'php:Y-m-d',
	                'options' => [
	                    'class' => 'form-control'
	                ]
	            ]),
	        ],
	        [
	            'header' => Yii::t('user', 'Confirmation'),
	            'value' => function ($model) {
	                if ($model->isConfirmed) {
	                    return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
	                } else {
	                    return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
	                        'class' => 'btn btn-xs btn-success btn-block',
	                        'data-method' => 'post',
	                        'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
	                    ]);
	                }
	            },
	            'format' => 'raw',
	            'visible' => Yii::$app->getModule('user')->enableConfirmation
	        ],
	        [
	            'header' => Yii::t('user', 'Block status'),
	            'value' => function ($model) {
	                if ($model->isBlocked) {
	                    return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
	                        'class' => 'btn btn-xs btn-success btn-block',
	                        'data-method' => 'post',
	                        'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?')
	                    ]);
	                } else {
	                    return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
	                        'class' => 'btn btn-xs btn-danger btn-block',
	                        'data-method' => 'post',
	                        'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?')
	                    ]);
	                }
	            },
	            'format' => 'raw',
	        ],
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