<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */

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
        $form->field($model, 'fOffLineTotal', [
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true, 'disabled' => true])
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
        
        <div class="form-group">
            <?= Html::a('线下代扣', null, ['class' => 'btn btn-primary','title' => '线下代扣', 'onclick' => '']);?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <hr>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>期数</th>
                <th>代扣本金</th>
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
