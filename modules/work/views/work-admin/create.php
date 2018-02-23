<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkAdmin */

$this->title = '新建管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-admin-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
