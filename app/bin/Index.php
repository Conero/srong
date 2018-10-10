<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/2 0002 16:59
 * Email: brximl@163.com
 * Name:
 */

namespace app\bin;


use tool\clisr\Home;
use tool\CliSrAbstract;

class Index extends CliSrAbstract
{
    /**
     * default action
     */
    public function index(){
        echo self::Border
            . self::H1. '欢迎使用 srong.phar'
            . self::T1. 'phar打包工具'
            . self::Br
            . self::H1 . '使用： '
            . self::T1 . '打包文件'
            . self::T2 . '$ php srong.phar <file>/<directory>'
            . self::T2 . '$ php srong.phar <file>/<directory> -r=name   命名为 name.phar'
            . self::Br
            . self::Br
            . self::Border
        ;
    }
}