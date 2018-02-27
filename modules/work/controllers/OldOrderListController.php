<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\OldOrderList;
use app\modules\base\models\search\OldOrderListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OldOrderListController implements the CRUD actions for OldOrderList model.
 */
class OldOrderListController extends Controller
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
     * Lists all OldOrderList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OldOrderListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all OldOrderList models.
     * @return mixed
     */
    public function actionList($ProjectID)
    {
        $searchModel = new OldOrderListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$ProjectID);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
