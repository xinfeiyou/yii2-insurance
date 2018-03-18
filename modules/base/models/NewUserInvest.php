<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%new_user_invest}}".
 *
 * @property string $id
 * @property string $oddNumber
 * @property double $money
 * @property string $userId
 * @property string $time
 * @property string $oddTitle
 * @property double $oddYearRate
 * @property double $oddMoney
 * @property string $oddRepaymentStyle
 * @property integer $oddBorrowPeriod
 * @property string $qishu
 * @property double $benjin
 * @property double $lixi
 */
class NewUserInvest extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%new_user_invest}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['money', 'oddYearRate', 'oddMoney', 'benjin', 'lixi','oddLixi'], 'number'],
            [['time'], 'safe'],
            [['oddRepaymentStyle'], 'string'],
            [['oddBorrowPeriod', 'qishu'], 'integer'],
            [['oddNumber', 'userId'], 'string', 'max' => 20],
            [['oddTitle'], 'string', 'max' => 100],
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
            'money' => 'Money',
            'userId' => 'User ID',
            'time' => 'Time',
            'oddTitle' => 'Odd Title',
            'oddYearRate' => 'Odd Year Rate',
            'oddMoney' => 'Odd Money',
            'oddLixi' => 'oddLixi',
            'oddRepaymentStyle' => 'Odd Repayment Style',
            'oddBorrowPeriod' => 'Odd Borrow Period',
            'qishu' => 'Qishu',
            'benjin' => 'Benjin',
            'lixi' => 'Lixi',
        ];
    }
}
