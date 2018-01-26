<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\base\models\WorkApply;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\base\models\search\WorkApplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '车险申请列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-apply-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'strWorkNum',
                'headerOptions' => ['width' => '140'],
            ],
            [
                'attribute' => 'strRealName',
                'headerOptions' => ['width' => '120'],
            ],
            [
                'attribute' => 'strPhone',
                'headerOptions' => ['width' => '80'],
            ],
            'strTravelAdder',
            [
                'attribute' => 'strCarNumber',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute' => 'strCompulsoryInsurance',
                'headerOptions' => ['width' => '120'],
                'value' => function($model) {
                    return ('true' == $model->strCompulsoryInsurance)?'投保':'不投保';
                },
            ],
            [
                'attribute' => 'tCompulsoryInsuranceEffectiveTime',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute' => 'strCommercialInsurance',
                'headerOptions' => ['width' => '70'],
                'value' => function($model) {
                    return ('true' == $model->strCommercialInsurance)?'投保':'不投保';
                },
            ],
            [
                'attribute' => 'tCommercialInsuranceEffectiveTime',
                'headerOptions' => ['width' => '100'],
            ],
            // 'strLossInsurance',
            // 'strThirdPartyInsurance',
            // 'strTheftInsurance',
            // 'strDriverLiabilityInsurance',
            // 'strPassengerLiabilityInsurance',
            // 'strGlassInsurance',
            // 'strSelfIgnitionInsurance',
            // 'strWadingInsurance',
            // 'strScratchInsurance',
            // 'strExcessInsurance',
            [
                'attribute' => 'strInsuranceOffice',
                'headerOptions' => ['width' => '90'],
                'value' => function($model) {
                    return $model->getSysConfigInfoType('strInsuranceOffice')[$model->strInsuranceOffice];
                },
                'filter' => (new WorkApply())->getSysConfigInfoType('strInsuranceOffice'),
            ],
            [
                'attribute' => 'eStatus',
                'headerOptions' => ['width' => '90'],
                'value' => function($model) {
                    return $model->getSysConfigInfoType('strApplyStatus')[$model->eStatus];
                },
                'filter' => (new WorkApply())->getSysConfigInfoType('strApplyStatus'),
            ],
            [
                'attribute' => 'oddNumber',
                'headerOptions' => ['width' => '140'],
            ],
            // 'tCreateTime',
            // 'tUpdateTime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a('申请', ['create'], ['class' => 'btn btn-success']),
                'template' => '{view} &nbsp&nbsp;&nbsp;{update}',
                'headerOptions' => ['width' => '70']
            ],
        ],
    ]); ?>
</div>
