-- 2018年8月22日 星期三
-- 测试数据库脚本
-- 以及登录用户

-- 删除已经创建的数据
  -- drop user `sr` if exists;
  -- drop database `srong`;

-- 创建数据库
  create database `srong`;

-- 新增用户 sr
  create user 'sr2018'@'%' identified by 'sr20180818';
  grant all privileges ON `srong`.* TO 'sr'@'%';