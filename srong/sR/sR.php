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