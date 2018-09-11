<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/10 0010 22:55
 * Email: brximl@163.com
 * Name: 内置服务器
 */

use sR\Router;
use sR\Adapter;
use sR\Cli;
use tool\Server;

// 框架顶级目录
define('ROOT_DIR', str_replace('\\', '/', __DIR__.'/'));

// 引入适配器文件
require_once(ROOT_DIR. 'srong/adapter.php');


// 路由器运行
if(Adapter::isCli()){
    Cli::init($argv);
}


// 载入内置服务器
if((new Server())->isCliServerHandler()){
    return true;
}

// 路由监听
Router::listen();