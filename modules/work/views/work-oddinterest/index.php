<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\WorkOddinterest */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '还款列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-oddinterest-index">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'oddNumber',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'intPeriod',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fOnLineCost',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fOnLineInterest',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fOnLineTotal',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fOffLineCost',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fOffLineInterest',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fOffLineTotal',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fRemainder',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fRealMonery',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'fRealinterest',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'strUserId',
                'headerOptions' => ['width' => '100']
            ],
            [
                'attribute' => 'tStartTime',
                'headerOptions' => ['width' => '160']
            ],
            [
                'attribute' => 'tEndTime',
                'headerOptions' => ['width' => '160']
            ],
//            [
//                'attribute' => 'tOperateTime',
//                'contentOptions' => ['style' => 'background-color:#61AFAF'],
//                'headerOptions' => ['width' => '160']
//            ],
            [
                'attribute' => 'strPaymentStatus',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fSubsidy',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fDiff',
                'contentOptions' => ['style' => 'background-color:#FF6633'],
                'headerOptions' => ['width' => '80'],
                'value' => function($model) {
                    if (!empty($model->fOffLineTotal)) {
                        return round(($model->fOffLineTotal - $model->fOnLineTotal), 2);
                    } else {
                        return 0;
                    }
                },
            ],
            [
                'attribute' => 'fSpreads',
                'contentOptions' => ['style' => 'background-color:#61AFAF'],
                'headerOptions' => ['width' => '80']
            ],
            // 'tCreateTime',
            // 'tUpdateTime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}&nbsp&nbsp;{update} &nbsp&nbsp;{collect}&nbsp;&nbsp;{deduct}',
                'headerOptions' => ['width' => '120'],
                'buttons' => [
                    'collect' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['/work/work-collect-record/create', 'oddNumber' => $model->oddNumber, 'intPeriod' => $model->intPeriod], ['title' => '编写催收']);
                    },
                    'deduct' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-yen"></span>', ['/work/work-oddinterest/deduct', 'oddNumber' => $model->oddNumber, 'intPeriod' => $model->intPeriod], ['title' => '金额代扣']);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
