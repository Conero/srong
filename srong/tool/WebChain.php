<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 21:58
 * Email: brximl@163.com
 * Name: web工具链
 */

namespace tool;


use sR\Adapter;
use sR\sR;

class WebChain
{
    protected $initMk = true;

    function __construct()
    {
        // 调试模式下，验证项目的正确性
        if(Adapter::isDebug()){
            $this->projectCheckValid();
        }
        $routerFile = sR::WebRouterFile;
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
        $routerDir = sR::WebRouterFile;
        $conf = Adapter::getAppConfig();
        $autoLoader = $conf->value('auto_router');

        if(!is_file($routerDir) && !$autoLoader){
            $msgQueue[] = '路由器未配置(router/web.php)';
            $this->initMk = false;
        }
        if($autoLoader){
            if(!is_dir(sR::HttpDir)){
                $msgQueue[] = '项目未初始化！';
                $this->initMk = false;
            }
        }
        return $msgQueue;
    }
}