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
 * @property string $EIsAdmin
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkAdmin extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strUserId'], 'string', 'max' => 50],
            [['username', 'EIsAdmin'], 'string', 'max' => 15],
            [['password'], 'string', 'max' => 64],
            [['authKey', 'accessToken'], 'string', 'max' => 255],
            [['realname'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strUserId' => '客户ID',
            'username' => '用户名',
            'password' => '密码',
            'authKey' => 'Auth值',
            'accessToken' => 'Token值',
            'realname' => '真实姓名',
            'EIsAdmin' => '是否管理员',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 编辑用户资料
     * @param type $model
     * @param type $arData
     * @return type
     */
    public function edit($model, $arData) {
        if ($model->password != $arData['password']) {
            $arData['password'] = md5($arData['password']);
        } else {
            unset($arData['password']);
        }
        return $this->edit_data($model, $arData);
    }

}
