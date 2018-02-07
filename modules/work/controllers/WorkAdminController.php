<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\WorkAdmin;
use app\modules\base\models\search\WorkAdminSearch;
use app\modules\work\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\filters\VerbFilter;

/**
 * WorkAdminController implements the CRUD actions for WorkAdmin model.
 */
class WorkAdminController extends BaseController {

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
     * Lists all WorkAdmin models.
     * @return mixed
     */
    public function actionIndex() {
        if (empty(Yii::$app->user->identity->EIsAdmin)) {
            throw new UnauthorizedHttpException('你无权操作');
        }
        $searchModel = new WorkAdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new WorkAdmin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (empty(Yii::$app->user->identity->EIsAdmin)) {
            throw new UnauthorizedHttpException('你无权操作');
        }
        $model = new WorkAdmin();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkAdmin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($username) {
        $model = $this->findModel($username);
        if (!empty(Yii::$app->request->post())) {
            $model->edit($model, Yii::$app->request->post('WorkAdmin'));
            return $this->redirect(['update', 'username' => $model->username]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WorkAdmin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        if (empty(Yii::$app->user->identity->EIsAdmin)) {
            throw new UnauthorizedHttpException('你无权操作');
        }
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkAdmin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkAdmin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($username) {
        if (($model = WorkAdmin::findOne(['username' => $username])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
