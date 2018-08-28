<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/24 0024 9:19
 * Email: brximl@163.com
 * Name: http(s)请求处理
 */

namespace sR;


class Response
{
    function __construct($param=array())
    {
    }

    /**
     * 地址请求
     * @param string|array $data
     */
    static function json($data){
        header('Content-type: application/json;');
        echo is_array($data)? json_encode($data): $data;
    }

    /**
     * @param string $xml
     * @param array $opt
     */
    static function xml($xml, $opt=array()){
        header('Content-type: application/xml;');
        $xml = '<?xml version="'.($opt['version'] ?? '1.0').'" encoding="'.
            ($opt['encoding'] ?? 'UTF-8').'"?>'. $xml
        ;
        echo $xml;
    }
}