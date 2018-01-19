<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\work\models\WorkOdd */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Work Odds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-odd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'oddNumber',
            'oddType',
            'oddTitle',
            'oddYearRate',
            'oddMoney',
            'successMoney',
            'startMoney',
            'endMoney',
            'oddBorrowStyle',
            'oddRepaymentStyle',
            'oddBorrowPeriod',
            'oddBorrowValidTime:datetime',
            'serviceFee',
            'oddTrialTime',
            'oddTrialRemark:ntext',
            'oddRehearTime',
            'oddRehearRemark:ntext',
            'addtime',
            'publishTime',
            'fullTime',
            'userId',
            'progress',
            'operator',
            'lookstatus',
            'investType',
            'readstatus',
            'openTime',
            'appointUserId',
            'oddReward',
            'oddStyle',
            'offlineRate',
            'cerStatus',
            'fronStatus',
            'firstFigure',
            'isCr',
            'receiptUserId',
            'receiptStatus',
            'isATBiding',
            'finishType',
            'finishTime',
        ],
    ]) ?>

</div>
