<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of Email
 *
 * @author Administrator
 */
class Email {

    /**
     * 设置密码重置信息
     * @param type $strEmail
     * @param type $strUrl
     * @return string 字符串
     */
    public function setEmailGetPass($strEmail, $strUrl) {
        $html = "<p>您好 {$strEmail}!</p>";
        $html .= "<p>您已经请求了重置密码，可以点击下面的链接来重置密码.</p>";
        $html .= "<p>{$strUrl}</p>";
        $html .= "<p>如果你没有请求重置密码，请忽略这封邮件.</p>";
        $html .= "<p>在你点击上面链接修改密码之前，你的密码将会保持不变.</p>";
        return $html;
    }

    /**
     * 设置确认注册信
     * @param type $strEmail
     * @param type $strOffName
     * @param type $strUrl
     * @return string
     */
    public function setEmailRegistConfirm($strEmail, $strOffName, $strUrl) {
        $tmp = explode('@', $strEmail);
        $html = "<p>亲爱的{$tmp[0]} 您好:</p>";
        $html .= "<p>恭喜您在{$strOffName}上注册成功.</p>";
        $html .= "<p>您的会员帐号是:{$tmp[0]}, 请您点击下面的邮件认证链接, 获取积分奖励.</p>";
        $html .= "<p>您邮件认证的链接是:{$strUrl},</p>";
        $html .= "<p>请<a href='{$strUrl}'>点击此链接</a>或在浏览器中输入此链接.</p>";
        $html .= "<p>{$strOffName} 客服中心.</p>";
        return $html;
    }

}
