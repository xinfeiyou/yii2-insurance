<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\ancun;

/**
 * Description of OpsStrategyInfo
 *
 * @author Administrator
 */
class OpsStrategyInfo {

    /** 在第几页签章 */
    public $page;

    /** 签章的坐标X */
    public $positionX;

    /** 签章的坐标Y */
    public $positionY;
    /*     * 签章主体人的证件号 */
    public $identityNo;

    function OpsStrategyInfo($page, $positionX, $positionY, $identityNo) {
        $this->page = $page;
        $this->positionX = $positionX;
        $this->positionY = $positionY;
        $this->identityNo = $identityNo;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $this->page = $page;
    }

    public function getPositionX() {
        return $this->positionX;
    }

    public function setPositionX($positionX) {
        $this->positionX = $positionX;
    }

    public function getPositionY() {
        return $this->positionY;
    }

    public function setPositionY($positionY) {
        $this->positionY = $positionY;
    }

    public function getIdentityNo() {
        return $this->identityNo;
    }

    public function setIdentityNo($identityNo) {
        $this->identityNo = $identityNo;
    }

}
