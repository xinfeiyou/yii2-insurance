<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\base\models\OldOrderList;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\OldOrderListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '投资记录';
if(!empty(\Yii::$app->request->get('ProjectID'))){
    $this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['/work/old-project-list/index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-order-list-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'OrderID',
            [
                'attribute' => 'OrderType',
                'headerOptions' => ['width' => '80'],
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('OrderType', $model->OrderType);
                },
                'filter' => (new OldOrderList())->getSysConfigInfoType('OrderType'),
            ],
            'ProjectID',
            //'AccountID',
            [
                'attribute' => 'ExtraRate',
                'headerOptions' => ['width' => '40'],
            ],
            [
                'attribute' => 'Amount',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute' => 'PreviousRepaymentDate',
                'headerOptions' => ['width' => '160'],
            ],
            [
                'attribute' => 'CreateTime',
                'headerOptions' => ['width' => '160'],
            ],
            [
                'attribute' => 'ExtraMoney',
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute' => 'SettlementPeriod',
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
            // 'tCreateTime',
            // 'tUpdateTime',

//            [
//                'class' => 'yii\grid\ActionColumn',
//                'header' => '操作',
//                'template' => '{view}',
//            ],
        ],
    ]); ?>
</div>
