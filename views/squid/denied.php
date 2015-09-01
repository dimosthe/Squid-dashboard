<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Squid Proxy message';
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>
<section class="content">
    <div class="error-page">
        <h2 class="headline text-info"> </h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Website access denied</h3>
            <p>
            You are not allowed to access this website at this time.
            </p>
            <p>
            Please contact us if you think this is a server error. Thank you.
            </p>
        </div>
    </div>
</section>