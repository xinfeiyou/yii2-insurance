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
    <?php /* $this->render('_form', [
        'model' => $model,
    ]) */?>
    <div class="form-group">
        <?= Html::submitButton('获取', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
