<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
$this->title = $name;

$this->context->layout = Yii::$app->user->isGuest? 'noheader' : 'main'; 
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(!Yii::$app->user->isGuest): ?>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $exception->statusCode ?> error</li>
    </ol>
    <?php endif; ?>
</section>
<section class="content">
    <div class="error-page">
        <h2 class="headline text-info"> <?= $exception->statusCode ?></h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> <?= nl2br(Html::encode($message)) ?></h3>
            <p>
            The above error occurred while the Web server was processing your request.
            </p>
            <p>
            Please contact us if you think this is a server error. Thank you.
            </p>
        </div>
    </div>
</section>
