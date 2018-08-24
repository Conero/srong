<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/24 0024 9:18
 * Email: brximl@163.com
 * Name: http(s)请求处理
 */

namespace sR;


class Request
{
    function __construct($param=array())
    {
    }

    /**
     * 获取方法： get/post
     * @return string
     */
    static function method(){
        return strtolower($_SERVER['REQUEST_METHOD'] ?? '');
    }
}