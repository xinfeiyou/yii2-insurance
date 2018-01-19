<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\work\models\WorkOddinterest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '还款列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-oddinterest-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'oddNumber',
            'qishu',
            'benJin',
            'interest',
            'zongEr',
            'yuEr',
            'realAmount',
            'realinterest',
            'userId',
            'addtime',
            'endtime',
            'operatetime',
            'status',
            'subsidy',
        ],
    ])
    ?>
    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
