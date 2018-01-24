<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\search\WorkUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'strUserId') ?>

    <?= $form->field($model, 'strPhone') ?>

    <?= $form->field($model, 'strPass') ?>

    <?= $form->field($model, 'nickName') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'openId') ?>

    <?php // echo $form->field($model, 'avatarUrl') ?>

    <?php // echo $form->field($model, 'tCreateTime') ?>

    <?php // echo $form->field($model, 'tUpdateTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
