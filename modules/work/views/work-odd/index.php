<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\base\models\WorkOdd;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\WorkOddSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-odd-index">
    <?=
    GridView::widget([
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
                'headerOptions' => ['width' => '120'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('oddType', $model->oddType);
                },
                'filter' => (new WorkOdd())->getSysConfigInfoType('oddType'),
            ],
            'oddTitle',
            [
                'attribute' => 'oddYearRate',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'oddMoney',
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'oddRepaymentStyle',
                'headerOptions' => ['width' => '120'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('oddRepaymentStyle', $model->oddRepaymentStyle);
                },
                'filter' => (new WorkOdd())->getSysConfigInfoType('oddRepaymentStyle'),
            ],
            [
                'attribute' => 'oddBorrowPeriod',
                'headerOptions' => ['width' => '50']
            ],
            // 'serviceFee',
            // 'oddTrialTime',
            [
                'attribute' => 'oddRehearTime',
                'headerOptions' => ['width' => '180']
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
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '70']
            ],
            [
                'attribute' => 'offlineRate',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
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
                'template' => '{view} &nbsp&nbsp;&nbsp;{update}&nbsp&nbsp;{editMoney}',
                'buttons' => [
                    'editMoney' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-yen"></span>', ['/work/work-odd/edit-off-money', 'strOddNum' => $model->oddNumber], ['title' => '填写线下放款利率']);
                    },
                ],
                'headerOptions' => ['width' => '120']
            ],
        ],
    ]);
    ?>
</div>
