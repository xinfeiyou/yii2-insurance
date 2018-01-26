<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_admin}}".
 *
 * @property string $id
 * @property string $strUserId
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string $realname
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkAdmin extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strUserId'], 'string', 'max' => 50],
            [['username'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 64],
            [['authKey', 'accessToken'], 'string', 'max' => 255],
            [['realname'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'strUserId' => 'Str User ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'realname' => 'Realname',
            'tCreateTime' => 'T Create Time',
            'tUpdateTime' => 'T Update Time',
        ];
    }
}
