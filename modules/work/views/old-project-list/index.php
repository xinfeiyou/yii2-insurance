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
                'template' => '<div class="btn-group">
                                <button type="button" class="btn btn-default">选择</button>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>{info}</li>
                                    <li>{invest}</li>
                                    <li>{invest1}</li>
                                    <li>{invest2}</li>
                                    <li role="separator" class="divider"></li>
                                    <li>{invest3}</li>
                                    <li>{invest4}</li>
                                    <li>{invest5}</li>
                                </ul>
                            </div>',
                'buttons' =>[
                    'info' => function ($url, $model) {
                        return Html::a('标的信息', ['/work/old-project-list/view', 'id' => $model->id], ['title' => '标的信息','target' => '_blank']);
                    },
//                    'invest' => function ($url, $model) {
//                        return Html::a('投资列表', ['/work/old-money-list/index', 'ProjectID' => $model->ProjectID], ['title' => '投资列表','target' => '_blank']);
//                    },
                    'invest' => function ($url, $model) {
                        return Html::a('本金投资', ['/work/old-money-list/index', 'Content' => $model->Title,'FundRecordType'=>'1'], ['title' => '本金投资','target' => '_blank']);
                    },
                    'invest1' => function ($url, $model) {
                        return Html::a('红包投资', ['/work/old-money-list/index', 'Content' => $model->Title,'FundRecordType'=>'8'], ['title' => '红包投资','target' => '_blank']);
                    },
                    'invest2' => function ($url, $model) {
                        return Html::a('转让/承接', ['/work/old-money-list/index', 'Content' => $model->Title,'FundRecordType'=>'7'], ['title' => '转让/承接','target' => '_blank']);
                    },
                    'invest3' => function ($url, $model) {
                        return Html::a('项目回款', ['/work/old-money-list/index', 'Content' => $model->Title,'FundRecordType'=>'3'], ['title' => '项目回款','target' => '_blank']);
                    },
                    'invest4' => function ($url, $model) {
                        return Html::a('利息管理费', ['/work/old-money-list/index', 'Content' => $model->Title,'FundRecordType'=>'2'], ['title' => '利息管理费','target' => '_blank']);
                    },
                    'invest5' => function ($url, $model) {
                        return Html::a('债权转让费', ['/work/old-money-list/index', 'Content' => $model->Title,'FundRecordType'=>'6'], ['title' => '债权转让费','target' => '_blank']);
                    },
                ]
            ],
        ],
    ]); ?>
</div>