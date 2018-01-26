<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_collect_record}}".
 *
 * @property string $id
 * @property string $oddNumber
 * @property int $intPeriod
 * @property string $strWay
 * @property string $strUser
 * @property string $strCollectResults
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkCollectRecord extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_collect_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['oddNumber'], 'string', 'max' => 40],
            [['strWay', 'strUser'], 'string', 'max' => 50],
            [['strCollectResults'], 'string', 'max' => 255],
            [['intPeriod'],'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'oddNumber' => '借款编号',
            'intPeriod' => '期数',
            'strWay' => '催收方式',
            'strUser' => '催收人员',
            'strCollectResults' => '催收结果',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 获取全部催收记录
     * @param string $oddNumber 借款编号
     * @param string $intPeriod 当前期数
     * @return boolean
     */
    public function getAll($oddNumber,$intPeriod) {
        $arData = WorkCollectRecord::find()
                ->where(['oddNumber' => $oddNumber,'intPeriod'=>$intPeriod])
                ->orderBy(['id' => SORT_ASC])
                ->all();
        if (empty($arData)) {
            return false;
        } else {
            return $arData;
        }
    }

    /**
     * 添加用户数据
     * @param array $arData
     * @return type
     */
    public function add($strUserId, $oddNumber, $intPeriod,$arData) {
        $model = new WorkCollectRecord();
        $arData['oddNumber'] = $oddNumber;
        $arData['intPeriod'] = $intPeriod;
        $arData['strUser'] = $strUserId;
        $arMsg = $this->create_data($model, $arData);
        return $arMsg;
    }

}
