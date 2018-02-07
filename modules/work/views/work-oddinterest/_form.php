<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-oddinterest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intPeriod')->textInput() ?>

    <?= $form->field($model, 'fRemainder')->textInput() ?>

    <?= $form->field($model, 'fRealMonery')->textInput() ?>

    <?= $form->field($model, 'fRealinterest')->textInput() ?>

    <?= $form->field($model, 'strUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tStartTime')->textInput() ?>

    <?= $form->field($model, 'tEndTime')->textInput() ?>

    <?= $form->field($model, 'tOperateTime')->textInput() ?>

    <?= $form->field($model, 'strPaymentStatus')->textInput() ?>

    <?= $form->field($model, 'fSubsidy')->textInput() ?>

    <?php // $form->field($model, 'tCreateTime')->textInput() ?>

    <?php // $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
