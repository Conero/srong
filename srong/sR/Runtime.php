<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/25 0025 22:52
 * Email: brximl@163.com
 * Name: 运行时
 */

namespace sR;


class Runtime
{
    static protected $baseDir;
    /**
     * 初始化
     */
    static function init(){
        $dir = ROOT_DIR.'runtime/';
        self::$baseDir = $dir;
        if(!is_dir($dir)){
            mkdir($dir);
        }
    }

    /**
     * 日志检测
     * @return string
     */
    static function getLogDir(){
        self::init();
        $dir = self::$baseDir . 'log/';
        if(!is_dir($dir)){
            mkdir($dir);
        }
        return $dir;
    }
}