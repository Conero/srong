# srong

## 项目介绍
php 轻量级框架以及常用库, wjtai 项目改进版(学习版)



## 特性

- 轻量级框架/应用
- 项目内部采用``插拔式``架构
- 支持*web/cli* 模式


![架构](/static/sRong.jpg)

## install/安装

> WEB

``$>php -S 0.0.0.0:1994 ``



> CLI

``$>php static/index.php ``




## 框架设计

###  项目结构

- ``<project>``
    - static 应用程序入口
      - *config.php* 框架默认配置
    - srong 框架核心程序
    - ``可选`` config 配置文件
    - router 路由配置文件
    - app 应用，默认为项目控制器文件，可为``cli/web`` 程序
    - ``cli/可选``bin  应用控制器
    - runtime 运行时目录



## 模式

### web

> 采用URL地址重写，解析路由

- 重写配置键 ``rewrite_key`` 
- ``auto_router`` 自动路由
  - :controller   控制器
  - :action   方法





```php
// CONFIG.PHP
[auto_router => true]

// ROUTER
Router::match('get|post', '/:controller/:action', function($contrl, $action){
    $instance = new $contrl();
    call_user_func([$instance, $action]);
});

```





### cli

> 通过解析第一个参数

``auto_router`` 自动路由

- :command   命令
- :action   命令方法

```php
// CONFIG.PHP
[auto_router => true]

// ROUTER
Router::match('cli', '/:command/:action', function($cmd, $action){
    $instance = new $cmd();
    call_user_func([$instance, $action]);
});

```

> 格式

``$> php static/index.php {command}  {action} :args :option``

- **command**
- *:参数*
  - **args**
    - ``{key=value}``
  - **option**
    - ``--option``
  - **unfind**
    - 路由失败时处理



## 常量

1. *ROOT_DIR* 项目主目录
2. *Version* 版本
3. *Release* 发布日期
4. *Author* 作者
5. *Name* 框架名称
6. *Since* 项目起始日期

