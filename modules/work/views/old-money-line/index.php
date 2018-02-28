<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\OldMoneyLineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '线下充值';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-money-line-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'AddMoneyApplicationID',
            'AccountID',
            'ManagerID',
            [
                'attribute' => 'Money',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute' => 'State',
                'headerOptions' => ['width' => '40'],
            ],
            'DealTime',
            'CreateTime',
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

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
