<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOdd */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-odd-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'oddNumber',
            'oddType',
            'oddTitle',
            'oddYearRate',
            'oddMoney',
            'oddRepaymentStyle',
            'oddBorrowPeriod',
            'serviceFee',
            'oddTrialTime',
            'oddRehearTime',
            'userId',
            'operator',
            'offlineMoney',
            'offlineRate',
            'isCr',
            'receiptUserId',
            'receiptStatus',
            'finishType',
            'finishTime',
        ],
    ]) ?>
    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
