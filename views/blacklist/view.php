<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Blacklist */

$this->title = $model->name;
?>
<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= Url::to(['/blacklist/index']); ?>">Blacklists</a></li>
        <li class="active"><?= Html::encode($this->title); ?></li>
    </ol>
</section>

<section class="content">
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'pjax'=> true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
            'options' => ['enablePushState' => false],
        ],
         'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'maxButtonCount' =>10
        ],
        'responsive' => true,
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'toolbar'=> [
            '{toggleData}',
        ],
        'panel'=>[
            'type'=>GridView::TYPE_PRIMARY,
            'heading'=>$this->title
        ],
        'layout'  => "{items}\n{pager}",
        'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'domain',
		],
    ]); ?>
</section>
