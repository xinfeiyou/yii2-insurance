<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%old_money_list_new}}".
 *
 * @property string $id
 * @property string $FundRecordID
 * @property string $FundRecordType
 * @property string $AccountID
 * @property string $Content
 * @property double $Money
 * @property string $UserName
 * @property string $RealName
 * @property string $CreateTime
 * @property string $tCreateTime
 * @property string $tUpdateTime
 * @property string $strType
 */
class OldMoneyListNew extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%old_money_list_new}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Content'], 'string'],
            [['Money'], 'number'],
            [['CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['FundRecordID', 'AccountID'], 'string', 'max' => 100],
            [['FundRecordType'], 'string', 'max' => 1],
            [['UserName', 'RealName'], 'string', 'max' => 40],
            [['strType'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'FundRecordID' => 'Fund Record ID',
            'FundRecordType' => 'Fund Record Type',
            'AccountID' => 'Account ID',
            'Content' => 'Content',
            'Money' => 'Money',
            'UserName' => 'User Name',
            'RealName' => 'Real Name',
            'CreateTime' => 'Create Time',
            'tCreateTime' => 'T Create Time',
            'tUpdateTime' => 'T Update Time',
            'strType' => 'Str Type',
        ];
    }
}
