<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/25 0025 22:42
 * Email: brximl@163.com
 * Name: 日志管理
 */

namespace sR;



class Log
{
    /**
     * 数据解析
     * @param mixed $data
     * @return array|mixed
     */
    protected static function parseData($data){
        if(is_object($data) || is_array($data)){
            $data = is_object($data)? (array)$data: $data;
            $data = print_r($data, true);
        }
        return $data;
    }
    /**
     * @param string $name
     * @param mixed $data
     * @param string $pref
     */
    static function writeFile($name, $data, $pref=''){
        $file = Runtime::getLogDir(). $name;
        $fh = fopen($file, 'a');
        $data = self::parseData($data);
        $data = $pref. $data;
        fwrite($fh, $data);
        fclose($fh);
    }

    /**
     * 单文件写入
     * @param mixed $data
     * @param null $topic
     */
    static function singleLog($data, $topic=null){
        $data = self::parseData($data);
        $data = "\r\n".'('.date('h:i:s').')['.($topic ?? 'info').']----------------------------------------.    '. "\r\n".
            'path: '. Router::getPath() . "\r\n".
            $data
            ;
        self::writeFile(date('Ymd').'.log', $data);
    }

    /**
     * @param mixed $data
     */
    static function debug($data){
        $multiple = Adapter::getAppConfig()->value('log.multiple');
        if($multiple){
            $name = 'debug.'. date('Ymd').'.log';
            self::writeFile($name, $data);
        }else{
            self::singleLog($data, 'debug');
        }
    }
    /**
     * @param mixed $data
     */
    static function error($data){
        $multiple = Adapter::getAppConfig()->value('log.multiple');
        if($multiple){
            $name = 'error.'. date('Ymd').'.log';
            self::writeFile($name, $data);
        }else{
            self::singleLog($data, 'error');
        }
    }
    /**
     * @param mixed $data
     */
    static function info($data){
        $multiple = Adapter::getAppConfig()->value('log.multiple');
        if($multiple){
            $name = 'info.'. date('Ymd').'.log';
            self::writeFile($name, $data);
        }else{
            self::singleLog($data, 'info');
        }
    }
}