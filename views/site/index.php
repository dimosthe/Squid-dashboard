<?php
use yii\base\View;
use app\helpers\Squid;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'PXaaS vNF'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= $this->title; ?>
        <small>Dashboard</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <?php if (Yii::$app->getSession()->hasFlash('reload_message')): ?>
            <div class="alert alert-success">
                <p><?= Yii::$app->getSession()->getFlash('reload_message') ?></p>
            </div>
        <?php endif; ?>

    <?= Html::a('Start Proxy', ['startsquid'], [
        'class' => 'btn btn-lg btn-danger',
        'data-method' => 'post',
    ]); ?>

    <?= Html::a('Stop Proxy', ['stopsquid'], [
        'class' => 'btn btn-lg btn-danger',
        'data-method' => 'post',
    ]); ?>

    <?= Html::a('Reload Proxy', ['reloadsquid'], [
        'class' => 'btn btn-lg btn-danger',
        'data-method' => 'post',
    ]); ?>

</section><!-- /.content -->
      