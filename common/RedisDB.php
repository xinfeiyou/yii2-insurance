<?php

namespace app\common;

class RedisDB {

    public $redis = null;

    public function __toString() {
        return "Redis操作类";
    }

    public function __construct() {
        if (empty($this->redis)) {
            $this->redis = new \Redis();
            $this->redis->connect('119.23.200.69', 6379);
            $this->redis->auth('3DKxtkwswWPU');
        }
    }

    /**
     * 添加键值对
     * @param string $key       键名
     * @param string $value     键值
     * @return boolean
     */
    public function setString($key, $value) {
        return $this->redis->set($key, $value);
    }

    /**
     * 获取值
     * @param string $key       键名
     * @return string
     */
    public function getString($key) {
        return $this->redis->get($key);
    }

    /**
     * 删除键值
     * @param string $key       键名
     * @return boolean
     */
    public function delString($arKey) {
        return $this->redis->delete($arKey);
    }

    /**
     * 验证键值是否存在
     * @param string $key
     * @return boolean
     */
    public function ckString($key) {
        return $this->redis->exists($key);
    }

    /**
     * 针对制定key值自增1或$num
     * @param stirng $key       键名
     * @param int $num          数字
     * @return string           新的数字
     */
    public function setKeyIncr($key, $num = 0) {
        if (empty($num)) {
            return $this->redis->incr($key);
        } else {
            return $this->redis->incrBy($key, $num);
        }
    }

    /**
     * 针对制定key值自减1或$num
     * @param stirng $key       键名
     * @param int $num          数字
     * @return string           新的数字
     */
    public function setKeyDecr($key, $num = 0) {
        if (empty($num)) {
            return $this->redis->decr($key);
        } else {
            return $this->redis->decrBy($key, $num);
        }
    }

    /**
     * 入队列
     * @param string $key       队列名称
     * @param string $value     值
     * @return boolean
     */
    public function inQueue($key, $value) {
        return $this->redis->lPush($key, $value);
    }

    /**
     * 出队列
     * @param string $key       队列名称
     * @return string           出队列值
     */
    public function outQueue($key) {
        return $this->redis->rPop($key);
    }

    /**
     * 返回数组全部数据
     * @param string $key       队列名称
     * @return array
     */
    public function getQueue($key) {
        $num = $this->redis->lSize($key);
        return $this->redis->lrange($key, 0, $num);
    }

    /**
     * 清楚队列
     * @param string $key   队列名
     * @return array
     */
    public function outAllQueue($key) {
        $arData = [];
        $num = $this->redis->lSize($key);
        for ($i = 0; $i < $num; $i++) {
            $arData[$i] = $this->outQueue($key);
        }
        return $arData;
    }

    /**
     * 列出全部键名
     * @return array
     */
    public function getKeyList() {
        return $this->redis->keys("*");
    }

    /**
     * 写入hash数据
     * @param type $strHash
     * @param type $key
     * @param type $value
     * @return boolean
     */
    public function setHash($strHash, $key, $value) {
        if (empty($strHash) || empty($key)) {
            return false;
        }
        $this->redis->hSet($strHash, $key, $value);
        return true;
    }

    /**
     * 获取hash数据指定key值
     * @param type $strHash
     * @param type $key
     * @return boolean
     */
    public function getHash($strHash, $key) {
        if (empty($strHash) || empty($key)) {
            return false;
        }
        return $this->redis->hGet($strHash, $key);
    }

    /**
     * 验证hash数据指定key是否存在
     * @param type $strHash
     * @param type $key
     * @return boolean
     */
    public function ckHash($strHash, $key) {
        if (empty($strHash) || empty($key)) {
            return false;
        }
        return $this->redis->hExists($strHash, $key);
    }

    /**
     * 返回hash数据全部key
     * @param type $strHash
     * @return array
     */
    public function getHashKeyList($strHash) {
        return $this->redis->hKeys($strHash);
    }

    /**
     * 返回hash数据全部值
     * @param type $strHash
     * @return array
     */
    public function getHashValueList($strHash) {
        return $this->redis->hVals($strHash);
    }

    /**
     * 返回hash数据键值对数组
     * @param type $strHash
     * @return array
     */
    public function getHashList($strHash) {
        return $this->redis->hGetAll($strHash);
    }

    /**
     * 删除指定元素
     * @param type $strHash
     * @param type $key
     * @return type
     */
    public function delHash($strHash, $key) {
        return $this->redis->hDel($strHash, $key);
    }

    /**
     * 添加一个值到容器中,如果这个值存在返回false
     * @param string $key
     * @param string $value
     * @return boolean
     */
    public function setStore($key, $value) {
        return $this->redis->sAdd($key, $value);
    }

    /**
     * 移除容器中指定的值
     * @param type $key
     * @param type $value
     * @return boolean
     */
    public function delStore($key, $value) {
        return $this->redis->sRemove($key, $value);
    }

    /**
     * 检查value是否是容器中的成员
     * @param type $key
     * @param type $value
     * @return boolean
     */
    public function ckStore($key, $value) {
        return $this->redis->sismember($key, $value);
    }

    /**
     * 获取容器中的所以元素
     * @param type $key
     * @return array
     */
    public function getStore($key) {
        return $this->redis->sMembers($key);
    }

    /**
     * 关闭连接
     */
    public function close() {
        $this->redis->close();
    }

    public function __destruct() {
        $this->redis->close();
    }

}
