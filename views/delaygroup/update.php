<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\DelayGroup */

$this->title = 'Update Group';
?>
<section class="content-header">
	<h1><?= Html::encode($this->title) ?> <?= Html::a('<i class="glyphicon glyphicon-eye-open"></i> View', ['/delaygroup/view','id'=>$model->id], ['class' => 'btn btn-success']) ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?= Url::to(['/delaygroup/index']); ?>">Web Access Groups</a></li>
		<li class="active"><?= Html::encode($this->title); ?></li>
	</ol>
</section>
<section class="content">
 	<div class="box box-primary">
 		<div class="box-header with-border">
    		<?= $this->render('_form', [
        		'model' => $model,
        		'users' => $users,
        		'selected_users' => $selected_users
    		]) ?>

		</div>
	</div>
</section>
