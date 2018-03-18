<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_user_invest}}".
 *
 * @property string $id
 * @property string $strTitle
 * @property string $strType
 * @property string $strContent
 * @property double $fMoney
 * @property double $fLixi
 * @property string $strPhone
 * @property string $strRealName
 * @property string $tCreateTime
 */
class OldUserInvest extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_user_invest}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['strContent'], 'string'],
            [['fMoney', 'fLixi'], 'number'],
            [['tCreateTime'], 'safe'],
            [['strTitle'], 'string', 'max' => 200],
            [['strType'], 'string', 'max' => 100],
            [['strPhone', 'strRealName'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'strTitle' => 'Str Title',
            'strType' => 'Str Type',
            'strContent' => 'Str Content',
            'fMoney' => 'F Money',
            'fLixi' => 'F Lixi',
            'strPhone' => 'Str Phone',
            'strRealName' => 'Str Real Name',
            'tCreateTime' => 'T Create Time',
        ];
    }
}
