<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DelayGroup */

$this->title = 'Create Delay Group';
$this->params['breadcrumbs'][] = ['label' => 'Delay Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delay-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
