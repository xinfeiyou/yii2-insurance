<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkAdmin */

$this->title = '编辑信息: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="work-admin-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
