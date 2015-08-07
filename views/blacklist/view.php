<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Blacklist */

$this->title = $model->name;
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= Url::to(['/blacklistgroup/index']); ?>">Website Filtering Groups</a></li>
        <li class="active"><?= Html::encode($this->title); ?></li>
    </ol>
</section>

<section class="content">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'label' => 'Blocked Urls',
                'value' => $model->getBlacklistURL()
            ],
//         'formatter' => asText(),
        ],
    ]) ?>
</section>
