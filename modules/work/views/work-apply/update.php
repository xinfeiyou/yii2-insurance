<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkApply */

$this->title = '车险申请编号: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '车险申请列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="work-apply-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
