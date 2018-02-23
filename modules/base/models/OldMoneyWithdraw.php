<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_money_withdraw}}".
 *
 * @property string $id
 * @property string $WithdrawalApplicationID
 * @property string $AccountID
 * @property double $WithdrawableMoney
 * @property string $WithdrawalState
 * @property string $DealTime
 * @property string $CreateTime
 * @property double $WithdrawalDisableMoney
 * @property string $Trans_batchid
 * @property string $Trans_no
 * @property string $UserName
 * @property string $RealName
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class OldMoneyWithdraw extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_money_withdraw}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['WithdrawableMoney', 'WithdrawalDisableMoney'], 'number'],
            [['DealTime', 'CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['WithdrawalApplicationID', 'AccountID', 'Trans_batchid', 'Trans_no'], 'string', 'max' => 100],
            [['WithdrawalState'], 'string', 'max' => 1],
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
            'WithdrawalApplicationID' => '提现申请ID',
            'AccountID' => '用户ID',
            'WithdrawableMoney' => '可提现部分金额',
            'WithdrawalState' => '提现状态',
            'DealTime' => '审核时间',
            'CreateTime' => '添加时间',
            'WithdrawalDisableMoney' => '不可提现部分金额',
            'Trans_batchid' => '宝付批次号',
            'Trans_no' => '宝付订单号',
            'UserName' => '用户名',
            'RealName' => '真实姓名',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }
}
