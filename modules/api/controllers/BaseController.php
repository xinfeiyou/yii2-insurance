<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use app\modules\base\models\WorkConfig;
use app\common\NetWork;

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
     * 根据经纬度获取城市信息
     * @param string $latitude  经度
     * @param string $longitude 纬度
     * @return array
     */
    public function getCity($latitude, $longitude) {
        $url = 'http://apis.map.qq.com/ws/geocoder/v1/?location=' . $latitude . ',' . $longitude . '&key=' . \Yii::$app->params['openTencentKey'];
        $array = json_decode(file_get_contents($url));
        return $array;
    }

    /**
     * 数据加密
     * @param type $array
     * @return type
     */
    function encrypt($array) {
        ksort($array);
        $str = '';
        foreach ($array as $k => $v) {
            $str .= $v;
        }
        $str .= \Yii::$app->params['web_line']['api_key'];
        return md5($str);
    }

}
