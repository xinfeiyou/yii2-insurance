<?php

/* * ********************************************************\
  |                                                          |
  | The implementation of yii2.0                             |
  |                                                          |
  | Lottery.php                                              |
  |                                                          |
  | Release 5.0.1                                            |
  | Copyright by Team-xinfeiyou                              |
  |                                                          |
  | WebSite:  http://www.xinfeiyou.com/                      |
  |           https://github.com/xinfeiyou/                  |
  |                                                          |
  | Authors:  panda Liu <admin@xinfeiyou.com>                |
  |                                                          |
  | This file may be distributed and/or modified under the   |
  | terms of the GNU General Public License (GPL) version    |
  | 2.0 as published by the Free Software Foundation and     |
  | appearing in the included file LICENSE.                  |
  |                                                          |
\* ******************************************************** */

namespace app\common;

/**
 * Description of Other
 *
 * @author Administrator
 */
class Lottery {

    /**
     * 抽取中奖号码
     * @param int $intStrNum        彩票号码
     * @param int $intBuyNum        购买次数
     * @param int $intPrizeNum      中奖个数
     * @return array
     */
    public function getPrizeDrawNum($intStrNum, $intBuyNum, $intPrizeNum) {
        /*
          第16262期福建22选5红球号：18 16 05 14 06
          设该奖项号码被兑换325次       奖品数量：3个
          第一个中奖号码算法：1816051406除325，余数+1=157
          第二个中奖号码算法：157+325/3（取整数）=265
          第三个中奖号码算法：265+325/3（取整数）=373>325  373-325=48
          最终三个中奖号码为：0157 , 0265 , 0048
         */
        $array = [];
        $array[0] = intval($intStrNum % $intBuyNum) + 1;
        if ($intPrizeNum > 1) {
            for ($i = 1; $i < $intPrizeNum; $i++) {
                $array[$i] = $array[$i - 1] + intval($intBuyNum / $intPrizeNum);
                if ($array[$i] > $intBuyNum) {
                    $array[$i] -= $intBuyNum;
                }
            }
        }
        return $array;
    }

}
