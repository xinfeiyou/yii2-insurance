<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\work\models\WorkOddinterest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-oddinterest-form clearfix">
    <?php $form = ActiveForm::begin(['class' => 'form-inline']); ?>
    <div class="row clearfix">
        <div class="col-md-3"><?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true, 'disabled' => true]) ?><?= $model->oddNumber ?></div>
        <div class="col-md-3"><?= $form->field($model, 'userId')->textInput(['maxlength' => true, 'disabled' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'qishu')->textInput(['disabled' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'benJin')->textInput(['disabled' => true]) ?></div>
    </div>
    <div class="row clearfix">
        <div class="col-md-3"><?= $form->field($model, 'interest')->textInput(['disabled' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'zongEr')->textInput(['disabled' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'yuEr')->textInput(['disabled' => true]) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'addtime')->textInput(['disabled' => true]) ?></div>
    </div>
    <div class="row clearfix">
        <div class="col-md-3"><?= $form->field($model, 'endtime')->textInput(['disabled' => true]) ?></div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6"><?= $form->field($model, 'realAmount')->textInput() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'realinterest')->textInput() ?></div>
    </div>
    <div class="row clearfix">
        <?php // $form->field($model, 'operatetime')->textInput() ?>
        <div class="col-md-6"><?= $form->field($model, 'status')->dropDownList(['0' => '未还', '1' => '已还', '2' => '提前', '3' => '逾期'], ['value' => '0']) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'subsidy')->textInput() ?></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Remember me
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
            </div>
        </div>
    </form>
</div>
