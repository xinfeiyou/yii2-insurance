<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\BaseController;
use app\modules\base\models\WorkUser;
use app\common\Str;

/**
 * Default controller for the `api` module
 */
class UserController extends BaseController {

    public $strTitle = '用户操作';
    public $strUserId = '2018012400000001';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionBind() {
        $model = new WorkUser();
        $arPost = \Yii::$app->request->post();
        unset($arPost['strCode']);
        $arMsg = $model->edit($this->strUserId, $arPost);
        $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
        $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);
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
        } else {
            $arPost['openId'] = $openId;
            unset($arPost['code']);
            $arMsg = $model->add($arPost);
            $strMsg = ('0000' == $arMsg['ret']) ? '成功' : '失败';
            $arReturn = NetWork::setMsg($this->strTitle, $strMsg, $arMsg['ret'], $arMsg['content']);
            Str::echoJson($arReturn);
        }
    }

    /**
     * 获取微信客户openid
     * @param type $code
     * @return boolean
     */
    public function getOpenId($code) {
        if (empty($code)) {
            return false;
        }
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . \Yii::$app->params['appId'] . "&secret=" . \Yii::$app->params['appSecret'] . "&js_code=" . $code . "&grant_type=authorization_code";
        //{"session_key":"DicATNOsJ+2jSzrAXvdSfA==","openid":"o0iwU0VcajjPGAvspRKv0ZvfBJas"}
        $arData = json_decode(file_get_contents($url), true);
        return $arData['openid'];
    }

}
