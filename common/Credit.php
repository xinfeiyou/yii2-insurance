<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of Credit
 *
 * @author Administrator
 */
class Credit {
        /**
     * 查下法案
     * @author panda Liu <admin@xinfeiyou.com>
     * @param type $realName 真实姓名
     * @param type $idCard   身份证号码
     * @throws file_get_contents 获取 https 记得开启php_openssl.dll
     */
    public function searchFaan($realName, $idCard)
    {
        $strMsg = '查询失信人';
        $strTitle = '查询失信人';
        $data['_'] = time();
        $data['areaName'] = "";
        $data['cardNum'] = $idCard;    //身份证
        $data['cd'] = "data" . rand(10000, 99999);
        $data['format'] = 'json';
        $data['ie'] = 'utf-8';
        $data['inname'] = $realName;      //真实姓名
        $data['query'] = '失信被执行人名单';
        $data['resource_id'] = '6899';
        $data['t'] = time();
        $url = 'https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?oe=utf-8';
        foreach ($data as $key => $val) {
            $url .= '&' . $key . '=' . $val;
        }
        $file = file_get_contents($url);
        $arrData = json_decode($file, true);
        if (empty($arrData['data'])) {
            return $this->SetBoolMsg($strTitle, $strMsg, true);
        } else {
            $n = count($arrData['data']['0']['result']);
            if ($n > 1) {
                foreach ($arrData['data']['0']['result'] as $v) {
                    /////待开发中
                }
                return $this->SetBoolMsg($strTitle, $strMsg, true);
            }
        }
    }
}
