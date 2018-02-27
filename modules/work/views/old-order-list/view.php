<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\OldOrderList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '投资记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-order-list-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'OrderID',
            'OrderType',
            'ProjectID',
            'AccountID',
            'ExtraRate',
            'Amount',
            'PreviousRepaymentDate',
            'CreateTime',
            'ExtraMoney',
            'SettlementPeriod',
            'tCreateTime',
            'tUpdateTime',
        ],
    ]) ?>

</div>
