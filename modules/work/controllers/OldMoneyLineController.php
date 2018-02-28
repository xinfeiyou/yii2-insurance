<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\OldMoneyLine;
use app\modules\base\models\search\OldMoneyLineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OldMoneyLineController implements the CRUD actions for OldMoneyLine model.
 */
class OldMoneyLineController extends Controller
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
     * Lists all OldMoneyLine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OldMoneyLineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
