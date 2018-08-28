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
    protected static $command;
    protected static $action;
    protected static $args = [];
    protected static $option = [];
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
            }elseif (empty(self::$action)){
                self::$action = $v;
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
}
