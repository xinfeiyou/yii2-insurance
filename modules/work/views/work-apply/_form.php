<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkApply */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-apply-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'strWorkNum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strRealName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strTravelAdder')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strCarNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strCompulsoryInsurance')->dropDownList($model->getSysConfigInfoType('strInsuranceStatus')) ?>

    <?= $form->field($model, 'tCompulsoryInsuranceEffectiveTime')->textInput() ?>

    <?= $form->field($model, 'strCommercialInsurance')->dropDownList($model->getSysConfigInfoType('strInsuranceStatus')) ?>

    <?= $form->field($model, 'tCommercialInsuranceEffectiveTime')->textInput() ?>

    <?= $form->field($model, 'strLossInsurance')->dropDownList($model->getSysConfigInfoType('strLossInsurance')) ?>

    <?= $form->field($model, 'strThirdPartyInsurance')->dropDownList($model->getSysConfigInfoType('strThirdPartyInsurance')) ?>

    <?= $form->field($model, 'strTheftInsurance')->dropDownList($model->getSysConfigInfoType('strTheftInsurance')) ?>

    <?= $form->field($model, 'strDriverLiabilityInsurance')->dropDownList($model->getSysConfigInfoType('strDriverLiabilityInsurance')) ?>

    <?= $form->field($model, 'strPassengerLiabilityInsurance')->dropDownList($model->getSysConfigInfoType('strPassengerLiabilityInsurance')) ?>

    <?= $form->field($model, 'strGlassInsurance')->dropDownList($model->getSysConfigInfoType('strGlassInsurance')) ?>

    <?= $form->field($model, 'strSelfIgnitionInsurance')->dropDownList($model->getSysConfigInfoType('strSelfIgnitionInsurance')) ?>

    <?= $form->field($model, 'strWadingInsurance')->dropDownList($model->getSysConfigInfoType('strWadingInsurance')) ?>

    <?= $form->field($model, 'strScratchInsurance')->dropDownList($model->getSysConfigInfoType('strScratchInsurance')) ?>

    <?= $form->field($model, 'strExcessInsurance')->dropDownList($model->getSysConfigInfoType('strExcessInsurance')) ?>

    <?= $form->field($model, 'strInsuranceOffice')->dropDownList($model->getSysConfigInfoType('strInsuranceOffice')) ?>
    
    <?= $form->field($model, 'strFaceIdCard')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strFaceVehicleLicense')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strReverseIdCard')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strOther')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'eStatus')->dropDownList($model->getSysConfigInfoType('strApplyStatus'))?>
    
    <?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'offlineMoney')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'offlineRate')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'oddRepaymentStyle')->dropDownList($model->getSysConfigInfoType('oddRepaymentStyle')) ?>
    
    <?= $form->field($model, 'oddBorrowPeriod')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'eApplyStatus')->dropDownList($model->getSysConfigInfoType('strApplyStatus')) ?>
    
    <?php // $form->field($model, 'tCreateTime')->textInput() ?>

    <?php // $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
