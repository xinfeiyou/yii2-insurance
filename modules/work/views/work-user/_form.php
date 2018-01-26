<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'strUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strPass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nickName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'openId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatarUrl')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'scene')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'strUserType')->dropDownList(['1' => '业务员', '2' => '推广员', '3' => '客户']) ?>

    <?= $form->field($model, 'tCreateTime')->textInput() ?>

    <?= $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
