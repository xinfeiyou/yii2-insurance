<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\OldOrderList;
use app\modules\base\models\search\OldOrderListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\base\models\OldUserInvestAll;
use app\modules\base\models\OldProjectList;
use app\modules\base\models\NewUserInvest;
use app\common\MathPayment;

/**
 * OldOrderListController implements the CRUD actions for OldOrderList model.
 */
class OldOrderListController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OldOrderList models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new OldOrderListSearch();
        $ProjectID = empty(\Yii::$app->request->get('ProjectID')) ? "" : \Yii::$app->request->get('ProjectID');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $ProjectID);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOldUserInvest() {
        $arUserInvest = OldUserInvestAll::find()
                ->all();
        foreach ($arUserInvest as $v) {
            $rate = $v->MonthlyReturnRate * 12 / 100;
            $type = ('0' == $v->RepaymentType) ? '3' : '1';
            $arMoney = MathPayment::PayInterest($v->fMoney, $rate, $v->RepaymentDuration, 'month', $type);
            $user = OldUserInvestAll::findOne(['id'=>$v->id]);
            $user->fLixi = $arMoney['yingli'];
            $user->save();
        }
    }
    public function actionNewUserInvest(){
        $arUserInvest = NewUserInvest::find()
                ->all();
        foreach ($arUserInvest as $v) {
            $type = ('monthpay' == $v->oddRepaymentStyle) ? '1' : '3';
            $arMoney = MathPayment::PayInterest($v->money, $v->oddYearRate, $v->oddBorrowPeriod, 'month', $type);
            if(!empty($v->qishu)){
                $benjin = $arMoney['notes'][1]['benjin'];
                $lixi = $arMoney['notes'][1]['lixi'];
            }else{
                $benjin = 0.00;
                $lixi = 0.00;
            }
            $oddLixi = $arMoney['yingli'];
            $user = NewUserInvest::findOne(['id'=>$v->id]);
            $user->benjin = $benjin;
            $user->lixi = $lixi;
            $user->oddLixi = $oddLixi;
            $user->save();
        }
        echo 'OK';
    }
    
    public function actionOldProjectList(){
        $arProject = OldProjectList::find()
                ->select(['ProjectID','Title','TargetAmount','MonthlyReturnRate','RepaymentDuration','RepaymentType'])
                ->where(['ProjectState'=>'6'])
                ->andWhere(['<','FundraisingBeginTime','2018-01-01 00:00:00'])
                //->asArray()
                ->all();
        $sMoney = 0;
        $sLixi = 0;
        foreach ($arProject as $v) {
            $rate = $v->MonthlyReturnRate * 12 / 100;
            $type = ('0' == $v->RepaymentType) ? '3' : '1';
            $arMoney = MathPayment::PayInterest($v->TargetAmount, $rate, $v->RepaymentDuration, 'month', $type);
            $sMoney += $v->TargetAmount;
            $sLixi += $arMoney['yingli'];
        }
        echo $sMoney.'--'.$sLixi;
    }
    
}
