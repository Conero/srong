<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/1 0001 16:51
 * Email: brximl@163.com
 * Name:
 */

namespace tool;


abstract class CliSrAbstract
{
    const Br = "\r\n";          // 换行
    const Tb = "\r\n";          // Tab
    const Border = '````````````````````````````````';
    const H1 = "\r\n".'  `';           // header1
    const T1 = "\r\n".'    .';         // .k = v
    function index(){
        echo '  .'. get_class($this).self::Br;
    }
}