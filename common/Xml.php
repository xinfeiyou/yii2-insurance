<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common;

/**
 * Description of Xml
 *
 * @author Administrator
 */
class Xml {

    /**
     * 数组转xml
     * @param type $arr
     * @param DOMDocument $dom
     * @param type $item
     * @return type string
     */
    public static Function ArrayToXml($arr, $dom = 0, $item = 0) {
        if (!$dom) {
            $dom = new \DOMDocument("1.0", "utf-8");
        }
        if (!$item) {
            $item = $dom->createElement("root");
            $dom->appendChild($item);
        }
        foreach ($arr as $key => $val) {
            $itemx = $dom->createElement(is_string($key) ? $key : "item");
            $item->appendChild($itemx);
            if (!is_array($val)) {
                $text = $dom->createTextNode($val);
                $itemx->appendChild($text);
            } else {
                self::ArrayToXml($val, $dom, $itemx);
            }
        }
        $xml = $dom->saveXML();
        $tmp = explode("\n", $xml);
        $xmlstring = "";
        foreach ($tmp as $val) {
            $xmlstring .= $val;
        }
        return $xmlstring;
    }

    /**
     * xml转数组
     * @param type $xmlstring
     * @return type array
     */
    public static Function XmlToArray($xmlstring) {
        $tmp = explode("\n", $xmlstring);
        $xmlstring = "";
        foreach ($tmp as $val) {
            $xmlstring .= trim($val);
        }
        $xml_parser = xml_parser_create();
        if (!xml_parse($xml_parser, $xmlstring, true)) {
            xml_parser_free($xml_parser);
            return false;
        } else {
            return json_decode(json_encode(simplexml_load_string($xmlstring, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        }
    }

}
