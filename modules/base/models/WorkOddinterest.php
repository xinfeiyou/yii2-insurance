<?php

namespace app\modules\base\models;

use Yii;
use app\modules\base\models\BaseModel;
/**
 * This is the model class for table "{{%work_oddinterest}}".
 *
 * @property string $id
 * @property string $oddNumber
 * @property integer $qishu
 * @property double $benJin
 * @property double $interest
 * @property double $zongEr
 * @property double $yuEr
 * @property double $realAmount
 * @property double $realinterest
 * @property string $userId
 * @property string $addtime
 * @property string $endtime
 * @property string $operatetime
 * @property integer $status
 * @property double $subsidy
 */
class WorkOddinterest extends BaseModel
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
            [['qishu', 'status'], 'integer'],
            [['benJin', 'interest', 'zongEr', 'yuEr', 'realAmount', 'realinterest', 'subsidy'], 'number'],
            [['addtime', 'endtime', 'operatetime'], 'safe'],
            [['oddNumber', 'userId'], 'string', 'max' => 20],
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
            'qishu' => '期数',
            'benJin' => '本金',
            'interest' => '利息',
            'zongEr' => '总额',
            'yuEr' => '余额',
            'realAmount' => '实还金额',
            'realinterest' => '实还利息',
            'userId' => '用户编号',
            'addtime' => '添加时间',
            'endtime' => '结束时间',
            'operatetime' => '操作时间',
            'status' => '状态',
            'subsidy' => '罚息',
        ];
    }
}
