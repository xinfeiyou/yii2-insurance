<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\WorkOdd;
use app\modules\base\models\search\WorkOddSearch;
use app\modules\base\models\WorkOddinterest;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkOddController implements the CRUD actions for WorkOdd model.
 */
class WorkOddController extends BaseController {

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
     * Lists all WorkOdd models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new WorkOddSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkOdd model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing WorkOdd model.
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
     * Deletes an existing WorkOddinterest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionEditOffMoney($strOddNum) {
        $model = (new WorkOdd())->getOddInfo($strOddNum);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['edit-off-money', 'strOddNum' => $strOddNum]);
        } else {
            $arInterest = (new WorkOddinterest())->getOddNumToOddinterest($strOddNum);
            return $this->render('edit-off-money', [
                        'model' => $model,
                        'arInterest' => $arInterest,
            ]);
        }
    }

    /**
     * 生成还款明细
     */
    public function actionReloadOnlineInterest($strOddNum) {
        $model = (new WorkOdd())->getOddInfo($strOddNum);
        $oddRepaymentStyle = 1;
        switch ($model->oddRepaymentStyle) {
            case 'monthpay': $oddRepaymentStyle = 1;
                break;
            case 'matchpay': $oddRepaymentStyle = 3;
                break;
        }
        $arReturn = (new WorkOddinterest())->editOddOffLineInterest($strOddNum, $model->offlineMoney, $model->offlineRate, $model->oddBorrowPeriod, $oddRepaymentStyle);
        return $this->redirect(['edit-off-money', 'strOddNum' => $strOddNum]);
    }

    /**
     * Finds the WorkOdd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkOdd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = WorkOdd::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
