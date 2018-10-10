<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 16:42
 * Email: brximl@163.com
 * Name: 框架协助类
 */

namespace sR;


class sR
{
    // 框架版本信息
    const Version = '2.1.11';
    const Release = '20181010';
    const Author = 'Joshua Conero';
    const Name = 'sRong';
    const Since = '20180821';

    // 框架架构信息
    const AppDir = ROOT_DIR. '/app';
    const HttpDir = ROOT_DIR. '/app/http';
    const BinDir = ROOT_DIR. '/app/bin';
    const ConfigDir = ROOT_DIR. '/app/config';
    const RouterDir = ROOT_DIR. '/app/router';
    const CliRouterFile = ROOT_DIR.'/app/router/cli.php';
    const WebRouterFile = ROOT_DIR.'/app/router/web.php';
    const ConfigFile = ROOT_DIR.'/app/config/config.php';

    // 系统
    const SysConfFile = ROOT_DIR.'/srong/config.php';

    /**
     * @param mixed ...$debug
     */
    static function println(...$debug){
        if(count($debug) == 1){
            $debug = $debug[0];
        }
        $data = print_r($debug, true);
        if(Adapter::isCli()){
            print $data."\r\n";
        }else{
            echo '<pre>'.$data.'</pre>';
        }
    }
}