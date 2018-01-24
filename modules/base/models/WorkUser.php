<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_user}}".
 *
 * @property string $id
 * @property string $strUserId
 * @property string $strPhone
 * @property string $strPass
 * @property string $nickName
 * @property string $gender
 * @property string $language
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $openId
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkUser extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strUserId'], 'string', 'max' => 50],
            [['strPhone'], 'string', 'max' => 15],
            [['strPass'], 'string', 'max' => 64],
            [['nickName', 'language'], 'string', 'max' => 20],
            [['gender'], 'string', 'max' => 1],
            [['city', 'province', 'country', 'openId'], 'string', 'max' => 100],
            [['avatarUrl'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strUserId' => '用户ID',
            'strPhone' => '手机号',
            'strPass' => '密码',
            'nickName' => '昵称',
            'gender' => '性别',
            'language' => '语言',
            'city' => '城市',
            'province' => '省份',
            'country' => '国籍',
            'openId' => 'OpenID',
            'avatarUrl' => '头像地址',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 验证openid是否存在
     * @param type $strOpenid
     * @return boolean
     */
    public function checkOpenId($strOpenid) {
        $arRow = WorkUser::findOne(['openId' => $strOpenid]);
        if (empty($arRow)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 添加用户数据
     * @param array $arData
     * @return type
     */
    public function add($arData) {
        $model = new WorkUser();
        $arData['strUserId'] = $this->getUserId();
        $arMsg = $this->create_data($model, $arData);
        $arMsg['content'] = $arData['strUserId'];
        return $arMsg;
    }

    /**
     * 编辑用户资料
     * @param type $strUserId
     * @param type $arData
     * @return type
     */
    public function edit($strUserId, $arData) {
        $model = WorkUser::findOne(['strUserId' => $strUserId]);
        return $this->edit_data($model, $arData);
    }

    /**
     * 获取新的用户ID
     * @return string
     */
    private function getUserId() {
        $objectData = WorkUser::find()
                ->where(['like', 'strUserId', date("Ymd")])
                ->orderBy(['id' => SORT_DESC])
                ->one();
        if (!empty($objectData)) {
            $num = substr($objectData->strUserId, 10) + 1;
            $num = sprintf("%08s", $num);
            $number = date("Ymd") . $num;
        } else {
            $number = date("Ymd") . "00000001";
        }
        return $number;
    }

}
