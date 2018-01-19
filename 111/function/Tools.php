<?php

class Tools {

    /**
     * 生成时间戳
     * @return type
     */
    public static function getTransid() {
        return strtotime(date('Y-m-d H:i:s', time()));
    }

    /**
     * 生成四位随机数
     * @return type
     */
    public static function getRand4() {
        return rand(1000, 9999);
    }

    /**
     * 生成四位随机数
     * @return type
     */
    public static function getTime() {
        return date('YmdHis', time());
    }

    /**
     * 明文请求参数
     * @return type
     */
    public static function getPostParm($txn_sub_type, $Encrypted) {

        if ($txn_sub_type == null || $txn_sub_type == "") {
            throw new Exception("方法：getPostParm，参数：txn_sub_type  异常为空！");
        }
        if ($Encrypted == null || $Encrypted == "") {
            throw new Exception("方法：getPostParm，参数：Encrypted  异常为空！");
        }

        $PostArry = array();
        $PostArry["version"] = $GLOBALS["version"];
        $PostArry["member_id"] = $GLOBALS["member_id"];
        $PostArry["terminal_id"] = $GLOBALS["terminal_id"];
        $PostArry["txn_type"] = $GLOBALS["txn_type"];
        $PostArry["txn_sub_type"] = $txn_sub_type;
        $PostArry["data_type"] = $GLOBALS["data_type"];
        $PostArry["data_content"] = $Encrypted;
        return $PostArry;
    }

}
