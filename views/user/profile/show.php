<?php
/*
* This file is part of the Dektrium project.
*
* (c) Dektrium project <http://github.com/dektrium>
*
* For the full copyright and license information, please view the LICENSE.md
* file that was distributed with this source code.
*/
use yii\helpers\Html;
use yii\helpers\Url;
/**
* @var \yii\web\View $this
* @var \dektrium\user\models\Profile $profile
*/
$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
?>

<section class="content-header">
	<h1><i class="glyphicon glyphicon-user"></i> <?= Html::encode($this->title) ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= Yii::$app->homeUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?= Url::to(['/user/admin/index']); ?>">Users</a></li>
		<li class="active"><?= Html::encode($this->title); ?></li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6">
			<div class="row">
				<div class="col-sm-6 col-md-4">
					<img src="http://gravatar.com/avatar/<?= $profile->gravatar_id ?>?s=230" alt="" class="img-rounded img-responsive" />
				</div>
				<div class="col-sm-6 col-md-8">
					<h4><?= $this->title ?></h4>
					<ul style="padding: 0; list-style: none outside none;">
						<?php if (!empty($profile->location)): ?>
						<li><i class="glyphicon glyphicon-map-marker text-muted"></i> <?= Html::encode($profile->location) ?></li>
						<?php endif; ?>
						<?php if (!empty($profile->website)): ?>
						<li><i class="glyphicon glyphicon-globe text-muted"></i> <?= Html::a(Html::encode($profile->website), Html::encode($profile->website)) ?></li>
						<?php endif; ?>
						<?php if (!empty($profile->user->email)): ?>
						<li><i class="glyphicon glyphicon-envelope text-muted"></i> <?= Html::a(Html::encode($profile->user->email), 'mailto:' . Html::encode($profile->public_email)) ?></li>
						<?php endif; ?>
						<li><i class="glyphicon glyphicon-time text-muted"></i> <?= Yii::t('user', 'Joined on {0, date}', $profile->user->created_at) ?></li>
					</ul>
					<?php if (!empty($profile->bio)): ?>
					<p><?= Html::encode($profile->bio) ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>