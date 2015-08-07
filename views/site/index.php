<?php
use yii\base\View;
use app\helpers\Squid;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'PXaaS vNF | Dashboard'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Blank page
        <small>it all starts here</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php if (Yii::$app->getSession()->hasFlash('reload_message')): ?>
        <div class="alert alert-success">
            <p><?= Yii::$app->getSession()->getFlash('reload_message') ?></p>
        </div>
    <?php endif; ?>

<?= Html::a('Reload Proxy', ['reloadconf'], [
    'class' => 'btn btn-lg btn-danger',
    'data-method' => 'post',
]);
?>

</section><!-- /.content -->
      