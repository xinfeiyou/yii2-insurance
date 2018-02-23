<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\base\models\OldMoneyList;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\OldMoneyListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '资金记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-money-list-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '40'],
            ],
            //'FundRecordID',
            [
                'attribute' => 'FundRecordType',
                'headerOptions' => ['width' => '120'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('FundRecordType', $model->FundRecordType);
                },
                'filter' => (new OldMoneyList())->getSysConfigInfoType('FundRecordType'),
            ],
            //'AccountID',
            'Content:ntext',
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
