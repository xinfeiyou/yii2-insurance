<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_project_list}}".
 *
 * @property string $id
 * @property string $ProjectID
 * @property string $ProjectType
 * @property string $Title
 * @property double $TargetAmount
 * @property double $MonthlyReturnRate
 * @property integer $RepaymentDuration
 * @property string $FundraisingBeginTime
 * @property string $FundraisingEndTime
 * @property string $RepaymentType
 * @property integer $InterestDate
 * @property string $Safeguards
 * @property string $BorrowerInformation
 * @property string $ProjectState
 * @property string $CreateTime
 * @property double $ExtraMonthlyReturnRate
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class OldProjectList extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_project_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TargetAmount', 'MonthlyReturnRate', 'ExtraMonthlyReturnRate'], 'number'],
            [['RepaymentDuration', 'InterestDate'], 'integer'],
            [['FundraisingBeginTime', 'FundraisingEndTime', 'CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['Safeguards', 'BorrowerInformation'], 'string'],
            [['ProjectID', 'Title'], 'string', 'max' => 255],
            [['ProjectType', 'RepaymentType', 'ProjectState'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ProjectID' => '项目ID',
            'ProjectType' => '项目类型',
            'Title' => '项目标题',
            'TargetAmount' => '募集资金',
            'MonthlyReturnRate' => '月利息',
            'RepaymentDuration' => '期数',
            'FundraisingBeginTime' => '募集开始时间',
            'FundraisingEndTime' => '募集结束时间',
            'RepaymentType' => '还款类型',
            'InterestDate' => '起息时间',
            'Safeguards' => '保障措施',
            'BorrowerInformation' => '借款人信息',
            'ProjectState' => '项目状态',
            'CreateTime' => '新增时间',
            'ExtraMonthlyReturnRate' => '额外月利率',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }
}
