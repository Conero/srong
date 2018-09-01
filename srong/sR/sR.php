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
    const Version = '2.0.7';
    const Release = '20180901';
    const Author = 'Joshua Conero';
    const Name = 'sRong';
    const Since = '20180821';

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