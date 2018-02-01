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
 * @property string $strCodeImg
 * @property string $strUserType
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
            [['nickName', 'language', 'strUserType'], 'string', 'max' => 20],
            [['gender'], 'string', 'max' => 1],
            [['city', 'province', 'country', 'openId'], 'string', 'max' => 100],
            [['avatarUrl', 'scene', 'strCodeImg'], 'string']
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
            'scene' => '推荐码',
            'strCodeImg' => '推荐码',
            'strUserType' => '用户类型',
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
        if (empty($arData['strUserId'])) {
            $arData['strUserId'] = $this->getUserId();
        }
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
     * 更加手机获取信息
     * @param string $strPhone
     * @return type
     */
    public function getPhone($strPhone) {
        $arObj = WorkUser::findOne(['strPhone' => $strPhone]);
        if (empty($arObj)) {
            return false;
        } else {
            return $arObj;
        }
    }

    /**
     * 获取用户模型
     * @param type $strUserId
     * @return type
     */
    public function getModels($strUserId) {
        $arObj = WorkUser::findOne(['strUserId' => $strUserId]);
        if (empty($arObj)) {
            return false;
        } else {
            return $arObj;
        }
    }

    /**
     * 通过推荐人列表获取用户ID列表
     * @param string $strUserId  主推荐人ID
     * @param array $arPromoter  推荐人数组
     * @return array 客户数组
     */
    public function getPromoterToUser($strUserId, $arPromoter) {
        $arObj = WorkUser::find()
                ->select(['strUserId'])
                ->where(['in', 'scene', $arPromoter])
                ->all();
        $arUserId[0] = $strUserId;
        $i = 1;
        foreach ($arObj as $obj) {
            $arUserId[$i] = $obj->strUserId;
            $i++;
        }
        return $arUserId;
    }

    /**
     * 获取推荐人对应的项目列表
     * @param string $arUserId 推荐人的ID 约定推荐码等于推荐人ID
     */
    public function getPromoterOddList($arUserId) {
        $arObj = WorkUser::find()
                ->where(['in', 'strUserId', $arUserId])
                ->all();
        $arData = [];
        $i = 0;
        foreach ($arObj as $obj) {
            $odd = $obj->oddinfo;
            if (!empty($odd)) {
                $arData[$i]['id'] = $i;
                $arData[$i]['faceSrc'] = $obj->avatarUrl;
                $arData[$i]['timer'] = $odd->oddRehearTime; //$timer;
                $arData[$i]['money'] = $odd->oddMoney; //$money;
                $arData[$i]['user'] = $obj->nickName;
                $arData[$i]['detailsEvent'] = 'detailsEvent';
                $arData[$i]['eventParams'] = "{\"inner_page_link\":\"\\/pages\\/workDetail\\/workDetail\",\"is_redirect\":0}";
                $arData[$i]['strWorkNum'] = $odd->applyinfo->strWorkNum;
                $i++;
            }
        }
        return $arData;
    }

    /**
     * 获取借款信息
     * @return type
     */
    public function getOddinfo() {
        return $this->hasOne(WorkOdd::className(), ['userId' => 'strUserId']);
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
