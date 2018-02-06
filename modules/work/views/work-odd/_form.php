<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOdd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-odd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'offlineMoney')->textInput() ?>

    <?= $form->field($model, 'offlineRate')->textInput() ?>
    
    <?= $form->field($model, 'oddRepaymentStyle')->dropDownList($model->getSysConfigInfoType('oddRepaymentStyle')) ?>
    
    <?= $form->field($model, 'oddType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oddTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oddYearRate')->textInput() ?>

    <?= $form->field($model, 'oddMoney')->textInput() ?>

    <?= $form->field($model, 'oddBorrowPeriod')->textInput() ?>

    <?= $form->field($model, 'serviceFee')->textInput() ?>

    <?= $form->field($model, 'oddTrialTime')->textInput() ?>

    <?= $form->field($model, 'oddRehearTime')->textInput() ?>

    <?= $form->field($model, 'userId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isCr')->textInput() ?>

    <?= $form->field($model, 'receiptUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receiptStatus')->textInput() ?>

    <?= $form->field($model, 'finishType')->textInput() ?>

    <?= $form->field($model, 'finishTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
