<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <!-- 正文内容 -->
        <div style="margin: 10px 10px 10px 10px;">
            <div class="work-apply-edit-off-money">
                <div class="work-apply-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="form-group field-workodd-offlinemoney has-success">
                        <label class="control-label" for="workodd-offlinemoney">线下金额</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" id="workodd-offlinemoney" class="form-control" name="WorkOdd[offlineMoney]" value="<?= isset($arData['info']['offlineMoney']) ? $arData['info']['offlineMoney'] : ""; ?>" aria-invalid="false">
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div> 


                    <div class="form-group field-workodd-offlinerate">
                        <label class="control-label" for="workodd-offlinerate">线下利率</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" id="workodd-offlinerate" class="form-control" name="WorkOdd[offlineRate]" value="<?= isset($arData['info']['offlineRate']) ? $arData['info']['offlineRate'] : ""; ?>">
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>


                    <div class="form-group field-workodd-oddrepaymentstyle">
                        <label class="control-label" for="workodd-oddrepaymentstyle">还款类型</label>
                        <select id="workodd-oddrepaymentstyle" class="form-control" name="WorkOdd[oddRepaymentStyle]">
                            <option value="1" <?php
                            if (isset($arData['info']['oddRepaymentStyle'])) {
                                echo ('1' == $arData['info']['oddRepaymentStyle']) ? 'selected' : '';
                            }
                            ?>>先息后本</option>
                            <option value="3" <?php
                            if (isset($arData['info']['oddRepaymentStyle'])) {
                                echo ('3' == $arData['info']['oddRepaymentStyle']) ? 'selected' : '';
                            }
                            ?>>等额本息</option>
                        </select>
                        <div class="help-block"></div>
                    </div>

                    <div class="form-group field-workodd-oddborrowperiod">
                        <label class="control-label" for="workodd-oddborrowperiod">借款期限</label>
                        <div class="input-group">
                            <input type="text" id="workodd-oddborrowperiod" class="form-control" name="WorkOdd[oddBorrowPeriod]" value="<?= isset($arData['info']['oddBorrowPeriod']) ? $arData['info']['oddBorrowPeriod'] : ""; ?>">
                            <span class="input-group-addon" id="basic-addon2">月</span>
                        </div>
                    </div>

                    <div class="form-group field-workodd-oddborrowperiod">
                        <label class="control-label" for="workodd-oddborrowtime">还款时间</label>
                        <div class="input-group">
                            <input type="text" id="workodd-oddborrowperiod" class="form-control" name="WorkOdd[oddBorrowTime]" value="<?= isset($arData['info']['oddBorrowTime']) ? $arData['info']['oddBorrowTime'] : date("Y-m-d H:i:s"); ?>">
                            <span class="input-group-addon" id="basic-addon2">日期</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('生成还款明细', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>期数</th>
                            <th>还款本金</th>
                            <th>还款利息</th>
                            <th>还款总额</th>
                            <th>还款余额</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($arData['list'])) {
                            foreach ($arData['list'] as $obj) {
                                ?>
                                <tr>
                                    <th scope="row"><?= $obj['month']; ?></th>
                                    <td><?= $obj['benjin']; ?></td>
                                    <td><?= $obj['lixi']; ?></td>
                                    <td><?= $obj['zonger']; ?></td>
                                    <td><?= $obj['yuer']; ?></td>
                                    <td><?= $obj['stime']; ?></td>
                                    <td><?= $obj['etime']; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>