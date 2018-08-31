<?php
/**
 * Auther: Joshua Conero
 * Date: 2018/8/21 0021 16:06
 * Email: brximl@163.com
 * Name: 项目默认配置
 */

return [
    'mode' => 'all',              // 系统模式： web、cli、all

    //'debug' => true,             // 调试开启
    'track'=> true,               // 性能追踪
    'env'  => 'dev',              // 项目环境，默认 dev-> 开启 调试； prod -> 发布模式 调试关闭
    // web 模式相关配置
    'web'   => [
        'tool_base_url' => 'srong', // [dev] tool 工具,前缀地址
        'rewrite_key'   => 'sr_query_string',       // 重写地址参数
    ],
    // cli 模式相关配置
    'cli'   => [
        'sr'    => true,            // 开启 sr 协助命令
        'ns_pref'   => [
            'app\\bin\\',
            'bin\\'
        ]
    ],

    'log'   => [
        'multiple' => false             // 多文件
    ],
    // 自动加载
    'autoload'=> [
        'psr-4' => [
            'app\\'    => 'app/',
            'bin\\'    => 'bin/'
        ]
    ],
    'auto_router' => true,         //自动路由，比配到模块
];