<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 14:38
 * Email: brximl@163.com
 * Name: 项目运行文件
 */
use sR\Adapter;
use sR\sR;

// 载入适配器
require_once(__DIR__.'/sR/Adapter.php');

// 加载
Adapter::startUp();

// 框架性配置文件
define('sR_Version', sR::Version);
define('sR_Release', sR::Release);
define('sR_Author', sR::Author);
define('sR_Name', sR::Name);
define('sR_Since', sR::Since);