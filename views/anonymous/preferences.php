<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\sortinput\SortableInput;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DelayGroup */

$this->title = 'Anonymity Preferences';
?>
<section class="content-header">
	<h1><?= Html::encode($this->title) ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><?= Html::encode($this->title); ?></li>
	</ol>
</section>

<section class="content">
	<?php if (Yii::$app->getSession()->hasFlash('Asuccess')): ?>
        <div class="alert alert-success">
            <p><?= Yii::$app->getSession()->getFlash('Asuccess') ?></p>
        </div>
    <?php endif; ?>
 	<div class="box box-primary">
 		<div class="box-header with-border">
 			<?php 
 			$temp = [];
			foreach ($users as $user) {
				$temp[$user->id] = ['content' => $user->username];
			}

			$temp1 = [];
			foreach ($users_anonymous as $user) {
				$temp1[$user->id] = ['content' => $user->username];
			}
 			?>
 			<?php $form = ActiveForm::begin(); ?>
 			<div class="row">
				<div class="col-sm-6">
					<strong>Users</strong></br></br>
					<?php
					echo SortableInput::widget([
						'name'=>'AnonymityForm[users]',
						'id' => 'sortable1',
						'items' => $temp,
						'hideInput' => true,
						'sortableOptions' => [
							'connected'=>true,	
							'itemOptions'=>['role'=>'option', 'aria-grabbed' =>'false', 'draggable' =>'true'],
						],
						'options' => ['class'=>'form-control', 'readonly'=>true, 'data-sortable'=>'sortable2-sortable']
					]);
					?>
				</div>
				<div class="col-sm-6">
					<strong>Anonymously Users</strong></br></br>
					<?php
					echo SortableInput::widget([
						'name'=>'AnonymityForm[anonymous_users]',
						'id' => 'sortable2',
						'items' => $temp1,
						'hideInput' => true,
						'sortableOptions' => [
							'itemOptions'=>['class'=>'alert alert-warning', 'role'=>'option', 'aria-grabbed' =>'false', 'draggable' =>'true'],
							'connected'=>true,
						],
						'options' => ['class'=>'form-control', 'readonly'=>true, 'data-sortable'=>'sortable2-sortable']
						]);
					?>
				</div>
			</div>
		
			<?php echo '</br></br>'; ?>
			<div class="alert alert-info">
				Drag and drop to add/remove a user
			</div>
    		
    		 <div class="form-group">
        		<?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id'=>'foo']) ?>
    		</div>

    		<?php ActiveForm::end(); ?>
    	</div>
    </div>
</section>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/scripts/draggable.js',['depends' => [\yii\web\JqueryAsset::className()]]); ?>
