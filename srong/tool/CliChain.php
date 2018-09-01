<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 22:00
 * Email: brximl@163.com
 * Name: cli 工具链
 */

namespace tool;


use sR\Adapter;
use sR\sR;

class CliChain
{
    protected $initMk = true;

    function __construct()
    {
        // 调试模式下，验证项目的正确性
        if(Adapter::isDebug()){
            $this->projectCheckValid();
        }
        $routerFile = ROOT_DIR.'router/cli.php';
        if(is_file($routerFile)){
            require_once($routerFile);
        }
    }

    /**
     * 项目争取行检测
     */
    function projectCheckValid(){
        $msg = $this->getErrorMsg();
        // 项目未未初始化话时，启动初始化器
        if(!$this->initMk){
            print('     欢迎使用框架 sRong, By '. sR::Author. "\r\n");
            print('         !! => 项目还未初始化'. "\r\n");
            print('             ) v'.sR::Version.'/'. sR::Release. "\r\n");
            print('             ) 用时 '.Adapter::getRtime(). "s, php-".phpversion()."\r\n");

            die();
        }
    }

    /**
     * 错误信息经过
     * @return array
     */
    function getErrorMsg(){
        $msgQueue = [];
        $routerDir = ROOT_DIR.'router/cli.php';
        if(!is_file($routerDir)){
            $msgQueue[] = '路由器未配置(router/cli.php)';
            $this->initMk = false;
        }
        return $msgQueue;
    }
}