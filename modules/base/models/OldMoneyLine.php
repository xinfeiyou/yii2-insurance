<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_money_line}}".
 *
 * @property integer $id
 * @property string $AddMoneyApplicationID
 * @property string $AccountID
 * @property string $ManagerID
 * @property double $Money
 * @property string $State
 * @property string $DealTime
 * @property string $CreateTime
 * @property string $UserName
 * @property string $RealName
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class OldMoneyLine extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_money_line}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Money'], 'number'],
            [['DealTime', 'CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['AddMoneyApplicationID', 'AccountID', 'ManagerID'], 'string', 'max' => 100],
            [['State'], 'string', 'max' => 10],
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
            'AddMoneyApplicationID' => '增加余额申请ID',
            'AccountID' => '用户ID',
            'ManagerID' => '管理员ID',
            'Money' => '金额',
            'State' => '状态',
            'DealTime' => '处理时间',
            'CreateTime' => '创建时间',
            'UserName' => '用户名',
            'RealName' => '真实姓名',
            'tCreateTime' => 'T Create Time',
            'tUpdateTime' => 'T Update Time',
        ];
    }
}
