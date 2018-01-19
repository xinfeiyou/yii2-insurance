<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\work\models\search\WorkOddSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Work Odds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-odd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Work Odd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'oddNumber',
            'oddType',
            'oddTitle',
            'oddYearRate',
            // 'oddMoney',
            // 'successMoney',
            // 'startMoney',
            // 'endMoney',
            // 'oddBorrowStyle',
            // 'oddRepaymentStyle',
            // 'oddBorrowPeriod',
            // 'oddBorrowValidTime:datetime',
            // 'serviceFee',
            // 'oddTrialTime',
            // 'oddTrialRemark:ntext',
            // 'oddRehearTime',
            // 'oddRehearRemark:ntext',
            // 'addtime',
            // 'publishTime',
            // 'fullTime',
            // 'userId',
            // 'progress',
            // 'operator',
            // 'lookstatus',
            // 'investType',
            // 'readstatus',
            // 'openTime',
            // 'appointUserId',
            // 'oddReward',
            // 'oddStyle',
            // 'offlineRate',
            // 'cerStatus',
            // 'fronStatus',
            // 'firstFigure',
            // 'isCr',
            // 'receiptUserId',
            // 'receiptStatus',
            // 'isATBiding',
            // 'finishType',
            // 'finishTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
