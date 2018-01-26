<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\WorkCollectRecord;
use app\modules\base\models\search\WorkCollectRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkCollectRecordController implements the CRUD actions for WorkCollectRecord model.
 */
class WorkCollectRecordController extends Controller {

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
     * Creates a new WorkCollectRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($oddNumber, $intPeriod) {
        $model = new WorkCollectRecord();
        if ($model->load(Yii::$app->request->post())) {
            $strUserId = Yii::$app->user->identity->strUserId;
            $model->add($strUserId, $oddNumber, $intPeriod, Yii::$app->request->post('WorkCollectRecord'));
            return $this->redirect(['create', 'oddNumber' => $oddNumber]);
        } else {
            $arData = $model->getAll($oddNumber, $intPeriod);
            return $this->render('create', [
                        'arData' => $arData,
                        'model' => $model,
            ]);
        }
    }

}
