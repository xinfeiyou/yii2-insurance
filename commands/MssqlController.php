<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\modules\base\models\OldMoneyList;
use app\modules\base\models\OldMoneyRecharge;
use app\modules\base\models\OldMoneyWithdraw;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MssqlController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionMoneyList() {
        try {
            $pdo_object = new \PDO("sqlsrv:Server=116.62.61.182,1444;Database=HCJF", "91hc", "Liuchenhui@2015#");
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        $sql = "SELECT TOP 5 T_FundRecord.*,T_Account.UserName,T_Account.RealName  FROM T_FundRecord
                LEFT JOIN T_Account ON T_FundRecord.AccountID = T_Account.AccountID";
        $pdo_statement_object = $pdo_object->prepare($sql);
        $pdo_statement_object->execute();
        $result = $pdo_statement_object->fetchAll(\PDO::FETCH_ASSOC);
        \Yii::$app->db->createCommand()->truncateTable('old_money_list')->execute();
        foreach ($result as $v) {
            $v['Money'] = round($v['Money'], 2);
            $model = new OldMoneyList();
            $model->create_data($model, $v);
        }
    }

    //充值记录
    public function actionMoneyRecharge() {
        try {
            $pdo_object = new \PDO("sqlsrv:Server=116.62.61.182,1444;Database=HCJF", "91hc", "Liuchenhui@2015#");
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        $sql = "SELECT T_RechargeRecord.*,T_Account.UserName,T_Account.RealName FROM T_RechargeRecord
                LEFT JOIN T_Account ON T_RechargeRecord.AccountID = T_Account.AccountID";
        $pdo_statement_object = $pdo_object->prepare($sql);
        $pdo_statement_object->execute();
        $result = $pdo_statement_object->fetchAll(\PDO::FETCH_ASSOC);
        \Yii::$app->db->createCommand()->truncateTable('old_money_recharge')->execute();
        foreach ($result as $v) {
            $v['Money'] = round($v['Money'], 2);
            $model = new OldMoneyRecharge();
            $model->create_data($model, $v);
        }
    }
    //提现记录
    public function actionMoneyWithdraw() {
        try {
            $pdo_object = new \PDO("sqlsrv:Server=116.62.61.182,1444;Database=HCJF", "91hc", "Liuchenhui@2015#");
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        $sql = "SELECT ST_WithdrawalApplication.*,T_Account.UserName,T_Account.RealName FROM ST_WithdrawalApplication
                LEFT JOIN T_Account ON ST_WithdrawalApplication.AccountID = T_Account.AccountID
                WHERE 1 = 1";
        $pdo_statement_object = $pdo_object->prepare($sql);
        $pdo_statement_object->execute();
        $result = $pdo_statement_object->fetchAll(\PDO::FETCH_ASSOC);
        \Yii::$app->db->createCommand()->truncateTable('old_money_withdraw')->execute();
        foreach ($result as $v) {
            $v['WithdrawableMoney'] = round($v['WithdrawableMoney'], 2);
            $v['WithdrawalDisableMoney'] = round($v['WithdrawalDisableMoney'], 2);
            $model = new OldMoneyWithdraw();
            $model->create_data($model, $v);
        }
    }
}
