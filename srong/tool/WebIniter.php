<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 22:17
 * Email: brximl@163.com
 * Name: 项目初始化器
 */

namespace tool;


use sR\Adapter;
use sR\sR;

class WebIniter
{
    protected $option;
    function __construct($option = [])
    {
        $this->option = $option;
        $this->innerRouter();
    }

    /**
     * 内部路由器
     */
    protected function innerRouter(){
        $step = ($_GET['step'] ?? null);
        $step = $step? $step: null;
        $dick = ['test'];
        if($step){
            foreach ($dick as $v){
                if($step == sha1(sR::Version. $v)){
                    return call_user_func([$this, 'u'. ucfirst($v)]);
                }
            }
        }
        $this->uIndex();
        return null;
    }

    /**
     * 初始化首页
     */
    function uIndex(){
        $version = sR::Name.'-v'.sR::Version.'/'.sR::Release;
        echo '
            <title>'.$version.'</title>
            <body>
                <div style="padding-top: 10%;padding-left: 20%;font-size: 1.2em;">
                    <img src="sRong.jpg">
                    <p>欢迎使用框架:  '.$version.'</p>
                    <p>{'.Adapter::getPrjName().'}</p>
                    <p>
                        <a href="?step='.sha1(sR::Version.'test').'">项目测试</a>
                    </p>
                    <p style="font-size: 0.89em;">页面加载时间: '.Adapter::getRtime().'s</p>
                </div>                
            </body>
        ';
    }

    /**
     * 项目测试
     */
    function uTest(){
        echo '<h1>项目测试</h1>';
    }
}