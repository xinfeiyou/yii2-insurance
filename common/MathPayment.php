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
     * @param type $type  1：按月付息，到期还本  2：一次性还款  3：等额本息
     * @return type array
     */
    public static Function PayInterest($money, $yearInterest, $month, $oddType, $type = '1', $time = "") {
        $array = array();
        if (empty($time)) {
            $time = date("Y-m-d H:i:s", time());
        }
        $money = floatval($money);
        $yearInterest = floatval($yearInterest);
        $interset = round((($money * $yearInterest) / 12), 2);
        $yingli = 0;
        if ('month' == $oddType) {
            $num = $month;
        } else {
            $num = 1;
        }
        switch ($type) {
            case '1': //按月付息，到期还本
                for ($i = 1; $i <= $num; $i++) {
                    switch ($oddType) {
                        case "month":
                            $etime = self::timeNextMonth($time);
                            $oddlixi = $interset;
                            break;
                        case "day":
                            $etime = self::timeNextDay($time, $month);
                            $oddlixi = round(($interset / 30) * $month, 2);
                            break;
                        case "sec":
                            $etime = self::timeEndSec($time);
                            $oddlixi = round(($interset / 30), 2);
                            break;
                    }
                    $array['notes'][$i]['lixi'] = $oddlixi;
                    if ($i != $num) {
                        $array['notes'][$i]['month'] = $i;
                        $array['notes'][$i]['benjin'] = '0';
                        $array['notes'][$i]['zonger'] = $oddlixi;
                        $array['notes'][$i]['yuer'] = $money;
                        $array['notes'][$i]['stime'] = $time;
                        $array['notes'][$i]['etime'] = $etime;
                        $time = $etime;
                    } else {
                        $array['notes'][$i]['month'] = $i;
                        $array['notes'][$i]['benjin'] = $money;
                        $array['notes'][$i]['zonger'] = ($money + $oddlixi);
                        $array['notes'][$i]['yuer'] = '0';
                        $array['notes'][$i]['stime'] = $time;
                        $array['notes'][$i]['etime'] = $etime;
                    }
                    $yingli += $oddlixi;
                }
                $array['yingli'] = $yingli;
                break;
            case '2'://一次性还款
                switch ($oddType) {
                    case "month":
                        $etime = self::timeNextMonth($time);
                        $oddlixi = $interset;
                        break;
                    case "day":
                        $etime = self::timeNextDay($time, $month);
                        $oddlixi = round(($interset / 30) * $month, 2);
                        break;
                    case "sec":
                        $etime = self::timeEndSec($time);
                        $oddlixi = round(($interset / 30), 2);
                        break;
                }
                $lixi = round(($oddlixi * $num), 2);
                $array['notes']['0']['lixi'] = $lixi;
                $array['notes']['0']['month'] = '1';
                $array['notes']['0']['benjin'] = $money;
                $array['notes']['0']['zonger'] = ($money + $lixi);
                $array['notes']['0']['yuer'] = '0';
                $array['notes']['0']['stime'] = $time;
                $array['notes']['0']['etime'] = $etime;
                $array['yingli'] = $lixi;
                break;
            case '3'://等额本息
                $monthInterest = $yearInterest / 12;
                $zonger = self::MonthHuan($money, $monthInterest, $num);
                $k = 1;
                for ($j = ($num - 1); $j >= 0; $j--) {
                    $array['notes'][$k]['month'] = $k;
                    if (($num - 1) == $j)
                        $yuer = $money;
                    else
                        $yuer = ($j + 1) * $zonger;
                    $lixi = round(($yuer * $monthInterest), 2);
                    switch ($oddType) {
                        case "month":
                            $etime = self::timeNextMonth($time);
                            $oddlixi = $lixi;
                            break;
                        case "day":
                            $etime = self::timeNextDay($time, $month);
                            $oddlixi = round(($lixi / 30) * $month, 2);
                            break;
                        case "sec":
                            $etime = self::timeEndSec($time);
                            $oddlixi = round(($lixi / 30) * 1, 2);
                            break;
                    }
                    $array['notes'][$k]['lixi'] = $oddlixi;
                    $array['notes'][$k]['benjin'] = $zonger - $oddlixi;
                    $array['notes'][$k]['zonger'] = $zonger;
                    $array['notes'][$k]['yuer'] = $j * $zonger;
                    $array['notes'][$k]['stime'] = $time;
                    $array['notes'][$k]['etime'] = $etime;
                    $yingli += $oddlixi;
                    $time = $etime;
                    $k++;
                }
                $array['yingli'] = $yingli;
                break;
            case '4'://等额本金
                $benjin = round(($money / $month), 2);
                $oLixi = round(($benjin * $yearInterest / 12), 2);
                $sLixi = round(($money * $yearInterest / 12), 2); //第一期3利息
                $n = 0;
                switch ($oddType) {
                    case "month":
                        $num = $num;
                        break;
                    case "day":
                        $num = 1;
                        break;
                    case "sec":
                        $num = 1;
                        break;
                }
                for ($m = 1; $m <= $num; $m++) {
                    $etime = self::timeNextMonth($time);
                    if (1 == $m) {
                        $oddlixi = $sLixi;
                        $yuer = $money - $benjin;
                    } else {
                        $oddlixi = $sLixi - $n * $oLixi;
                        $yuer = $money - $m * $benjin;
                        if ($yuer < 0) {
                            $yuer = 0;
                        }
                    }
                    $array['notes'][$n]['month'] = $m;
                    $array['notes'][$n]['lixi'] = $oddlixi;
                    $array['notes'][$n]['benjin'] = $benjin;
                    $array['notes'][$n]['zonger'] = round(($benjin + $oddlixi), 2);
                    $array['notes'][$n]['yuer'] = $yuer;
                    $array['notes'][$n]['stime'] = $time;
                    $array['notes'][$n]['etime'] = $etime;
                    $time = $etime;
                    $n++;
                }
                $array['yingli'] = $oLixi * $num;
                break;
        }
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

    public static Function MonthHuan($a, $i, $n) {
        $b = ($a * $i * pow((1 + $i), $n)) / (pow((1 + $i), $n) - 1);
        return round($b, 2);
    }

}
