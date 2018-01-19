<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\ancun;

/**
 * Description of OpsSignClient
 *
 * @author Administrator
 */
class OpsSignClient {
    /*     * 证件号 */

    public $identNo;
    /*     * 签章关键字 */
    public $keyWord;
    /*     * 签章文件 */
    public $fileName;

    function OpsSignClient($identNo, $keyWord, $fileName) {
        $this->identNo = $identNo;
        $this->keyWord = $keyWord;
        $this->fileName = $fileName;
    }

    public function getIdentNo() {
        return $this->identNo;
    }

    public function setIdentNo($identNo) {
        $this->identNo = $identNo;
    }

    public function getkeyWord() {
        return $this->keyWord;
    }

    public function setKeyWord($keyWord) {
        $this->keyWord = $keyWord;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

}