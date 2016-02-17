<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\FilteringGroup */

$this->title = $model->name;

?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?> <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Update', ['/filteringgroup/update','id'=>$model->id], ['class' => 'btn btn-success'])?>
         <?= Html::a(Yii::t('app', '<i class="glyphicon glyphicon-remove"></i> Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this group?'),
                'method' => 'post',
            ],
        ]) ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= Url::to(['/filteringgroup/index']); ?>">Website Filtering Groups</a></li>
        <li class="active"><?= Html::encode($this->title); ?></li>
    </ol>
</section>

<section class="content">
    <?php if (Yii::$app->getSession()->hasFlash('FGsuccess')): ?>
        <div class="alert alert-success">
            <p><?= Yii::$app->getSession()->getFlash('FGsuccess') ?></p>
        </div>
    <?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        	[
	        	'label' => 'Blocked Content',
	        	'value' =>  $model->getBlacklistsString(),
        		'format' => 'html',
        	],
            [
                'label' => 'Joined Users',
                'value' => $model->getUsersString()
            ],
        ],
    ]) ?>
</section>
