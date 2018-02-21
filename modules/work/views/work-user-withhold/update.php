<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkUserWithhold */
$js = <<<EOD
function bindBank(strPhone,strRealName,strBankCode,strBankNum,strUserCode,strUserId){
    $.post("/index.php?r=api/baofu/bind-user-bank", { phone: strPhone, name: strRealName, bankCode: strBankCode, bankNum: strBankNum, cardnum: strUserCode},
    function(data){
        if('0000' == data.ret){
            $.post("/index.php?r=api/baofu/edit-status", { strUserId: strUserId } );
        }
        alert(data.msg);
    }, "json");    
}
EOD;
$this->registerJs($js, View::POS_END);
$this->title = '用户银行信息: ' . $model->strUserId;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['/work/work-user/index']];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="work-user-withhold-update">
    <div class="work-user-withhold-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'strUserId')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'strBankName')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'strBankCode')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'strBankNum')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'strUserCode')->textInput(['maxlength' => true, 'disabled' => true]) ?>

        <?= $form->field($model, 'strRealName')->textInput(['maxlength' => true, 'disabled' => true]) ?>

        <?= $form->field($model, 'strUserPhone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'strStatus')->textInput(['maxlength' => true, 'disabled' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('编辑银行卡信息', ['class' => 'btn btn-primary']) ?>
            &nbsp;&nbsp;
            <?= Html::a('验证用户绑卡', null, ['title' => '编辑', 'onclick' => 'bindBank("' . $model->strUserPhone . '","' . $model->strRealName . '","' . $model->strBankCode . '","' . $model->strBankNum . '","' . $model->strUserCode . '","' . $model->strUserId . '")', 'class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>