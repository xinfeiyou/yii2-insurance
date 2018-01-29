<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\BaseController;
use app\modules\base\models\WorkApply;
use app\modules\base\models\WorkApplyPage;
use app\modules\base\models\WorkPromoter;
use app\modules\base\models\WorkOdd;
use app\modules\base\models\WorkUser;
use app\modules\base\models\WorkOddinterest;
use app\common\Str;
use app\common\NetWork;

/**
 * Default controller for the `api` module
 */
class WorkController extends BaseController {

    public $strTitle = '车险申请';

    public function actionWorkGetPage() {
        $strWorkNum = \Yii::$app->request->post('strWorkNum');
        $arRow = WorkApplyPage::findOne(['strWorkNum' => $strWorkNum]);
        if ($arRow) {
            $key = $arRow->strPage;
        } else {
            $key = '';
        }
        $arMsg['content'] = ['key' => $key];
        $arReturn = NetWork::setMsg($this->strTitle, '填写表单', '0000', $arMsg['content']);
        Str::echoJson($arReturn);
    }

    /**
     * 流程申请第一，填写用户资料
     */
    public function actionWorkUserData() {
        $strPageKey = 'work_chooseinsurancetype';
        $arPost = \Yii::$app->request->post();
        $model = new WorkApply();
        $arPost['strWorkNum'] = $model->getWorkNum();
        $arMsg = $model->add($arPost);
        $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
        $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);
        (new WorkApplyPage())->add($arPost['strWorkNum'], ['strPage' => $strPageKey]);
        Str::echoJson($arReturn);
    }

    /**
     * 流程申请第二，选择险种
     */
    public function actionWorkInsuranceData() {
        $strPageKey = 'work_chooseinsurancecompany';
        $arPost = \Yii::$app->request->post();
        $model = new WorkApply();
        $arMsg = $model->edit($arPost['strWorkNum'], $arPost);
        $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
        $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);

        Str::echoJson($arReturn);
    }

    /**
     * 流程申请第三，选择保险公司
     */
    public function actionWorkOfficeData() {
        $strPageKey = 'work_submitmaterial';
        $arPost = \Yii::$app->request->post();
        $model = new WorkApply();
        $arMsg = $model->edit($arPost['strWorkNum'], $arPost);
        $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
        $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);
        (new WorkApplyPage())->edit($arPost['strWorkNum'], ['strPage' => $strPageKey]);
        Str::echoJson($arReturn);
    }

    /**
     * 流程申请第四，上传证件照片
     */
    public function actionWorkUserCard() {
        $arPost = \Yii::$app->request->post();
        $model = new WorkApply();
        $arMsg = $model->edit($arPost['strWorkNum'], $arPost);
        $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
        $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);
        Str::echoJson($arReturn);
    }

    /**
     * 证件图片上传
     */
    public function actionWorkUserImage() {
        $arPost = \Yii::$app->request->post();
        $key = 'file';
        if (isset($_FILES[$key])) {
            $url = '/upload/' . $_FILES[$key]['name'];
            $bStatus = move_uploaded_file($_FILES[$key]['tmp_name'], '.' . $url);
            if ($bStatus) {
                $ret = '0000';
                $strMsg = '成功';
            } else {
                $ret = '1000';
                $strMsg = '失败';
            }
            $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $ret, ['url' => $url, 'name' => $arPost['name']]);
            Str::echoJson($arReturn);
        } else {
            $arReturn = NetWork::setMsg($this->strTitle, '失败', '1001', []);
            Str::echoJson($arReturn);
        }
    }

    /**
     * 获取用户项目列表
     */
    public function actionWorkUserOddList() {
        $cWorkOdd = new WorkOdd();
        $strUserId = \Yii::$app->request->post('strUserId');
        $arData = [];
        $arOdd = $cWorkOdd->getWorkList($strUserId);
        if (!empty($arOdd)) {
            $i = 0;
            foreach ($arOdd as $obj) {
                $arData[$i]['id'] = $i;
                $arData[$i]['faceSrc'] = $obj->username->avatarUrl;
                $arData[$i]['timer'] = $obj->oddRehearTime; //$timer;
                $arData[$i]['money'] = $obj->oddMoney; //$money;
                $arData[$i]['user'] = $obj->username->nickName;
                $arData[$i]['detailsEvent'] = "detailsEvent";
                $arData[$i]['eventParams'] = "{\"inner_page_link\":\"\\/pages\\/repayDetail\\/repayDetail\",\"is_redirect\":0}";
                $arData[$i]['oddNumber'] = $obj->oddNumber;
                $i++;
            }
        }
        $arReturn = NetWork::setMsg($this->strTitle, '成功', '0000', $arData);
        Str::echoJson($arReturn);
    }

    /**
     * 获取用户项目列表
     */
    public function actionWorkPromoterOddList() {
        $strUserId = \Yii::$app->request->post('strUserId');
        $arPromoter = (new WorkPromoter())->getPromoterAllList($strUserId);
        $cWorkUser = new WorkUser();
        $arUserId = $cWorkUser->getPromoterToUser($strUserId, $arPromoter);
        $arData = $cWorkUser->getPromoterOddList($arUserId);
        $arReturn = NetWork::setMsg($this->strTitle, '成功', '0000', $arData);
        Str::echoJson($arReturn);
    }

    /**
     * 获取当前用户申请列表
     */
    public function actionWorkUserOddApplyList() {
        $strUserId = \Yii::$app->request->post('strUserId');
        $arData = (new WorkApply())->getApplyList($strUserId);
        $arReturn = NetWork::setMsg($this->strTitle, '成功', '0000', $arData);
        Str::echoJson($arReturn);
    }

    /**
     * 获取用户申请详情
     */
    public function actionWorkUserOddApply() {
        $strWorkNum = \Yii::$app->request->post('oddNumber');
        $arObj = (new WorkApply())->getApplyInfo($strWorkNum);
        $arData['user_src'] = (new WorkUser())->getModels($arObj->strUserId)->avatarUrl;
        $arData['name'] = $arObj->strRealName;
        $arData['phone'] = $arObj->strPhone;
        $arData['car']['title'] = "车辆信息";
        $arData['car']['list'][0]['title'] = "行驶城市";
        $arData['car']['list'][0]['value'] = $arObj->strTravelAdder;
        $arData['car']['list'][0]['style'] = "";
        $arData['car']['list'][1]['title'] = "车牌号码";
        $arData['car']['list'][1]['value'] = $arObj->strCarNumber;
        $arData['car']['list'][1]['style'] = "";
        $arData['insurance']['title'] = "保险信息";
        $arData['insurance']['list'][0]['title'] = "保险公司";
        $arData['insurance']['list'][0]['value'] = $arObj->strInsuranceOffice;
        $arData['insurance']['list'][0]['style'] = "";
        $arData['insurance']['list'][1]['title'] = "交强险+车船险";
        $arData['insurance']['list'][1]['value'] = ($arObj->strCompulsoryInsurance) ? '投保' : '不投保';
        $arData['insurance']['list'][1]['style'] = "";
        $arData['insurance']['list'][2]['title'] = "生效时间";
        $arData['insurance']['list'][2]['value'] = $arObj->tCompulsoryInsuranceEffectiveTime;
        $arData['insurance']['list'][2]['style'] = "";
        $arData['insurance']['list'][3]['title'] = "商业主险";
        $arData['insurance']['list'][3]['value'] = ($arObj->strCommercialInsurance) ? '投保' : '不投保';
        $arData['insurance']['list'][3]['style'] = "";
        $arData['insurance']['list'][4]['title'] = "生效时间";
        $arData['insurance']['list'][4]['value'] = $arObj->tCommercialInsuranceEffectiveTime;
        $arData['insurance']['list'][4]['style'] = "";
        $arData['business']['title'] = "商业主险";
        $arData['business']['list'][0]['title'] = "车辆损失险";
        $arData['business']['list'][0]['value'] = $arObj->strLossInsurance;
        $arData['business']['list'][0]['style'] = "";
        $arData['business']['list'][1]['title'] = "第三责任险";
        $arData['business']['list'][1]['value'] = $arObj->strThirdPartyInsurance;
        $arData['business']['list'][1]['style'] = "";
        $arData['business']['list'][2]['title'] = "全车盗抢险";
        $arData['business']['list'][2]['value'] = $arObj->strTheftInsurance;
        $arData['business']['list'][2]['style'] = "";
        $arData['business']['list'][3]['title'] = "司机责任险";
        $arData['business']['list'][3]['value'] = $arObj->strDriverLiabilityInsurance;
        $arData['business']['list'][3]['style'] = "";
        $arData['business']['list'][4]['title'] = "乘客责任险";
        $arData['business']['list'][4]['value'] = $arObj->strPassengerLiabilityInsurance;
        $arData['business']['list'][4]['style'] = "";
        $arData['addition']['title'] = "商业附加险";
        $arData['addition']['list'][0]['title'] = "玻璃破碎险";
        $arData['addition']['list'][0]['value'] = $arObj->strGlassInsurance;
        $arData['addition']['list'][0]['style'] = "";
        $arData['addition']['list'][1]['title'] = "自燃损失险";
        $arData['addition']['list'][1]['value'] = $arObj->strSelfIgnitionInsurance;
        $arData['addition']['list'][1]['style'] = "";
        $arData['addition']['list'][2]['title'] = "发动机涉水险";
        $arData['addition']['list'][2]['value'] = $arObj->strWadingInsurance;
        $arData['addition']['list'][2]['style'] = "";
        $arData['addition']['list'][3]['title'] = "划痕险";
        $arData['addition']['list'][3]['value'] = $arObj->strScratchInsurance;
        $arData['addition']['list'][3]['style'] = "";
        $arData['addition']['list'][4]['title'] = "不计免赔率险";
        $arData['addition']['list'][4]['value'] = $arObj->strExcessInsurance;
        $arData['addition']['list'][4]['style'] = "";
        $arData['eventHandler'] = 'eventHandler';
        $arData['eventParams'] = '{"inner_page_link":"/pages/idImg/idImg","is_redirect":0}';
        $arData['listid'] = '';
        $arData['oddNumber'] = $arObj->oddNumber;
        $arReturn = NetWork::setMsg($this->strTitle, '成功', '0000', $arData);
        Str::echoJson($arReturn);
    }

    /**
     * 获取证件详情
     */
    public function actionWorkUserOddIdimg() {
        $oddNumber = \Yii::$app->request->post('oddNumber');
        $arObj = (new WorkApply())->getApplyInfo($oddNumber);
        $arData[0]['name'] = "身份证";
        $arData[0]['list'][0]['imgSrc'] = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . $arObj->strFaceIdCard;
        $arData[0]['list'][1]['imgSrc'] = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . $arObj->strFaceVehicleLicense;
        $arData[1]['name'] = "行驶证";
        $arData[1]['list'][0]['imgSrc'] = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . $arObj->strReverseIdCard;
        $arData[2]['name'] = "其他证件";
        if (!empty($arObj->strOther)) {
            $arTmp = explode(',', $arObj->strOther);
            $i = 0;
            foreach ($arTmp as $v) {
                $arData[2]['list'][$i]['imgSrc'] = $v;
                $i++;
            }
        }
        $arReturn = NetWork::setMsg($this->strTitle, '成功', '0000', $arData);
        Str::echoJson($arReturn);
    }

    /**
     * 还款列表明细
     */
    public function actionWorkUserOddReplay() {
        $oddNumber = \Yii::$app->request->post('oddNumber');
        $arData = (new WorkOddinterest())->getReplayDetail($oddNumber);
        $arReturn = NetWork::setMsg($this->strTitle, '成功', '0000', $arData);
        Str::echoJson($arReturn);
    }

}
