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
			$temp[$user->id] = ['content' => $user->username];
		}
		/*if(!$model->isNewRecord)
		{
			$temp1 = [];
			foreach ($sel as $category) {
				$temp1[$category->id] = ['content' => $category->name];
			}
		}*/
		$temp1 = [];
		?>
		<div class="row">
			<div class="col-sm-6">
				<strong>Users</strong></br></br>
				<?php
				echo SortableInput::widget([
					'name'=>'all-users',
					'items' => $temp,
					'hideInput' => true,
					'sortableOptions' => [
						'connected'=>true,
					],
					'options' => ['class'=>'form-control', 'readonly'=>true]
				]);
				?>
			</div>
			<div class="col-sm-6">
				<strong>Selected Users</strong></br></br>
				<?php
				echo $form->field($model, 'users')->begin();
				echo Html::error($model,'users', ['class' => 'help-block']);
				echo $form->field($model, 'users')->end();
				
				echo SortableInput::widget([
					'name'=>'DelayGroup[users]',
					'items' => $model->isNewRecord? []: $temp1,
					'hideInput' => true,
					'sortableOptions' => [
						'itemOptions'=>['class'=>'alert alert-warning'],
						'connected'=>true,
					],
					'options' => ['class'=>'form-control', 'readonly'=>true]
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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 <?php 
 	$this->registerJsFile(Yii::$app->request->baseUrl.'/scripts/hide.js',['depends' => [\yii\web\JqueryAsset::className()]]);
 	 $this->registerJsFile(Yii::$app->request->baseUrl.'/scripts/draggable.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
?>