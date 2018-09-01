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
        if(!self::$appConfig){
            self::$appConfig = new Config(ROOT_DIR.'srong/config.php');
        }
        return self::$appConfig;
    }
    /**
     * 适配器启动
     */
    static function startUp(){
        self::getRtime();
        self::_loadRequire();
        // 框架公共文件
        require_once(ROOT_DIR.'srong/common.php');
        // 工具链选择
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
        $conf = self::getAppConfig();
        if(null === self::$isDebug){
            $debug = $conf->debug;
            if(!$debug){
                $debug = (self::DevEnv == $conf->env);
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
        // 系统注册级自动导入
        $app = self::getAppConfig();
        $autoload = $app->value('autoload');
        $autoload = is_array($autoload) ? $autoload : [];
        $psr4 = ($autoload['psr-4'] ?? []);
        self::autoLoaderPsr4($psr4);
    }

    /**
     * @param array $data
     */
    static function autoLoaderPsr4($data){
        $data = is_array($data)? $data : [];
        spl_autoload_register(function ($cls) use ($data){
            foreach ($data as $ns => $path){
                $cls = ($ns? str_replace($ns, '', $path): '') . $cls;
                $file = $path . $cls. '.php';
                //echo '   -> '.$file."\r\n";
                if(is_file($file)){
                    require_once $file;
                    break;
                }
            }
        });
    }
}