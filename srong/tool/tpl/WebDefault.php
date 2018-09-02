<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/2 0002 16:59
 * Email: brximl@163.com
 * Name:
 */

namespace app\http;


use sR\sR;

class Index
{
    /**
     * default action
     */
    public function index(){
        return [
            'verson'    => sR::Version,
            'release'   => sR::Release,
            'title'     => '欢迎使用， sR 框架'
        ];
    }
}