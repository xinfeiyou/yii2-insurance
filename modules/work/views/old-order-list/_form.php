<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\OldOrderList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="old-order-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'OrderID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OrderType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ProjectID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AccountID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ExtraRate')->textInput() ?>

    <?= $form->field($model, 'Amount')->textInput() ?>

    <?= $form->field($model, 'PreviousRepaymentDate')->textInput() ?>

    <?= $form->field($model, 'CreateTime')->textInput() ?>

    <?= $form->field($model, 'ExtraMoney')->textInput() ?>

    <?= $form->field($model, 'SettlementPeriod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tCreateTime')->textInput() ?>

    <?= $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
