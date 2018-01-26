<?php

namespace app\modules\base\models;

use Yii;

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
class WorkOddinterest extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_oddinterest}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intPeriod', 'strPaymentStatus'], 'integer'],
            [['fOnLineCost', 'fOnLineInterest', 'fOnLineTotal', 'fOffLineCost', 'fOffLineInterest', 'fOffLineTotal', 'fRemainder', 'fRealMonery', 'fRealinterest', 'fSubsidy'], 'number'],
            [['tStartTime', 'tEndTime', 'tOperateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['oddNumber', 'strUserId'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }
}
