<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\work\models\search\WorkOddinterestSearch */
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
            // 'id',
            [
                'attribute' => 'oddNumber',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'qishu',
                'headerOptions' => ['width' => '30']
            ],
            'benJin',
            'interest',
            'zongEr',
            'yuEr',
            'realAmount',
            'realinterest',
            'userId',
            [
                'attribute' => 'addtime',
                'value' => function($model) {
                    return substr($model->addtime, 0, 10);
                },
                'headerOptions' => ['width' => '90']
            ],
            [
                'attribute' => 'endtime',
                'value' => function($model) {
                    return substr($model->endtime, 0, 10);
                },
                'headerOptions' => ['width' => '90']
            ],
            'operatetime',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    $strName = "未还";
                    switch ($model->status) {
                        case "0":
                            $strName = "未还";
                            break;
                        case "1":
                            $strName = "已还";
                            break;
                        case "2":
                            $strName = "提前";
                            break;
                        case "3":
                            $strName = "逾期";
                            break;
                    }
                    return $strName;
                },
                'headerOptions' => ['width' => '70']
            ],
            'subsidy',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view} &nbsp&nbsp;&nbsp;{update}',
                'headerOptions' => ['width' => '70']
            ],
        ],
    ]);
    ?>
</div>
