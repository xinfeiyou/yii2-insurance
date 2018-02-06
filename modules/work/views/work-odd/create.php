<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkApply */

$this->title = '借款信息';
$this->params['breadcrumbs'][] = ['label' => '项目列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-apply-create">
        <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true]) ?>
   
    <?= $form->field($model, 'offlineMoney')->textInput() ?>

    <?= $form->field($model, 'offlineRate')->textInput() ?>
    
    <?= $form->field($model, 'oddRepaymentStyle')->dropDownList($model->getSysConfigInfoType('oddRepaymentStyle')) ?>
    <?php /* $this->render('_form', [
        'model' => $model,
    ]) */?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '编辑', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
