<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of Files
 *
 * @author Administrator
 */
class Files {

    /**
     * 读取文件
     * @param string $fFileName
     * @return type
     */
    static Function readFile($fFileName) {
        $string = file_get_contents($fFileName);
        return $string;
    }

    /**
     * 写日志文件
     * @param string $fFileName     文件名称
     * @param type $fContent        文件内容
     * @param type $fTag            写入方式
     * @return boolean
     */
    public static function writeFileLog($fFileName, $fContent, $fTag = 'a') {
        $fFileName = \Yii::$app->basePath . '/runtime/logs/' . $fFileName . '_log' . date("Ymd") . '.txt';
        ignore_user_abort(TRUE);
        if (!file_exists($fFileName)) {
            $fp = fopen($fFileName, 'w');
        } else {
            $fp = fopen($fFileName, 'a');
        }
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, date("Y-m-d H:i:s") . "=>" . $fContent . "\n");
            flock($fp, LOCK_UN);
        }
        fclose($fp);
        ignore_user_abort(FALSE);
        return true;
    }

    /**
     * 删除文件夹，及下面的文件
     * @param string $dir
     * @return boolean
     */
    public static Function delFolder($dir) {
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
        closedir($dh);
        return true;
        /* if (rmdir($dir)){
          return true;
          } else {
          return false;
          } */
    }

    /**
     * 存图片到本地
     * @param type $imageData
     */
    public static Function writeFile($strName, $fContent, $fTag = 'a') {
        $fFileName = \Yii::$app->basePath . '/web/upload/weixin/' . $strName;
        ignore_user_abort(TRUE);
        $fp = fopen($fFileName, $fTag);
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $fContent);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
        ignore_user_abort(FALSE);
        return true;
    }

}
