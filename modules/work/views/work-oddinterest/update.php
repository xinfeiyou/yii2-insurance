<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */

$this->title = '编辑资料: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '还款列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="work-oddinterest-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
