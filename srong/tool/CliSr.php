<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/31 0031 14:26
 * Email: brximl@163.com
 * Name: sr - cli 管理器
 */

namespace tool;


use sR\Cli;
use sR\sR;

class CliSr
{
    const Command = 'sr';
    /**
     * 是否匹配成功
     * @return bool
     */
    function isMatched(){
        $matched = false;
        $inputCmd = Cli::getCommand();
        if($inputCmd){
            $inputCmd = strtolower($inputCmd);
            if($inputCmd === self::Command){
                $instance = null;
                $findMethod = false;
                $ct = 1;
                $data = [];
                $quque = Cli::getCmdQueue();
                $quque[2] = $quque[2] ?? 'home';
                foreach ($quque as $v){
                    if($ct == 2){
                        $cls = 'tool\\clisr\\'.ucfirst($v);
                        if(class_exists($cls)){
                            $instance = new $cls();
                        }
                    }
                    else if($ct == 3 && $instance && method_exists($instance, $v)){
                        call_user_func([$instance, $v]);
                        $findMethod = true;
                    }else if($ct >3){
                        $data[] = $v;
                    }
                    $ct += 1;
                }
                if($instance && $findMethod == false){
                    call_user_func([$instance, 'index']);
                }
                $matched = !empty($instance);
            }
        }
        return $matched;
    }
}