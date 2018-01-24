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

    <?= $form->field($model, 'strCompulsoryInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tCompulsoryInsuranceEffectiveTime')->textInput() ?>

    <?= $form->field($model, 'strCommercialInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tCommercialInsuranceEffectiveTime')->textInput() ?>

    <?= $form->field($model, 'strLossInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strThirdPartyInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strTheftInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strDriverLiabilityInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strPassengerLiabilityInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strGlassInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strSelfIgnitionInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strWadingInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strScratchInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strExcessInsurance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strInsuranceOffice')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strFaceIdCard')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strFaceVehicleLicense')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strReverseIdCard')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strOther')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'tCreateTime')->textInput() ?>

    <?= $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
