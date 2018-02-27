<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\OldProjectList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="old-project-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProjectID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ProjectType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TargetAmount')->textInput() ?>

    <?= $form->field($model, 'MonthlyReturnRate')->textInput() ?>

    <?= $form->field($model, 'RepaymentDuration')->textInput() ?>

    <?= $form->field($model, 'FundraisingBeginTime')->textInput() ?>

    <?= $form->field($model, 'FundraisingEndTime')->textInput() ?>

    <?= $form->field($model, 'RepaymentType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'InterestDate')->textInput() ?>

    <?= $form->field($model, 'Safeguards')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'BorrowerInformation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ProjectState')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CreateTime')->textInput() ?>

    <?= $form->field($model, 'ExtraMonthlyReturnRate')->textInput() ?>

    <?= $form->field($model, 'tCreateTime')->textInput() ?>

    <?= $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
