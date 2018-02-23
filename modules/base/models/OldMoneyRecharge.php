<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_money_recharge}}".
 *
 * @property string $id
 * @property string $RechargeRecordID
 * @property string $ServiceID
 * @property string $AccountID
 * @property double $Money
 * @property string $CreateTime
 * @property string $UserName
 * @property string $RealName
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class OldMoneyRecharge extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%old_money_recharge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['Money'], 'number'],
            [['CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['RechargeRecordID', 'ServiceID', 'AccountID'], 'string', 'max' => 100],
            [['UserName', 'RealName'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'RechargeRecordID' => '充值对账记录ID',
            'ServiceID' => '宝付订单号',
            'AccountID' => '用户ID',
            'Money' => '金额',
            'CreateTime' => '添加时间',
            'UserName' => '用户名',
            'RealName' => '真实姓名',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

}
