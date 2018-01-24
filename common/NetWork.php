<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of NetWork
 *
 * @author Administrator
 */
class NetWork {

    /**
     * 微信POST数据
     * @param type $json_string
     * @param type $token
     * @param string $url
     * @return type
     */
    public static Function CurlUrlData($json_string, $token, $url) {
        $url = $url . $token;
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); //设置链接
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置是否返回信息
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($json_string))
        );
        curl_setopt($ch, CURLOPT_POST, 1); //设置为POST方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string); //POST数据
        $response = curl_exec($ch); //接收返回信息
        if (curl_errno($ch)) {//出错则显示错误信息
            print curl_error($ch);
        }
        curl_close($ch); //关闭curl链接
        return $response;
    }

    /**
     * stock提交数据
     * @param type $ip
     * @param type $port
     * @param type $data
     * @return type
     */
    public static Function socketPost($ip, $port, $data) {
        error_reporting(E_ALL);
        set_time_limit(0);
//echo "<h2>TCP/IP Connection</h2>\n";
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket < 0) {
            echo "socket_create() failed: reason: " . socket_strerror($socket) . "\n";
        } else {
            //echo "OK.\n";
        }
//echo "试图连接 '$ip' 端口 '$port'...\n";
        $result = socket_connect($socket, $ip, $port);
        if ($result < 0) {
            echo "socket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "\n";
        } else {
            //echo "连接OK\n";
        }
        $in = $data . "\r\n";
        $out = '';
        if (!socket_write($socket, $in, strlen($in))) {
            //echo "socket_write() failed: reason: " . socket_strerror($socket) . "\n";
        } else {
            //echo "发送到服务器信息成功！\n";
            //echo "发送的内容为:<font color='red'>$in</font> <br>";
        }
        $data = '';
        while ($out = socket_read($socket, 8192)) {
            //echo "接收服务器回传信息成功！\n";
            //echo "接受的内容为:",$out;
            $data .= $out;
        }
//echo "关闭SOCKET...\n";
        socket_close($socket);
        return $data;
//echo "关闭OK\n";
    }

    /**
     * 模拟提交https 数据
     * @param type $url
     * @param type $data
     * @return type
     */
    public static Function CurlPost($url, $data, $header = array(), $cmd = '1') { // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header); //设置header
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        if ($cmd) {
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        }
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $response = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl); //捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $response; // 返回数据
    }

    /**
     * 带公秘钥提交数据
     * @param type $url
     * @param type $vars
     * @param type $second
     * @param type $aHeader
     * @return boolean
     * @remark 由于php的curl只支持pem格式、der、eng格式，而之前生成的是p12的格式，所以需要转换一下
      PKCS#12 到 PEM 的转换
      openssl pkcs12 -nocerts -nodes -in cert.p12 -out private.pem
      验证
      openssl pkcs12 -clcerts -nokeys -in cert.p12 -out cert.pem
     */
    public static Function CurlPostSsl($url, $data, $second = 30, $aHeader = array()) {
        $ch = curl_init();
        //curl_setopt($ch,CURLOPT_VERBOSE,'1');
        curl_setopt($ch, CURLOPT_TIMEOUT, $second); //超时时间
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //是否要求返回数据
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //是否检测服务器的证书是否由正规浏览器认证过的授权CA颁发的
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //是否检测服务器的域名与证书上的是否一致
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM'); //证书类型，"PEM" (default), "DER", and"ENG"
        curl_setopt($ch, CURLOPT_SSLCERT, '/data/cert/php.pem'); //证书存放路径
        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, '1234'); //证书密码
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM'); //私钥类型，"PEM" (default), "DER", and"ENG".
        curl_setopt($ch, CURLOPT_SSLKEY, '/data/cert/php_private.pem'); //私钥存放路径
        if (count($aHeader) >= 1) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        curl_close($ch);
        if ($data)
            return $data;
        else
            return false;
    }

    /**
     * 通过GET形式获取数据
     * @param type $url
     * @return boolean
     */
    public static Function GetUrl($url) {
        if (empty($url)) {
            $response = file_get_contents($url);
            return $response;
        } else {
            return FALSE;
        }
    }

    /**
     * 上传文件 $file = $_FILES['file']  $file_path = "./images/upload/"
     * @param type $file
     * @param type $file_path
     * @return string
     */
    public static Function updateImg($file, $file_path) {
        $destination = "";
        if ($file['size'] > 1024 * 1024) {
            echo '上传文件太大';
            return "";
        }
        $array = array(
            'image/jpg',
            'image/png',
            'image/jpeg',
            'image/pjpeg',
            'image/gif',
            'image/bmp',
            'image/x-png');
        if (!in_array($file['type'], $array)) {//判断文件的类型
            echo '上传文件类型不符';
            return "";
        }
        $file_string = $file_path . date("Ym");
        if (!file_exists($file_string)) {
            mkdir($file_string);
        }
        $finfo = pathinfo($file['name']);
        $filename = time() . "." . $finfo['extension'];
        $destination = $file_string . "/" . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            echo "移动文件出错";
            return "";
        }
        return date("Ym") . "/" . $filename;
    }

    /**
     * 判断当前浏览器是否是手机浏览器
     * @return boolean
     */
    public static Function isMobile() {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $clientkeywords = array(
                'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh',
                'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel',
                'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android',
                'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini',
                'operamobi', 'opera mobi', 'openwave', 'nexusone', 'cldc',
                'midp', 'wap', 'mobile');
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", $userAgent) && strpos($userAgent, 'ipad') === false) {
                return true;
            }
        }
        return false;
    }

    /**
     * 生成验证码图片
     * @param type $num
     * @param type $size
     * @param type $width
     * @param type $height
     * @param type $code   验证码内容
     */
    public static function vCode($num = 4, $size = 20, $width = 0, $height = 0, $code = "1232") {
        !$width && $width = $num * $size * 4 / 5 + 5;
        !$height && $height = $size + 10;
        // 去掉了 0 1 O l 等
        // 画图像
        $im = imagecreatetruecolor($width, $height);
        // 定义要用到的颜色
        $back_color = imagecolorallocate($im, 235, 236, 237);
        $boer_color = imagecolorallocate($im, 118, 151, 199);
        $text_color = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
        // 画背景
        imagefilledrectangle($im, 0, 0, $width, $height, $back_color);
        // 画边框
        imagerectangle($im, 0, 0, $width - 1, $height - 1, $boer_color);
        // 画干扰线
        for ($i = 0; $i < 5; $i++) {
            $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagearc($im, mt_rand(- $width, $width), mt_rand(- $height, $height), mt_rand(30, $width * 2), mt_rand(20, $height * 2), mt_rand(0, 360), mt_rand(0, 360), $font_color);
        }
        // 画干扰点
        for ($i = 0; $i < 50; $i++) {
            $font_color = imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $font_color);
        }
        // 画验证码 
        @imagefttext($im, $size, 0, 5, $size + 3, $text_color, dirname(__FILE__) . '/t1.ttf', $code);
        //@imagefttext($im, $size, 0, 5, $size + 3, $text_color, 'c:\\WINDOWS\\Fonts\\simsun.ttc', $code);
        //setcookie("code", strtolower($code));
        header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
        header("Content-type: image/png;charset=utf-8");
        imagepng($im);
        imagedestroy($im);
    }

    /**
     * 生成随机数
     * @param type $num
     */
    public static function randNum($num = 4) {
        $str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVW";
        $code = '';
        for ($i = 0; $i < $num; $i++) {
            $code .= $str[mt_rand(0, strlen($str) - 1)];
        }
        return $code;
    }

    /**
     * 获取客户端IP
     * @return string
     */
    public static function getIp() {
        $ip = "nil";
        $cIP = getenv($_SERVER['REMOTE_ADDR']);
        $cIP1 = isset($_SERVER['HTTP_X_FORWORD_FOR']) ? getenv($_SERVER['HTTP_X_FORWORD_FOR']) : "";
        $cIP2 = isset($_SERVER['HTTP_CLIENT_IP']) ? getenv($_SERVER['HTTP_CLIENT_IP']) : "";
        if (!empty($cIP)) {
            $ip = $cIP;
        } else if (!empty($cIP1)) {
            $ip = $cIP1;
        } elseif (!empty($cIP2)) {
            $ip = $cIP2;
        }
        return $ip;
    }

    /**
     * 跳转
     * @param type $msg
     * @param type $url
     */
    public static Function goBack($msg, $url = '') {
        if ($url == "exit") {
            echo "<script language=javascript>\n";
            echo "window.alert('$msg');";
            echo "</script>\n";
            echo $msg;
            exit;
        }
        echo "<script language=javascript>\n";
        if ($msg != '') {
            echo "window.alert('$msg');";
        }
        if ($url == "close") {
            echo "self.close();";
        } elseif ($url != '') {
            if (strstr($url, '|')) {
                $url_ary = explode('|', $url);
                echo $url_ary[0] . ".location.href='" . $url_ary[1] . "'\n";
            } else {
                echo "document.location.href='$url'\n";
            }
        } else {
            echo "window.history.go(-1);";
        }
        echo "</script>\n";
        exit();
    }

    /**
     * 参数接口返回值
     * @author Panda Liu <admin@xinfeiyou.com>
     * @param string $strTitle      标题
     * @param string $strMsg        反馈信息
     * @param string $enStatus      状态码
     * @param array $arContent      返回的值
     * @return array
     */
    public static function setMsg($strTitle, $strMsg, $enStatus, $arContent) {
        $msg['ret'] = $enStatus;
        $msg['data'] = ['title' => $strTitle, 'content' => $arContent, 'version' => '5.0.1', 'time' => time()];
        $msg['msg'] = $strMsg;
        return $msg;
    }
}
