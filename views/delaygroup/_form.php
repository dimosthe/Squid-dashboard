<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DelayGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delay-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bandwidth')->radioList([0=>" Unlimited", 1=>" Custom"], ['separator'=>'</br>']) ?>

    <?php if($model->bandwidth): ?>
		<div id="bandwidth">
	<?php else: ?>
		<div id="bandwidth" style="display: none;">
	<?php endif?>
    
    	<?= $form->field($model, 'rate')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 <?php 
 	$this->registerJsFile(Yii::$app->request->baseUrl.'/scripts/hide.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>