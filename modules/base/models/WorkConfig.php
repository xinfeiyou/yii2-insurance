<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_config}}".
 *
 * @property string $id
 * @property string $strType
 * @property string $strKey
 * @property string $strValue
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkConfig extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strType'], 'string', 'max' => 50],
            [['strKey', 'strValue'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strType' => '类型',
            'strKey' => 'Key',
            'strValue' => 'Value',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 根据关键字查找对应的值
     * @param string $strType
     * @return boolean|string
     */
    public function getKeyToValue($strKey) {
        $arObj = WorkConfig::findOne(['strType' => $strKey]);
        if (empty($arObj)) {
            return false;
        } else {
            return $arObj->strKey;
        }
    }

    /**
     * 更新数据
     * @param string $strKey
     * @param string $strValue
     * @return array
     */
    public function editKeyToValue($strKey, $strValue) {
        $arObj = $this->getKeyToValue($strKey);
        if (empty($arObj)) {
            $model = new WorkConfig();
            $arData['strType'] = $strKey;
            $arData['strKey'] = $strValue;
            $arData['strValue'] = "微信token值";
            $arMsg = $this->create_data($model, $arData);
        } else {
            $model = WorkConfig::findOne(['strType' => $strKey]);
            $arData['strKey'] = $strValue;
            $arMsg = $this->edit_data($model, $arData);
        }
        return $arMsg;
    }

    /**
     * 获取多条配置信息
     * @param type $strType
     * @return boolean
     */
    public function getKeyToValueAll($strType) {
        $arObj = WorkConfig::find()
                ->where(['strType' => $strType])
                ->all();
        if (empty($arObj)) {
            return false;
        } else {
            return $arObj;
        }
    }

}
