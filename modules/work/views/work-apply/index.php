<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'strWorkNum',
            'strRealName',
            'strPhone',
            'strTravelAdder',
            'strCarNumber',
            'strCompulsoryInsurance',
            'tCompulsoryInsuranceEffectiveTime',
            'strCommercialInsurance',
            'tCommercialInsuranceEffectiveTime',
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
                'value' => function($model) {
                    return $model->getSysConfigInfoType('strInsuranceOffice')[$model->strInsuranceOffice];
                },
                'headerOptions' => ['width' => '70']
            ],
            'eStatus',
            'oddNumber',
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
