<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\search\WorkApplySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-apply-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'strWorkNum') ?>

    <?= $form->field($model, 'strRealName') ?>

    <?= $form->field($model, 'strPhone') ?>

    <?= $form->field($model, 'strTravelAdder') ?>

    <?php // echo $form->field($model, 'strCarNumber') ?>

    <?php // echo $form->field($model, 'strCompulsoryInsurance') ?>

    <?php // echo $form->field($model, 'tCompulsoryInsuranceEffectiveTime') ?>

    <?php // echo $form->field($model, 'strCommercialInsurance') ?>

    <?php // echo $form->field($model, 'tCommercialInsuranceEffectiveTime') ?>

    <?php // echo $form->field($model, 'strLossInsurance') ?>

    <?php // echo $form->field($model, 'strThirdPartyInsurance') ?>

    <?php // echo $form->field($model, 'strTheftInsurance') ?>

    <?php // echo $form->field($model, 'strDriverLiabilityInsurance') ?>

    <?php // echo $form->field($model, 'strPassengerLiabilityInsurance') ?>

    <?php // echo $form->field($model, 'strGlassInsurance') ?>

    <?php // echo $form->field($model, 'strSelfIgnitionInsurance') ?>

    <?php // echo $form->field($model, 'strWadingInsurance') ?>

    <?php // echo $form->field($model, 'strScratchInsurance') ?>

    <?php // echo $form->field($model, 'strExcessInsurance') ?>

    <?php // echo $form->field($model, 'strInsuranceOffice') ?>

    <?php // echo $form->field($model, 'tCreateTime') ?>

    <?php // echo $form->field($model, 'tUpdateTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
