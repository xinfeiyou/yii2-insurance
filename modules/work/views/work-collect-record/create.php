<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */

$this->title = '新增催收';
$this->params['breadcrumbs'][] = ['label' => '还款列表', 'url' => ['/work/work-oddinterest/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-collect-record-create">
    <div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
                    <?php if(!empty($arData)){ foreach($arData as $v){ ?>
			<blockquote>
				<p>
				<?=$v->strCollectResults?>
				</p> <small>催收人:<?=$v->strUser;?> <cite>时间:<?=$v->tCreateTime?></cite></small>
			</blockquote>
                    <?php }}?>
		</div>
	</div>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
