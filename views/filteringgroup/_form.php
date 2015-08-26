<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveField;
use kartik\sortinput\SortableInput;
/* @var $this yii\web\View */
/* @var $model app\models\FilteringGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filtering-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php 
	    $bl = [];
// 	    print_r(array_values($blists));
	    foreach ($blists as $blist) {
	    	$bl[$blist['id']] = Html::a($blist['name'],['/blacklist/view', 'id' => (int)$blist['id']],['data-pjax'=>0,]);
	    }
	    /*
	     * If selected_bls does not exist then request came from create and no blacklists are selected.
	     * Otherwise the request came from Update and the selected_bls array exists.
	     */
	    try{
	    	$model->users_input_bl=  $selected_bls;
	    } catch (Exception $e){
	    	$model->users_input_bl = [];
	    }
    ?>
    
    
    <?=
		$form->field($model, 'users_input_bl')->checkboxList($bl, ['separator'=>'</br>','encode'=>False]);
    ?>
    
    <div class="alert alert-info">
			Drag and drop to add/remove a user from the New Website Filtering Group.
	</div>
    
    <?php
		$temp = [];
		foreach ($users as $user) {
			$status = $user->filtering_group_id === NULL? false:true;
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
					'name'=>'FilteringGroup[users_input]',
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
		

	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
 <?php 
 	$this->registerJsFile(Yii::$app->request->baseUrl.'/scripts/draggable.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
?>