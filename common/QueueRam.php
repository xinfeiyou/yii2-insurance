<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of QueueRam
 *
 * @author Administrator
 */
class QueueRam {

    public $queue = array();

    /**
     * （尾部）入队
     * @param type $value
     * @return type
     */
    public function AddLast($value) {
        return array_push($this->queue, $value);
    }

    /**
     * （尾部）出队
     * @return type
     */
    public function RemoveLast() {
        return array_pop($this->queue);
    }

    /**
     * （头部）入队
     * @param type $value
     * @return type
     */
    public function AddFirst($value) {
        return array_unshift($this->queue, $value);
    }

    /**
     * （头部）出队
     * @return type
     */
    public function RemoveFirst() {
        return array_shift($this->queue);
    }

    /**
     * 清空队列
     */
    public function ClearEmpty() {
        unset($this->queue);
    }

    /**
     * 获取列头
     * @return type
     */
    public function GetFirst() {
        return reset($this->queue);
    }

    /**
     * 获取列尾
     * @return type
     */
    public function GetLast() {
        return end($this->queue);
    }

    /**
     * 获取队列位置
     * @param type $value
     * @return type
     */
    public function GetQueueLocation($value) {
        $key = array_search($value, $this->queue);
        return $key;
    }

    /**
     * 获取长度
     * @return type
     */
    public function GetLength() {
        return count($this->queue);
    }

}
