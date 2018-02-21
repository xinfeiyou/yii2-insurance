<?php

namespace app\modules\base\models;

use Yii;
use app\common\MathPayment;

/**
 * This is the model class for table "{{%work_oddinterest}}".
 *
 * @property string $id
 * @property string $oddNumber
 * @property integer $intPeriod
 * @property double $fOnLineCost
 * @property double $fOnLineInterest
 * @property double $fOnLineTotal
 * @property double $fOffLineCost
 * @property double $fOffLineInterest
 * @property double $fOffLineTotal
 * @property double $fRemainder
 * @property double $fRealMonery
 * @property double $fRealinterest
 * @property string $strUserId
 * @property string $tStartTime
 * @property string $tEndTime
 * @property string $tOperateTime
 * @property integer $strPaymentStatus
 * @property double $fSubsidy
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkOddinterest extends \app\modules\base\models\BaseModel {

    public $fDiff;
    public $fMoney;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_oddinterest}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['intPeriod', 'strPaymentStatus'], 'integer'],
            [['fOnLineCost', 'fOnLineInterest', 'fOnLineTotal', 'fOffLineCost', 'fOffLineInterest', 'fOffLineTotal', 'fRemainder', 'fRealMonery', 'fRealinterest', 'fSubsidy'], 'number'],
            [['tStartTime', 'tEndTime', 'tOperateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['strWorkNum'], 'string', 'max' => 40],
            [['oddNumber', 'strUserId'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strWorkNum' => '申请编号',
            'oddNumber' => '借款单编号',
            'intPeriod' => '期数',
            'fOnLineCost' => '线上本金',
            'fOnLineInterest' => '线上利息',
            'fOnLineTotal' => '线上总额',
            'fOffLineCost' => '线下本金',
            'fOffLineInterest' => '线下利息',
            'fOffLineTotal' => '线下总额',
            'fRemainder' => '余额',
            'fRealMonery' => '实还本金',
            'fRealinterest' => '实还利息',
            'strUserId' => '客户ID',
            'tStartTime' => '开始时间',
            'tEndTime' => '结束时间',
            'tOperateTime' => '还款时间',
            'strPaymentStatus' => '还款状态',
            'fSubsidy' => '逾期罚息',
            'fDiff' => '差额',
            'fMoney' => '实扣金额',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 添加数据
     * @param type $oddNumber
     * @param type $arData
     */
    public function add($oddNumber, $arData) {
        $arData['oddNumber'] = $oddNumber;
        return $this->create_data((new WorkOddinterest()), $arData);
    }

    /**
     * 清除记录
     * @param type $oddNumber
     */
    public function del($oddNumber) {
        $model = WorkOddinterest::findOne(['oddNumber' => $oddNumber]);
        if (!empty($model)) {
            $model->delete();
        }
    }

    /**
     * 项目还款明细
     * @param type $strWorkNum
     */
    public function getReplayDetail($strWorkNum) {
        $objOddInfo = WorkApply::findOne(['strWorkNum' => $strWorkNum]);
        $arData['user_src'] = $objOddInfo->username->avatarUrl;
        $arData['name'] = $objOddInfo->username->nickName;
        $arData['fOffLineTotal'] = $objOddInfo->offlineMoney;
        $arData['intPeriod'] = $objOddInfo->oddBorrowPeriod;
        $arObj = WorkOddinterest::find()
                ->where(['strWorkNum' => $strWorkNum])
                ->all();
        $i = 0;
        foreach ($arObj as $obj) {
            $arData['list'][$i]['title'] = "第" . $obj->intPeriod . "期";
            $arData['list'][$i]['list'][1]['title'] = "还款利息";
            $arData['list'][$i]['list'][1]['value'] = $obj->fOffLineInterest;
            $arData['list'][$i]['list'][1]['style'] = true;
            $arData['list'][$i]['list'][2]['title'] = "还款本金";
            $arData['list'][$i]['list'][2]['value'] = $obj->fOffLineCost;
            $arData['list'][$i]['list'][2]['style'] = true;
            $arData['list'][$i]['list'][3]['title'] = "还款时间";
            $arData['list'][$i]['list'][3]['value'] = substr($obj->tEndTime, 0, 10);
            $arData['list'][$i]['list'][3]['style'] = true;
            $arData['list'][$i]['list'][4]['title'] = "实还金额";
            $arData['list'][$i]['list'][4]['value'] = round(($obj->fRealMonery + $obj->fRealinterest), 2);
            $arData['list'][$i]['list'][4]['style'] = true;
            $i++;
        }
        return $arData;
    }

    /**
     * 根据申请编号获取还款明细
     * @param string $strWorkNum
     * @return type
     */
    public function getWorkNumToOddinterest($strWorkNum) {
        return WorkOddinterest::find()
                        ->where(['strWorkNum' => $strWorkNum])
                        ->all();
    }

    /**
     * 根据申请编号获取还款明细
     * @param string $strWorkNum
     * @return type
     */
    public function getOddNumToOddinterest($strOddNum) {
        return WorkOddinterest::find()
                        ->where(['oddNumber' => $strOddNum])
                        ->all();
    }

    /**
     * 重置线下还款列表
     * @param string $strWorkNum    申请流水号
     * @param string $offlineMoney
     * @param double $offlineRate
     * @param int $oddBorrowPeriod
     * @param int $oddRepaymentStyle
     * @return type
     */
    public function editWorkOffLineInterest($strWorkNum, $offlineMoney, $offlineRate, $oddBorrowPeriod, $oddRepaymentStyle) {
        $arObj = WorkOddinterest::findOne(['strWorkNum' => $strWorkNum]);
        if (empty($arObj)) {
            $arDataAll = MathPayment::PayInterest($offlineMoney, $offlineRate, $oddBorrowPeriod, 'month', $oddRepaymentStyle);
            foreach ($arDataAll['notes'] as $ar) {
                $model = new WorkOddinterest();
                $arData['strWorkNum'] = $strWorkNum;
                $arData['intPeriod'] = $ar['month'];
                $arData['fOffLineCost'] = $ar['benjin'];
                $arData['fOffLineInterest'] = $ar['lixi'];
                $arData['fOffLineTotal'] = $ar['zonger'];
                $this->create_data($model, $arData);
            }
        }
        return $this->setReturnMsg('0000');
    }

    /**
     * 重置线下还款列表
     * @param string $strOddNum    申请流水号
     * @param string $offlineMoney
     * @param double $offlineRate
     * @param int $oddBorrowPeriod
     * @param int $oddRepaymentStyle
     * @return type
     */
    public function editOddOffLineInterest($strOddNum, $offlineMoney, $offlineRate, $oddBorrowPeriod, $oddRepaymentStyle) {
        $arDataAll = MathPayment::PayInterest($offlineMoney, $offlineRate, $oddBorrowPeriod, 'month', $oddRepaymentStyle);
        foreach ($arDataAll['notes'] as $ar) {
            $model = WorkOddinterest::findOne(['oddNumber' => $strOddNum, 'intPeriod' => $ar['month']]);
            $arData['fOffLineCost'] = $ar['benjin'];
            $arData['fOffLineInterest'] = $ar['lixi'];
            $arData['fOffLineTotal'] = $ar['zonger'];
            $arData['fRemainder'] = $ar['yuer'];
//                $arData['tStartTime'] = $ar['stime'];
//                $arData['tEndTime'] = $ar['etime'];
            $ar = $this->edit_data($model, $arData);
        }
        return $this->setReturnMsg('0000');
    }

    /**
     * 修改还款金额
     * @param string $strOddNum     借款编号
     * @param int $intPeriod        还款期数
     * @param string $strField      字段名称
     * @param float $fMoney         金额
     */
    public function editOddMoney($strOddNum, $intPeriod, $strField, $fMoney) {
        if (in_array($strField, ['fRealMonery', 'fRealinterest', 'fSubsidy']) && $fMoney > 0) {
            $model = WorkOddinterest::findOne(['oddNumber' => $strOddNum, 'intPeriod' => $intPeriod]);
            $arData[$strField] = $model->$strField + $fMoney;
            return $model->edit_data($model, $arData);
        } else {
            return $this->setReturnMsg('1000');
        }
    }

}
