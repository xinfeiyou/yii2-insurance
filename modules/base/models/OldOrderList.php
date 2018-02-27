<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_order_list}}".
 *
 * @property string $id
 * @property string $OrderID
 * @property string $OrderType
 * @property string $ProjectID
 * @property string $AccountID
 * @property double $ExtraRate
 * @property double $Amount
 * @property string $PreviousRepaymentDate
 * @property string $CreateTime
 * @property double $ExtraMoney
 * @property string $SettlementPeriod
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class OldOrderList extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_order_list}}';
    }

    /**
     * @inheritdoc
     */
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ExtraRate', 'Amount', 'ExtraMoney'], 'number'],
            [['PreviousRepaymentDate', 'CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['OrderID', 'ProjectID', 'AccountID'], 'string', 'max' => 100],
            [['OrderType', 'SettlementPeriod'], 'string', 'max' => 10],
            [['UserName', 'RealName'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'OrderID' => '订单ID',
            'OrderType' => '订单类型',
            'ProjectID' => '项目ID',
            'AccountID' => '用户ID',
            'ExtraRate' => '额外月利率',
            'Amount' => '金额',
            'PreviousRepaymentDate' => '上次还款日期',
            'CreateTime' => '订单创建日期',
            'ExtraMoney' => '额外金额',
            'SettlementPeriod' => '结算周期',
            'UserName' => '用户名',
            'RealName' => '真实姓名',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }
}
