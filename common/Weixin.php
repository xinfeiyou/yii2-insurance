<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

use app\common\Snoopy;

/**
 * Description of Weixin
 *
 * @author Administrator
 */
class Weixin {

    public $appUser;
    public $appPass;
    public $appCookie;
    public $appCookieFileName = 'cookie.log';
    public $strUrl = 'https://mp.weixin.qq.com';

    /**
     * 公众号账号和密码
     * @param string $appUser   登录账号
     * @param string $appPass   登录密码
     */
    public function __construct($appUser, $appPass) {
        $this->appUser = $appUser;
        $this->appPass = $appPass;
        $this->appCookie = $this->getCookieFile();
    }

    /**
     * 读取用户信息
     * @param string $fakeId    用户fakeId
     * @return type             [description]
     */
    public function getUserInfo($fakeId) {
        $send_snoopy = new Snoopy();
        $send_snoopy->rawheaders['Cookie'] = $this->appCookie;
        $submit = "http://mp.weixin.qq.com/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&fakeid=" . $fakeId;
        $send_snoopy->submit($submit, array());
        $result = json_decode($send_snoopy->results, 1);
        if (!$result) {
            $this->login();
        }
        return $result;
    }

    /**
     * 主动发消息
     * @param  string appCookie用户的fakeid//o4-aI0VAqHij2ClnZ-S2b0by4OMw
     * @param  string $content 发送的内容
     * @return [type]          [description]
     */
    public function sendUserMsg($fakeId, $content) {
        
//        $send_snoopy = new Snoopy();
//        $post = array();
//        $post['tofakeid'] = $fakeId;
//        $post['type'] = 1;
//        $post['content'] = $content;
//        $post['ajax'] = 1;
//        $send_snoopy->referer = "http://mp.weixin.qq.com/cgi-bin/singlemsgpage?fromfakeid={$fakeId}&msgid=&source=&count=20&t=wxm-singlechat&lang=zh_CN";
//        $send_snoopy->rawheaders['Cookie'] = $this->appCookie;
//        $submit = "http://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response";
//        $send_snoopy->submit($submit, $post);
//        return $send_snoopy->results;
    }

    /**
     * 验证cookie的有效性
     * @return [type] [description]
     */
    public function checkCookieValid() {
        $send_snoopy = new Snoopy();
        $post = array();
        $submit = "http://mp.weixin.qq.com/cgi-bin/getregions?id=1017&t=ajax-getregions&lang=zh_CN";
        $send_snoopy->rawheaders['Cookie'] = $this->appCookie;
        $send_snoopy->submit($submit, $post);
        $result = $send_snoopy->results;
        if (json_decode($result, 1)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取Cookie文件内容
     */
    public function getCookieFile() {
        $strFileName = $this->setCookieFile();
        if (file_exists($strFileName)) {
            $data = Files::readFile($strFileName);
            if (empty($data)) {
                return $this->login();
            } else {
                $result = $this->CurlUrlData([], "http://mp.weixin.qq.com/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&fakeid=", $data);
                if (!$result) {
                    return $this->login();
                } else {
                    return $data;
                }
            }
        } else {
            return $this->login();
        }
    }

    /**
     * 模拟登录获取Cookie
     * @return string
     */
    public function login() {
        $post["username"] = $this->appUser;
        $post["pwd"] = md5($this->appPass);
        $post["f"] = "json";
        $post['userlang'] = "zh_CN";
        $post['lang'] = "zh_CN";
        $post['ajax'] = "1";
        $arData = $this->CurlUrlData($post, 'https://mp.weixin.qq.com/cgi-bin/bizlogin?action=startlogin');
        $this->writeFile($arData['cookie']);
        return $arData['cookie'];
    }

    /**
     * 设置cookie文件地址
     * @return string
     */
    public function setCookieFile() {
        $strFileName = \Yii::$app->basePath . '/runtime/logs/' . $this->appCookieFileName;
        return $strFileName;
    }

    /**
     * 存Cookie到本地
     * @param string $fContent  存放内容
     * @param string $fTag      标签
     * @return boolean
     */
    public Function writeFile($fContent, $fTag = 'w+') {
        $fFileName = $this->setCookieFile();
        ignore_user_abort(TRUE);
        $fp = fopen($fFileName, $fTag);
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $fContent);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
        ignore_user_abort(FALSE);
        return true;
    }

    /**
     * 模拟提交数据
     * @param type $json_string
     * @param type $url
     * @param type $cookie
     * @param type $method
     * @return type
     */
    public Function CurlUrlData($json_string, $url, $cookie = "", $method = 'POST') {
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); //设置链接
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置是否返回信息
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //这个是重点
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Referer:' . $this->strUrl,
            'origin: ' . $this->strUrl
                )
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
        if (empty($cookie)) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($ch, CURLOPT_HEADER, 1); //设置返回头部信息
        $response = curl_exec($ch); //接收返回信息
        if (curl_errno($ch)) {//出错则显示错误信息
            print curl_error($ch);
        }
        curl_close($ch); //关闭curl链接
        $arData = $this->setReponseData($response);
        return $arData;
    }
    /**
     * 解析返回的数据
     * @param string $txt
     * @return array
     */
    public function setReponseData($txt) {
        $arData = explode("\n", $txt);
        $array['cookie'] = "";
        $array['response'] = "";
        foreach ($arData as $value) {
            $value = trim($value);
            if (strpos($value, 'Set-Cookie: ') || strpos($value, 'Set-Cookie: ') === 0) {
                $tmp = str_replace("Set-Cookie: ", "", $value);
                $tmp = str_replace("Path=/", "", $tmp);
                $array['cookie'] .= $tmp;
            }
        }
        $n = count($arData) - 1;
        for ($i = $n; $i >= 0; $i--) {
            if (strpos($arData[$i], 'Set-Cookie: ') || strpos($arData[$i], 'Set-Cookie: ') === 0) {
                break;
            } elseif (empty(trim($arData[$i]))) {
                break;
            } else {
                $array['response'] .= trim($arData[$i]);
            }
        }
        return $array;
    }

}
