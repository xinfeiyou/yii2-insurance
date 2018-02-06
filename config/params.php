<?php

return [
    'adminEmail' => 'admin@example.com',
    'appId' => 'wxdce69c2e12bdbef2',
    'appSecret' => '22478d6523f635cfe90f44cf97002ec2',
    'openTencentKey' => 'GUGBZ-VLRC3-R2N3V-YXBTW-VWKA2-QXBYH', //腾讯开放平台key
    'api_url' => 'https://www.hcjrfw.com',
    'baofu' => [
        'version' => '4.0.0.0',
        'member_id' => "1191123", //商户号
        'terminal_id' => "36452", //终端号
        'data_type' => "json", //加密报文的数据类型（xml/json）
        'txn_type' => "0431", //交易类型
        'private_key_password' => "Hcjrfw", //商户私钥证书密码
        'pfx_file_name' => dirname(__DIR__) . '/common/baofu/cer/baofu.pfx',
        'cer_file_name' => dirname(__DIR__) . '/common/baofu/cer/baofu.cer',
        'url' => 'https://public.baofoo.com/cutpayment/api/backTransRequest',
    ],
];
