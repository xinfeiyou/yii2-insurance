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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'oddNumber',
            [
                'attribute' => 'intPeriod',
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fOnLineCost',
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fOnLineInterest',
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fOnLineTotal',
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fOffLineCost',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fOffLineInterest',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fOffLineTotal',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fRemainder',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fRealMonery',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fRealinterest',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'strUserId',
                'headerOptions' => ['width' => '160']
            ],
            [
                'attribute' => 'tStartTime',
                'headerOptions' => ['width' => '160']
            ],
            [
                'attribute' => 'tEndTime',
                'headerOptions' => ['width' => '160']
            ],
            [
                'attribute' => 'tOperateTime',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '160']
            ],
            [
                'attribute' => 'strPaymentStatus',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            [
                'attribute' => 'fSubsidy',
                'contentOptions' => ['style'=>'background-color:#61AFAF'],
                'headerOptions' => ['width' => '40']
            ],
            // 'tCreateTime',
            // 'tUpdateTime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}&nbsp&nbsp;{update} &nbsp&nbsp;{collect}',
                'headerOptions' => ['width' => '100'],
                'buttons' => [
                 'collect' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['/work/work-collect-record/create','oddNumber'=>$model->oddNumber,'intPeriod'=>$model->intPeriod], ['title' => '编写催收']);
                 },
                ],
            ],
        ],
    ]); ?>
</div>
