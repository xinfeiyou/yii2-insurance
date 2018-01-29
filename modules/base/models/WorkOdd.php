<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_odd}}".
 *
 * @property string $id
 * @property string $oddNumber
 * @property string $oddType
 * @property string $oddTitle
 * @property double $oddYearRate
 * @property double $oddMoney
 * @property string $oddRepaymentStyle
 * @property integer $oddBorrowPeriod
 * @property double $serviceFee
 * @property string $oddTrialTime
 * @property string $oddRehearTime
 * @property string $userId
 * @property string $operator
 * @property double $offlineMoney
 * @property double $offlineRate
 * @property integer $isCr
 * @property string $receiptUserId
 * @property integer $receiptStatus
 * @property integer $finishType
 * @property string $finishTime
 */
class WorkOdd extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_odd}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['oddNumber', 'oddType', 'oddTitle', 'oddYearRate', 'oddBorrowPeriod'], 'required'],
            [['oddYearRate', 'oddMoney', 'serviceFee', 'offlineMoney', 'offlineRate'], 'number'],
            [['oddRepaymentStyle'], 'string'],
            [['oddBorrowPeriod', 'isCr', 'receiptStatus', 'finishType'], 'integer'],
            [['oddTrialTime', 'oddRehearTime', 'finishTime'], 'safe'],
            [['oddNumber', 'oddType', 'userId', 'operator', 'receiptUserId'], 'string', 'max' => 20],
            [['oddTitle'], 'string', 'max' => 100],
            [['oddNumber'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'oddNumber' => '标的编号',
            'oddType' => '标的类型',
            'oddTitle' => '借标标题',
            'oddYearRate' => '年化率',
            'oddMoney' => '借款金额',
            'oddRepaymentStyle' => '还款类型',
            'oddBorrowPeriod' => '借款期限',
            'serviceFee' => '借款服务费',
            'oddTrialTime' => '初审时间',
            'oddRehearTime' => '复审时间',
            'userId' => '用户ID',
            'operator' => '代发标人',
            'offlineMoney' => '线下金额',
            'offlineRate' => '线下利率',
            'isCr' => '是否代偿',
            'receiptUserId' => '收款人ID',
            'receiptStatus' => '受托状态',
            'finishType' => '完结类型',
            'finishTime' => '完结时间',
        ];
    }

    /**
     * 根据用户ID获取项目信息
     * @param type $strUserId
     * @return type
     */
    public function getWorkList($strUserId) {
        return WorkOdd::find()
                        ->where(['userId' => $strUserId])
                        ->all();
    }

    /**
     * 通过用户组获取odd列表
     * @param array $arUserId
     * @return array
     */
    public function getWorkAllList($arUserId) {
        return WorkOdd::find()
                        ->where(['in', 'userId', $arUserId])
                        ->all();
    }

    /**
     * 获取申请信息
     * @return type
     */
    public function getApplyinfo() {
        return $this->hasOne(WorkApply::className(), ['oddNumber' => 'oddNumber']);
    }

    /**
     * 获取用户名
     * @return type
     */
    public function getUsername() {
        return $this->hasOne(WorkUser::className(), ['strUserId' => 'userId']);
    }

}
