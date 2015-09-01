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
 			<div class="nav-tabs-custom">
                <?php $form = ActiveForm::begin();
	 			$cacheform->patterns =  $patterns_enabled;
	 			$patt = [];
		    	foreach ($patterns as $pat) {
		    		$patt[$pat['id']] = $pat['name'];
		    	}

		    	$cacheform->options =  $options_enabled;
	 			$opt = [];
		    	foreach ($options as $op) {
		    		$opt[$op['id']] = $op['name'];
		    	}
				?>

                <ul class="nav nav-tabs">
                  	<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Settings</a></li>
                  	<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Advanced Settings</a></li>
                </ul>
                <div class="tab-content">
                	<div class="tab-pane active" id="tab_1">
                    	<?= $form->field($cacheform, 'patterns')->checkboxList($patt, ['separator'=>'</br>','encode'=>False]); ?>
                  	</div><!-- /.tab-pane -->
                  	<div class="tab-pane" id="tab_2">
                   		<?= $form->field($cacheform, 'options')->checkboxList($opt, ['separator'=>'</br>','encode'=>False]); ?>
                  	</div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div>
 			<div class="form-group">
        		<?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id'=>'foo']) ?>
    		</div>
 			<?php ActiveForm::end(); ?>
 		</div>
 	</div>
 </section>