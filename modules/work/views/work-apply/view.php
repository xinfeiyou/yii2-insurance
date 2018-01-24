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
    <?= DetailView::widget([
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
            'strInsuranceOffice',
            [
                'attribute' => 'strFaceIdCard',
                'label' => '身份证正面',
                'format' => ['image', ['width' => '40', 'height' => '40',]],
                'headerOptions' => ['width' => '50']
            ],
            'tCreateTime',
            'tUpdateTime',
        ],
    ]) ?>
    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
