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


-- 数据表
DROP TABLE IF EXISTS country;
-- 国家地区
create table country (
   code varchar(5),                                         -- 国家代码
   cname varchar(30),                                       -- 中文名字
   ename varchar(100),                                      -- 英文名字
   phone_coe varchar(10),                                   -- 号码前缀
   continent varchar(20),                                   -- 大洲
   continent_jc varchar(10),                                -- 大洲简称
   mtime datetime not null default CURRENT_TIMESTAMP
);


-- 省/州
DROP TABLE IF EXISTS province;

create table province (
  name varchar(100),        -- 英文
  cname varchar(50),        -- 中文名称
  area  number(10, 4),      -- 面积
  capital varchar(50),      -- 首府
  ct_city    int,              -- 市
  ct_county  int,              -- 县
  ct_area    int,              -- 区
  ct_village int,              -- 村
  ct_cho     int,              -- 町
  country varchar(10),         -- 国家
  mtime datetime not null default CURRENT_TIMESTAMP
);

