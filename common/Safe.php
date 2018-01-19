<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of Safe
 * 数据安全
 * @author Administrator
 */
class Safe {
    /*     * RSA签名
     * $data签名数据(需要先排序，然后拼接)
     * 签名用商户私钥，必须是没有经过pkcs8转换的私钥
     * 最后的签名，需要用base64编码
     * return Sign签名
     */

    public static function rsaSign($data) {
        $priKey = file_get_contents(dirname(__FILE__) . '/rsa_private_key.pem'); //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_MD5); //调用openssl内置签名方法，生成签名$sign
        openssl_free_key($res); //释放资源
        $sign = base64_encode($sign); //base64编码
        return $sign;
    }

    /*     * RSA验签
     * $data待签名数据(需要先排序，然后拼接)
     * $sign需要验签的签名,需要base64_decode解码
     * 验签用连连支付公钥
     * return 验签是否通过 bool值
     */

    public static function rsaVerify($data, $sign) {
        $pubKey = file_get_contents(dirname(__FILE__) . '/rsa_public_key.pem');
        $res = openssl_get_publickey($pubKey); //转换为openssl格式密钥
        $result = (bool) openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_MD5); //调用openssl内置方法验签，返回bool值
        openssl_free_key($res); //释放资源
        return $result; //返回资源是否成功
    }

////////////////////////////////////////////////////////////////////////////////

    /**
     * 签名字符串
     * @param $prestr 需要签名的字符串
     * @param $key 私钥
     * return 签名结果
     */
    public static function md5Sign($prestr, $key) {
        $prestr = $prestr . "&key=" . $key;
        return md5($prestr);
    }

    /**
     * 验证签名
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $key 私钥
     * return 签名结果
     */
    public static function md5Verify($prestr, $sign, $key) {
        $prestr = $prestr . "&key=" . $key;
        $mysgin = md5($prestr);
        if ($mysgin == $sign) {
            return true;
        } else {
            return false;
        }
    }

////////////////////////////////////////////////////////////////////////////////

    /**
     * 加密函数
     * @param type $str
     * @param type $key
     * @return string
     */
    public static function xxtea_encrypt($str, $key) {
        if ($str == "") {
            return "";
        }
        $v = self::str2long($str, true);
        $k = self::str2long($key, false);
        if (count($k) < 4) {
            for ($i = count($k); $i < 4; $i++) {
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;
        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = 0;
        while (0 < $q--) {
            $sum = self::int32($sum + $delta);
            $e = $sum >> 2 & 3;
            for ($p = 0; $p < $n; $p++) {
                $y = $v[$p + 1];
                $mx = self::int32(( ($z >> 5 & 0x07ffffff ) ^ $y << 2) + (($y >> 3 & 0x1fffffff ) ^ $z << 4)) ^ self::int32(( $sum ^ $y ) + ( $k[$p & 3 ^ $e] ^ $z));
                $z = $v[$p] = self::int32($v[$p] + $mx);
            }
            $y = $v[0];
            $mx = self::int32(( ($z >> 5 & 0x07ffffff ) ^ $y << 2) + (($y >> 3 & 0x1fffffff ) ^ $z << 4)) ^ self::int32(( $sum ^ $y ) + ( $k[$p & 3 ^ $e] ^ $z));
            $z = $v[$n] = self::int32($v[$n] + $mx);
        }
        return $this->long2str($v, false);
    }

    /**
     * 解密函数
     * @param type $str
     * @param type $key
     * @return string
     */
    public static function xxtea_decrypt($str, $key) {
        if ($str == "") {
            return "";
        }
        $v = self::str2long($str, false);
        $k = self::str2long($key, false);
        if (count($k) < 4) {
            for ($i = count($k); $i < 4; $i++) {
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;

        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = self::int32($q * $delta);
        while ($sum != 0) {
            $e = $sum >> 2 & 3;
            for ($p = $n; $p > 0; $p--) {
                $z = $v[$p - 1];
                $mx = self::int32(( ($z >> 5 & 0x07ffffff ) ^ $y << 2) + (($y >> 3 & 0x1fffffff ) ^ $z << 4)) ^ self::int32(( $sum ^ $y ) + ( $k[$p & 3 ^ $e] ^ $z));
                $y = $v[$p] = self::int32($v[$p] - $mx);
            }
            $z = $v[$n];
            $mx = self::int32(( ($z >> 5 & 0x07ffffff ) ^ $y << 2) + (($y >> 3 & 0x1fffffff ) ^ $z << 4)) ^ self::int32(( $sum ^ $y ) + ( $k[$p & 3 ^ $e] ^ $z));
            $y = $v[0] = self::int32($v[0] - $mx);
            $sum = self::int32($sum - $delta);
        }
        return $this->long2str($v, true);
    }

    static private function long2str($v, $w) {
        $len = count($v);
        $n = ( $len - 1) << 2;
        if ($w) {
            $m = $v[$len - 1];
            if (($m < $n - 3) || ($m > $n))
                return false;
            $n = $m;
        }
        $s = array();
        for ($i = 0; $i < $len; $i++) {
            $s[$i] = pack("V", $v[$i]);
        }
        if ($w) {
            return substr(join('', $s), 0, $n);
        } else {
            return join('', $s);
        }
    }

    static private function str2long($s, $w) {
        $v = unpack("V*", $s . str_repeat("\0", (4 - strlen($s) % 4) & 3));
        $v = array_values($v);
        if ($w) {
            $v[count($v)] = strlen($s);
        }
        return $v;
    }

    static private function int32($n) {
        while ($n >= 2147483648)
            $n -= 4294967296;
        while ($n <= -2147483649)
            $n += 4294967296;
        return (int) $n;
    }

}
