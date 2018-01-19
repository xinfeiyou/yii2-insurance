<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of FormField
 * 表单操作
 * @author Administrator
 */
class FormField {

    var $layout = true; //是否使用表格布局
    var $action; //表单要提交到的URL
    var $method;
    var $enctype = "";
    var $name = "";
    var $id = "";
    var $class = "";
    /**
     * 通过构造函数初始化成员变量
     * @param type $action
     * @param type $method
     */
    public function __construct($action, $method = "POST") {
        $this->action = $action;
        $this->method = $method;
    }
    /**
     * 表单头
     * @return string
     */
    public Function FormStart() {
        $text = "<form action=\"{$this->action}\" method=\"{$this->method}\"";
        if ($this->class !== "") {
            $text .= " class=\"{$this->class}\"";
        }
        if ($this->enctype !== "") {
            $text .= " enctype=\"{$this->enctype}\"";
        }
        if ($this->id !== "") {
            $text .= " id=\"{$this->id}\"";
        }
        if ($this->name !== "") {
            $text .= " name=\"{$this->name}\"";
        }
        $text .= ">\n";
        if ($this->layout == true) {
            $text .= "<table>\n";
        }
        return $text;
    }
    /**
     * 表单尾
     * @return string
     */
    public Function FormEnd() {
        if ($this->layout == true) {
            $text = "\t</table>\n";
            $text .= "</form>\n";
        } else {
            $text = "</form>\n";
        }
        return $text;
    }

    /**
     * 文本框函数
     * @param type $name
     * @param type $id
     * @param type $label_name
     * @param type $label_for
     * @param type $value
     * @return type
     */
    public Function FormText($name, $id, $label_name, $label_for, $value = "") {
        $text = "<input type=\"text\" name=\"{$name}\" ";
        $text .= "id=\"{$id}\" ";
        if (isset($value)) {
            $text .= "value=\"{$value}\" ";
        }
        $text .= "/>\n";
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 密码框函数
     * @param type $name
     * @param type $id
     * @param type $label_name
     * @param type $label_for
     * @param type $value
     * @return type
     */
    public Function FormPasswd($name, $id, $label_name, $label_for, $value = "") {
        $text = "<input type=\"password\" name=\"{$name}\" ";
        $text .= "id=\"{$id}\" ";
        if (isset($value)) {
            $text .= "value=\"{$value}\" ";
        }
        $text .= "/>\n";
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 隐藏域函数
     * @param type $name
     * @param type $id
     * @param type $label_name
     * @param type $label_for
     * @param type $value
     * @return type
     */
    public Function FormHidden($name, $id, $label_name, $label_for, $value = "") {
        $text = "<input type=\"hidden\" name=\"{$name}\" id=\"{$id}\" ";
        if (isset($value)) {
            $text .= "value=\"{$value}\" ";
        }
        $text .= "/>\n";
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 文件域函数
     * @param type $name
     * @param type $id
     * @param type $label_name
     * @param type $label_for
     * @param type $size
     * @return type
     */
    public Function FormFile($name, $id, $label_name, $label_for, $size = "") {
        $text = "<input type=\"file\" name=\"{$name}\" ";
        $text .= "id=\"{$id}\" ";
        if (isset($size)) {
            $text .= "size=\"{$size}\" ";
        }
        $text .= "/>\n";
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 复选框函数
     * @param type $name
     * @param type $label
     * @param type $label_name
     * @param type $label_for
     * @return type
     */
    public Function FormCheckbox($name, $label = array(), $label_name, $label_for = "") {
        $i = 0;
        $text = array();
        foreach ($label as $id => $value) {
            $text[$i] = "<input type=\"checkbox\" id=\"{$id}\" name=\"{$name}\" value=\"{$value}\" />";
            $text[$i] .= "<label for=\"{$id}\">{$value}</label>";
            $i++;
        }
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 单选框函数
     * @param type $name
     * @param type $label
     * @param type $label_name
     * @param type $label_for
     * @return type
     */
    public Function FormRadio($name, $label = array(), $label_name, $label_for = "") {
        $i = 0;
        $text = array();
        foreach ($label as $id => $value) {
            $text[$i] = "<input type=\"radio\" id=\"{$id}\" name=\"{$name}\" value=\"{$value}\" />";
            $text[$i] .= "<label for=\"{$id}\">{$value}</label>";
            $i++;
        }
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 下拉菜单函数
     * @param type $id
     * @param type $name
     * @param type $options
     * @param type $selected
     * @param type $label_name
     * @param type $label_for
     * @param type $onchange
     * @return type
     */
    public Function FormSelect($id, $name, $options = array(), $selected = false, $label_name, $label_for, $onchange = "") {
        if ($onchange !== "") {
            $text = "<select id=\"{$id}\" name=\"{$name}\" onchang=\"{$onchange}\">\n";
        } else {
            $text = "<select id=\"{$id}\" name=\"{$name}\">\n";
        }

        foreach ($options as $value => $key) {
            if ($selected == $value) {
                $text .= "\t<option valute=\"{$value}\" selected=\"selected\">{$key}</option>\n";
            } elseif ($selected === false) {
                $text .= "\t<option value=\"{$value}\">{$key}</option>\n";
            }
        }
        $text .= "</select>";
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 多选列表函数
     * @param type $id
     * @param type $name
     * @param type $size
     * @param type $options
     * @param type $label_name
     * @param type $label_for
     * @return type
     */
    public Function FormSelectmul($id, $name, $size, $options = array(), $label_name, $label_for) {
        $text = "<select id=\"{$id}\" name=\"{$name}\" size=\"{$size}\" multiple=\"multiple\">\n";
        foreach ($options as $value => $key) {
            $text .= "\t<option value=\"{$value}\">{$key}</option>\n";
        }
        $text .= "</select>\n";
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 按钮函数
     * @param type $id
     * @param type $name
     * @param type $type
     * @param type $value
     * @param type $onclick
     * @return string
     */
    public Function FormButton($id, $name, $type, $value, $onclick = "") {
        $text = "<button id=\"{$id}\" name=\"{$name}\" type=\"{$type}\"";
        if ($onclick !== "") {
            $text .= " onclick='{$onclick}'";
        }
        $text .= ">" . $value;
        $text .= "</button>\n";
        if ($this->layout == true) {
            $FormItem = "<tr>\n\t<th> </th><td>{$text}</td>\n</tr>\n";
        } else {
            $FormItem = $text;
        }
        return $FormItem;
    }

    /**
     * 文本域函数
     * @param type $id
     * @param type $name
     * @param type $cols
     * @param type $rows
     * @param type $label_name
     * @param type $label_for
     * @param type $value
     * @return type
     */
    public Function FormTextarea($id, $name, $cols, $rows, $label_name, $label_for, $value = "") {
        $text = "<textarea id=\"{$id}\" name=\"{$name}\" cols=\"{$cols}\" rows=\"{$rows}\">{$value}</textarea>\n";
        $label = $this->FormLabel($label_name, $label_for);
        $FormItem = $this->FormItem($label, $text);
        return $FormItem;
    }

    /**
     * 文字标签函数
     * @param type $text
     * @param type $for
     * @return string
     */
    public Function FormLabel($text, $for) {
        if ($for !== "") {
            $label = "<label for=\"{$for}\">{$text}：</label>";
        } else {
            $label = $text . "：";
        }
        return $label;
    }
    /**
     * 表单项目列表
     * @param type $FormLabel
     * @param type $form_text
     * @return type
     */
    public Function FormItem($FormLabel, $form_text) {
        switch ($this->layout) {
            case true:
                $text = "<tr>\n";
                $text .= "\t<th class=\"label\">";
                $text .= $FormLabel;
                $text .= "</th>\n";
                $text .= "\t<td>";
                $text .= $form_text;
                $text .= "</td>\n";
                $text .= "</tr>\n";
                break;
            case false:
                $text = $FormLabel;
                $text .= $form_text;
                break;
        }
        return $text;
    }
    /**
     * 创建完整表单
     * @param type $FormItem
     */
    public Function CreateForm($FormItem = array()) {
        echo $this->FormStart();
        foreach ($FormItem as $item) {
            echo $item;
        }
        echo $this->FormEnd();
    }

}

/*
require_once("form.php");
$form=new form($_SERVER['PHP_SELF']);     //提交到本页
$form->layout=false;                      //不使用表格布局，大家可以把这句注释掉看结果有何不同
$name=$form->form_text("userid","userid","用户名","userid");
$passwd=$form->form_passwd("passwd","passwd","密码","passwd");
$submit=$form->form_button("","submit","submit","登录");
$form_item=array($name,$passwd,$submit);
$form->CreateForm($form_item);
*/
