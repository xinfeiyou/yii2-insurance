<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\WorkApply;
use app\modules\base\models\search\WorkApplySearch;
use app\modules\base\models\WorkOddinterest;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkApplyController implements the CRUD actions for WorkApply model.
 */
class WorkApplyController extends Controller {

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
     * Lists all WorkApply models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new WorkApplySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkApply model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WorkApply model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new WorkApply();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkApply model.
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
    public function actionEditOffMoney($strWorkNum) {
        $model = (new WorkApply())->getApplyInfo($strWorkNum);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $arPost = \Yii::$app->request->post('WorkApply');
            $oddRepaymentStyle = 1;
            switch ($arPost['oddRepaymentStyle']) {
                case 'monthpay': $oddRepaymentStyle = 1;
                    break;
                case 'matchpay': $oddRepaymentStyle = 3;
                    break;
            }
            (new WorkOddinterest())->editWorkOffLineInterest($strWorkNum, $arPost['offlineMoney'], $arPost['offlineRate'], $arPost['oddBorrowPeriod'], $oddRepaymentStyle);
            return $this->redirect(['edit-off-money', 'strWorkNum' => $strWorkNum]);
        } else {
            $arInterest = (new WorkOddinterest())->getWorkNumToOddinterest($strWorkNum);
            return $this->render('edit-off-money', [
                        'model' => $model,
                        'arInterest' => $arInterest,
            ]);
        }
    }

    /**
     * Finds the WorkApply model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkApply the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = WorkApply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
