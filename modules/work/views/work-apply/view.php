<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkApply */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '车险申请列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-apply-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'strWorkNum',
            'strRealName',
            'strPhone',
            'strTravelAdder',
            'strCarNumber',
            'strCompulsoryInsurance',
            'tCompulsoryInsuranceEffectiveTime',
            'strCommercialInsurance',
            'tCommercialInsuranceEffectiveTime',
            'strLossInsurance',
            'strThirdPartyInsurance',
            'strTheftInsurance',
            'strDriverLiabilityInsurance',
            'strPassengerLiabilityInsurance',
            'strGlassInsurance',
            'strSelfIgnitionInsurance',
            'strWadingInsurance',
            'strScratchInsurance',
            'strExcessInsurance',
            [
                'attribute' => 'strInsuranceOffice',
                'value' => function($model) {
                    return $model->getSysConfigInfoTypeValue('strInsuranceOffice', $model->strInsuranceOffice);
                },
                'headerOptions' => ['width' => '70']
            ],
            [
                'attribute' => 'strFaceIdCard',
                'label' => '身份证正面',
                'format' => ['image', ['width' => '40', 'height' => '40',]],
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'strFaceVehicleLicense',
                'label' => '身份证反面',
                'format' => ['image', ['width' => '40', 'height' => '40',]],
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'strReverseIdCard',
                'label' => '行驶证件',
                'format' => ['image', ['width' => '40', 'height' => '40',]],
                'headerOptions' => ['width' => '50']
            ],
            [
                'attribute' => 'strOther',
                'label' => '其他证件',
                'format' => ['image', ['width' => '40', 'height' => '40',]],
                'headerOptions' => ['width' => '50']
            ],
            'eStatus',
            'oddNumber',
            'offlineMoney',
            'offlineRate',
            'oddRepaymentStyle',
            'oddBorrowPeriod',
            'eApplyStatus',
            'tCreateTime',
            'tUpdateTime',
        ],
    ])
    ?>
    <p>
<?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
