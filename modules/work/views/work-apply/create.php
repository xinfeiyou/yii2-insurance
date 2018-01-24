<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkApply */

$this->title = '车险申请';
$this->params['breadcrumbs'][] = ['label' => '车险申请列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-apply-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
