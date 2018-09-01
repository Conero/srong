<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/30 0030 13:32
 * Email: brximl@163.com
 * Name: sR\Router 判断测试
 */

use PHPUnit\Framework\TestCase;
use sR\Router;
use sR\Cli;

//require_once dirname(__DIR__).'/static/index.php';
final class sRRouterTest extends TestCase
{
    // cli 监听测试
    // 启动 cli监听
    function testCliListener(){
        define('ROOT_DIR', dirname(__DIR__));
        Cli::init(['', 'test']);

        Router::cli('test', function (){
           echo mt_rand(). "\r\n";
        });

        Router::listen();
    }

}