# reference





## 数据库连接配置

> 配置信息

```php
    // 数据配置信息
    $options = [
        // 类型
        'type'      => 'mysql,oci,pgsql,sqlite',
        'user'      => '用户名称',
        'password'  => '',
        'host'      => '请求地址',
        'port'      => '端口号'
        'dbname'    => '数据库名称',        
    ];
```



### DSN

**SQLite**

```
sqlite:/opt/databases/mydb.sq3
sqlite::memory:
sqlite2:/opt/databases/mydb.sq2
sqlite2::memory:
```

**PostgreSQL**

```
pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
```

**oracle**

```
oci:dbname=//localhost:1521/mydb
```

**mysql**

```
mysql:host=localhost;dbname=testdb
mysql:host=localhost;port=3307;dbname=testdb
mysql:unix_socket=/tmp/mysql.sock;dbname=testdb
```



