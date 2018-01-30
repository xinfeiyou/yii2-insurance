<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\base\models\WorkOddinterest */

$this->title = '申请信息: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '申请列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '生成线下还款列表';
?>
<div class="work-apply-edit-off-money">
    <div class="work-apply-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'strWorkNum')->textInput(['maxlength' => true,'disabled'=>true]) ?>

        <?= $form->field($model, 'offlineMoney',[
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true])?>
        
        <?= $form->field($model, 'offlineRate',[
            'template' => '{label}<div class="input-group">
                <span class="input-group-addon">$</span>
                {input}
                <span class="input-group-addon">.00</span>
              </div>',
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'oddRepaymentStyle')->dropDownList($model->getSysConfigInfoType('oddRepaymentStyle')) ?>

        <?= $form->field($model, 'oddBorrowPeriod',[
            'template' => '{label}<div class="input-group">
                {input}
                <span class="input-group-addon" id="basic-addon2">月</span>
              </div>',
        ])->textInput(['maxlength' => true]) ?>

        <div class="form-group">
        <?= Html::submitButton( '生成线下还款明细', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <hr>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>期数</th>
          <th>线下本金</th>
          <th>线下利息</th>
          <th>线下总额</th>
          <th>线下余额</th>
        </tr>
      </thead>
      <tbody>
          <?php if(!empty($arInterest)){foreach($arInterest as $obj){?>
        <tr>
          <th scope="row"><?=$obj->intPeriod;?></th>
          <td><?=$obj->fOffLineCost;?></td>
          <td><?=$obj->fOffLineInterest;?></td>
          <td><?=$obj->fOffLineTotal;?></td>
          <td><?=$obj->fRemainder;?></td>
        </tr>
          <?php }}?>
      </tbody>
    </table>
</div>
