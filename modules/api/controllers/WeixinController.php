<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\controllers\BaseController;
use app\common\Files;
use app\common\EleRedPack;
use app\common\Weixin;

/**
 * Default controller for the `api` module
 */
class WeixinController extends BaseController {

    public $cookieData = ''; //登录公众平台的cookie
    public $cookieName = 'weixin_cookie.txt';
    public $strTitle = '微信公众号';

    /**
     * 服务号入口
     */
    public function actionIndex() {
        $weixin = new Weixin(\Yii::$app->params['weixin']['appUser'], \Yii::$app->params['weixin']['appPass']);
        $json = $weixin->sendUserMsg('o4-aI0VAqHij2ClnZ-S2b0by4OMw', '测试是否能发信息');
        print_r($json);
        exit();
        $arMsg = json_decode($json, true);
        if ('ok' != $arMsg['base_resp']['err_msg']) {
            exit('登录失败');
        }
        exit('OK');
        if (!empty(\Yii::$app->request->get('echostr'))) {
            $this->checkSignature(\Yii::$app->request->get('echostr')); //验证数据
        } else {
            //$postStr = \Yii::$app->request->getRawBody(); // 替换 $GLOBALS["HTTP_RAW_POST_DATA"];
            $postStr = '<xml><ToUserName><![CDATA[gh_04a844bb0fdd]]></ToUserName><FromUserName><![CDATA[o4-aI0VAqHij2ClnZ-S2b0by4OMw]]></FromUserName><CreateTime>1520260304</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[https://h5.ele.me/hongbao/#hardware_id=&is_lucky_group=True&lucky_number=10&track_id=&platform=0&sn=29e9a1479139a0c3&theme_id=2233&device_id=]]></Content><MsgId>6529468287506454312</MsgId></xml>';
            $this->responseMsg($postStr); //处理数据
        }
    }

    /**
     * 验证数据
     * @return boolean
     */
    public function checkSignature($echostr) {
        $signature = \Yii::$app->request->get('signature');
        $timestamp = \Yii::$app->request->get('timestamp');
        $nonce = \Yii::$app->request->get('nonce');
        $token = \Yii::$app->params['weixin']['appToken'];
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            echo $echostr;
            exit();
        } else {
            exit();
        }
    }

    /**
     * 接收数据
     */
    public function responseMsg($postStr) {
        //$postStr = '<xml><ToUserName><![CDATA[gh_e9cf364a02cb]]></ToUserName><FromUserName><![CDATA[o_HnUt7CiUQczh8C_f1tYbsPpSmo]]></FromUserName><CreateTime>1456197615</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[CLICK]]></Event><EventKey><![CDATA[list_year]]></EventKey></xml>';
        Files::writeFileLog('weixin_log', $postStr);
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = strtolower(trim($postObj->MsgType));
            $keyword = strtolower(trim($postObj->Content));
            $keyword = str_replace('：', ':', $keyword);
            $resultStr = $this->message($RX_TYPE, $postObj, $keyword);
            Files::writeFileLog('weixin_log', $resultStr);
            echo $resultStr;
            exit();
        }
    }

    /**
     * 处理消息
     * @param type $RX_TYPE 消息类型
     * @param type $postObj 数据对象
     * @param type $keyword 文本内容
     * @return string
     */
    public function message($RX_TYPE, $postObj, $keyword) {
        switch ($RX_TYPE) {
            case 'text':
                if (strpos($keyword, 'ele.me/hongbao')) {
                    $content = (new EleRedPack())->GetEleMaxRedPack('18779970815', $keyword);
                } else {
                    $content = $keyword;
                }
                $resultStr = $this->GetTypeBuildXML('text', $postObj, $content);
                break;
            case 'event':
                $eventTyp = strtolower(trim($postObj->Event));
                $eventKey = strtolower(trim($postObj->EventKey));
                switch ($eventTyp) {
                    case "subscribe"://关注
                        break;
                    case "unsubscribe":
                        $content = "取消关注";
                        break;
                    case "click":
                        break;
                }
                break;
            case 'location':
                $locationX = strtolower(trim($postObj->Location_X));
                $locationY = strtolower(trim($postObj->Location_Y));
                $adder = strtolower(trim($postObj->Label));
                $content = "经纬度:" . $locationX . "," . $locationY . "地址" . $adder;
                break;
            default :
                $resultStr = "";
        }
        return $resultStr;
    }

    /*
     * 构建相应的XML代码
     */

    public function GetTypeBuildXML($type, $object, $content = "") {
        switch ($type) {
            case 'text': $xml = $this->buildTextXml($object, $content);
                break;
            case 'jpgText':$xml = $this->buildImageATextXml($object, $content);
                break;
            case 'music': $xml = $this->buildMusicXml($object, $content);
                break;
            default : $xml = '';
        }
        return $xml;
    }

    /*
     * 返回 text xml代码段
     */

    public function buildTextXml($object, $content) {
        $rand = time() . rand(1000, 9999);
        $headerStr = $this->buildHeaderToXml('text', $object);
        $result = '<xml>' . $headerStr . '<Content><![CDATA[' . $content . ']]></Content><MsgId>' . $rand . '</MsgId></xml>';
        return $result;
    }

    /*
     * 返回 image&text  xml代码段
     * $titleArray = array(array('Title'=>'标题','Description'=>'描述','PicUrl'=>'图片链接，支持JPG、PNG格式，较好的效果为大图360*200，小图200*200','Url'=>'点击图文消息跳转链接'));
     * 列表数不要超过10条
     */

    public function buildImageATextXml($object, $titleArray) {
        $count = count($titleArray);
        $itemStr = "";
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $itemStr .= "<item>";
                foreach ($titleArray[$i] as $key => $val) {
                    if ($count > 1) {
                        if ($key != 'Description')
                            $itemStr .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
                    } else {
                        $itemStr .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
                    }
                }
                $itemStr .= "</item>";
            }
            $headerStr = $this->buildHeaderToXml('news', $object);
            $result = '<xml>' . $headerStr . '<ArticleCount>' . $count . '</ArticleCount><Articles>' . $itemStr . '</Articles></xml>';
        } else {
            $result = "";
        }
        return $result;
    }

    /*
     * array('Title'=>'最炫民族风','Description'=>'凤凰传奇','MusicUrl'=>'音乐链接 ','HQMusicUrl'=>'高质量音乐链接');
     * 返回 音乐 xml代码
     */

    public function buildMusicXml($object, $musicArray) {
        if (is_array($musicArray) AND ! empty($musicArray)) {
            $musicStr = $this->buildItemArrToXml('Music', $musicArray);
            $headerStr = $this->buildHeaderToXml('music', $object);
            $result = '<xml>' . $headerStr . $musicStr . '<FuncFlag>0</FuncFlag></xml>';
        } else {
            $result = "";
        }
        return $result;
    }

    /*
     * 公共函数 生成头XML
     */

    public function buildHeaderToXml($type, $object) {
        $xmlTpl = '<ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType>';
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $type);
        return $result;
    }

    /*
     * 公共函数 列表生成
     */

    public function buildItemArrToXml($type, $ItemArray) {
        $xmlStr = '<' . $type . '>';
        foreach ($ItemArray as $key => $value) {
            $xmlStr .= '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>';
        }
        $xmlStr .= '</' . $type . '>';
        return $xmlStr;
    }
}
