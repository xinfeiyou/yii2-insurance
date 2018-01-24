<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkUser */

$this->title = '编辑用户编号: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="work-user-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
