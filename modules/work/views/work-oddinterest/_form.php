<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-oddinterest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true,'disabled' => true]) ?>

    <?= $form->field($model, 'intPeriod')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'fRemainder')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'fRealMonery')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'fRealinterest')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'fSubsidy')->textInput(['disabled' => true]) ?>
    
    <?php // $form->field($model, 'strUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tStartTime')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'tEndTime')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'tOperateTime')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'strPaymentStatus')->dropDownList($model->getSysConfigInfoType('strPaymentStatus')) ?>

    

    <?php // $form->field($model, 'tCreateTime')->textInput() ?>

    <?php // $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
