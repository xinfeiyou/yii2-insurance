<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_money_list}}".
 *
 * @property string $id
 * @property string $FundRecordID
 * @property string $FundRecordType
 * @property string $AccountID
 * @property string $Content
 * @property double $Money
 * @property string $UserName
 * @property string $RealName
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class OldMoneyList extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%old_money_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['Content'], 'string'],
            [['Money'], 'number'],
            [['tCreateTime', 'tUpdateTime', 'CreateTime'], 'safe'],
            [['FundRecordID', 'AccountID'], 'string', 'max' => 100],
            [['FundRecordType'], 'string', 'max' => 1],
            [['UserName', 'RealName'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'FundRecordID' => '资金记录ID',
            'FundRecordType' => '资金类型',
            'AccountID' => '用户ID',
            'Content' => '备注',
            'Money' => '金额',
            'UserName' => '账户名',
            'RealName' => '真实姓名',
            'CreateTime' => '添加时间',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

}
