<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\WorkOddinterest;
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
