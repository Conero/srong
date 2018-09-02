<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/28 0028 13:33
 * Email: brximl@163.com
 * Name: 命令行解析
 */

namespace sR;


class Cli
{
    protected static $command;              // 命令(类)
    protected static $action;               // 动作
    protected static $args = [];            // 参数[k=v]
    protected static $option = [];          // 配置 [--option]
    protected static $cmdQueue = [];        // 命令列，用于自由路由配置
    protected static $rawArgv = null;
    /**
     * 命令行初始化
     */
    static function init($rawArgv){
        if(!self::$rawArgv){
            self::$rawArgv = $rawArgv;
            self::parseRawArgv($rawArgv);
        }
    }

    /**
     * @param $rawArgv
     */
    protected static function parseRawArgv($rawArgv){
        foreach ($rawArgv as $i=>$v){
            $v = trim($v);
            if($i<1 || empty($v)){
                continue;
            }
            if(($idx = strpos($v, '=') !== false)){
                $key = substr($v, 0, $idx);
                $value = substr($v, $idx+1);
                self::$args[$key] = $value;
            }elseif (($idx = strpos($v, '--') !== false)){
                self::$option[] = substr($v, $idx+1);
            }elseif (empty(self::$command)){
                self::$command = $v;
                self::$cmdQueue[] = $v;
            }elseif (empty(self::$action)){
                self::$action = $v;
                self::$cmdQueue[] = $v;
            }else{
                self::$cmdQueue[] = $v;
            }
        }
    }
    /**
     * @return string|null
     */
    static function getCommand(){
        return self::$command;
    }

    /**
     * @return string|null
     */
    static function getAction(){
        return self::$action;
    }

    /**
     * @return array
     */
    static function getArgs(){
        return self::$args;
    }

    /**
     * @return array
     */
    static function getOption(){
        return self::$option;
    }

    /**
     * @return array
     */
    static function getCmdQueue(){
        return self::$cmdQueue;
    }

    /**
     * @return array|null
     */
    static function getRawArgv(){
        return self::$rawArgv;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    static function args($key){
        return (self::$args[$key] ?? null);
    }
}
