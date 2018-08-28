<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 14:54
 * Email: brximl@163.com
 * Name: 适配器
 */

namespace sR;


use tool\CliChain;
use tool\WebChain;

class Adapter
{
    const DevEnv = 'dev';   // 开发环境
    protected static $startRtime = null;  // 起始时间戳
    protected static $projectName;
        /**
     * @var Config
     */
    protected static $appConfig  = null;  // 应用配置文件
    protected static $isCli = null;
    protected static $isDebug = null;

    /**
     * 获取系统运行时间
     * @return bool|float|null
     */
    static function getRtime()
    {
        list($usec, $sec) = explode(" ", microtime());
        $currentRtime = ((float)$usec + (float)$sec);
        if(!self::$startRtime){
            self::$startRtime = $currentRtime;
            return true;
        }
        return $currentRtime - self::$startRtime;
    }

    /**
     * 获取项目名称
     * @return string
     */
    static function getPrjName(){
        if(!self::$projectName){
            self::$projectName = basename(ROOT_DIR);
        }
        return self::$projectName;
    }

    /**
     * 获取系统配置文件
     * @return Config
     */
    static function getAppConfig(){
        return self::$appConfig;
    }
    /**
     * 适配器启动
     */
    static function startUp(){
        self::getRtime();
        self::_loadRequire();
        // 工具文件引入
        require_once(ROOT_DIR.'srong/common.php');
        self::$appConfig = new Config(ROOT_DIR.'srong/config.php');
        if(self::isCli()){
            new CliChain();
        }else{
            new WebChain();
        }
    }

    /**
     * @return bool
     */
    static function isCli(){
        if(null === self::$isCli){
            self::$isCli = php_sapi_name() == 'cli';
        }
        return self::$isCli;
    }

    /**
     * @return bool|mixed|null
     */
    static function isDebug(){
        if(null === self::$isDebug){
            $debug = self::$appConfig->debug;
            if(!$debug){
                $debug = (self::DevEnv == self::$appConfig->env);
            }
            self::$isDebug = $debug;
        }
        return self::$isDebug;
    }
    /**
     * 依赖加载器
     */
    private static function _loadRequire(){
        // sql 注册
        spl_autoload_register(function ($cls){
            $file = ROOT_DIR.'srong/'. $cls.'.php';
            if(is_file($file)){
                require_once($file);
            }
        });
    }
}