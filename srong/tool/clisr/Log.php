<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/11/21 0021 23:09
 * Email: brximl@163.com
 * Name:
 */

namespace tool\clisr;

use sR\Adapter;
use tool\CliSrAbstract;
use sR\Log as sRLog;

class Log extends CliSrAbstract
{
    /**
     * 清理全部日志
     */
    function clear(){
        echo  self::Br.
            self::H1. (sRLog::clearLog()? '日志已经清空！': '日志清理失败.').
            self::T1. '用时 '.Adapter::getRtime().'s'.
            self::Border
        ;
    }
}