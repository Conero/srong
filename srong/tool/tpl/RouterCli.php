<?php
/**
 * Auther: Joshua Conero
 * Date: {date}
 * Email: brximl@163.com
 * Name: cli 路由配置
 */

use sR\Router;


Router::cli('test', function (){
    print '   test:';
});

Router::cli('test/{emma}', function ($emma){
    print '   test:'. $emma;
});


Router::cli(':unfind', function ($cmd){
    print '   unfind:'. $cmd;
});
