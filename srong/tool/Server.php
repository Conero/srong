<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/10 0010 23:02
 * Email: brximl@163.com
 * Name:php 内置服务器
 */

namespace tool;


use sR\Adapter;
use sR\Mime;

class Server
{
    const readableMime = '/\.(?:png|jpg|jpeg|gif)$/';
    protected $uri;
    protected $unHandleScript = false;
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
            return null;
        }
        $_GET[$rewriteKey] = $this->uri;
    }

    /**
     * @return bool
     */
    private function _matchMimeAndRequest(){
        $matched = false;
        if (preg_match(self::readableMime, $this->uri)){
            $file = ROOT_DIR.'/static/' . $this->uri;
            header('Content-Type: '. Mime::mime($this->uri));
            $fh = fopen($file, 'r');
            fpassthru($fh);
            fclose($fh);
            $this->unHandleScript = true;
            return true;
        }
        return $matched;
    }

    /**
     * @return bool
     */
    function isCliServerHandler(){
        return $this->unHandleScript;
    }
}