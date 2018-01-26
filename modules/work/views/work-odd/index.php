<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\WorkOddSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-odd-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'oddNumber',
                'headerOptions' => ['width' => '100']
            ],
            [
                'attribute' => 'oddType',
                'headerOptions' => ['width' => '100']
            ],
            'oddTitle',
            [
                'attribute' => 'oddYearRate',
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'oddMoney',
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'oddRepaymentStyle',
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'oddBorrowPeriod',
                'headerOptions' => ['width' => '50']
            ],
            // 'serviceFee',
            // 'oddTrialTime',
            [
                'attribute' => 'oddRehearTime',
                'headerOptions' => ['width' => '150']
            ],
            [
                'attribute' => 'userId',
                'headerOptions' => ['width' => '70']
            ],
            [
                'attribute' => 'operator',
                'headerOptions' => ['width' => '70']
            ],
            [
                'attribute' => 'offlineMoney',
                'contentOptions' => ['style'=>'background-color:#99CCCC'],
                'headerOptions' => ['width' => '70']
            ],
            [
                'attribute' => 'offlineRate',
                'contentOptions' => ['style'=>'background-color:#99CCCC'],
                'headerOptions' => ['width' => '70']
            ],
            // 'isCr',
            // 'receiptUserId',
            // 'receiptStatus',
            // 'finishType',
            // 'finishTime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view} &nbsp&nbsp;&nbsp;{update}',
                'headerOptions' => ['width' => '70']
            ],
        ],
    ]); ?>
</div>
