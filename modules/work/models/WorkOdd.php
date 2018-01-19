<?php

namespace app\modules\work\models;

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
 * @property double $successMoney
 * @property double $startMoney
 * @property double $endMoney
 * @property string $oddBorrowStyle
 * @property string $oddRepaymentStyle
 * @property integer $oddBorrowPeriod
 * @property integer $oddBorrowValidTime
 * @property double $serviceFee
 * @property string $oddTrialTime
 * @property string $oddTrialRemark
 * @property string $oddRehearTime
 * @property string $oddRehearRemark
 * @property string $addtime
 * @property string $publishTime
 * @property string $fullTime
 * @property string $userId
 * @property string $progress
 * @property string $operator
 * @property integer $lookstatus
 * @property integer $investType
 * @property integer $readstatus
 * @property string $openTime
 * @property string $appointUserId
 * @property double $oddReward
 * @property string $oddStyle
 * @property double $offlineRate
 * @property integer $cerStatus
 * @property integer $fronStatus
 * @property string $firstFigure
 * @property integer $isCr
 * @property string $receiptUserId
 * @property integer $receiptStatus
 * @property integer $isATBiding
 * @property integer $finishType
 * @property string $finishTime
 */
class WorkOdd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_odd}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oddNumber', 'oddType', 'oddTitle', 'oddYearRate', 'oddBorrowStyle', 'oddBorrowPeriod', 'oddBorrowValidTime'], 'required'],
            [['oddYearRate', 'oddMoney', 'successMoney', 'startMoney', 'endMoney', 'serviceFee', 'oddReward', 'offlineRate'], 'number'],
            [['oddBorrowStyle', 'oddRepaymentStyle', 'oddTrialRemark', 'oddRehearRemark', 'progress', 'oddStyle'], 'string'],
            [['oddBorrowPeriod', 'oddBorrowValidTime', 'lookstatus', 'investType', 'readstatus', 'cerStatus', 'fronStatus', 'isCr', 'receiptStatus', 'isATBiding', 'finishType'], 'integer'],
            [['oddTrialTime', 'oddRehearTime', 'addtime', 'publishTime', 'fullTime', 'openTime', 'finishTime'], 'safe'],
            [['oddNumber', 'oddType', 'userId', 'operator', 'appointUserId', 'receiptUserId'], 'string', 'max' => 20],
            [['oddTitle'], 'string', 'max' => 100],
            [['firstFigure'], 'string', 'max' => 120],
            [['oddNumber'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oddNumber' => 'Odd Number',
            'oddType' => 'Odd Type',
            'oddTitle' => 'Odd Title',
            'oddYearRate' => 'Odd Year Rate',
            'oddMoney' => 'Odd Money',
            'successMoney' => 'Success Money',
            'startMoney' => 'Start Money',
            'endMoney' => 'End Money',
            'oddBorrowStyle' => 'Odd Borrow Style',
            'oddRepaymentStyle' => 'Odd Repayment Style',
            'oddBorrowPeriod' => 'Odd Borrow Period',
            'oddBorrowValidTime' => 'Odd Borrow Valid Time',
            'serviceFee' => 'Service Fee',
            'oddTrialTime' => 'Odd Trial Time',
            'oddTrialRemark' => 'Odd Trial Remark',
            'oddRehearTime' => 'Odd Rehear Time',
            'oddRehearRemark' => 'Odd Rehear Remark',
            'addtime' => 'Addtime',
            'publishTime' => 'Publish Time',
            'fullTime' => 'Full Time',
            'userId' => 'User ID',
            'progress' => 'Progress',
            'operator' => 'Operator',
            'lookstatus' => 'Lookstatus',
            'investType' => 'Invest Type',
            'readstatus' => 'Readstatus',
            'openTime' => 'Open Time',
            'appointUserId' => 'Appoint User ID',
            'oddReward' => 'Odd Reward',
            'oddStyle' => 'Odd Style',
            'offlineRate' => 'Offline Rate',
            'cerStatus' => 'Cer Status',
            'fronStatus' => 'Fron Status',
            'firstFigure' => 'First Figure',
            'isCr' => 'Is Cr',
            'receiptUserId' => 'Receipt User ID',
            'receiptStatus' => 'Receipt Status',
            'isATBiding' => 'Is Atbiding',
            'finishType' => 'Finish Type',
            'finishTime' => 'Finish Time',
        ];
    }
}
