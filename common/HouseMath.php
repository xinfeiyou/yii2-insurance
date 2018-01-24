<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of HouseMath
 *
 * @author Administrator
 */
class HouseMath {

    public $HOUSE = [
        'H31' => -0.03, //无电梯
        'H32' => 0.03, //有电梯
        'H35' => -0.06, //多梯多户
        'H36' => -0.06, //其他
        'H37' => 0.02, //三梯四户
        'H38' => 0.02, //二梯三户
        'H39' => 0, //二梯四户
        'H40' => -0.02, //二梯六户
        'H41' => 0.01, //一梯二户
        'H42' => 0.06, //一梯一户
        'H47' => 0.03, //板式（东西）南头
        'H48' => -0.03, //板式（东西）北头
        'H49' => -0.09, //板式（东西）中间
        'H50' => 0.09, //板式（南北）东头
        'H51' => 0, //板式（南北）西头
        'H52' => -0.09, //板式（南北）中间
        'H53' => -0.1, //点式朝北
        'H54' => 0.02, //点式朝东
        'H55' => 0.08, //点式朝南
        'H56' => -0.04, //点式朝西
        'H57' => -0.04, //点式东北
        'H58' => 0.08, //点式东南
        'H59' => -0.1, //点式西北
        'H60' => 0.02, //点式西南
        'H61' => -0.1//其它
    ];
    public $DEEDTAX = [
        'I1' => 100, //交易费
        'I4' => -1, //契税<90(平方米)
        'I5' => -1.5, //90<=契税<=140
        'I6' => -1.5, //契税>140
        'I7' => -1, //个人所得税
    ];
    public $OTHER = [
        'H22' => 0.3,
        'I22' => 0.2,
        'J22' => 0.2,
        'K22' => 0.3
    ];
    public $fBaseMoney;
    public $fHoseErea;
    public $fAffiliatedErea;
    public $fOrientation;
    public $fElevator;
    public $fLadderRatio;
    public $fSumFloor;
    public $fLocation;
    public $tObtainTime;

    /**
     * 
     * @param float $fBaseMoney     基准价
     * @param float $fHoseErea      房屋面积
     * @param float $fAffiliatedErea 附属间面积
     * @param float $fOrientation   朝向结构
     * @param float $fElevator      有无电梯
     * @param float $fLadderRatio   梯户比
     * @param float $fSumFloor      楼层
     * @param float $fLocation      总楼层
     * @param time $tObtainTime     交房时间
     */
    public function __construct($fBaseMoney, $fHoseErea, $fAffiliatedErea, $fOrientation, $fElevator, $fLadderRatio, $fSumFloor, $fLocation, $tObtainTime) {
        $this->fBaseMoney = $fBaseMoney;
        $this->fHoseErea = $fHoseErea;
        $this->fAffiliatedErea = $fAffiliatedErea;
        $this->fOrientation = $fOrientation;
        $this->fElevator = $fElevator;
        $this->fLadderRatio = $fLadderRatio;
        $this->fSumFloor = $fSumFloor;
        $this->fLocation = $fLocation;
        $this->tObtainTime = $tObtainTime;
    }

    /**
     * 测算单价
     * @return float
     */
    public function getUnitPrice() {
        $fMoney = 0.0;
        $H16 = $this->getH16($this->fOrientation, $this->fElevator, $this->fLadderRatio, $this->fSumFloor, $this->fLocation);
        $fTmp = ($H16 * $this->fBaseMoney / 100);
        if ($this->fHoseErea <= 90) {
            $fMoney = round($fTmp) * $this->getJ4($this->tObtainTime);
        } elseif ($this->fHoseErea >= 144) {
            $fMoney = round($fTmp) * $this->getJ6($this->tObtainTime);
        } else {
            $fMoney = round($fTmp) * $this->getJ5($this->tObtainTime);
        }
        $fMoney = round($fMoney * $this->getL12($this->fHoseErea));
        return $fMoney;
    }

    /**
     * 计算确认总价
     * @param float $fmoney     确认单价
     * @return float
     */
    public function getSumPrice($fmoney) {
        $fTmp = $fmoney * ($this->fHoseErea + $this->fAffiliatedErea / 2);
        return round($fTmp, -2);
    }

    /**
     * 计算上调值
     * @return type
     */
    public function getFloatPrice() {
        $fUnitPrice = $this->getUnitPrice();
        $arData[0]['rate'] = 1.05;
        $arData[0]['price'] = round($fUnitPrice * 1.05);
        $arData[1]['rate'] = 1.1;
        $arData[1]['price'] = round($fUnitPrice * 1.1);
        return $arData;
    }

    /**
     * 总体修正值
     * @param type $fOrientation
     * @param type $fElevator
     * @param type $fLadderRatio
     * @param type $fSumFloor
     * @param type $fLocation
     * @return type
     */
    private function getH16($fOrientation, $fElevator, $fLadderRatio, $fSumFloor, $fLocation) {
//        echo '--1:' . $this->getH14($fOrientation)."\n";
//        echo '--2:' . $this->getH23($fSumFloor, $fLocation)."\n";
//        echo '--3:' . $this->getI14($fElevator)."\n";
//        echo '--4:' . $this->getI23($fSumFloor, $fLocation)."\n";
//        echo '--5:' . $this->getJ14($fLadderRatio)."\n";
//        echo '--6:' . $this->getJ23($fSumFloor, $fLocation)."\n";
//        echo '--7:' . $this->getK14($fSumFloor, $fLocation, $fElevator)."\n";
//        echo '--8:' . $this->getK23($fSumFloor, $fLocation)."\n";
        $fTmp = $this->getH14($fOrientation) * $this->getH23($fSumFloor, $fLocation);
        $fTmp += $this->getI14($fElevator) * $this->getI23($fSumFloor, $fLocation);
        $fTmp += $this->getJ14($fLadderRatio) * $this->getJ23($fSumFloor, $fLocation);
        $fTmp += $this->getK14($fSumFloor, $fLocation, $fElevator) * $this->getK23($fSumFloor, $fLocation);
        return round($fTmp, 2);
    }

    /**
     * 计算减去契约税后的价格
     * @param type $tObtainTime 什么时候购买
     * @return type
     */
    private function getJ4($tObtainTime) {
        $fTmp = round(($this->DEEDTAX['I1'] + $this->getI3($tObtainTime) + $this->DEEDTAX['I4'] + $this->DEEDTAX['I7']) / 100, 3);
        return $fTmp;
    }

    /**
     * 计算减去契约税后的价格
     * @param type $tObtainTime 什么时候购买
     * @return type
     */
    private function getJ5($tObtainTime) {
        $fTmp = round(($this->DEEDTAX['I1'] + $this->getI3($tObtainTime) + $this->DEEDTAX['I5'] + $this->DEEDTAX['I7']) / 100, 3);
        return $fTmp;
    }

    /**
     * 计算减去契约税后的价格
     * @param type $tObtainTime 什么时候购买
     * @return type
     */
    private function getJ6($tObtainTime) {
        $fTmp = round(($this->DEEDTAX['I1'] + $this->getI3($tObtainTime) + $this->DEEDTAX['I6'] + $this->DEEDTAX['I7']) / 100, 3);
        return $fTmp;
    }

    /**
     * 计算营业税和附加税
     * @param type $tObtainTime
     * @return type
     */
    private function getI3($tObtainTime) {
        $num = $this->getI12($tObtainTime);
        $fTmp = ($num < 21) ? -5.6 : 0;
        $fTmp = round(($fTmp * 1.01), 2);
        return $fTmp;
    }

    /**
     * 房龄是否满两年
     * @param type $tObtainTime
     * @return type
     */
    private function getJ3($tObtainTime) {
        return $this->getI3($tObtainTime) * 0.1;
    }

    /**
     * 房子朝向修正值
     * @param type $fOrientation
     * @return type
     */
    private function getH14($fOrientation) {
        return (1 + $fOrientation) * 100;
    }

    /**
     * 电梯修正值
     * @param type $fElevator
     * @return type
     */
    private function getI14($fElevator) {
        return (1 + $fElevator) * 100;
    }

    /**
     * 梯户比修正值
     * @param type $fLadderRatio
     * @return type
     */
    private function getJ14($fLadderRatio) {
        return (1 + $fLadderRatio) * 100;
    }

    private function getK14($fSumFloor, $fLocation, $fElevator) {
        $fTmp = 0.0;
        if (empty($fSumFloor) || empty($fLocation)) {
            $fTmp = 0.0;
        } else {
            $fTmp = $fTmp + 100;
            if ($fElevator < 0) {
                $fTtp = 0.0;
                if ($fLocation <= 3) {
                    $fTtp = $fTtp + $fSumFloor;
                } else {
                    if (empty($fLocation % 2)) {
                        if ($fSumFloor > round($fLocation / 2, 2)) {
                            $fTtp = $fTtp + $fLocation - $fSumFloor + 1;
                        } else {
                            $fTtp = $fTtp + $fSumFloor;
                        }
                    } else {
                        if ($fSumFloor > $fLocation / 2) {
                            $fTtp = $fTtp + $fLocation - $fSumFloor + 1;
                        } else {
                            $fTtp = $fTtp + $fSumFloor;
                        }
                    }
                    $fTtp = $fTtp - 1;
                }
                $fTmp = $fTmp + $fTtp * $this->getL14($fSumFloor, $fElevator);
            } else {
                $fTmp = $fTmp + $fSumFloor * $this->getL14($fSumFloor, $fElevator);
            }
        }
        return $fTmp;
    }

    private function getL14($fSumFloor, $fElevator) {
        $fTmp = 0.0;
        if ($fElevator < 0) {
            $fTmp = 2;
        } else {
            if ($fSumFloor > 18) {
                $fTmp = 3;
            } else {
                $fTmp = 1.8 + max(($fSumFloor - 9) / 9, 0);
            }
        }
        $fTmp = round($fTmp, 2);
        return $fTmp;
    }

    private function getH23($fSumFloor, $fLocation) {
        return ($this->OTHER['H22'] + $this->getK24($fSumFloor, $fLocation) / 2);
        return 0.45;
    }

    private function getI23($fSumFloor, $fLocation) {
        return ($this->OTHER['I22'] + $this->getK24($fSumFloor, $fLocation) / 4);
    }

    private function getJ23($fSumFloor, $fLocation) {
        return ($this->OTHER['J22'] + $this->getK24($fSumFloor, $fLocation) / 4);
    }

    private function getK23($fSumFloor, $fLocation) {
        return ($this->OTHER['K22'] - $this->getK24($fSumFloor, $fLocation));
    }

    private function getK24($fSumFloor, $fLocation) {
        $fTmp = 0.0;
        if ($fSumFloor <= 10) {
            $fTmp = 0;
        } else {
            $fTmp = $fSumFloor / $fLocation / 10;
        }
        if ($fLocation == $fSumFloor) {
            $fTmp = $fTmp - 0.02;
        }
        return round($fTmp, 2);
    }

    private function getI12($tObtainTime) {
        $tNewYear = intval(date("Y"));
        $tNewMonth = intval(date("m"));
        $tOldYear = intval(substr($tObtainTime, 0, 4));
        $tOldMonth = intval(substr($tObtainTime, 6, 2));
        $num = $tNewMonth - $tOldMonth + 12 * ($tNewYear - $tOldYear);
        return $num;
    }

    private function getL12($fHoseErea) {
        $fTmp = 0.0;
        if ($fHoseErea < 70) {
            $fTmp = min(1.05, 1 + 0.05 * (70 - $fHoseErea) / 40);
        } else {
            if ($fHoseErea > 130) {
                $fTmp = max(0.95, 1 - 0.02 * ($fHoseErea - 130) / 40);
            } else {
                $fTmp = 1;
            }
        }
        return round($fTmp, 6);
    }

}

//        $fBaseMoney = 17917; //基准价
//        $fHoseErea = 87.25; //房屋面积
//        $fAffiliatedErea = 0; //附属间面积
//        $fOrientation = 0.09; //点式朝东
//        $fElevator = 0.03; // '有电梯';
//        $fLadderRatio = 0.01; // '一梯二户';
//        $fSumFloor = 2; //总楼层
//        $fLocation = 8; //所在楼层
//        $tObtainTime = '2014-05-10'; //交房时间
//        $house = (new \app\common\HouseMath($fBaseMoney, $fHoseErea, $fAffiliatedErea, $fOrientation, $fElevator, $fLadderRatio, $fSumFloor, $fLocation, $tObtainTime));
//        echo $house->getUnitPrice();
//        echo "<hr>";
//        echo $house->getSumPrice(16255);
//        echo "<hr>";
//        $a = $house->getFloatPrice();
//        print_r($a);
