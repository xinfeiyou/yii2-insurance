<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use app\modules\base\models\WorkConfig;

/**
 * Default controller for the `api` module
 */
class BaseController extends Controller {

    public $enableCsrfValidation = false;

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
        //$json = '{"session_key":"DicATNOsJ+2jSzrAXvdSfA==","openid":"o0iwU0VcajjPGAvspRKv0ZvfBJas"}';
        $json = file_get_contents($url);
        $arData = json_decode($json, true);
        return $arData['openid'];
    }

    /**
     * 更新token值
     * @return type
     */
    public function getToken() {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . \Yii::$app->params['appId'] . "&secret=" . \Yii::$app->params['appSecret'];
        //$json = '{"access_token":"6_BcxREiAaFsFf8A6MJmW1YfeRUK13ku_E0d9RltpuNhZsG0pCzqtH1SFe1iOYHowpKCwgTUZ4v_u4PJmgc9WjBNdJeFmXW1ouRSv9-NYPhJYOMbf1yp5Dh1Sr1KLOBpUWX0F83MzqWAyPOBd5THThAGAHVH","expires_in":7200}';
        $json = file_get_contents($url);
        $arData = json_decode($json, true);
        return (new WorkConfig())->editKeyToValue('strToken', $arData['access_token']);
    }

}
