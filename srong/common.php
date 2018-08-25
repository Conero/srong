<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 16:42
 * Email: brximl@163.com
 * Name: 公共文件
 */
use sR\sR;
use sR\Log;

/**
 * @param mixed ...$debug
 */
function println(...$debug){
    sR::println(...$debug);
}

/**
 * 调试输出
 * @param mixed ...$debug
 */
function debug(...$debug){
    Log::debug($debug);
}