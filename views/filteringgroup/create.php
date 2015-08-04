<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilteringGroup */

$this->title = 'Create Filtering Group';
$this->params['breadcrumbs'][] = ['label' => 'Filtering Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filtering-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
