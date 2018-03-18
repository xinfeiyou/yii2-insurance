<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of MathPayment
 *
 * @author Administrator
 */
class MathPayment {

    /**
     * 周还款表
     * @param float $money
     * @param float $dayInterest
     * @param int $weekNum
     */
    public static Function WeekPayment($money, $dayInterest, $weekNum) {
        if (is_numeric($weekNum) AND $weekNum > 0) {
            $array = array();
            $fMoney = $money / $weekNum;
            $fManage = $money * $dayInterest * 7;
            $fSumMoney = $money + $fManage * $weekNum;
            $stime = date("Y-m-d 00:00:01");
            for ($i = 1; $i <= $weekNum; $i++) {
                $etime = self::timeNextWeek($stime);
                $array['notes'][$i]['week'] = $i;
                $array['notes'][$i]['benjin'] = $fMoney;
                $array['notes'][$i]['lixi'] = $fManage;
                $array['notes'][$i]['zonger'] = ($fMoney + $fManage);
                $array['notes'][$i]['yuer'] = ($fSumMoney - ($fMoney + $fManage) * $i);
                $array['notes'][$i]['stime'] = $stime;
                $array['notes'][$i]['etime'] = $etime;
                $stime = date('Y-m-d 00:00:01', strtotime('+1 day', strtotime($etime)));
            }
        } else {
            
        }
        return $array;
    }

    /**
     * 还款计算公式  payInterest('50000', '0.1', '3', '1');
     * @param type $money  借款总金额
     * @param type $yearInterest  年化率
     * @param type $month  借月份数
     * @param type $oddType 标类型 month , day , sec
     * @param type $type  1：按月付息，到期还本  2：一次性还款  3：等额本息 4：等额本金
     * @return type array
     */
    public static Function PayInterest($money, $yearInterest, $month, $oddType, $type = '1', $time = "") {
        $array = array();
        if (empty($time)) {
            $time = date("Y-m-d H:i:s", time());
        }
        $num = ('month' == $oddType) ? $month : 1;
        $money = floatval($money);
        $yearInterest = floatval($yearInterest);
        switch ($type) {
            case "1"://按月付息，到期还本
                $array = self::fixedFrontInterest($money, $yearInterest, $num, $oddType, $time);
                break;
            case "2"://一次性还款
                $array = self::fixedOneInterest($money, $yearInterest, $num, $oddType, $time);
                break;
            case "3"://等额本息
                $array = self::fixedInstallment($money, $yearInterest, $num, $oddType, $time);
                break;
            case "4"://等额本金
                $array = self::fixedPrincipal($money, $yearInterest, $num, $oddType, $time);
                break;
        }
        return $array;
    }

    /**
     * 一次性还本息
     * @param float $money
     * @param float $yearInterest
     * @param int $month
     * @param string $oddType   month|day|sec
     * @return array
     */
    public static function fixedOneInterest($money, $yearInterest, $month, $oddType, $time) {
        for ($i = 1; $i <= $month; $i++) {
            if ($i == $month) {
                $benjin = $money;
                $interest = round(($money * $yearInterest * $month / 12), 2);
                $yuer = 0;
            } else {
                $benjin = 0;
                $interest = 0;
                $yuer = $money + round(($money * $yearInterest * $month / 12), 2);
            }
            $array['notes'][$i]['lixi'] = round($interest, 2);
            $array['notes'][$i]['month'] = $i;
            $array['notes'][$i]['benjin'] = $benjin;
            $array['notes'][$i]['zonger'] = round(($benjin + $interest), 2);
            $array['notes'][$i]['yuer'] = ($yuer > 0) ? round($yuer, 2) : 0;
            $array['notes'][$i]['stime'] = $time;
            $array['notes'][$i]['etime'] = self::timeNextMonth($time);
            $time = self::timeNextMonth($time);
        }
        $array['yingli'] = $interest;
        return $array;
    }

    /**
     * 先息后本
     * @param float $money
     * @param float $yearInterest
     * @param int $month
     * @param string $oddType   month|day|sec
     * @return array
     */
    public static function fixedFrontInterest($money, $yearInterest, $month, $oddType, $time) {
        $interest = $money * $yearInterest / 12;
        $yingli = round(($interest * $month), 2);
        for ($i = 1; $i <= $month; $i++) {
            $benjin = ($i == $month) ? $money : 0;
            $yuer = $money + $yingli - $benjin - ($interest * $i);
            $array['notes'][$i]['lixi'] = round($interest, 2);
            $array['notes'][$i]['month'] = $i;
            $array['notes'][$i]['benjin'] = $benjin;
            $array['notes'][$i]['zonger'] = round(($benjin + $interest), 2);
            $array['notes'][$i]['yuer'] = ($yuer > 0) ? round($yuer, 2) : 0;
            $array['notes'][$i]['stime'] = $time;
            $array['notes'][$i]['etime'] = self::timeNextMonth($time);
            $time = self::timeNextMonth($time);
        }
        $array['yingli'] = $yingli;
        return $array;
    }

    /**
     * 等额本息还款法
     * @param float $money
     * @param float $yearInterest
     * @param int $month
     * @param string $oddType   month|day|sec
     * @param time $time
     * @return array
     */
    public static function fixedInstallment($money, $yearInterest, $month, $oddType, $time) {
        $array = [];
        $monthlyPayment = $money * $yearInterest / 12 * pow(1 + $yearInterest / 12, $month) / (pow(1 + $yearInterest / 12, $month) - 1); //每月还款金额
        $interestTotal = 0; //总利息
        for ($i = 1; $i <= $month; $i++) {
            $interest = $money * $yearInterest / 12;   //每月还款利息
            $monthlyRepaymentPrincipal = $monthlyPayment - $interest;  //每月还款本金
            $money = $money - $monthlyRepaymentPrincipal;
            $array['notes'][$i]['lixi'] = round($interest, 2);
            $array['notes'][$i]['month'] = $i;
            $array['notes'][$i]['benjin'] = round($monthlyRepaymentPrincipal, 2);
            $array['notes'][$i]['zonger'] = round($monthlyPayment, 2);
            $array['notes'][$i]['yuer'] = ($money > 0) ? round($money, 2) : 0;
            $array['notes'][$i]['stime'] = $time;
            $array['notes'][$i]['etime'] = self::timeNextMonth($time);
            $interestTotal += $interest;
            $time = self::timeNextMonth($time);
        }
        $array['yingli'] = round($interestTotal, 2);
        return $array;
    }

    /**
     * (Reducing Balance) 等额本金还款法（利随本清）
     * @param float $money
     * @param float $yearInterest
     * @param int $month
     * @param string $oddType   month|day|sec
     * @param time $time
     * @return array
     */
    public static function fixedPrincipal($money, $yearInterest, $month, $oddType, $time) {
        $monthlyRepaymentPrincipal = round($money / $month, 2); //每个月还款本金
        $interestTotal = 0; //总利息
        for ($i = 1; $i <= $month; $i++) {
            $interest = round($money * $yearInterest / 12, 2); //每月还款利息
            $money -= $monthlyRepaymentPrincipal;
            $monthlyPayment = $monthlyRepaymentPrincipal + $interest;
            $array['notes'][$i]['lixi'] = round($interest, 2);
            $array['notes'][$i]['month'] = $i;
            $array['notes'][$i]['benjin'] = round($monthlyRepaymentPrincipal, 2);
            $array['notes'][$i]['zonger'] = round($monthlyPayment, 2);
            $array['notes'][$i]['yuer'] = ($money > 0) ? round($money, 2) : 0;
            $array['notes'][$i]['stime'] = $time;
            $array['notes'][$i]['etime'] = self::timeNextMonth($time);
            $interestTotal += $interest;
            $time = self::timeNextMonth($time);
        }
        $array['yingli'] = round($interestTotal, 2);
        return $array;
    }

    /**
     * 判断奇数，是返回TRUE，否返回FALSE
     * @param type $num
     * @return type
     */
    public static Function IsOdd($num) {
        return (is_numeric($num) & ($num & 1));
    }

    /**
     * 判断偶数，是返回TRUE，否返回FALSE
     * @param type $num
     * @return type
     */
    public static Function IsEven($num) {
        return (is_numeric($num) & (!($num & 1)));
    }

    /**
     * 系统生成20位商品订单号 
     * @return type 
     */
    public static Function setOddNumber() {
        $array = explode(" ", microtime());
        return $array['1'] . substr($array['0'], 2, 6) . rand(0000, 9999);
    }

    /**
     * 计算时间间隔天数
     * @param type $stime
     * @param type $etime
     * @return type
     */
    public static Function TimeSpace($stime, $etime) {
        $tmp = explode('-', $stime);
        $ttp = explode('-', $etime);
        $startdate = mktime("0", "0", "0", "$tmp[1]", "$tmp[2]", "$tmp[0]");
        $enddate = mktime("0", "0", "0", "$ttp[1]", "$ttp[2]", "$ttp[0]");
        $days = round(($enddate - $startdate) / 3600 / 24);
        return $days;
    }

    /**
     * 获取下一个月的时间
     */
    public static Function timeNextMonth($time) {
        //return date('Y-m-d H:i:s',strtotime('+1 month',strtotime($time)));
        return date('Y-m-d H:i:s', strtotime('+30 day', strtotime($time)));
    }

    public static Function timeNextWeek($time) {
        return date('Y-m-d 23:59:59', strtotime('+7 day', strtotime($time)));
    }

    /**
     * 获取过天数后时间
     * @param type $time
     * @param type $day
     */
    public static Function timeNextDay($time, $day) {
        $time = strtotime($time);
        $time = $time + ($day * 24 * 60 * 60);
        $time = date("Y-m-d H:i:s", $time);
        return $time;
    }

    /**
     * 获取秒标结束后的时间
     * @param string $time
     * @return string
     */
    public static Function timeEndSec($time) {
        $time = substr($time, 0, 10) . " 23:59:59";
        return $time;
    }

    /**
     * 秒数转出小时
     * @param type $sec
     * @return type
     */
    public static Function Sec2Hour($sec) {
        $m = intval($sec / 60);
        $ysec = $sec % 60;
        if ($m >= 60) {
            $h = intval($m / 60);
            $m = $m - ($h * 60);
        } else {
            $h = 0;
        }
        return $h . "时" . $m . "分" . $ysec . "秒";
    }

    /**
     * 格式化金额至小数点后三位
     * @param type $money
     * @return type
     */
    public static Function FormatMoney2($money) {
        $money = floor($money * 100) / 100;
        return sprintf("%01.3f", $money);
    }

    /**
     * 格式化金额至小数点后三位
     * @param type $money
     * @return type
     */
    public static Function FormatMoney3($money) {
        $money = floor($money * 1000) / 1000;
        return sprintf("%01.3f", $money);
    }

    /**
     * 将金额格式转换为货币形式 123,234.67
     * @param type $fVal 123234.67
     * @return string
     */
    public static Function NumToMoney($fVal) {
        $tmpMoney = explode('.', $fVal);
        $len = strlen($tmpMoney[0]);
        if ($len > 3) {
            $num = "";
            for ($i = 0; $i < $len; $i++) {
                $num .= substr($tmpMoney[0], $i, 1);
                if (0 == (($len - $i - 1) % 3)) {
                    if (($len - $i - 1) > 0)
                        $num .= ",";
                }
            }
        } else {
            $num = $fVal;
        }
        if (!empty($tmpMoney[1])) {
            $num .= '.' . $tmpMoney[1];
        }
        Return $num;
    }

}
