<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-user-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'strUserId',
            'strPhone',
            'strPass',
            'nickName',
            [
                'attribute' => 'gender',
                'value' => function($model) {
                    return ($model->gender)?'男':'女';
                },
                'headerOptions' => ['width' => '70']
            ],
            'language',
            'city',
            'province',
            'country',
            'openId',
            [
                'attribute' => 'avatarUrl',
                'label' => '头像',
                'format' => ['image', ['width' => '40', 'height' => '40',]],
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'strUserType',
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('strUserType',$model->strUserType);
                },
                'headerOptions' => ['width' => '70']
            ],
            'tCreateTime',
            'tUpdateTime',
        ],
    ]) ?>
    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
