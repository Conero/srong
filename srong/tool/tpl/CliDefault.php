<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/9/2 0002 16:59
 * Email: brximl@163.com
 * Name:
 */

namespace app\bin;


use tool\clisr\Home;

class Index
{
    /**
     * default action
     */
    public function index(){
        $app = new Home();
        $app->index();
    }
}