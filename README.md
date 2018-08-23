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



## 常量

1. *ROOT_DIR* 项目主目录
2. *Version* 版本
3. *Release* 发布日期
4. *Author* 作者
5. *Name* 框架名称
6. *Since* 项目起始日期

