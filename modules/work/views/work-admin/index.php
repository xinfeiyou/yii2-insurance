<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\WorkAdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-admin-index">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'strUserId',
            'username',
            [
                'attribute' => 'password',
                'headerOptions' => ['width' => '280'],
            ],
            [
                'attribute' => 'authKey',
                'headerOptions' => ['width' => '280'],
            ],
            [
                'attribute' => 'accessToken',
                'headerOptions' => ['width' => '280'],
            ],
            'realname',
            // 'tCreateTime',
            // 'tUpdateTime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('新增', ['create'], ['class' => 'btn btn-success']),
                'template' => '{update}&nbsp&nbsp;&nbsp&nbsp;{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'username' => $model->username], ['title' => '编辑用户']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'username' => $model->username], ['title' => '编辑用户']);
                    },
                ],
                'headerOptions' => ['width' => '80']
            ],
        ],
    ]);
    ?>
</div>
