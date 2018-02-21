<?php

namespace app\modules\work\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;
use app\common\NetWork;

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
//
//    /**
//     * 签名
//     * @param array $params 参数
//     * @return string sign密文
//     */
//    public function getEncryptDataResult($code, $arData) {
//        $paramsFilter = $this->paramsFilter($arData);
//        $paramsSort = $this->paramsSort($paramsFilter);
//        $paramsLinkString = $this->createLinkString($paramsSort);
//        $sign = md5($paramsLinkString . Yii::$app->params['on_line']['authKey']);
//        $urlParam = '';
//        foreach ($arData as $k => $v) {
//            $urlParam .= '&' . $k . '=' . $v;
//        }
//        $url = \Yii::$app->params['on_line']['api_url'] . '/' . $code . '?sign=' . $sign . $urlParam;
//        $strResult = NetWork::GetUrl($url);
//        $strResult = empty($strResult) ? "" : $strResult;
//        return $strResult;
//    }
//
//    /**
//     * 除去数组中的空值和签名参数
//     * @param   array   $params   签名参数组
//     * @return  array             去掉空值与签名参数后的新签名参数组
//     */
//    public function paramsFilter($params, $signKey = 'sign') {
//        $params_filter = array();
//        while (list ($key, $val) = each($params)) {
//            if ($key == $signKey || $val == '') {
//                continue;
//            } else {
//                $params_filter[$key] = $params[$key];
//            }
//        }
//        return $params_filter;
//    }
//
//    /**
//     * 对数组排序
//     * @param array $params  排序前的数组
//     * @param array $isDelEmpty
//     * @return array
//     */
//    public function paramsSort($params, $isDelEmpty = false) {
//        ksort($params);
//        reset($params);
//        if ($isDelEmpty) {
//            foreach ($params as $key => $value) {
//                if ($value === '' || $value === null) {
//                    unset($params[$key]);
//                }
//            }
//        }
//        return $params;
//    }
//
//    /**
//     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
//     * @param array $params 需要拼接的数组
//     * @return string       拼接完成以后的字符串
//     */
//    public function createLinkString($params) {
//        $arg = "";
//        while (list ($key, $val) = each($params)) {
//            if (is_array($val)) {
//                $val = implode(',', $val);
//            }
//            $arg .= $key . "=" . $val . "&";
//        }
//        //去掉最后一个&字符
//        $arg = substr($arg, 0, count($arg) - 2);
//        //如果存在转义字符，那么去掉转义
//        if (get_magic_quotes_gpc()) {
//            $arg = stripslashes($arg);
//        }
//        return $arg;
//    }
}
