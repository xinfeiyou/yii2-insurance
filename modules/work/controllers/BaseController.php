<?php

namespace app\modules\work\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;

/**
 * WorkApplyController implements the CRUD actions for WorkApply model.
 */
class BaseController extends Controller {

    /**
     * 验证是否登录
     * @param type $action
     * @return boolean
     * @throws UnauthorizedHttpException
     */
    public function beforeAction($action) {
        if (\Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException('对不起，您现在还没获得此操作权限');
        } else {
            return true;
        }
        parent::beforeAction($action);
    }

}
