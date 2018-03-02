<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\common\Files;
use app\common\NetWork;
use app\common\Str;

/**
 * Default controller for the `api` module
 */
class FootPackController extends BaseController {

    public $strTitle = '红包';
    public $streEleUrl = "https://h5.ele.me";

    public function actionEleRedPack() {

        $cookie = 'ubt_ssid=egw2ruzkki8qiut6ypy93r9difyzjcir_2018-02-04; _utrace=69edb1440f770834a2265890f94a38c6_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%E8%B5%A3%E5%B7%9E%22%2C%22eleme_key%22%3A%229a2e74c50f96438cb8c123a0ecb39fa8%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22%E3%80%80%22%2C%22openid%22%3A%223DD28AD69CEF89D0B60F013CBB652031%22%2C%22province%22%3A%22%E6%B1%9F%E8%A5%BF%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%221993%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22%E3%80%80%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F40%22%7D';
        $tmp = explode('{"', urldecode($cookie));
        if (!empty($tmp[1])) {
            $objData = json_decode('{"' . $tmp[1]);
            $openId = $objData->openid;
        } else {
            exit('数据为空');
        }
        $arData['sign'] = $objData->eleme_key;
        $arData['phone'] = "13245546608";
        $strData = Str::cnJsonEncode($arData);
        $header = [
            'Referer:' . $this->streEleUrl,
            'user-agent:Mozilla/5.0 (Linux; Android 6.0; PRO 6 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.49 Mobile MQQBrowser/6.2 TBS/043221 Safari/537.36 V1_AND_SQ_7.0.0_676_YYB_D QQ/7.0.0.3135 NetType/WIFI WebP/0.3.0 Pixel/1080',
            'X-Shard:eosid=29e8ecf17139ac1e',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($strData)
        ];
        print_r($header);
        echo $this->streEleUrl . '/restapi/v1/weixin/' . $openId . '/phone';
        exit($strData);
        $ar = $this->PostUrl($this->streEleUrl . '/restapi/v1/weixin/' . $openId . '/phone', $strData, $header, $cookie);
        print_r($ar);
        Files::writeFileLog('redpack.txt', Str::cnJsonEncode($ar));
        //$strMsg = $this->postData($txn_sub_type, $Encrypted_string);
        //return $strMsg;
    }

    public function PostUrl($strUrl, $data_string, $arHeader = [], $cookie = "") {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $strUrl);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //这个是重点。
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($arHeader)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $arHeader);
        }
        if (!empty($cookie)) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl); //捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $response; // 返回数据
    }

}
