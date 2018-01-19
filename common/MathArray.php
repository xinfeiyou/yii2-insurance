<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of MathArray
 *
 * @author Administrator
 */
class MathArray {

    /**
     * 将数组内的数据转码
     * @param type $fArray
     * @param type $fFrom
     * @param type $fTo
     * @return type
     */
    public static Function ArrayAutoCharSet($fArray, $fFrom = "gbk", $fTo = "utf-8") {
        if (is_array($fArray)) {
            foreach ($fArray AS $_arrykey => $_arryval) {
                if (is_string($_arryval)) {
                    $fArray[$_arrykey] = iconv($fFrom, $fTo, $fArray[$_arrykey]);
                } else if (is_array($_arryval)) {
                    $fArray[$_arrykey] = arrayAutoCharSet($_arryval, $fFrom, $fTo);
                }
            }
        }
        reset($fArray);
        Return $fArray;
    }

    /**
     * 将数组内的html代码转码
     * @param type $fArray
     * @return type
     */
    public static Function VarFilter($fArray) {
        if (is_array($fArray)) {
            foreach ($fArray AS $_arrykey => $_arryval) {
                if (is_string($_arryval)) {
                    $fArray[$_arrykey] = trim($fArray[$_arrykey]);
                    $fArray[$_arrykey] = htmlspecialchars($fArray[$_arrykey]);
                    $fArray[$_arrykey] = str_replace('javascript', 'javascript ', $fArray[$_arrykey]);
                    if (!get_magic_quotes_gpc()) {
                        $fArray[$_arrykey] = addslashes($fArray[$_arrykey]);
                    }
                } else if (is_array($_arryval)) {
                    $fArray[$_arrykey] = varFilter($_arryval);
                }
            }
        } else {
            $fArray = trim($fArray);
            $fArray = htmlspecialchars($fArray);
            $fArray = str_replace("javascript", "javascript ", $fArray);
        }
        Return $fArray;
    }

    /**
     * 将数组内的html代码还原
     * @param type $fArray
     * @return type
     */
    public static Function VarResume($fArray) {
        if (is_array($fArray)) {
            foreach ($fArray AS $_arrykey => $_arryval) {
                if (is_string($_arryval)) {
                    $fArray[$_arrykey] = str_replace('&quot;', '\'', $fArray[$_arrykey]);
                    $fArray[$_arrykey] = str_replace('&lt;', '<', $fArray[$_arrykey]);
                    $fArray[$_arrykey] = str_replace('&gt;', '>', $fArray[$_arrykey]);
                    $fArray[$_arrykey] = str_replace('&amp;', '&', $fArray[$_arrykey]);
                    $fArray[$_arrykey] = str_replace('javascript ', 'javascript', $fArray[$_arrykey]);
                } else if (is_array($_arryval)) {
                    $fStr[$_arrykey] = varResume($_arryval);
                }
            }
        } else {
            $fArray = str_replace("&quot;", "\"", $fArray);
            $fArray = str_replace("&lt;", "<", $fArray);
            $fArray = str_replace("&gt;", ">", $fArray);
            $fArray = str_replace("&amp;", "&", $fArray);
            $fArray = str_replace("javascript ", "javascript", $fArray);
        }
        Return $fArray;
    }

    /**
     * 对象数组转普通数组
     * @param type $object
     * @return type
     */
    public static Function ObjectToArray($object) {
        $object = empty($object) ? array() : $object;
        $result = array();
        $object = is_object($object) ? get_object_vars($object) : $object;
        foreach ($object as $key => $val) {
            $val = (is_object($val) || is_array($val)) ? objectToArray($val) : $val;
            $result[$key] = $val;
        }
        return $result;
    }

    /**
     * 去除数组中空数据
     * @param type $array
     * @return array
     */
    public static Function RemoveNullData($array) {
        $tArray = array();
        foreach ($array as $key => $value) {
            if ("" != $value) {
                $tArray[$key] = $value;
            }
        }
        return $tArray;
    }

    /**
     * 去除数组中数据两边空格
     * @param type $arr
     * @param type $trim
     */
    public static function trimArray(&$arr, $trim = true) {
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                self::trimArray($arr[$key]);
            } else {
                $arr[$key] = trim($value);
            }
        }
        return $arr;
    }

    /**
     * 去除数组中数据两边空格
     * @param type $arr
     * @param type $trim
     */
    public static function ArrayToString(&$arr, $type = "int") {
        $string = "";
        if ('int' == $type) {
            $string = implode(',', $arrStaff);
        } else {
            foreach ($arr as $value) {
                $string .= "'" . $value . "',";
            }
            $string = substr($string, 0, -1);
        }
        return $string;
    }

    /**
     * 获取数组维度
     * @param type $arr
     * @return int
     */
    public static function ArrayDimensionGet(&$arr) {
        $al = array(0);
        self::aL($arr, $al);
        return max($al);
    }

    public static function aL($arr, &$al, $level = 0) {
        if (is_array($arr)) {
            $level++;
            $al[] = $level;
            foreach ($arr as $v) {
                self::aL($v, $al, $level);
            }
        }
    }

    /**
     * 删除指定键值
     * @param type $arr
     * @param type $strKey
     * @return type
     */
    public static function ArrayDelKeyVal(&$arr, $arrKey) {
        $arrData = [];
        foreach ($arr as $key => $value) {
            if (!in_array($key, $arrKey)) {
                $arrData[$key] = $value;
            }
        }
        return $arrData;
    }

}
