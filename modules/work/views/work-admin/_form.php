<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkAdmin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-admin-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'realname')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strUserId')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authKey')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'accessToken')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?php // $form->field($model, 'tCreateTime')->textInput() ?>

    <?php // $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
