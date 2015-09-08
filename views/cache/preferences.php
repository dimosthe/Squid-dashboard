<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\sortinput\SortableInput;
use yii\widgets\ActiveForm;
use app\models\Cache;
/* @var $this yii\web\View */
/* @var $model app\models\DelayGroup */

$this->title = 'Caching Preferences';
?>
<section class="content-header">
	<h1><?= Html::encode($this->title) ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><?= Html::encode($this->title); ?></li>
	</ol>
</section>

<section class="content">
	<?php if (Yii::$app->getSession()->hasFlash('Csuccess')): ?>
        <div class="alert alert-success">
            <p><?= Yii::$app->getSession()->getFlash('Csuccess') ?></p>
        </div>
    <?php endif; ?>
 	<div class="box box-primary">
 		<div class="box-header with-border">
 			<?php $form = ActiveForm::begin(); ?>
 				<?= $form->field($cachestatus, 'enabled')->checkbox() ?>
 				<div class="form-group">
        			<?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id'=>'foo']) ?>
    			</div>
 			<?php ActiveForm::end(); ?>
 		</div>
 	</div>
</section>