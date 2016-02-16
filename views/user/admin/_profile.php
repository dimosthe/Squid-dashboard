<?php
/** 
 * This view overrides the admin/_profile view defined in yii2-user module
 * -> public_email removed 
 * 
 * @author George Dimosthenous
 * 
 **/
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/**
 * @var yii\web\View 					$this
 * @var common\models\User 		        $user
 * @var dektrium\user\models\Profile 	$profile
 */
?>

<?php $this->beginContent('@app/views/user/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
]); ?>

<?= $form->field($profile, 'name') ?>
<?= $form->field($profile, 'website') ?>
<?= $form->field($profile, 'location') ?>
<?= $form->field($profile, 'gravatar_email') ?>
<?= $form->field($profile, 'bio')->textarea() ?>


<div class="form-group">
    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>