<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_apply}}".
 *
 * @property string $id
 * @property string $strWorkNum
 * @property string $strRealName
 * @property string $strPhone
 * @property string $strTravelAdder
 * @property string $strCarNumber
 * @property string $strCompulsoryInsurance
 * @property string $tCompulsoryInsuranceEffectiveTime
 * @property string $strCommercialInsurance
 * @property string $tCommercialInsuranceEffectiveTime
 * @property string $strLossInsurance
 * @property string $strThirdPartyInsurance
 * @property string $strTheftInsurance
 * @property string $strDriverLiabilityInsurance
 * @property string $strPassengerLiabilityInsurance
 * @property string $strGlassInsurance
 * @property string $strSelfIgnitionInsurance
 * @property string $strWadingInsurance
 * @property string $strScratchInsurance
 * @property string $strExcessInsurance
 * @property string $strInsuranceOffice
 * @property string $eStatus
 * @property string $oddNumber
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkApply extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_apply}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['strWorkNum', 'strRealName', 'strPhone', 'strTravelAdder', 'strUserId'], 'required'],
            [['tCompulsoryInsuranceEffectiveTime', 'tCommercialInsuranceEffectiveTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['strWorkNum', 'strUserId', 'eStatus', 'oddNumber','oddRepaymentStyle'], 'string', 'max' => 40],
            [['strRealName', 'strPhone', 'strTravelAdder', 'strCarNumber', 'strCompulsoryInsurance', 'strCommercialInsurance', 'strLossInsurance', 'strThirdPartyInsurance', 'strTheftInsurance', 'strDriverLiabilityInsurance', 'strPassengerLiabilityInsurance', 'strGlassInsurance', 'strSelfIgnitionInsurance', 'strWadingInsurance', 'strScratchInsurance', 'strExcessInsurance'], 'string', 'max' => 50],
            [['strInsuranceOffice'], 'string', 'max' => 100],
            [['strFaceIdCard', 'strFaceVehicleLicense', 'strReverseIdCard', 'strOther'], 'string'],
            [['offlineMoney','offlineRate','oddBorrowPeriod'],'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strUserId' => '用户ID',
            'strWorkNum' => '流水号',
            'strRealName' => '真实姓名',
            'strPhone' => '手机号码',
            'strTravelAdder' => '行驶城市',
            'strCarNumber' => '车牌号码',
            'strCompulsoryInsurance' => '交强险+车船险',
            'tCompulsoryInsuranceEffectiveTime' => '交强险生效日期',
            'strCommercialInsurance' => '商业险',
            'tCommercialInsuranceEffectiveTime' => '商业险生效日期',
            'strLossInsurance' => '车辆损失险',
            'strThirdPartyInsurance' => '第三责任险',
            'strTheftInsurance' => '全车盗抢险',
            'strDriverLiabilityInsurance' => '司机责任险',
            'strPassengerLiabilityInsurance' => '乘客责任险',
            'strGlassInsurance' => '玻璃破碎险',
            'strSelfIgnitionInsurance' => '自燃损失险',
            'strWadingInsurance' => '发动机涉水损失',
            'strScratchInsurance' => '车辆划痕险',
            'strExcessInsurance' => '不计免赔率险',
            'strInsuranceOffice' => '保险公司',
            'strFaceIdCard' => '身份证正面',
            'strFaceVehicleLicense' => '身份证背面',
            'strReverseIdCard' => '行驶证',
            'strOther' => '其他证件',
            'eStatus' => '申请状态',
            'oddNumber' => '借款编号',
            'offlineMoney' => '线下金额',
            'offlineRate' => '线下利率',
            'oddBorrowPeriod' => '期限',
            'oddRepaymentStyle' => '还款类型',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 添加申请数据
     * @param array $arData
     * @return type
     */
    public function add($arData) {
        $model = new WorkApply();
        $arMsg = $this->create_data($model, $arData);
        $arMsg['content'] = $arData['strWorkNum'];
        return $arMsg;
    }

    /**
     * 编辑申请资料
     * @param type $strUserId
     * @param type $arData
     * @return type
     */
    public function edit($strWorkNum, $arData) {
        $model = WorkApply::findOne(['strWorkNum' => $strWorkNum]);
        return $this->edit_data($model, $arData);
    }

    /**
     * 根据申请编号获取申请资料
     * @param string $strWorkNum
     * @return type
     */
    public function getApplyInfo($strWorkNum) {
        return WorkApply::findOne(['strWorkNum' => $strWorkNum]);
    }

    /**
     * 获取用户申请列表
     * @param type $strUserId
     * @return type
     */
    public function getApplyList($strUserId) {
        $arObj = WorkApply::find()
                ->where(['strUserId' => $strUserId])
                ->all();
        $arData = [];
        $i = 0;
        foreach ($arObj as $obj) {
            $arData[$i]['id'] = $obj->id;
            $arData[$i]['faceSrc'] = $obj->username->avatarUrl;
            $arData[$i]['timer'] = substr($obj->tUpdateTime, 0, 10);
            $arData[$i]['eStatus'] = $this->getSysConfigInfoType('strApplyStatus')[$obj->eStatus];
            $arData[$i]['user'] = $obj->strRealName;
            $arData[$i]['detailsEvent'] = 'detailsEvent';
            $arData[$i]['eventParams'] = "{\"inner_page_link\":\"\\/pages\\/workDetail\\/workDetail\",\"is_redirect\":0}";
            $arData[$i]['strWorkNum'] = $obj->strWorkNum;
            $i++;
        }
        return $arData;
    }

    /**
     * 获取新的流程流水号ID
     * @return string
     */
    public function getWorkNum() {
        $objectData = WorkApply::find()
                ->where(['like', 'strWorkNum', date("Ymd")])
                ->orderBy(['id' => SORT_DESC])
                ->one();
        if (!empty($objectData)) {
            $num = substr($objectData->strWorkNum, 12) + 1;
            $num = sprintf("%08s", $num);
            $number = date("Ymd") . $num;
        } else {
            $number = date("Ymd") . "00000001";
        }
        return 'LC' . $number;
    }

    /**
     * 获取用户信息
     * @return type
     */
    public function getUsername() {
        return $this->hasOne(WorkUser::className(), ['strUserId' => 'strUserId']);
    }

}
