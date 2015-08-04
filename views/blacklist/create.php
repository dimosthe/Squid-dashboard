<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Blacklist */

$this->title = 'Create Blacklist';
$this->params['breadcrumbs'][] = ['label' => 'Blacklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blacklist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
