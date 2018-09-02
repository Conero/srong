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

    function __construct()
    {
        $this->conf = Adapter::getAppConfig();
    }

    /**
     * 默认首页
     */
    function index(){
        echo '  .'. get_class($this).self::Br;
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
        return Cli::args($key);
    }
}