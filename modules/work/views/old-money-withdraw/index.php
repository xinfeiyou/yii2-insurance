<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\base\models\OldMoneyWithdraw;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\OldMoneyWithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '宝付提现记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-money-withdraw-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'WithdrawalApplicationID',
            //'AccountID',
            [
                'attribute' => 'WithdrawableMoney',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute' => 'WithdrawalState',
                'headerOptions' => ['width' => '120'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('WithdrawalState', $model->WithdrawalState);
                },
                'filter' => (new OldMoneyWithdraw())->getSysConfigInfoType('WithdrawalState'),
            ],
            [
                'attribute' => 'DealTime',
                'headerOptions' => ['width' => '160'],
            ],
            [
                'attribute' => 'WithdrawalDisableMoney',
                'headerOptions' => ['width' => '160'],
            ],
            [
                'attribute' => 'Trans_batchid',
                'headerOptions' => ['width' => '120'],
            ],
            [
                'attribute' => 'Trans_no',
                'headerOptions' => ['width' => '120'],
            ],
            [
                'attribute' => 'UserName',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute' => 'RealName',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute' => 'CreateTime',
                'headerOptions' => ['width' => '180'],
            ],
            // 'tCreateTime',
            // 'tUpdateTime',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}',
                'headerOptions' => ['width' => '80']
            ],
        ],
    ]); ?>
</div>
