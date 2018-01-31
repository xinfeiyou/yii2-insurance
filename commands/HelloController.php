<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\modules\base\models\WorkConfig;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller {

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world') {
        echo $message . "\n";
    }

    public function actionToken() {
        echo $this->getToken();
    }

    /**
     * 更新token值
     * @return type
     */
    public function getToken() {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . \Yii::$app->params['appId'] . "&secret=" . \Yii::$app->params['appSecret'];
        //$json = '{"access_token":"6_BcxREiAaFsFf8A6MJmW1YfeRUK13ku_E0d9RltpuNhZsG0pCzqtH1SFe1iOYHowpKCwgTUZ4v_u4PJmgc9WjBNdJeFmXW1ouRSv9-NYPhJYOMbf1yp5Dh1Sr1KLOBpUWX0F83MzqWAyPOBd5THThAGAHVH","expires_in":7200}';
        $json = file_get_contents($url);
        $arData = json_decode($json, true);
        if(!empty($arData['access_token'])){
            return (new WorkConfig())->editKeyToValue('strToken', $arData['access_token']);
        }else{
            return $json;
        }
    }

}
