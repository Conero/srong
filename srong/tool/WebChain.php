<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 21:58
 * Email: brximl@163.com
 * Name: web工具链
 */

namespace tool;


use sR\Adapter;

class WebChain
{
    protected $initMk = true;

    function __construct()
    {
        // 调试模式下，验证项目的正确性
        if(Adapter::isDebug()){
            $this->projectCheckValid();
        }
    }

    /**
     * 项目争取行检测
     */
    function projectCheckValid(){
        $msg = $this->getErrorMsg();
        // 项目未未初始化话时，启动初始化器
        if(!$this->initMk){
            new WebIniter(['msg'=>$msg]);
            die();
        }
    }

    /**
     * 错误信息经过
     * @return array
     */
    function getErrorMsg(){
        $msgQueue = [];
        $routerDir = ROOT_DIR.'router/web.php';
        if(!is_file($routerDir)){
            $msgQueue[] = '路由器未配置(router/web.php)';
            $this->initMk = false;
        }
        return $msgQueue;
    }
}