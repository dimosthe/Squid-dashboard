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
    <div class="row">
         <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">ACCOUNTS</span>
                    <span class="info-box-number"><?= $users ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-firefox"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">WEB ACCESS</span>
                    <span class="info-box-number"><?= $delaygroups ?><small> groups</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-filter"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">WEB FILTERING</span>
                    <span class="info-box-number"><?= $filteringgroups ?><small> groups</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">BLACKLISTS</span>
                    <span class="info-box-number"><?= $blacklists ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Proxy Actions</h3>
        </div>
        <div class="box-body">       
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
        </div>
    </div>

</section><!-- /.content -->
      