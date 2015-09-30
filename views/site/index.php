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
                    <span class="info-box-text"><?= Html::a('ACCOUNTS', ['/user/admin/index']); ?></span>
                    <span class="info-box-number"><?= $users ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-firefox"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= Html::a('WEB ACCESS', ['/delaygroup/index']); ?></span>
                    <span class="info-box-number"><?= $delaygroups ?><small> groups</small></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-filter"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?= Html::a('WEB FILTERING', ['/filteringgroup/index']); ?></span>
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
                    <span class="info-box-text"><?= Html::a('BLACKLISTS', ['/blacklist/index']); ?></span>
                    <span class="info-box-number"><?= $blacklists ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Proxy Actions</h3>
                </div>
                <div class="box-body">       
                    <?php if (Yii::$app->getSession()->hasFlash('reload_message')): ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="icon fa fa-check"></i> <?= Yii::$app->getSession()->getFlash('reload_message') ?>
                            </div>
                    <?php endif; ?>
                    <?php if (Yii::$app->getSession()->hasFlash('warning_message')): ?>
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="icon fa fa-warning"></i> <?= Yii::$app->getSession()->getFlash('warning_message') ?>
                            </div>
                    <?php endif; ?>

                    <?= Html::a('<i class="fa fa-play"></i> Start Proxy', ['startsquid'], [
                        'class' => 'btn btn-lg btn-success',
                        'data-method' => 'post',
                    ]); ?>

                    <?= Html::a('<i class="fa fa-stop"></i> Stop Proxy', ['stopsquid'], [
                        'class' => 'btn btn-lg btn-danger',
                        'data-method' => 'post',
                    ]); ?>

                    <?= Html::a('<i class="fa fa-repeat"></i> Reload Proxy', ['reloadsquid'], [
                        'class' => 'btn btn-lg btn-warning',
                        'data-method' => 'post',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box <?= $squidstatus? 'bg-green': 'bg-red' ?>">
                <span class="info-box-icon"><i class="ion <?= $squidstatus? 'ion-thumbsup' : 'ion-thumbsdown' ?>"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Proxy Status</span>
                    <span class="info-box-number"><?= $squidstatus?'Proxy is Running':'Proxy is not Running' ?></span>
                </div>
            </div>
            <div class="info-box <?= $cachestatus? 'bg-green': 'bg-red' ?>">
                <span class="info-box-icon"><i class="ion <?= $cachestatus? 'ion-checkmark' : 'ion-close' ?>"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Caching Status</span>
                    <span class="info-box-number"><?= $cachestatus?'Caching is Enabled':'Caching is Disabled' ?></span>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->