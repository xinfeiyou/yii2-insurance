<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\modules\base\models\WorkConfig;
use app\modules\base\models\WorkOddinterest;
use app\modules\base\models\WorkUserWithhold;
use app\modules\base\models\WorkUser;
use app\modules\base\models\WorkOdd;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world') {
        echo $message . "\n";
    }

    public function actionToken() {
        echo $this->getToken();
    }

    /**
     * 获取线上服务器信息
     */
    public function actionOdd() {
        $arOddInfo = Yii::$app->db->createCommand('SELECT oddNumber FROM hcpuhui.work_odd WHERE progress = :progress ')
                ->bindValue(':progress', "run")
                ->queryAll();
        foreach ($arOddInfo as $odd) {
            $arOdd = WorkOdd::findOne(['oddNumber' => $odd['oddNumber']]);
            if (empty($arOdd)) {
                $this->getOddInfo($odd['oddNumber']);
            }
        }
    }

    /**
     * 更新token值
     * @return type
     */
    public function getToken() {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . \Yii::$app->params['appId'] . "&secret=" . \Yii::$app->params['appSecret'];
        $json = file_get_contents($url);
        $arData = json_decode($json, true);
        if (!empty($arData['access_token'])) {
            return json_encode((new WorkConfig())->editKeyToValue('strToken', $arData['access_token']));
        } else {
            return $json;
        }
    }

    public function getOddInfo($oddNumber) {
        $model = new WorkOdd();
        $arOdd = Yii::$app->db->createCommand('SELECT * FROM hcpuhui.work_odd WHERE oddNumber =:oddNumber ')
                ->bindValue(':oddNumber', $oddNumber)
                ->queryOne();
        $arData['oddType'] = $arOdd['oddType'];
        $arData['oddTitle'] = $arOdd['oddTitle'];
        $arData['oddYearRate'] = $arOdd['oddYearRate'];
        $arData['oddMoney'] = $arOdd['oddMoney'];
        $arData['oddRepaymentStyle'] = $arOdd['oddRepaymentStyle'];
        $arData['oddBorrowPeriod'] = $arOdd['oddBorrowPeriod'];
        $arData['serviceFee'] = $arOdd['serviceFee'];
        $arData['oddTrialTime'] = $arOdd['oddTrialTime'];
        $arData['oddRehearTime'] = $arOdd['oddRehearTime'];
        $arData['userId'] = $arOdd['userId'];
        $arData['operator'] = $arOdd['operator'];
        $arData['isCr'] = $arOdd['isCr'];
        $arData['receiptUserId'] = $arOdd['receiptUserId'];
        $arData['receiptStatus'] = $arOdd['receiptStatus'];
        $arData['finishType'] = $arOdd['finishType'];
        $arData['finishTime'] = $arOdd['finishTime'];
        $arResult = $model->add($oddNumber, $arData);
        $arOddInterest = Yii::$app->db->createCommand('SELECT * FROM hcpuhui.work_oddinterest WHERE oddNumber =:oddNumber ')
                ->bindValue(':oddNumber', $oddNumber)
                ->queryAll();
        (new WorkOddinterest())->del($oddNumber);
        foreach ($arOddInterest as $interest) {
            $arInterest['intPeriod'] = $interest['qishu'];
            $arInterest['fOnLineCost'] = $interest['benJin'];
            $arInterest['fOnLineInterest'] = $interest['interest'];
            $arInterest['fOnLineTotal'] = $interest['zongEr'];
            $arInterest['strUserId'] = $interest['userId'];
            $arInterest['tStartTime'] = $interest['addtime'];
            $arInterest['tEndTime'] = $interest['endtime'];
            $arInterest['tOperateTime'] = $interest['operatetime'];
            $arInterest['strPaymentStatus'] = $interest['status'];
            $arInterest['fSubsidy'] = $interest['subsidy'];
            $arResult = (new WorkOddinterest())->add($oddNumber, $arInterest);
        }
        $arUserBank = Yii::$app->db->createCommand('SELECT system_userinfo.userId,system_userinfo.phone,system_userinfo.cardnum,system_userinfo.`name`,user_bank_account.bankNum,user_bank_account.bankName,user_bank_account.bankCName FROM hcpuhui.system_userinfo 
INNER JOIN hcpuhui.user_bank_account ON user_bank_account.userId = system_userinfo.userId
WHERE system_userinfo.userId = :userId AND user_bank_account.`status` = :status')
                ->bindValue(':userId', $arOdd['userId'])
                ->bindValue(':status', "1")
                ->queryOne();
        $arBankData['strUserPhone'] = $arUserBank['phone'];
        $arBankData['strUserCode'] = $arUserBank['cardnum'];
        $arBankData['strRealName'] = $arUserBank['name'];
        $arBankData['strBankNum'] = $arUserBank['bankNum'];
        $arBankData['strBankCode'] = $arUserBank['bankName'];
        $arBankData['strBankName'] = $arUserBank['bankCName'];
        (new WorkUserWithhold())->add($arUserBank['userId'], $arBankData);
        $arUserData['strUserId'] = $arUserBank['userId'];
        $arUserData['strPhone'] = $arUserBank['phone'];
        $arUserData['nickName'] = $arUserBank['name'];
        (new WorkUser())->add($arUserData);
    }

}
