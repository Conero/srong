<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/10/10 0010 15:06
 * Email: brximl@163.com
 * Name: cli 配置文件
 */
use sR\Router;
use app\bin\Build;
use sR\Cli;


// 默认路由
Router::unfind(function (){
    $command = Cli::getCommand();
    $data = [];
    if($command){
        $data['args'] = [
            'src' => $command
        ];
    }
    (new Build($data))
        ->index();
});

