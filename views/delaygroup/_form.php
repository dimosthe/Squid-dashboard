<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
/* @var $model app\models\DelayGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delay-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php 
    	if($model->isNewRecord)
    	 	$model->bandwidth = $model->bandwidth? $model->bandwidth : 0;
    	else
    	{
    		$model->bandwidth = $model->rate == -1? 0:1;
    		$model->rate = $model->rate == -1? "":$model->rate;
    	}
    ?>

    <?= $form->field($model, 'bandwidth')->radioList([0=>" Unlimited", 1=>" Custom"], ['separator'=>'</br>']) ?>

    <?php if($model->bandwidth): ?>
		<div id="bandwidth">
	<?php else: ?>
		<div id="bandwidth" style="display: none;">
	<?php endif?>
    
    	<?= $form->field($model, 'rate')->textInput() ?>
    </div>

     <?php
		$temp = [];
		foreach ($users as $user) {
			$status = $user->delay_group_id === NULL? false:true;
			$temp[$user->id] = ['content' => $user->username, 'disabled'=>$status];
		}
		if(!$model->isNewRecord)
		{
			$temp1 = [];
			foreach ($selected_users as $user) {
				$temp1[$user->id] = ['content' => $user->username];
			}
		}
		?>
		<div class="row">
			<div class="col-sm-6">
				<strong>Users</strong></br></br>
				<?php
				echo SortableInput::widget([
					'name'=>'all-users',
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
				<strong>Selected Users</strong></br></br>
				<?php
				echo SortableInput::widget([
					'name'=>'DelayGroup[anonymous_users]',
					'id' => 'sortable2',
					'items' => $model->isNewRecord? []: $temp1,
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
		
		<?php echo '</br></br>';
		?>
		<div class="alert alert-info">
			Drag and drop to add/remove a user
		</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'foo']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 <?php 
 	$this->registerJsFile(Yii::$app->request->baseUrl.'/scripts/hide.js',['depends' => [\yii\web\JqueryAsset::className()]]);
 	$this->registerJsFile(Yii::$app->request->baseUrl.'/scripts/draggable.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
?>