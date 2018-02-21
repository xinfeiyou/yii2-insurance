<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_odd_deduct}}".
 *
 * @property string $id
 * @property string $strWorkNum
 * @property string $oddNumber
 * @property integer $intPeriod
 * @property double $fRealMonery
 * @property string $tOperateTime
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkOddDeduct extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_odd_deduct}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['intPeriod'], 'integer'],
            [['fRealMonery'], 'number'],
            [['tOperateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['strWorkNum'], 'string', 'max' => 40],
            [['oddNumber'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strWorkNum' => '申请编号',
            'oddNumber' => '标的编号',
            'intPeriod' => '期数',
            'fRealMonery' => '代扣金额',
            'tOperateTime' => '代扣时间',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

}
