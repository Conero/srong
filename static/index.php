<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 14:33
 * Email: brximl@163.com
 * Name: 入口文件
 */
use sR\Router;
use sR\Adapter;
use sR\Cli;

// 框架顶级目录
define('ROOT_DIR', str_replace('\\', '/', dirname(__DIR__)).'/');

// 引入适配器文件
require_once(ROOT_DIR. 'srong/adapter.php');

// 路由器运行
if(Adapter::isCli()){
    Cli::init($argv);
}
// 路由监听
Router::listen();