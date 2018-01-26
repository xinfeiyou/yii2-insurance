<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_config}}".
 *
 * @property string $id
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
            [['strKey'], 'string', 'max' => 50],
            [['strValue'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strKey' => 'Str Key',
            'strValue' => 'Str Value',
            'tCreateTime' => 'T Create Time',
            'tUpdateTime' => 'T Update Time',
        ];
    }

    /**
     * 根据关键字查找对应的值
     * @param string $strKey
     * @return boolean|string
     */
    public function getKeyToValue($strKey) {
        $arObj = WorkConfig::findOne(['strKey' => $strKey]);
        if (empty($arObj)) {
            return false;
        } else {
            return $arObj->strValue;
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
        if ($arObj) {
            $model = WorkConfig::findOne(['strKey' => $strKey]);
            $arMsg = $this->edit_data($model, ['strValue' => $strValue]);
        } else {
            $model = new WorkConfig();
            $arMsg = $this->create_data($model, ['strKey' => $strKey, 'strValue' => $strValue]);
        }
        return $arMsg;
    }

}
