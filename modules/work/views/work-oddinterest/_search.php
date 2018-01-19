<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\work\models\search\WorkOddinterestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-oddinterest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'oddNumber') ?>

    <?= $form->field($model, 'qishu') ?>

    <?= $form->field($model, 'benJin') ?>

    <?= $form->field($model, 'interest') ?>

    <?php // echo $form->field($model, 'zongEr') ?>

    <?php // echo $form->field($model, 'yuEr') ?>

    <?php // echo $form->field($model, 'realAmount') ?>

    <?php // echo $form->field($model, 'realinterest') ?>

    <?php // echo $form->field($model, 'userId') ?>

    <?php // echo $form->field($model, 'addtime') ?>

    <?php // echo $form->field($model, 'endtime') ?>

    <?php // echo $form->field($model, 'operatetime') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'subsidy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
