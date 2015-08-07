<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\FilteringGroup */

$this->title = 'Update Filtering Group: ' . ' ' . $model->name;
// $this->params['breadcrumbs'][] = ['label' => 'Filtering Groups', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<section class="content-header">
	<h1><?= Html::encode($this->title) ?> <?= Html::a('Show Group', ['/filteringgroup/view','id'=>$model->id], ['class' => 'btn btn-success btn-xs']) ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?= Url::to(['/filteringgroup/index']); ?>">Website Filtering Groups</a></li>
		<li class="active"><?= Html::encode($this->title); ?></li>
	</ol>
</section>
<section class="content">
 	<div class="box box-primary">
 		<div class="box-header with-border">
    		<?= $this->render('_form', ['model' => $model, 'blists' => $blists, 'users' => $users,'selected_users' => $selected_users,
            'selected_bls' => $selected_bls]) ?>

		</div>
	</div>
</section>
