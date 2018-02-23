<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\OldMoneyWithdraw */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '宝付提现记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-money-withdraw-view">
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'WithdrawalApplicationID',
            'AccountID',
            'WithdrawableMoney',
            'WithdrawalState',
            'DealTime',
            'CreateTime',
            'WithdrawalDisableMoney',
            'Trans_batchid',
            'Trans_no',
            'UserName',
            'RealName',
            'tCreateTime',
            'tUpdateTime',
        ],
    ]) ?>

</div>
