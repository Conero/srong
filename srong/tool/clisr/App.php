<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/1 0001 22:47
 * Email: brximl@163.com
 * Name: 项目关联
 */

namespace tool\clisr;


use sR\Adapter;
use tool\Application;
use tool\CliSrAbstract;

class App extends CliSrAbstract
{
    /**
     * 项目初始化
     */
    function init(){
        $mode = $this->argv('mode');
        $mode = $mode ?? $this->conf->value('mode');
        echo self::Border;
        echo self::H1. '项目正在初始化....';
        Application::initApp([
            'mode' => $mode
        ]);
        echo  self::Br.
            self::H1. '项目初始化完成.'.
            self::T1. '用时 '.Adapter::getRtime().'s'.
            self::Border
            ;
    }

    /**
     * 删除初始化
     */
    function remove(){
        $mode = $this->argv('mode');
        $mode = $mode ?? $this->conf->value('mode');
        echo self::Border;
        echo self::H1. '项目正在移除....';
        Application::removeApp([
            'mode' => $mode
        ]);
        echo  self::Br.
            self::H1. '项目移除已.'.
            self::T1. '用时 '.Adapter::getRtime().'s'.
            self::Border
        ;
    }
}