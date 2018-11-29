# Db(database)

## 项目介绍
php 数据库封装



## 特性

- 数据库操作
- orm 包等



## 设计

### 基本流程

```php
// 1. 数据库注册，支持多数据库
Db::register(string $name, array $options): AbstractQuery；
    // 1.1 工程模式选择-对应数据库查询驱动
    ConnectFactory::connect(array $options)；
    // 1.2 获取 Abstract Query 类
     	AbstractQuery；
        	// mysql
        	return new Mysql(array $options);
        	// oracle
        	return new Oci(array $options);
// 2. 注册完成后，可直接用 Db::调用AbstractQuery 的 public 方法

```






## 数据库连接
> 支持数据库

- mysql

- oracle

- pgsql

- sqlite

> 基本配置

```php
$option = [
    'type'      	=> 'mysql/oci',
    'dbname'    	=> '数据库名称',
    'user'      	=> '用户代码',
    'password'  	=> '用户密码',
    'host'      	=> '地址'
    'port'			=> '部分数据库可默认'
    
    // oracle
    'charset'		=> '字符格式'
    
    // mysql
    'unix_socket'	=> ''
    'charset'		=> ''
    'port'			=> '端口号'
    
    // PostgreSQL
    
    // SQLite
    'dsn'			=> '!!仅支持该配置'
    
]
```

