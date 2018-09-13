<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\api\controllers;

use Yii;
use app\common\NetWork;
use app\common\baofu\Tools;
use app\common\baofu\BFRSA;
use app\common\baofu\BFAES;
use app\common\baofu\BFSHA;
use app\common\baofu\HttpClient;
use app\common\baofu\Log;
use app\modules\api\controllers\BaseController;

/**
 * Description of AgreePay
 * 协议支付
 * @author Administrator
 */
class AgreePayController extends BaseController {

    public $strAesKey = '4f66405c4f66405c'; //商户自定义（可随机生成  商户自定义(AES key长度为=16位)）

    /**
     * 预绑定
     */
    public function actionPreBind() {
        exit("OK");
        $strPhone = Yii::$app->request->post('phone'); //手机号
        $strName = Yii::$app->request->post('name'); //真实姓名
        $strBankCode = Yii::$app->request->post('bankCode'); //银行卡编码
        $strBankNum = Yii::$app->request->post('bankNum'); //银行卡号
        $strCardNum = Yii::$app->request->post('cardnum'); //身份证号
        $strValidTime = Yii::$app->request->post('strValidTime'); //银行卡有效期;
        if (!empty($strPhone) && !empty($strName) && !empty($strBankNum) && !empty($strCardNum)) {
            $arPost = $this->setPreBindData($strName, $strCardNum, $strBankCode, $strBankNum, $strPhone, $strValidTime);
            $arData = HttpClient::Post($arPost, \Yii::$app->params['agree_pay']['url']);
            $arReturn = NetWork::setMsg($this->strTitle, $arData['resp_msg'], $arData['resp_code'], []);
        } else {
            $arReturn = NetWork::setMsg($this->strTitle, '参数不能为空', '4001', []);
        }
        Str::echoJson($arReturn);
    }

    public function actionConfirmBind() {
        //绑定确认
    }

    public function actionSearchBind() {
        //查询绑卡
    }

    public function actionRemoveBind() {
        //解除绑定
    }

    public function actionPrePay() {
        //预支付
    }

    public function acitonConfirmPay() {
        //确认支付
    }

    public function actionDirectPay() {
        //直接支付
    }

    public function actionSearchOdd() {
        //查询订单
    }

    /**
     * 构造代扣数据
     * @param type $strName     真实姓名
     * @param type $strCardNum  身份证号码
     * @param type $strBankCode 银行CODE
     * @param type $strBankNum  银行卡号
     * @param type $strPhone    绑定手机
     * @param real $strValidTime 有效期
     * @return type
     */
    private function setPreBindData($strName, $strCardNum, $strBankCode, $strBankNum, $strPhone, $strValidTime) {
        $dgtl_envlp = '01|' . $this->strAesKey;
        $BFRsa = new BFRSA(\Yii::$app->params['agree_pay']["pfx_file_name"], \Yii::$app->params['agree_pay']["cer_file_name"], \Yii::$app->params['agree_pay']["private_key_password"]);
        $dgtl_envlp = $BFRsa->encryptByPublicKey($dgtl_envlp);
        Log::LogWirte("RSA数字信封：" . $dgtl_envlp);
        //$Cardinfo = "6222020111122220000|张宝|320301198502169142|15823781632||"; 
        $Cardinfo = $strBankNum . '|' . $strName . '|' . $strCardNum . '|' . $strPhone . '|' . $strBankCode . '|' . $strValidTime; //账户信息[银行卡号|持卡人姓名|证件号|手机号|银行卡安全码|银行卡有效期]
        $CardinfoAES = BFAES::AesEncrypt(base64_encode($Cardinfo), $this->strAesKey);
        Log::EchoFormat("AES加密结果:" . $Cardinfo);
        $data_content_parms = [
            'send_time' => Tools::getTime(), //订单日期
            'msg_id' => $this->setTransId(), //商户流水号
            'version' => \Yii::$app->params['agree_pay']['version'],
            'terminal_id' => \Yii::$app->params['agree_pay']['terminal_id'],
            'txn_type' => '01', //交易类型
            'member_id' => \Yii::$app->params['agree_pay']['member_id'],
            'dgtl_envlp' => $dgtl_envlp, //实例化加密类。
            'user_id' => $userId, //用户在商户平台唯一ID
            'card_type' => '101', //卡类型  101	借记卡，102 信用卡
            'id_card_type' => '01', //证件类型
            'acc_info' => $CardinfoAES,
        ];
        $SignVStr = Tools::SortAndOutString($data_content_parms);
        $SHA1Sign = BFSHA::Sha1AndHex(urldecode($SignVStr)); //签名(注意此处urldecode方法主要是去除send_time中间的空格和符号的自动自urlencode)
        $Sign = $BFRsa->Sign($SHA1Sign);
        $data_content_parms["signature"] = $Sign; //签名域
        $Encrypted_string = str_replace("\\/", "/", json_encode($data_content_parms)); //转JSON
        Log::LogWirte("序列化结果：" . $Encrypted_string);
        return $data_content_parms;
    }

    /**
     * 生成商户订单号
     * @param string $trans_id  流水号
     * @return type
     */
    private function setTransId($trans_id = "") {
        return empty($trans_id) ? "TISN" . Tools::getTransid() . Tools::getRand4() : trim($trans_id); //商户订单号
    }

}
