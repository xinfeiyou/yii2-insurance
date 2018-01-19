<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\ancun;

/**
 * Description of ClientUser
 *
 * @author Administrator
 */
class ClientUser {

    public $userIdcard;
    public $userMobile;
    public $userTruename;

    public function getUserIdcard() {
        return $this->userIdcard;
    }

    public function setUserIdcard($userIdcard) {
        $this->userIdcard = $userIdcard;
    }

    public function getUserMobile() {
        return $this->userMobile;
    }

    public function setUserMobile($userMobile) {
        $this->userMobile = $userMobile;
    }

    public function getUserTruename() {
        return $this->userTruename;
    }

    public function setUserTruename($userTruename) {
        $this->userTruename = $userTruename;
    }

}
