<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\search\WorkOddinterest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-oddinterest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'oddNumber') ?>

    <?= $form->field($model, 'intPeriod') ?>

    <?= $form->field($model, 'fOnLineCost') ?>

    <?= $form->field($model, 'fOnLineInterest') ?>

    <?php // echo $form->field($model, 'fOnLineTotal') ?>

    <?php // echo $form->field($model, 'fOffLineCost') ?>

    <?php // echo $form->field($model, 'fOffLineInterest') ?>

    <?php // echo $form->field($model, 'fOffLineTotal') ?>

    <?php // echo $form->field($model, 'fRemainder') ?>

    <?php // echo $form->field($model, 'fRealMonery') ?>

    <?php // echo $form->field($model, 'fRealinterest') ?>

    <?php // echo $form->field($model, 'strUserId') ?>

    <?php // echo $form->field($model, 'tStartTime') ?>

    <?php // echo $form->field($model, 'tEndTime') ?>

    <?php // echo $form->field($model, 'tOperateTime') ?>

    <?php // echo $form->field($model, 'strPaymentStatus') ?>

    <?php // echo $form->field($model, 'fSubsidy') ?>

    <?php // echo $form->field($model, 'tCreateTime') ?>

    <?php // echo $form->field($model, 'tUpdateTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
