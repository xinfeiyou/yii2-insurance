<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\WorkOddinterest;
use app\modules\base\models\WorkOddDeduct;
use app\modules\base\models\WorkUserWithhold;
use app\modules\base\models\search\WorkOddinterestSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\MathPayment;

/**
 * WorkOddinterestController implements the CRUD actions for WorkOddinterest model.
 */
class WorkOddinterestController extends BaseController {

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
     * Lists all WorkOddinterest models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new WorkOddinterestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkOddinterest model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WorkOddinterest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new WorkOddinterest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkOddinterest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * 代扣
     * @return type
     */
    public function actionDeduct($oddNumber, $intPeriod) {
        $model = WorkOddinterest::findOne(['oddNumber' => $oddNumber, 'intPeriod' => $intPeriod]);
        if (!empty(\Yii::$app->request->post('WorkOddinterest'))) {
            $strUserId = $model->strUserId;
            $fMoney = \Yii::$app->request->post('WorkOddinterest')['fMoney'];
            $objBank = WorkUserWithhold::findOne(['strUserId' => $strUserId]);
            $params['strPhone'] = $objBank->strUserPhone;
            $params['strName'] = $objBank->strRealName;
            $params['strBankCode'] = $objBank->strBankCode;
            $params['strBankNum'] = $objBank->strBankNum;
            $params['strCardNum'] = $objBank->strUserCode;
            $params['fMoney'] = $fMoney;
            $arData = \Yii::$app->runAction('/api/baofu/withhold-user-money', $params);
            switch (\Yii::$app->request->post('strField')) {
                case '本金':
                    $strField = 'fRealMonery';
                    break;
                case '利息':
                    $strField = 'fRealinterest';
                    break;
                case '罚息':
                    $strField = 'fSubsidy';
                    break;
            }
            if ('0000' == $arData['ret']) {
                (new WorkOddinterest())->editOddMoney($oddNumber, $intPeriod, $strField, $fMoney);
                (new WorkOddDeduct())->add($oddNumber, $intPeriod, $strField, $fMoney);
                \Yii::$app->runAction('/api/user/add-money-log', ['userId' => $strUserId, 'money' => $fMoney]);
                return $this->redirect(['deduct', 'oddNumber' => $oddNumber, 'intPeriod' => $intPeriod]);
            }
        }
        $arData = WorkOddDeduct::findAll(['oddNumber' => $oddNumber, 'intPeriod' => $intPeriod]);
        return $this->render('deduct', [
                    'model' => $model,
                    'arData' => $arData,
        ]);
    }

    /**
     * 计算器
     */
    public function actionCal() {
        $arData = [];
        if (!empty(Yii::$app->request->post())) {
            $arPost = Yii::$app->request->post('WorkOdd');
            $arDataAll = MathPayment::PayInterest($arPost['offlineMoney'], $arPost['offlineRate'], $arPost['oddBorrowPeriod'], 'month', $arPost['oddRepaymentStyle'], $arPost['oddBorrowTime']);
            $arData['list'] = $arDataAll['notes'];
            $arData['info'] = $arPost;
        }
        return $this->renderPartial('cal', ['arData' => $arData]);
    }

    /**
     * Finds the WorkOddinterest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkOddinterest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = WorkOddinterest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
