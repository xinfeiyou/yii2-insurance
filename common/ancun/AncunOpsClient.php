<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\ancun;

/**
 * version:1.1.1
 */
class AncunOpsClient {

    private $apiAddress;
    private $partnerKey;
    private $secret;

    function AncunOpsClient($apiAddress, $partnerKey, $secret) {
        $this->apiAddress = $apiAddress;
        $this->partnerKey = $partnerKey;
        $this->secret = $secret;
    }

    /**
     * 数据保全
     */
    function save($AncunOpsRequest) {
        $apiHost = "/preserve/save";
        $ancunOpsResponse = $this->post($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 获取保全数据列表
     */
    function getPreserveDataList($AncunOpsRequest) {
        $apiHost = "/preserve/list";
        $ancunOpsResponse = $this->send($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 获取保全数据详情
     */
    function getPreserveDetail($AncunOpsRequest) {
        $apiHost = "/preserve/detail";
        $ancunOpsResponse = $this->send($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 申请公证
     */
    function applyNotary($AncunOpsRequest) {
        $apiHost = "/notary/apply";
        $ancunOpsResponse = $this->send($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 取消公证
     */
    function cancelNotary($AncunOpsRequest) {
        $apiHost = "/notary/cancel";
        $ancunOpsResponse = $this->send($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * CA签章接口
     */
    function caSeal($AncunOpsRequest) {
        $apiHost = "/preserve/caSeal";
        $ancunOpsResponse = $this->post($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 获取印章信息
     */
    function obtainPersonSeal($AncunOpsRequest) {
        $apiHost = "/preserve/obtainPersonSeal";
        $ancunOpsResponse = $this->post($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 制作企业章
     */
    function awardCaForCompany($AncunOpsRequest) {
        $apiHost = "/preserve/awardCaForCompany";
        $ancunOpsResponse = $this->post($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 制作人名章
     */
    function awardCaForPersonal($AncunOpsRequest) {
        $apiHost = "/preserve/awardCaForPersonal";
        $ancunOpsResponse = $this->post($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 制作人名章(自定义印章图片)
     */
    function awardCaForPersonalWithPic($AncunOpsRequest) {
        $apiHost = "/preserve/awardCaForPersonalWithPic";
        $ancunOpsResponse = $this->post($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    /**
     * 获取公证省市
     */
    function getNotaryRegions($AncunOpsRequest) {
        $apiHost = "/notary/regions";
        $ancunOpsResponse = $this->send($this->apiAddress, $apiHost, $this->partnerKey, $this->secret, $AncunOpsRequest);
        return $ancunOpsResponse;
    }

    function send($apiAddress, $apiHost, $partnerKey, $secret, $AncunOpsRequest) {
        $data = "";
        $ancunOpsResponse = new AncunOpsResponse();
        $bussinsesData = $AncunOpsRequest->getData();
        $reqdata = json_encode($bussinsesData);
        $boundary = substr(md5(time()), 8, 16);
        //         print_r($bussinsesData);
        $md5 = md5($reqdata);
        $AncunOpsRequest->setMd5($md5);
        $content_array = (array) $AncunOpsRequest;
        $contents = json_encode($content_array);
        $sign_array = $bussinsesData;
        $data = $bussinsesData;
        $ContentType = "application/x-www-form-urlencoded; charset=ISO-8859-1";

        // print_r($data);
        $url = $apiAddress . $apiHost;
        $ch = curl_init();
        $date = date('Ymdhis', time());
        // print_r($bussinsesData);
        $sign = $this->sign($bussinsesData, $secret, $date);
        // echo $sign;

        $head = array(
            'Content-Type:' . $ContentType,
            'reqlength:' . strlen($data),
            'sign:' . $sign,
            'accessKey:' . $partnerKey,
            'reqTime:' . $date,
            'content-encoding:UTF-8',
            'sdkversion:php_1.0.0'
        ); // ,'sign:'.sign($this->apiparameter, $secretkey)
//         print_r($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $file_contents = curl_exec($ch);

        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);
        if ($curl_errno > 0) {
            $ancunOpsResponse->setMsg("系统维护中");
            $ancunOpsResponse->setCode(100010);
        } else {
            $data_content = json_decode($file_contents, true);
            $ancunOpsResponse->setMsg($data_content['msg']);
            $ancunOpsResponse->setCode($data_content['code']);
            $ancunOpsResponse->setData($data_content['data']);
        }
        return $ancunOpsResponse;
    }

    function post($apiAddress, $apiHost, $partnerKey, $secret, $AncunOpsRequest) {
        $data = "";
        $ancunOpsResponse = new AncunOpsResponse();
        $bussinsesData = $AncunOpsRequest->getData();
        $reqdata = json_encode($bussinsesData);
        $boundary = substr(md5(time()), 8, 16);
//         print_r($bussinsesData);
        $md5 = md5($reqdata);
        $AncunOpsRequest->setMd5($md5);
        $content_array = (array) $AncunOpsRequest;
        $contents = json_encode($content_array);
        $aospFiles = $AncunOpsRequest->getList();
        if (count($aospFiles) == 0) {
            $data = $bussinsesData;
            $ContentType = "multipart/form-data";
        } else {
            $array_keys = array_keys($bussinsesData);
            for ($i = 0; $i < count($array_keys); $i ++) {
                $data .= "--{$boundary}\r\n";
                $data .= "Content-Disposition: form-data; name=\"$array_keys[$i]\"\r\n";
                $data .= "\r\n{$bussinsesData[$array_keys[$i]]}\r\n";
            }
            $data .= "--{$boundary}\r\n";
            $ContentType = "multipart/form-data; charset=utf-8;boundary=" . $boundary;
            foreach ($aospFiles as $aospFile) {

                if ($aospFile->getFileFullPath() != null) {
                    $file = $aospFile->getFileFullPath();
                } else {
                    if ($aospFile->getFile() != null) {
                        $file = $aospFile->getFile();
                    }
                }
                $filename = basename($file);
                if (file_exists($file)) {
                    $length = filesize($file);
                    $suffix = substr(strrchr($file, '.'), 1); // 文件类型
                    $fileNameFAosp = urlencode($aospFile->getFileName() . "." . $suffix);
                    if ($aospFile->getEncryptionAlgorithm() != null) {
                        $fileNameFAosp = $fileNameFAosp . "_" . "encryptionAlgorithm" . $aospFile->getEncryptionAlgorithm();
                    }
                    $filestring = @ file_get_contents($file);
                    $data .= "--{$boundary}\r\n";
                    $data .= "Content-Disposition: form-data; name=\"$fileNameFAosp\"; filename=\"$filename\"\r\n";
                    $data .= "Content-Type: $suffix\r\n";
                    $data .= "\r\n$filestring\r\n";
//                     unlink($newfilename);
                    if ($filestring == "" || $filestring == null) {
                        $ancunOpsResponse->setMsg("保全附件" . $filename . "不存在,请选择正确的附件");
                        $ancunOpsResponse->setCode(110065);
                        return $ancunOpsResponse;
                    }
                } else {
                    $filename = $aospFile->getFileName();
                    $suffix = substr(strrchr($file, '.'), 1); // 文件类型
                    $handle = fopen($file, "rb");
                    $length = filesize($file);
                    $filestring = stream_get_contents($handle);
                    $newfilename = $filename . "." . $suffix;
                    file_put_contents('D:/' . $newfilename, $filestring);
                    $filestring = @file_get_contents("D:/" . $newfilename);
                    $data .= "--{$boundary}\r\n";
                    $data .= "Content-Disposition: form-data; name=\"$filename\"; filename=\"$filename\"\r\n";
                    $data .= "Content-Type: $suffix\r\n";
                    $data .= "\r\n$filestring\r\n";
                    fclose($handle);
                    unlink($newfilename);
                    if ($filestring == "" || $filestring == null) {
                        $ancunOpsResponse->setMsg("保全附件" . $filename . "不存在,请选择正确的附件");
                        $ancunOpsResponse->setCode(110065);
                        return $ancunOpsResponse;
                    }
                }
            }
            $data .= "\r\n--{$boundary}--\r\n";
        }
//         print_r($data);
        $url = $apiAddress . $apiHost;
        $ch = curl_init();
        $date = date('Ymdhis', time());
        // print_r($bussinsesData);
        $sign = $this->sign($bussinsesData, $secret, $date);
        // echo $sign;

        $head = array(
            'Content-Type:' . $ContentType,
            'reqlength:' . strlen($data['preserveData']),
            'sign:' . $sign,
            'accessKey:' . $partnerKey,
            'reqTime:' . $date,
            'sdkversion:php_1.0.0'
        ); // ,'sign:'.sign($this->apiparameter, $secretkey)
//         print_r($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $file_contents = curl_exec($ch);

        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);
        if ($curl_errno > 0) {
            $ancunOpsResponse->setMsg("系统维护中");
            $ancunOpsResponse->setCode(100010);
        } else {
            $data_content = json_decode($file_contents, true);
            $ancunOpsResponse->setMsg($data_content['msg']);
            $ancunOpsResponse->setCode($data_content['code']);
            $ancunOpsResponse->setData($data_content['data']);
        }
        return $ancunOpsResponse;
    }

    function sign($apiparameter, $secretkey, $reqtime) {
        // $apiparameter['req_time'] = $reqtime;
        ksort($apiparameter);
        $string = "";
        while (list ($key, $val) = each($apiparameter)) {
            if ($val != "") {
                if ($string == "") {
                    $string = $key . $val;
                } else {
                    $string = $string . $key . $val;
                }
            }
        }
        $sign = md5($secretkey . "reqTime" . $reqtime . $string);
        return $sign;
    }

}
