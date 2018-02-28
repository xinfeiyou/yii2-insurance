<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\OldMoneyList;
use app\modules\base\models\search\OldMoneyListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OldMoneyListController implements the CRUD actions for OldMoneyList model.
 */
class OldMoneyListController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all OldMoneyList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OldMoneyListSearch();
        $Content = empty(\Yii::$app->request->get('Content'))?"":\Yii::$app->request->get('Content');
        $FundRecordType = empty(\Yii::$app->request->get('FundRecordType'))?"":\Yii::$app->request->get('FundRecordType');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$Content ,$FundRecordType);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single OldMoneyList model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the OldMoneyList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OldMoneyList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OldMoneyList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
