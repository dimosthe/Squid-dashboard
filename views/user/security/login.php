<?php
/* Overrides login view of yii2-user module
* This file is part of the Dektrium project.
*
* (c) Dektrium project <http://github.com/dektrium>
*
* For the full copyright and license information, please view the LICENSE.md
* file that was distributed with this source code.
*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dektrium\user\widgets\Connect;
/**
* @var yii\web\View $this
* @var yii\widgets\ActiveForm $form
* @var dektrium\user\models\LoginForm $model
*/
$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
	<div class="login-logo">
     	<b>PXaaS</b> vNF
    </div><!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg"><strong>Sign in to start your session</strong></p>

		<?php $form = ActiveForm::begin([
			'id' => 'login-form',
			'enableAjaxValidation'   => true,
            'enableClientValidation' => false,
            'validateOnBlur'         => false,
            'validateOnType'         => false,
            'validateOnChange'       => false,
		]) ?>
	
		<div class="form-group has-feedback">
			<?= $form->field($model, 'login', [
			'options'=> ['class'=>'input-group'],
			'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => 'Username or Email'],
			'template' => "<span class='input-group-addon'><i class='fa fa-user'></i></span>{input}"]);
			echo $form->field($model, 'login')->begin();
			echo Html::error($model,'login', ['class' => 'help-block']);
			echo $form->field($model, 'login')->end(); ?>
		</div>
	
		<div class="form-group has-feedback">
			<?= $form->field($model, 'password', [
			'options'=> ['class'=>'input-group'],
			'inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => 'Password'],
			'template' => "<span class='input-group-addon'><i class='fa fa-lock'></i></span>{input}"])
			->passwordInput();
			echo $form->field($model, 'password')->begin();
			echo Html::error($model,'password', ['class' => 'help-block']);
			echo $form->field($model, 'password')->end(); ?>
		</div>
		
		<div class="row">
            <div class="col-xs-8">
          
					<?= $form->field($model, 'rememberMe', ['options'=> ['class'=>'checkbox icheck']])->checkbox(['tabindex' => '3']) ?>
			
			</div>
			<div class="col-xs-4">
				<?= Html::submitButton(Yii::t('user', 'Sign in'), ['class' => 'btn btn-primary btn-block btn-flat btn-login', 'tabindex' => '4']) ?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>


