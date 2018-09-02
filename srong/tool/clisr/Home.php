<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/1 0001 17:53
 * Email: brximl@163.com
 * Name:
 */

namespace tool\clisr;


use sR\Adapter;
use sR\sR;
use tool\CliSrAbstract;

class Home extends CliSrAbstract
{
    /**
     * sr 首页
     */
    function index(){
        echo
            self::Border.
            self::H1. sR::Name . '-v' . sR::Version.
            self::Br.
            self::H1. '欢迎使用 sR (sRong) 框架： '.
            self::T1. 'sR-version   ----- '. sR::Version. '/'. sR::Release .
            self::T1. 'sR-author    ----- '. sR::Author .
            self::T1. 'github       ----- https://github.com/Conero/srong'.
            self::T1. 'gitee        ----- https://gitee.com/conero/srong'.
            self::Br.
            self::H1. '命令参考(sr [command] [action])： '.
            self::T1. 'app 项目管理'.
            self::T2. 'init   ~~~ 项目初始化'.
            self::T2. 'remove ~~~ 移除项目'.
            self::Br.
            self::H1. '您当前的使用环境： '.
            self::T1. 'php  '. phpversion().
            self::T1. 'OS   '. PHP_OS.
            self::Br.
            self::H1. '祝您{Coding}愉快！'.
            self::H1. 'If ya wanna make a friend for us. C\'mon, Let do it.'.
            self::H1. 'Y\'know how to find us, don\'t ya?'.
            self::H1. 'Anyway, I\'mmmmmm not not not not ~ good.'.
            self::Br.
            self::Br.
            self::H1. '用时： '.Adapter::getRtime().'s'.
            self::Br.
            self::Br.
            self::Border
        ;
    }
}