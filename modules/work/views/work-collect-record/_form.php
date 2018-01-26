<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkCollectRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-collect-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'oddNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strWay')->dropDownList(['电催' => '电催', '上门' => '上门'])  ?>

    <?php // $form->field($model, 'strUser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'strCollectResults')->textarea(['maxlength' => true]) ?>

    <?php // $form->field($model, 'tCreateTime')->textInput() ?>

    <?php // $form->field($model, 'tUpdateTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
