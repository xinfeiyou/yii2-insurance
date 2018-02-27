<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_project_id}}".
 *
 * @property string $id
 * @property string $ProjectID
 */
class OldProjectId extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_project_id}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ProjectID'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ProjectID' => 'Project ID',
        ];
    }
}
