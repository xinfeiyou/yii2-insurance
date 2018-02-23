<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\OldMoneyRechargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '宝付充值记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-money-recharge-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'RechargeRecordID',
            'ServiceID',
            //'AccountID',
            [
                'attribute' => 'Money',
                'headerOptions' => ['width' => '80'],
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
