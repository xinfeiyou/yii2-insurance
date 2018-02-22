<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */
$js = <<<EOD
function bindBank(strPhone,strRealName,strBankCode,strBankNum,strUserCode,strUserId){
    $.post("/index.php?r=api/baofu/bind-user-bank", { phone: strPhone, name: strRealName, bankCode: strBankCode, bankNum: strBankNum, cardnum: strUserCode},
    function(data){
        alert(data.msg);
    }, "json");    
}
EOD;
$jsj = <<<EOD
    $(".dropdown-menu li a").on("click",function(){
        var text = $(this).text();
        $("#strField").val(text)
        $("#strValue").text(text);
	//$(this).parent().parent().parent().find("button span.text").text($(this).text())
    })    
EOD;
$this->registerJs($js, View::POS_END);
$this->registerJs($jsj, View::POS_READY);
$this->title = '申请信息: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '代扣列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '代扣列表详情';
?>
<div class="work-oddinterest-deduct">
    <div class="work-apply-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'oddNumber')->textInput(['maxlength' => true, 'disabled' => true]) ?>

        <?=
        $form->field($model, 'intPeriod', [
            'template' => '{label}<div class="input-group">
                {input}
                <span class="input-group-addon" id="basic-addon2">期</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?=
        $form->field($model, 'fRemainder', [
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?=
        $form->field($model, 'fOnLineCost', [
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?=
        $form->field($model, 'fOnLineInterest', [
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?php
//        $form->field($model, 'fOnLineTotal', [
//            'template' => '{label}<div class="input-group">
//                <span class="input-group-addon">$</span>
//                {input}
//                <span class="input-group-addon">.00</span>
//              </div>',
//        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?=
        $form->field($model, 'fRealMonery', [
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?=
        $form->field($model, 'fRealinterest', [
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?=
        $form->field($model, 'fSubsidy', [
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
        ?>

        <?=
        $form->field($model, 'fMoney', [
            'template' => '{label}<div class="input-group">
                       <span class="input-group-addon">$</span>
                       {input}
                       <input type="hidden" name="strField" id="strField">
                       <span class="input-group-addon">.00</span>
                       <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="text" id="strValue">选择</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                          <li><a href="javascript:">本金</a></li>
                          <li><a href="javascript:">利息</a></li>
                          <li><a href="javascript:">罚息</a></li>
                        </ul>
                      </div><!-- /btn-group -->
                    </div><!-- /input-group -->',
        ])->textInput(['maxlength' => true])
        ?>
        <div class="form-group">
            <?= Html::submitButton('线下代扣', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>期数</th>
                <th>代扣类型</th>
                <th>代扣金额</th>
                <th>操作时间</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($arData)) {
                foreach ($arData as $obj) {
                    ?>
                    <tr>
                        <th scope="row"><?= $obj->intPeriod; ?></th>
                        <td><?= $obj->getSysConfigInfoTypeValue('strTypeMonery', $obj->strTypeMonery); ?></td>
                        <td><?= $obj->fRealMonery; ?></td>
                        <td><?= $obj->tOperateTime; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
