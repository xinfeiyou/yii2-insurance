<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\BaseController;
use app\modules\base\models\WorkUser;
use app\modules\base\models\WorkPromoter;
use app\modules\base\models\WorkConfig;
use app\common\Str;
use app\common\NetWork;
use app\common\Files;

/**
 * Default controller for the `api` module
 */
class UserController extends BaseController {

    public $strTitle = '用户操作';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionBind() {
        $arPost = \Yii::$app->request->post();
        $url = \Yii::$app->params['api_url'] . '/common/register';
        $arData['phone'] = $arPost['strPhone'];
        $arData['smsCode'] = $arPost['strCode'];
        $arData['password'] = md5(rand(1000, 9999));
//{"status":0,"info":"该手机号已经被占用！","data":{"version": "0.1.0","time": 1517453007}}
//{"status":1,"info":"注册成功！","userId":"2000000161","data":{"version":"0.1.0","time":1517454980}}
        $strJson = NetWork::CurlPost($url, $arData);
        $obj = json_decode($strJson);
        if (empty($obj->userId)) {
            $arReturn = NetWork::setMsg($this->strTitle, $obj->info, '1001', []);
        } else {
            $model = new WorkUser();
            $arObj = $model->getPhone($arPost['strPhone']);
            if (empty($arObj)) {
                $arPost['strUserId'] = $obj->userId;
                $arMsg = (new WorkUser())->add($arPost);
                $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
                $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);
                if ('undefined' != $arPost['scene']) {
                    (new WorkPromoter())->add(['strUserId' => $arMsg['content'], 'strPromoterId' => $arPost['scene']]);
                }
            } else {
                $arReturn = NetWork::setMsg($this->strTitle, "成功", '0000', $arObj->strUserId);
            }
        }
        Str::echoJson($arReturn);
    }

    /**
     * 验证是否登录
     */
    public function actionCheckLogin() {
        $arPost = \Yii::$app->request->post();
        $openId = $this->getOpenId($arPost['code']);
        $model = new WorkUser();
        if ($model->checkOpenId($openId)) {
//已经登录
            $arMsg['ret'] = '0000';
            $arMsg['content'] = [];
        } else {
            $arPost['openId'] = $openId;
            unset($arPost['code']);
            $arMsg = $model->edit($arPost['strUserId'], $arPost);
        }
        $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
        $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);
        Str::echoJson($arReturn);
    }

    /**
     * 获取自己推广二维码
     */
    public function actionGetQrcode() {
        $strUserId = \Yii::$app->request->post('strUserId');
        $arObj = (new WorkUser())->getModels($strUserId);
        if (!empty($arObj->strCodeImg)) {
            $arReturn = NetWork::setMsg($this->strTitle, "获取成功", "0000", ['url' => $arObj->strCodeImg]);
            Str::echoJson($arReturn);
        }
        $strToken = (new WorkConfig())->getKeyToValue('strToken');
        if (empty($strToken)) {
            $arReturn = NetWork::setMsg($this->strTitle, "获取token值失败", "1001", []);
        } else {
            $json_string = \Yii::$app->request->post('data');
            $url = \Yii::$app->request->post('url') . '?access_token=';
            $imageData = NetWork::CurlUrlData($json_string, $strToken, $url);
            Files::writeFile($strUserId . '.jpg', $imageData);
            $imagUrl = $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/upload/weixin/' . $strUserId . '.jpg';
            (new WorkUser())->edit($strUserId, ['strCodeImg' => $imagUrl]);
            $arReturn = NetWork::setMsg($this->strTitle, "获取成功", "0000", ['url' => $imagUrl]);
        }
        Str::echoJson($arReturn);
    }

    /**
     * 获取当前用户推广员列表
     */
    public function actionGetPromoter() {
//$strUserId = '2018012500000002';
        $strUserId = \Yii::$app->request->post('strUserId');
        $arPromoter = (new WorkPromoter())->getPromoterList($strUserId);
        $arReturn = NetWork::setMsg($this->strTitle, "获取成功", $arPromoter['ret'], $arPromoter['content']);
        Str::echoJson($arReturn);
    }

    /**
     * 获取当前用户基础信息
     */
    public function actionGetUserInfo() {
        $strUserId = \Yii::$app->request->post('strUserId');
        $arRow = (new WorkUser())->getModels($strUserId);
        $arData['strUserId'] = $arRow->strUserId;
        $arData['nickName'] = $arRow->nickName;
        $arData['avatarUrl'] = $arRow->avatarUrl;
        $arData['strUserType'] = $arRow->strUserType;
        $arReturn = NetWork::setMsg($this->strTitle, "获取成功", "0000", $arData);
        Str::echoJson($arReturn);
    }

    /**
     * 获取客户的经纬度
     */
    public function actionGetCity() {
        $latitude = \Yii::$app->request->post('latitude');
        $longitude = \Yii::$app->request->post('longitude');
        if (!empty($latitude) && !empty($longitude)) {
            $array = $this->getCity($latitude, $longitude);
            Str::echoJson($array);
        }
    }

    /**
     * 发送短信
     * @return type
     */
    public function actionSendSms() {
        $url = \Yii::$app->params['api_url'] . '/common/sms';
        $phone = \Yii::$app->request->post('strPhone');
        $arData['phone'] = $phone;
        $arData['msgType'] = 'register';
//{"status":1,"info":"\u53d1\u9001\u6210\u529f\uff01","data":{"version":"0.1.0","time":1517452454}}
        return NetWork::CurlPost($url, $arData);
    }

}
