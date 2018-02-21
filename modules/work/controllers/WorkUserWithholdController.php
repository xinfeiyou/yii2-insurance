<?php

namespace app\modules\work\controllers;

use Yii;
use app\modules\base\models\WorkUserWithhold;
use app\modules\base\models\search\WorkUserWithholdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkUserWithholdController implements the CRUD actions for WorkUserWithhold model.
 */
class WorkUserWithholdController extends Controller {

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
     * Updates an existing WorkUserWithhold model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($strUserId) {
        $model = $this->findModel($strUserId);
        if(!empty(Yii::$app->request->post('WorkUserWithhold'))){
            $arPost = Yii::$app->request->post('WorkUserWithhold');
            $arPost['strStatus'] = "0";
            $model->edit_data($model, $arPost);
            return $this->redirect(['update', 'strUserId' => $model->strUserId]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Finds the WorkUserWithhold model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkUserWithhold the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($strUserId) {
        if (($model = WorkUserWithhold::findOne(['strUserId' => $strUserId])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
