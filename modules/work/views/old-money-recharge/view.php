<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\OldMoneyRecharge */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '宝付充值记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-money-recharge-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'RechargeRecordID',
            'ServiceID',
            'AccountID',
            'Money',
            'CreateTime',
            'UserName',
            'RealName',
            'tCreateTime',
            'tUpdateTime',
        ],
    ]) ?>

</div>
