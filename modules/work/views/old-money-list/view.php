<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\OldMoneyList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '宝付资金记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="old-money-list-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'FundRecordID',
            'FundRecordType',
            'AccountID',
            'Content:ntext',
            'Money',
            'UserName',
            'RealName',
            'CreateTime',
            'tCreateTime',
            'tUpdateTime',
        ],
    ]) ?>

</div>
