<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%view_work_odd}}".
 *
 * @property string $id
 * @property string $strWorkNum
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
 * @property string $tCreateTime
 * @property string $tUpdateTime
 * @property string $nickName
 * @property string $strPhone
 */
class ViewWorkOdd extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%view_work_odd}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'oddBorrowPeriod', 'isCr', 'receiptStatus', 'finishType'], 'integer'],
            [['oddYearRate', 'oddMoney', 'serviceFee', 'offlineMoney', 'offlineRate'], 'number'],
            [['oddRepaymentStyle'], 'string'],
            [['oddTrialTime', 'oddRehearTime', 'finishTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['strWorkNum'], 'string', 'max' => 40],
            [['oddNumber', 'oddType', 'userId', 'operator', 'receiptUserId', 'nickName'], 'string', 'max' => 20],
            [['oddTitle'], 'string', 'max' => 100],
            [['strPhone'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'strWorkNum' => 'Str Work Num',
            'oddNumber' => '标的编号',
            'oddType' => '标的类型',
            'oddTitle' => '借标标题',
            'oddYearRate' => '年化率',
            'oddMoney' => '借款金额',
            'oddRepaymentStyle' => '还款方式',
            'oddBorrowPeriod' => '借款期限',
            'serviceFee' => '借款服务费',
            'oddTrialTime' => '初审时间',
            'oddRehearTime' => '复审时间',
            'userId' => '用户ID',
            'operator' => '用户名',
            'offlineMoney' => '线下金额',
            'offlineRate' => '线下利率',
            'isCr' => '是否代偿',
            'receiptUserId' => '收款人ID',
            'receiptStatus' => '受托状态',
            'finishType' => '标的状态',
            'finishTime' => '完结时间',
            'nickName' => '用户名称',
            'strPhone' => '用户手机',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }
}
