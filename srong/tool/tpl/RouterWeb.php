<?php
/**
 * Auther: Joshua Conero
 * Date: {date}
 * Email: brximl@163.com
 * Name: web 路由配置
 */

use sR\Router;
use sR\Response;
use sR\sR;


//phpinfo();

Router::get('user/{id}', function ($id) {
    Response::json(['path'=>'ddd', 'id' => $id]);
    //return 'User '.$id;
});


Router::get('test/{name}', function ($name){
    echo 'get test: router; with the param {name}='.$name;
});


Router::get('test', function (){
    echo 'get test: router';
});


Router::post('test', function (){
    echo 'post test: router';
});

// => json
Router::match('get|post', '/', function (){
   return [
       'title'   => '欢迎使用'. sR::Name,
       'version' => sR::Version . '/'. sR::Release
   ];
});

Router::unfind(function (){
    echo '未发现地址： =》 ';
});
