<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\common\Files;
use app\common\NetWork;

/**
 * Default controller for the `api` module
 */
class FootPackController extends BaseController {

    public $strTitle = '红包';
    public $streEleUrl = "https://h5.ele.me";

    public function getEleRedPack() {
        
        Files::writeFileLog('redpack.txt', $fContent);
        $header = [
            'referer'=>''
        ];
        $UserAgent = 'Mozilla/5.0 (Linux; Android 6.0; PRO 6 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.49 Mobile MQQBrowser/6.2 TBS/043221 Safari/537.36 V1_AND_SQ_7.0.0_676_YYB_D QQ/7.0.0.3135 NetType/WIFI WebP/0.3.0 Pixel/1080';
        curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
        NetWork::CurlPost($this->streEleUrl, $arData, $header, $cmd);
        //$strMsg = $this->postData($txn_sub_type, $Encrypted_string);
        //return $strMsg;
    }

}
