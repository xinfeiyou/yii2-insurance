<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_user_invest_all}}".
 *
 * @property string $id
 * @property string $strTitle
 * @property string $strType
 * @property string $strContent
 * @property double $fMoney
 * @property double $fLixi
 * @property string $strPhone
 * @property string $strRealName
 * @property string $tCreateTime
 * @property double $MonthlyReturnRate
 * @property integer $RepaymentDuration
 * @property string $RepaymentType
 */
class OldUserInvestAll extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_user_invest_all}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['strContent'], 'string'],
            [['fMoney', 'fLixi', 'MonthlyReturnRate'], 'number'],
            [['tCreateTime'], 'safe'],
            [['RepaymentDuration'], 'integer'],
            [['strTitle'], 'string', 'max' => 200],
            [['strType'], 'string', 'max' => 100],
            [['strPhone', 'strRealName'], 'string', 'max' => 20],
            [['RepaymentType'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'strTitle' => 'Str Title',
            'strType' => 'Str Type',
            'strContent' => 'Str Content',
            'fMoney' => 'F Money',
            'fLixi' => 'F Lixi',
            'strPhone' => 'Str Phone',
            'strRealName' => 'Str Real Name',
            'tCreateTime' => 'T Create Time',
            'MonthlyReturnRate' => 'Monthly Return Rate',
            'RepaymentDuration' => 'Repayment Duration',
            'RepaymentType' => 'Repayment Type',
        ];
    }
}
