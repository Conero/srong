<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/1 0001 16:51
 * Email: brximl@163.com
 * Name:
 */

namespace tool;


use sR\Adapter;
use sR\Cli;

abstract class CliSrAbstract
{
    const Br = "\r\n";          // 换行
    const Tb = "\r\n";          // Tab
    const Border = '````````````````````````````````';
    const H1 = "\r\n".'  `';           // header1
    const T1 = "\r\n".'    .';         // .k = v
    const T2 = "\r\n".'        .';         // .k = v
    /**
     * @var \sR\Config
     */
    protected $conf;
    protected $args = array();
    protected $option = array();

    function __construct($data=array())
    {
        $this->conf = Adapter::getAppConfig();
        $args = $data['args'] ?? false;
        if($args && is_array($args)){
            $this->args = array_merge(Cli::getArgs(), $args);
        }
        $option = $data['option'] ?? false;
        if($option && is_array($option)){
            $this->option = array_merge(Cli::getOption(), $option);
        }

    }

    /**
     * 默认首页
     */
    function index(){
        echo '  .'. get_class($this)
            .self::Br
            .self::H1 .' need to work.'
            .self::T1 .' to create default method in controller!'
        ;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    function __get($name)
    {
        return $this->argv($name);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    function argv($key){
        return $this->args[$key] ?? null;
    }

    /**
     * @param string $option
     * @return bool
     */
    function hasOption($option){
        return in_array($option, $this->option);
    }
}