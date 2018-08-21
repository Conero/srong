<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 14:41
 * Email: brximl@163.com
 * Name: 路由器
 */

namespace sR;


class Router
{
    protected static $routerRuleDick = [];
    /**
     * 路由监听器
     */
    static function listen(){
        println('系统载入成功！');
    }

    /**
     * @param $path
     * @param $callback
     */
    static function get($path, $callback){
        if(!isset(self::$routerRuleDick['get'])){
            self::$routerRuleDick['get'] = [];
        }
        self::$routerRuleDick['get'][] = ['path'=>$path, 'callback'=>$callback];
    }

    /**
     * @param $path
     * @param $callback
     */
    static function post($path, $callback){
        if(!isset(self::$routerRuleDick['post'])){
            self::$routerRuleDick['post'] = [];
        }
        self::$routerRuleDick['post'][] = ['path'=>$path, 'callback'=>$callback];
    }
}