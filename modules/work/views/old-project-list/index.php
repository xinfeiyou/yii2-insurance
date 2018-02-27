<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\base\models\OldProjectList;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\OldProjectListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-project-list-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'ProjectID',
                'headerOptions' => ['width' => '320'],
            ],
            [
                'attribute' => 'ProjectType',
                'headerOptions' => ['width' => '80'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('ProjectType', $model->ProjectType);
                },
                'filter' => (new OldProjectList())->getSysConfigInfoType('ProjectType'),
            ],
            'Title',
            [
                'attribute' => 'TargetAmount',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute' => 'MonthlyReturnRate',
                'headerOptions' => ['width' => '40'],
            ],
            [
                'attribute' => 'RepaymentDuration',
                'headerOptions' => ['width' => '40'],
            ],
            [
                'attribute' => 'FundraisingBeginTime',
                'headerOptions' => ['width' => '100'],
                'value' => function($model){
                    return substr($model->FundraisingBeginTime,0,10);
                }
            ],
            [
                'attribute' => 'FundraisingEndTime',
                'headerOptions' => ['width' => '100'],
                'value' => function($model){
                    return substr($model->FundraisingEndTime,0,10);
                }
            ],
            [
                'attribute' => 'RepaymentType',
                'headerOptions' => ['width' => '100'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('RepaymentType', $model->RepaymentType);
                },
                'filter' => (new OldProjectList())->getSysConfigInfoType('RepaymentType'),
            ],
            [
                'attribute' => 'InterestDate',
                'headerOptions' => ['width' => '40'],
            ],
            //'Safeguards:ntext',
            //'BorrowerInformation:ntext',
            [
                'attribute' => 'ProjectState',
                'headerOptions' => ['width' => '80'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('ProjectState', $model->ProjectState);
                },
                'filter' => (new OldProjectList())->getSysConfigInfoType('ProjectState'),
            ],
            [
                'attribute' => 'CreateTime',
                'headerOptions' => ['width' => '160'],
            ],
            [
                'attribute' => 'ExtraMonthlyReturnRate',
                'headerOptions' => ['width' => '40'],
            ],
            // 'tCreateTime',
            // 'tUpdateTime',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;{invest}',
                'buttons' =>[
                     'invest' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['/work/old-order-list/list', 'ProjectID' => $model->ProjectID], ['title' => '投资列表']);
                    },
                ]
            ],
        ],
    ]); ?>
</div>