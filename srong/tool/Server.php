<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/10 0010 23:02
 * Email: brximl@163.com
 * Name:php 内置服务器
 */

namespace tool;


use sR\Adapter;

class Server
{
    const readableMime = '/\.(?:png|jpg|jpeg|gif)$/';
    protected $uri;
    function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $this->_init();
    }

    /**
     * 服务器初始化
     */
    private function _init(){
        $conf = Adapter::getAppConfig();
        $rewriteKey = $conf->value('web.rewrite_key');
        if($this->_matchMimeAndRequest()){
            die();
        }
        $_GET[$rewriteKey] = $this->uri;
    }

    /**
     * @return bool
     */
    private function _matchMimeAndRequest(){
        //@todo need to make it: 2.1.1
        $matched = false;
        if((preg_match(self::readableMime, $this->uri))){
            $file = ROOT_DIR.'/static/' . $this->uri;
            $mine = mime_content_type($file);
            debug($mine, $file);
            if(is_file($file)){
                echo file_get_contents($file);
            }
            $matched = true;
        }
        return $matched;
    }
}