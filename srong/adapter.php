<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 14:38
 * Email: brximl@163.com
 * Name: 项目运行文件
 */

// 框架性配置文件
define('Version', '2.0.1-alpha');
define('Release', '20180823');
define('Author', 'Joshua Conero');
define('Name', 'sRong');
define('Since', '20180821');
// 载入适配器
require_once(__DIR__.'/sR/Adapter.php');

// 加载
\sR\Adapter::startUp();
