<?php

namespace app\common;

/**
 * 功能：表单验证的一些信息
 * 功能列表1：邮箱:checkEmail， 中文:checkCn，    存在中文:deCn:，     英文:checkEn
 * 功能列表2：数字:checkNumber，字符:checkStr，   百分率:checkPercent，价格:checkMoney，
 * 功能列表3：QQ:checkQq，      手机:checkMobile，电话:checkPhone，    身份证:checkIdCard
 * 功能列表4：日期:checkDateTime浮点数:checkFloat
 * $str：被验证的字符串
 * 日期：2008-5-19
 * 作者：刘晨辉
 * */
class CheckData {

    /**
     * 功能：验证邮箱是否准确
     * 日期：2008-5-19
     * */
    public static function CheckEmail($str) {
        if (preg_match("/^([a-zA-Z0-9])+([\w-.])*([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)/", $str))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证是否全是中文
     * 日期：2008-5-19
     * */
    public static function CheckCn($str) {
        if (!eregi("[^\x80-\xff]", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：判断是否存在中文
     * 日期：2008-5-19
     * */
    public static function DeCn($str) {
        $strlen = strlen($str);
        $length = 1;
        for ($i = 0; $i < $strlen; $i++) {
            $tmpstr = ord(substr($str, $i, 1));
            if (($tmpstr <= 161 || $tmpstr >= 247)) {
                $a = 0;
            } else {
                $a = 1;
                break;
            }
        }
        if ($a == '0')
            return false;
        else
            return true;
    }

    /**
     * 功能：验证是否全是字母
     * 日期：2008-5-19
     * */
    public static function CheckEn($str) {
        if (preg_match("/^[a-zA-Z]+$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证是否全是数字
     * 日期：2008-5-19
     * */
    public static function CheckNumber($str) {
        if (preg_match("/\d/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证是否全是字符
     * 日期：2008-5-19
     * */
    public static function CheckStr($str) {
        if (preg_match("/^[a-zA-Z_0-9]+$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证是否是百分率
     * 日期：2008-5-19
     * */
    public static function CheckPercent($str) {
        if (preg_match("/^[0-9]+(.[0-9]+)?%$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证价格格式是否正确
     * 日期：2008-5-19
     * */
    public static function CheckMoney($str) {
        if (preg_match("/^[-]?[0-9]+(.[0-9]+)?$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证浮点数
     * 日期：2008-5-27
     * */
    public static function CheckFloat($str) {
        if (preg_match("/^[0-9]+(.[0-9]+)?$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证QQ号码
     * 日期：2008-5-19
     * */
    public static function CheckQq($str) {
        if (preg_match("/^[1-9][0-9]{4,9}$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证手机号码
     * 日期：2008-5-19
     * */
    public static function CheckMobile($str) {
        if (preg_match("/^[0]{0,1}1[0-9]{10}$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证电话号码
     * 日期：2008-5-19
     * */
    public static function CheckPhone($str) {
        if (preg_match("/^[0-9]{3,4}[-]{0,1}[0-9]{7,8}$/", "$str"))
            return true;
        else
            return false;
    }

    /**
     * 功能：验证日期是否有效
     * 日期：2008-5-19
     * */
    public static function CheckDateTime($str) {
        if (preg_match("/^[1-9][0-9]{3}-[0-1]?[0-9]-[0-3][0-9]$/", "$str")) {
            $tmp_arr = explode("-", $str);
            //				 『月			『日		  『年
            if (checkdate("$tmp_arr[1]", "$tmp_arr[2]", "$tmp_arr[0]"))
                return true;
        } else
            return false;
    }

    /**
     * 验证身份证号码
     * @param type $vStr
     * @return boolean
     */
    public static function CheckIdCard($vStr) {
        $vCity = array(
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91'
        );
        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr))
            return false;

        if (!in_array(substr($vStr, 0, 2), $vCity))
            return false;
        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);
        if ($vLength == 18) {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }
        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday)
            return false;
        if ($vLength == 18) {
            $vSum = 0;
            for ($i = 17; $i >= 0; $i--) {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
            }
            if ($vSum % 11 != 1)
                return false;
        }
        return true;
    }

}
