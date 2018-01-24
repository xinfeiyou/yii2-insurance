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
     * 加解密函数
     * @param string $string    待加密的字符串
     * @param string $operation 操作 ENCODE:加密|DECODE:加密
     * @param string $key       秘钥
     * @param string $expiry    
     * @return string
     */
    public static function DzCrypt($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙   
        $ckey_length = 4;
        // 密匙   
        $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);
        // 密匙a会参与加解密   
        $keya = md5(substr($key, 0, 16));
        // 密匙b会用来做数据完整性验证   
        $keyb = md5(substr($key, 16, 16));
        // 密匙c用于变化生成的密文   
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
                substr(md5(microtime()), -$ckey_length)) : '';
        // 参与运算的密匙   
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)， 
        //解密时会通过这个密匙验证数据完整性   
        // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确   
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
                sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        // 产生密匙簿   
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度   
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        // 核心加解密部分   
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            // 从密匙簿得出密匙进行异或，再转成字符   
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            // 验证数据有效性，请看未加密明文的格式   
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                    substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因   
            // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码   
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

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
        return self::long2str($v, false);
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
        return self::long2str($v, true);
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
