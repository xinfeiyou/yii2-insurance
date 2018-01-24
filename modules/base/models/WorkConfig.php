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
class WorkConfig extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strKey'], 'string', 'max' => 50],
            [['strValue'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'strKey' => 'Str Key',
            'strValue' => 'Str Value',
            'tCreateTime' => 'T Create Time',
            'tUpdateTime' => 'T Update Time',
        ];
    }
}
