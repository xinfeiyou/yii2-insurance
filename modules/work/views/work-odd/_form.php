<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\work\models\WorkOdd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-odd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oddType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oddTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oddYearRate')->textInput() ?>

    <?= $form->field($model, 'oddMoney')->textInput() ?>

    <?= $form->field($model, 'successMoney')->textInput() ?>

    <?= $form->field($model, 'startMoney')->textInput() ?>

    <?= $form->field($model, 'endMoney')->textInput() ?>

    <?= $form->field($model, 'oddBorrowStyle')->dropDownList([ 'sec' => 'Sec', 'day' => 'Day', 'week' => 'Week', 'month' => 'Month', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'oddRepaymentStyle')->dropDownList([ 'monthpay' => 'Monthpay', 'weekpay' => 'Weekpay', 'matchpay' => 'Matchpay', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'oddBorrowPeriod')->textInput() ?>

    <?= $form->field($model, 'oddBorrowValidTime')->textInput() ?>

    <?= $form->field($model, 'serviceFee')->textInput() ?>

    <?= $form->field($model, 'oddTrialTime')->textInput() ?>

    <?= $form->field($model, 'oddTrialRemark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'oddRehearTime')->textInput() ?>

    <?= $form->field($model, 'oddRehearRemark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'addtime')->textInput() ?>

    <?= $form->field($model, 'publishTime')->textInput() ?>

    <?= $form->field($model, 'fullTime')->textInput() ?>

    <?= $form->field($model, 'userId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'progress')->dropDownList([ 'prep' => 'Prep', 'published' => 'Published', 'start' => 'Start', 'review' => 'Review', 'run' => 'Run', 'end' => 'End', 'fail' => 'Fail', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'operator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lookstatus')->textInput() ?>

    <?= $form->field($model, 'investType')->textInput() ?>

    <?= $form->field($model, 'readstatus')->textInput() ?>

    <?= $form->field($model, 'openTime')->textInput() ?>

    <?= $form->field($model, 'appointUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oddReward')->textInput() ?>

    <?= $form->field($model, 'oddStyle')->dropDownList([ 'normal' => 'Normal', 'newhand' => 'Newhand', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'offlineRate')->textInput() ?>

    <?= $form->field($model, 'cerStatus')->textInput() ?>

    <?= $form->field($model, 'fronStatus')->textInput() ?>

    <?= $form->field($model, 'firstFigure')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isCr')->textInput() ?>

    <?= $form->field($model, 'receiptUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receiptStatus')->textInput() ?>

    <?= $form->field($model, 'isATBiding')->textInput() ?>

    <?= $form->field($model, 'finishType')->textInput() ?>

    <?= $form->field($model, 'finishTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
