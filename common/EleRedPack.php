<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;
use app\common\Files;
use app\common\Str;
/**
 * Description of EleRedPack
 *
 * @author Administrator
 */
class EleRedPack {

    public $strTitle = '红包';
    public $streEleUrl = "https://h5.ele.me";

    public function GetEleMaxRedPack($phone, $packUrl) {
//        $phone = \Yii::$app->request->post('phone'); //领取红包手机号
//        $packUrl = \Yii::$app->request->post('packUrl'); //领取红包地址
        Files::writeFileLog('weixin_log', $packUrl);
        if (empty($phone) || empty($packUrl)) {
            $msg = "参数缺失";
        } else {
            $msg = $this->getElemPackRun($phone, $packUrl);
        }
        Files::writeFileLog('weixin_log', $msg);
        return $msg;
    }

    public Function CurlUrlData($json_string, $url, $sn, $cookie, $method = 'POST') {
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); //设置链接
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置是否返回信息
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //这个是重点
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Referer:' . $this->streEleUrl . '/hongbao/',
            'origin: ' . $this->streEleUrl,
            'X-Shard:eosid=' . $sn,
            //'user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_2 like Mac OS X) AppleWebKit/603.2.4 (KHTML, like Gecko) Mobile/14F89 MicroMessenger/6.6.1 NetType/WIFI Language/zh_CN',
            'user-agent: Mozilla/5.0 (Linux; Android 6.0; PRO 6 Build/MRA58K; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.49 Mobile MQQBrowser/6.2 TBS/043221 Safari/537.36 V1_AND_SQ_7.0.0_676_YYB_D QQ/7.0.0.3135 NetType/WIFI WebP/0.3.0 Pixel/1080',
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($json_string))
        );
        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string); //设置请求体，提交数据包
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string); //设置请求体，提交数据包
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $response = curl_exec($ch); //接收返回信息
        if (curl_errno($ch)) {//出错则显示错误信息
            print curl_error($ch);
        }
        curl_close($ch); //关闭curl链接
        return $response;
    }
    /**
     * 获取红包
     * @param type $strPhone
     * @param type $packUrl
     * @return string
     */
    public function getElemPackRun($strPhone, $packUrl) {
        $arUrl = Str::parseUrlParam($packUrl, '#');
        $arCookieList = $this->getCookiesData();
        $phone = $this->randomPhone($strPhone);
        for ($i = 0; $i <= 0; $i++) {
            $arCookie = $this->getCookies($arCookieList[$i]);
            $this->bindPhone($phone, $arCookie, $arUrl['sn'], $arCookieList[$i]); //绑定手机号
            $arPost = $this->getEleRedPack($arCookie, $arUrl, $phone, $arCookieList[$i]); //领取红包
            $n = count($arPost);
            $intSurplusNum = $arUrl['lucky_number'] - $n;
            if ($intSurplusNum > 0) {
                if ($intSurplusNum == 1) {
                    $phone = $strPhone;
                } else {
                    $phone = $this->randomPhone($strPhone);
                }
                $msg = '还要领 ' . $intSurplusNum . ' 个红包才是手气最佳';
            } elseif ($intSurplusNum == 0) {
                if ($strPhone == $phone) {
                    $num = $n - 1;
                    $msg = "红包领取完毕\n\n手气最佳：" . $phone . ",\n红包金额：" . $arPost[$num]['amount'] . " 元";
                    break;
                } else {
                    $msg = "红包被人抢完";
                    break;
                }
            } else {
                $msg = "红包被人抢完";
                break;
            }
            sleep(2);
        }
        return $msg;
    }

    /**
     * 绑定手机号
     * @param type $phone
     * @param type $arCookie
     */
    public function bindPhone($phone, $arCookie, $sn, $strCookie) {
        $url = $this->streEleUrl . '/restapi/v1/weixin/' . $arCookie['openId'] . '/phone';
        $strJson = Str::cnJsonEncode(['sign' => $arCookie['sign'], 'phone' => $phone]);
        $string = $this->CurlUrlData($strJson, $url, $sn, $strCookie, 'PUT');
        Files::writeFileLog('redpack.txt', date("Y-m-d H:i:s") . '@' . '绑定手机号' . $phone . 'log:' . $string);
        return true;
    }

    /**
     * 领取红包
     * @param array $arCookie   cookie数组
     * @param array $arUrl      红包地址参数数据
     * @param string $phone     领红包的手机号码
     * @return int $n           已经领到第几个红包
     */
    public function getEleRedPack($arCookie, $arUrl, $phone, $strCookie) {
        $url = $this->streEleUrl . '/restapi/marketing/promotion/weixin/' . $arCookie['openId'];
        $arPost['device_id'] = '';
        $arPost['group_sn'] = $arUrl['sn'];
        $arPost['hardware_id'] = '';
        $arPost['method'] = 'phone';
        $arPost['phone'] = $phone;
        $arPost['platform'] = $arUrl['platform'];
        $arPost['sign'] = $arCookie['sign'];
        $arPost['track_id'] = '';
        $arPost['unionid'] = 'fuck';
        $arPost['weixin_avatar'] = '';
        $arPost['weixin_username'] = '';
        $strJson = Str::cnJsonEncode($arPost);
        Files::writeFileLog('redpack.txt', date("Y-m-d H:i:s") . '@' . '提交的log:' . $strJson);
        $string = $this->CurlUrlData($strJson, $url, $arUrl['sn'], $strCookie);
        $arResut = json_decode($string, true);
        $n = count($arResut['promotion_records']);
        $number = $arUrl['lucky_number'] + 1 - $n;
        Files::writeFileLog('redpack.txt', date("Y-m-d H:i:s") . '@' . '还要领' . $number . '个红包才是手气最佳' . 'log:' . $string);
        return $arResut['promotion_records'];
    }

    /**
     * 构造数据
     * @param type $phone
     */
    public function setData($phone) {
        $arData['amount'] = rand(1, 6);
        $arData['created_at'] = time();
        $arData['is_lucky'] = false;
        $arData['sns_avatar'] = "";
        $arData['sns_username'] = $phone;
        array_push($this->arTxt, $arData);
    }

    /**
     * 获取Cookie中的数据
     * @return array
     */
    public function getCookies($strCookie) {
        $tmp = explode('{"', urldecode($strCookie));
        if (!empty($tmp[1])) {
            $objData = json_decode('{"' . $tmp[1]);
            $arData['openId'] = $objData->openid;
            $arData['sign'] = $objData->eleme_key;
        } else {
            $arData = [];
        }
        return $arData;
    }

    /**
     * 随机生成phone号
     * @param type $phone
     * @return type
     */
    public function randomPhone($phone) {
        $arPhoneHeadar = [130, 131, 132, 145, 155, 156, 166, 175, 176, 185, 186, 134, 135, 136, 137, 138, 139, 147, 150, 151, 152, 157, 158, 159, 178, 182, 183, 184, 187, 188, 198];
        $n = count($arPhoneHeadar);
        $num = rand(0, $n);
        $newPhone = $arPhoneHeadar[$num] . rand(10000000, 99999999);
        if ($newPhone != $phone) {
            return $newPhone;
        } else {
            return $arPhoneHeadar[$num] . rand(10000000, 99999999);
        }
    }

    /**
     * 获取可用cookie数据
     * @return type
     */
    public function getCookiesData() {
        return [
            'ubt_ssid=wil6z103gedhsuhimk6cp3515m9hf8hu_2018-03-05; _utrace=d735952f34d37d9190c420b28a373347_2018-03-05; snsInfo[101204453]=%7B%22city%22%3A%22%E7%A6%8F%E5%B7%9E%22%2C%22eleme_key%22%3A%221c559eac9bdee2e92edb3a292112058e%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F2BFEB90C5C4384928FE9E8E1F7C269CC%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F2BFEB90C5C4384928FE9E8E1F7C269CC%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F2BFEB90C5C4384928FE9E8E1F7C269CC%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fthirdqq.qlogo.cn%2Fqqapp%2F101204453%2F2BFEB90C5C4384928FE9E8E1F7C269CC%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fthirdqq.qlogo.cn%2Fqqapp%2F101204453%2F2BFEB90C5C4384928FE9E8E1F7C269CC%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22%E5%96%B5%E5%85%AB%E5%93%A5-%E7%A7%91%E6%8A%80%E6%94%B9%E5%8F%98%E4%BA%BA%E7%94%9F%22%2C%22openid%22%3A%222BFEB90C5C4384928FE9E8E1F7C269CC%22%2C%22province%22%3A%22%E7%A6%8F%E5%BB%BA%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%221990%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22%E5%96%B5%E5%85%AB%E5%93%A5-%E7%A7%91%E6%8A%80%E6%94%B9%E5%8F%98%E4%BA%BA%E7%94%9F%22%2C%22avatar%22%3A%22http%3A%2F%2Fthirdqq.qlogo.cn%2Fqqapp%2F101204453%2F2BFEB90C5C4384928FE9E8E1F7C269CC%2F40%22%7D',
            'ubt_ssid=egw2ruzkki8qiut6ypy93r9difyzjcir_2018-02-04; _utrace=69edb1440f770834a2265890f94a38c6_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%E8%B5%A3%E5%B7%9E%22%2C%22eleme_key%22%3A%229a2e74c50f96438cb8c123a0ecb39fa8%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22%E3%80%80%22%2C%22openid%22%3A%223DD28AD69CEF89D0B60F013CBB652031%22%2C%22province%22%3A%22%E6%B1%9F%E8%A5%BF%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%221993%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22%E3%80%80%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3DD28AD69CEF89D0B60F013CBB652031%2F40%22%7D',
            'ubt_ssid=m5p86qjtb95kll3pil21jhtmh58kdy5e_2018-02-04; _utrace=bc416af5861c5ba07f6c9d42ecf57375_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%22%2C%22eleme_key%22%3A%22b3bd1d2845bca419cda6a5261004cbf9%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F5FAA737C565A8D7FBB25643EE2719E14%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F5FAA737C565A8D7FBB25643EE2719E14%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F5FAA737C565A8D7FBB25643EE2719E14%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F5FAA737C565A8D7FBB25643EE2719E14%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F5FAA737C565A8D7FBB25643EE2719E14%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22q0%22%2C%22openid%22%3A%225FAA737C565A8D7FBB25643EE2719E14%22%2C%22province%22%3A%22%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%220%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22q0%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F5FAA737C565A8D7FBB25643EE2719E14%2F40%22%7D',
            'ubt_ssid=0f2pyn9g7vm3wvbv3cclxawm72jp5e0n_2018-02-04; _utrace=5d15ba588f846b9eb3fb7ae8c784d441_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%E6%B7%B1%E5%9C%B3%22%2C%22eleme_key%22%3A%22453f4592ac4f530ae7cece0809a3e028%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22qzuser%22%2C%22openid%22%3A%22184AAE14458AD189528D3668A1C6F296%22%2C%22province%22%3A%22%E5%B9%BF%E4%B8%9C%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%221990%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22qzuser%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%7D',
            'ubt_ssid=w7l33l0lf60k48kac3fwk7nrgpbxalz8_2018-02-04; _utrace=a406144164e430f199f20c4be85bda0b_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%22%2C%22eleme_key%22%3A%22f863270206f63d6e73971b71018e0459%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3722C12B44DEB8D0CE788AC294BA16A3%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3722C12B44DEB8D0CE788AC294BA16A3%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F3722C12B44DEB8D0CE788AC294BA16A3%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3722C12B44DEB8D0CE788AC294BA16A3%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3722C12B44DEB8D0CE788AC294BA16A3%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22q2%22%2C%22openid%22%3A%223722C12B44DEB8D0CE788AC294BA16A3%22%2C%22province%22%3A%22%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%220%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22q2%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F3722C12B44DEB8D0CE788AC294BA16A3%2F40%22%7D',
            'ubt_ssid=z3ndbh0669b1ams0dmp1lnuxt3m21wwz_2018-02-04; _utrace=9449a95ee053439333e1715393182c76_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%E6%B7%B1%E5%9C%B3%22%2C%22eleme_key%22%3A%22b3f3d92e59fb65a08c907e79cf9c1d29%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22qzuser%22%2C%22openid%22%3A%22A5AF968E88ACE852BE1BC7D86F775112%22%2C%22province%22%3A%22%E5%B9%BF%E4%B8%9C%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%221990%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22qzuser%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%7D',
            'ubt_ssid=ehgosb9alx3k5kqa0rzs3r4d0gvcbwof_2018-02-04; _utrace=6250e98971a6f88526bd9fb4ca0093ba_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%22%2C%22eleme_key%22%3A%22f01f8b87d323822768f4623abc7ef914%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2FC7AB6BF8DA5C64E20C26AB93DAF1EEC8%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2FC7AB6BF8DA5C64E20C26AB93DAF1EEC8%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2FC7AB6BF8DA5C64E20C26AB93DAF1EEC8%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2FC7AB6BF8DA5C64E20C26AB93DAF1EEC8%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2FC7AB6BF8DA5C64E20C26AB93DAF1EEC8%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22q4%22%2C%22openid%22%3A%22C7AB6BF8DA5C64E20C26AB93DAF1EEC8%22%2C%22province%22%3A%22%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%220%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22q4%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2FC7AB6BF8DA5C64E20C26AB93DAF1EEC8%2F40%22%7D',
            'ubt_ssid=v6tia4871j20blgm58ey7i6cp8x6od17_2018-02-04; _utrace=3ed0ebc900e0f90351b12ac8edf1b747_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%E6%B7%B1%E5%9C%B3%22%2C%22eleme_key%22%3A%2285e582983992b2ffc63cac1cc3345e73%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22qzuser%22%2C%22openid%22%3A%22C1EC255A92EBB13CB489933256B8F125%22%2C%22province%22%3A%22%E5%B9%BF%E4%B8%9C%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%221990%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22qzuser%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%7D',
            'ubt_ssid=qyhf4a10bvfamnwmyxa4qa3av74ucwa0_2018-02-04; _utrace=8291060d9c8335bf52762d4177df9bd0_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%22%2C%22eleme_key%22%3A%220cd8c32ad6b93963bb9e5dcc3bfa48fb%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2FD3728F828CAD7FB726386915E78CDD9C%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2FD3728F828CAD7FB726386915E78CDD9C%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2FD3728F828CAD7FB726386915E78CDD9C%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2FD3728F828CAD7FB726386915E78CDD9C%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2FD3728F828CAD7FB726386915E78CDD9C%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22q6%22%2C%22openid%22%3A%22D3728F828CAD7FB726386915E78CDD9C%22%2C%22province%22%3A%22%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%220%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22q6%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2FD3728F828CAD7FB726386915E78CDD9C%2F40%22%7D',
            'ubt_ssid=t4kgl4ywhgepybxaz8zw2nblt3vk1rn1_2018-02-04; _utrace=6dd4a0a476869b5280e18afa689dfd69_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%E6%B7%B1%E5%9C%B3%22%2C%22eleme_key%22%3A%226a1c7c8a16e114e54d648ba39dda4be2%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22qzuser%22%2C%22openid%22%3A%22FAE707F7F4575C0401BFB7C3D4550A63%22%2C%22province%22%3A%22%E5%B9%BF%E4%B8%9C%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%221990%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22qzuser%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F111111%2F942FEA70050EEAFBD4DCE2C1FC775E56%2F40%22%7D',
            'ubt_ssid=fwonx2m8q2tbm9vwxhyh9eyxt7gfmj6b_2018-02-04; _utrace=0d953ef0cf7674dea0d92c47256387c3_2018-02-04; snsInfo[101204453]=%7B%22city%22%3A%22%22%2C%22eleme_key%22%3A%22056e3656f3eb631225fadcfb8771efa8%22%2C%22figureurl%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F26689B4FA073BF48F0FE585296303EFA%2F30%22%2C%22figureurl_1%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F26689B4FA073BF48F0FE585296303EFA%2F50%22%2C%22figureurl_2%22%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101204453%2F26689B4FA073BF48F0FE585296303EFA%2F100%22%2C%22figureurl_qq_1%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F26689B4FA073BF48F0FE585296303EFA%2F40%22%2C%22figureurl_qq_2%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F26689B4FA073BF48F0FE585296303EFA%2F100%22%2C%22gender%22%3A%22%E7%94%B7%22%2C%22is_lost%22%3A0%2C%22is_yellow_vip%22%3A%220%22%2C%22is_yellow_year_vip%22%3A%220%22%2C%22level%22%3A%220%22%2C%22msg%22%3A%22%22%2C%22nickname%22%3A%22q8%22%2C%22openid%22%3A%2226689B4FA073BF48F0FE585296303EFA%22%2C%22province%22%3A%22%22%2C%22ret%22%3A0%2C%22vip%22%3A%220%22%2C%22year%22%3A%220%22%2C%22yellow_vip_level%22%3A%220%22%2C%22name%22%3A%22q8%22%2C%22avatar%22%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F101204453%2F26689B4FA073BF48F0FE585296303EFA%2F40%22%7D'
        ];
    }

    public function getServerUrl() {
        return [
            'http://101.226.171.170:3007/hongbao',
            'https://hongbao.xxooweb.com/hongbao',
            'http://hongbao.dingjian.name/hongbao',
            'http://hongbao.lte.pw:3007/hongbao',
            'http://118.126.88.246:3007/hongbao',
            'https://hbapi.moexian.com/hongbao',
            'http://45.77.165.37:3007/hongbao',
        ];
        //{"mobile":"13245546608","url":"https://h5.ele.me/hongbao/#hardware_id=&is_lucky_group=True&lucky_number=6&track_id=&platform=0&sn=29e9316c19b9a0c3&theme_id=2225&device_id="}
        //{"message":"红包领取完毕\n\n手气最佳：187****0815\n红包金额：5.6 元"}
    }

}
