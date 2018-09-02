<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/1 0001 22:51
 * Email: brximl@163.com
 * Name: app 应用管理
 */

namespace tool;


use sR\Adapter;
use sR\Fs;
use sR\sR;
use sR\Template;

class Application
{
    static function checkApp(){
        //@TODO 检测 app 是否存在
    }

    /**
     * http 项目初始化
     */
    protected static function iniHttpApp(){
        if(!is_dir(sR::HttpDir)){
            mkdir(sR::HttpDir);
        }
        $conf = Adapter::getAppConfig();
        $autoRouter = $conf->value('auto_router');
        $createRouterFlMk = empty($autoRouter);
        $webRs = $conf->value('web');

        // 自动路由
        if($autoRouter){
            $cliDefault = sR::HttpDir.'/'.ucfirst($webRs['default_ctrl'] ?? 'index'). '.php';
            (new Template([
                'tplFile' => __DIR__.'/tpl/WebDefault.php'
            ]))
                ->render($cliDefault)
            ;
        }
        // 路由文件配置
        if($createRouterFlMk){
            if(!is_dir(sR::RouterDir)){
                mkdir(sR::RouterDir);
            }

            // cli 文件渲染
            $cliRputer = sR::RouterDir.'/web.php';
            if(!is_file($cliRputer)){
                (new Template([
                    'tplFile' => __DIR__.'/tpl/RouterWeb.php'
                ]))
                    ->render($cliRputer, [
                        'date' => date('Y-m-d H:i:s')
                    ])
                ;
            }
        }
    }

    /**
     * bin 项目初始化
     */
    protected static function iniBinApp(){
        if(!is_dir(sR::BinDir)){
            mkdir(sR::BinDir);
        }
        $conf = Adapter::getAppConfig();
        $autoRouter = $conf->value('auto_router');
        $createRouterFlMk = empty($autoRouter);
        $cliRs = $conf->value('cli');

        // 自动路由
        if($autoRouter){
            $cliDefault = sR::BinDir.'/'.ucfirst($cliRs['default_ctrl'] ?? 'index'). '.php';
            (new Template([
                'tplFile' => __DIR__.'/tpl/CliDefault.php'
            ]))
                ->render($cliDefault)
            ;
        }
        // 路由文件配置
        if($createRouterFlMk){
            if(!is_dir(sR::RouterDir)){
                mkdir(sR::RouterDir);
            }

            // cli 文件渲染
            $cliRputer = sR::RouterDir.'/cli.php';
            if(!is_file($cliRputer)){
                (new Template([
                    'tplFile' => __DIR__.'/tpl/RouterCli.php'
                ]))
                    ->render($cliRputer, [
                        'date' => date('Y-m-d H:i:s')
                    ])
                ;
            }
        }
    }

    /**
     * app 初始化
     * @param array $param
     */
    static function initApp($param=array()){
        $appDir = sR::AppDir;
        if(!is_dir($appDir)){
            mkdir($appDir);
        }
        $mode = $param['mode'] ?? 'all';
        switch ($mode){
            case 'web':
                self::iniHttpApp();
                break;
            case 'cli':
                self::iniBinApp();
                break;
            default:
                self::iniHttpApp();
                self::iniBinApp();
        }
    }

    /**
     * web app 移除
     */
    protected static function rmHttpApp(){
        Fs::rmdirs(sR::HttpDir);
        $webRouter = sR::RouterDir.'/web.php';
        if(is_file($webRouter)){
            unlink($webRouter);
        }
    }

    /**
     * cli app 移除
     */
    protected static function rmBinApp(){
        Fs::rmdirs(sR::BinDir);
        $webRouter = sR::RouterDir.'/cli.php';
        if(is_file($webRouter)){
            unlink($webRouter);
        }
    }
    /**
     * 移除项目
     * @param array $param
     */
    static function removeApp($param=array()){
        $appDir = sR::AppDir;
        if(!is_dir($appDir)){
            mkdir($appDir);
        }
        $mode = $param['mode'] ?? 'all';
        switch ($mode){
            case 'web':
                self::rmHttpApp();
                break;
            case 'cli':
                self::rmBinApp();
                break;
            default:
                self::rmHttpApp();
                self::rmBinApp();
                Fs::rmdirs(sR::AppDir);
        }
    }
}