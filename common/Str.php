<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of Str
 *
 * @author Administrator
 */
class Str {

    /**
     * 将json字符串中float值为0.0转为0--C#中的问题
     * @param string $json  json字符串
     * @return array
     */
    public static function setJsonFloatNum($json) {
        preg_match_all('|"\w+":0.0+,|U', $json, $out, PREG_PATTERN_ORDER);
        $array = [];
        if (!empty($out[0])) {
            foreach ($out[0] as $v) {
                $t = explode(':', $v);
                $key = trim(substr(trim($t[0]), 1, -1));
                $array[$key] = substr(trim($t[1]), 0, -1);
            }
        }
        return $array;
    }

    /**
     * 解决提交二次json数据问题
     * @param stirng $strJson   json字符串
     * @return json
     */
    public static function formatJson($strJson) {
        $strJson = str_replace(':"{"', ':{"', $strJson);
        return str_replace('"}",', '"},', $strJson);
    }

    /**
     * 验证是否有效json
     * @param string $string
     * @return boolean
     */
    public static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * 验证json格式是否错误
     * @param type json_decode($sting); 操作后直接调用
     */
    public static function ckJsonError() {
        $strMsg = "";
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $strMsg = ' - No errors';
                break;
            case JSON_ERROR_DEPTH:
                $strMsg = ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $strMsg = ' - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $strMsg = ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $strMsg = ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $strMsg = ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $strMsg = ' - Unknown error';
                break;
        }
        return $strMsg;
    }

    /**
     * 中文不转码
     * @param array $array  数组
     * @return json
     */
    public static function cnJsonEncode($array) {
        $options = JSON_PRESERVE_ZERO_FRACTION + JSON_UNESCAPED_UNICODE;
        return json_encode($array, $options);
    }

    /**
     * 兼容js生成的json字符串
     * @param string $strJson   json字符串
     * @param boolean $mode     显示数组OR对象
     * @return array|obj
     */
    public static function extJsonDecode($strJson, $mode = false) {
        if (preg_match('/\w:/', $str)) {
            $str = preg_replace('/(\w+):/is', '"$1":', $str);
        }
        return json_decode($str, $mode);
    }

    /**
     * 设置流水号
     * @param type $type
     * @param type $number
     * @return string
     */
    public static function setSerialNum($type, $number) {
        $typeLen = strlen($type);
        if (!empty($number)) {
            if (date("Ymd") == substr($number, $typeLen, 8)) {
                $num = intval(substr($number, (8 + $typeLen))) + 1;
                $num = sprintf("%012s", $num);
                $number = $type . date("Ymd") . $num;
            } else {
                $number = $type . date("Ymd") . "000000000001";
            }
        } else {
            $number = $type . date("Ymd") . "000000000001";
        }
        return $number;
    }

    /**
     * 显示字符串固定长度，多出已点显示
     * @param type $fStr
     * @param type $fStart
     * @param type $fLen
     * @param type $fCode
     * @return string
     */
    public static Function msubstr($fStr, $fStart, $fLen, $fCode = "utf-8") {
        $fCode = strtolower($fCode);
        switch ($fCode) {
            case 'utf8':
            case 'utf-8':
                $fStr = trueHtml($fStr);
                preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $fStr, $ar);
                $i = 0;
                $aC = count($ar[0]);
                foreach ($ar[0] as $value) {
                    $i++;
                    if (ord($value) > 127) {
                        if (1 == strlen($result)) {
                            $ar[1][] = $result . " ";
                            $result = "";
                        }
                        $ar[1][] = $value;
                    } else {
                        $result .= htmlspecialchars($value);
                        if (strlen($result) > 1) {
                            $ar[1][] = $result;
                            $result = "";
                        } elseif ($i == $aC) {
                            $ar[1][] = $result;
                        }
                    }
                }
                if (func_num_args() >= 3) {
                    if (count($ar[1]) > $fLen) {
                        return @join("", array_slice($ar[1], $fStart, $fLen)) . "..";
                    }
                    return @join("", array_slice($ar[1], $fStart, $fLen));
                } else {
                    return @join("", array_slice($ar[1], $fStart));
                }
                break;
            default:
                $fStart = $fStart * 2;
                $fLen = $fLen * 2;
                $strlen = strlen($fStr);
                for ($i = 0; $i < $strlen; $i++) {
                    if ($i >= $fStart && $i < ( $fStart + $fLen )) {
                        if (ord(substr($fStr, $i, 1)) > 129)
                            $tmpstr .= substr($fStr, $i, 2);
                        else
                            $tmpstr .= substr($fStr, $i, 1);
                    }
                    if (ord(substr($fStr, $i, 1)) > 129)
                        $i++;
                }
                if (strlen($tmpstr) < $strlen)
                    $tmpstr .= "...";
                Return $tmpstr;
        }
    }

    /**
     * 生成唯一推荐码
     * @param type $id
     * @return type
     */
    public static function getCard($id) {
        return md5($id . microtime());
    }

    /**
     * 已json格式输出
     * @param type $array
     */
    public static function echoJson($array) {
        header('Content-Type:application/json; charset=utf-8');
        exit(self::cnJsonEncode($array));
    }

}
