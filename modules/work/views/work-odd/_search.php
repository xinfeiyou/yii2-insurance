<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\search\WorkOddSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-odd-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'oddNumber') ?>

    <?= $form->field($model, 'oddType') ?>

    <?= $form->field($model, 'oddTitle') ?>

    <?= $form->field($model, 'oddYearRate') ?>

    <?php // echo $form->field($model, 'oddMoney') ?>

    <?php // echo $form->field($model, 'oddRepaymentStyle') ?>

    <?php // echo $form->field($model, 'oddBorrowPeriod') ?>

    <?php // echo $form->field($model, 'serviceFee') ?>

    <?php // echo $form->field($model, 'oddTrialTime') ?>

    <?php // echo $form->field($model, 'oddRehearTime') ?>

    <?php // echo $form->field($model, 'userId') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <?php // echo $form->field($model, 'offlineMoney') ?>

    <?php // echo $form->field($model, 'offlineRate') ?>

    <?php // echo $form->field($model, 'isCr') ?>

    <?php // echo $form->field($model, 'receiptUserId') ?>

    <?php // echo $form->field($model, 'receiptStatus') ?>

    <?php // echo $form->field($model, 'finishType') ?>

    <?php // echo $form->field($model, 'finishTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
