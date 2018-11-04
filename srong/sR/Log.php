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
    protected static $expire;
    protected static $checkExpireMkToday = false;           //  当天已经检测，日志的有效性
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
     * 日志期限检测(删除过期的日志)
     */
    static function checkExpire($force=false){
        if(empty(self::$expire)){
            $expire = Adapter::getAppConfig()->value('log.expire');
            if($expire && is_numeric($expire)){
                self::$expire = intval($expire);
            }
        }
        // 不重复检测后删除文件
        if((!self::$checkExpireMkToday || $force) && self::$expire){
            self::$checkExpireMkToday = true;
            //$today = time();
            $today = new \DateTime();
            $today->sub(new \DateInterval('P'.self::$expire.'D'));
            $minDay = $today->format('Ydm');
            $minDay = intval($minDay);
            $logDir = Runtime::getLogDir();
            if(is_dir($logDir)){
                foreach (scandir($logDir) as $n){
                    $path = $logDir.'/'. $n;
                    if(is_file($path)){
                        $pathInfo = pathinfo($path);
                        $filename = $pathInfo['filename'];
                        if(is_numeric($filename) && intval($filename) < $minDay){
                            unlink($path);
                        }
                    }
                }
            }
        }
    }

    /**
     * 清空日志
     * @return bool
     */
    static function clearLog(){
        return Fs::rmdirs(Runtime::getLogDir());
    }
    /**
     * 便陷入文件
     * @param string $name
     * @param mixed $data
     * @param string $pref
     */
    static function writeFile($name, $data, $pref=''){
        self::checkExpire();
        $file = Runtime::getLogDir(). $name;
        $fh = fopen($file, 'a');
        $data = self::parseData($data);
        $data = $pref. $data;
        fwrite($fh, $data);
        fclose($fh);
    }

    /**
     * 单(日志)文件写入
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
     * [调试信息]
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
     * [错误] 级别日志
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
     * [详情] 级别日志
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