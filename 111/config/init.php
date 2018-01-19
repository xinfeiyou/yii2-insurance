<?php

$path_base = dirname(__DIR__);
$path_cer = $path_base . "/cer/";
require_once($path_base."/function/BFRSA.php");
require_once($path_base."/function/SdkXML.php");
require_once($path_base."/function/Log.php");
require_once($path_base."/function/Tools.php");
require_once($path_base."/function/HttpClient.php");
Log::LogWirte("=================安全服务验证=====================");
//====================配置商户的宝付接口授权参数==============
$version = "4.0.0.0";//版本号
$member_id = "100000276";	//商户号
$terminal_id = "100000990";	//终端号
$data_type="json";//加密报文的数据类型（xml/json）
$txn_type = "0431";//交易类型
$private_key_password = "123456";	//商户私钥证书密码
$pfxfilename = $path_cer."bfkey_100000276@@100000990.pfx";  //注意证书路径是否存在
$cerfilename = $path_cer."bfkey_100000276@@100000990.cer";//注意证书路径是否存在

$request_url = "https://vgw.baofoo.com/cutpayment/api/backTransRequest";  //测试环境请求地址
//$request_url = "https://public.baofoo.com/livesplatform/api/backTransRequest";  //正试环境请求地址

if(!file_exists($pfxfilename))
{
    die("私钥证书不存在！<br>");
}
if(!file_exists($cerfilename))
{
    die("公钥证书不存在！<br>");
}

