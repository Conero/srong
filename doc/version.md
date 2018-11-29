# version

## v1.1

### v1.1.3/20181129

**设计库**

- *AbstractQuery*
  - (优化) *`qV方法`添加对 `数字` 类型的支持；*
- *Builder*
  - (+) *添加方法`subSql` 用于获取子查询SQL语句，即不使用数绑定类型*
  - (修复) *`getWhere` 添加连接拼接未实现或者未考虑到（遗漏）*
  - (+) *根据 `getWhere` 方法衍生新的方法用于生成非绑定式的SQL语句方法`getNoBindWhr`*

**tests/测试用例**

- _`DbTest` 添加基本 **Builder**生成SQL的测试_



### v1.1.2/20181129

**设计库**

- *Db*
  - (优化) *PHPdoc 更新，修复doc格式错误，即未区分Db的动态事件*
  - (+) *添加数据库类型常量，如: `DbType_` 系*
  - (修复) *__callStatic 方法调用方法后未能发挥数据*
  - (+) *添加方法 `getKey` 用于获取当前注册数据库的键值*
- *db\ConnectFactory*
  - (优化) *`connect` 数据库连接判断常量使用 `Db 类常量`*
- *db\Query*
  - (+) *添加方法 `type` 用于获取当前数据库对象的类型*
  - (+) *实现类： MySQL/Oci/PgSQL/SQLite 等添加属性 `dbType ` 用于实现通用的 `type`方法*

**tests/测试用例**

- `DbTest` 修复历史测试无法，未使用 `assertEquals` 断言测试



### v1.1.1/20180916

> 1. 进一步实现数据库 *.点操作字段* 处理，如:  mysql(a.name ->a.\`name\`)
> 2. Builder 添加外部配置参数

**设计库**

- *AbstractQuery*
  - (+) *qC* 利用正则表达式处理实现对数据库点操作的处理
- *Builder*
  - (+) 类初始化添加*setting* 配置参数
  - (+) *_getNewBindKey* 添加对绑定的键值进行处理
  - (优化) *sql* 若*cSql* 不存在时自动生成SQL，避免只有执行SQL才能生成SQL语句。暂未支持*insert/update/delete*等
  - (修复) *getTable* *表连接时的别名错误，以及字符拼接空格处理失误*
  - (优化) *getWhere* 优化对*三重条件*的处理
  - (优化) *field* 处理时添加配置键值 *expStr* ，用于否是是否开启“字符串分割处理”(默认非)



### v1.1.0/20180914

> 1. 根据 *PHPdoc* 规范编写注释，使得 *Db* 魔术方法依然支持自动完成。框架引入 *PHPdoc*
> 2. *doc/api* 目录根据 *PHPdoc* 生成文档
> 3. 库增加对 *pgsql* 、*sqlite* 数据支持

**设计库**

- (+) *Db* 添加文档，使之支持对魔术方法实现自动完成
- *AbstractQuery*
  - (实现) *all、row、one* 方法查询
  - (+) 新增方法 *exec，qV，qC，builder，table，query*，增加对 *Builder* 类的嵌入调用
- *Builder*
  - (+) 新增类实现 *SQL生成*，支持对数据表进行 *增删改查*操作
- (优化) *Mysql* 支持*charset* 参数
- (优化) *Oci* 支持*port*参数
- (+) 新增类 *Pgsql*，和 *SQLite* 增加对对应数据库的支持



## v1.0

### v1.0.1-alpha/20180913

- **设计库**
  - (优化) *sR\Db* *register* 方法修复php-doc返回的数据类型为 *AbstractQuery*
  - (调整) *sR\db\AbstractQuery* *getDsn* 更改为*public*类型
    - 方法 *prepareThenExec* 调整，尝试实现 *bind* 
  - (+) *sR\db\ConnectFactory* 方法*connect* 添加对 *oracle* 的支持
  - (+) *sR\db\Oci* 添加对 *oracle* 数据库的支持尝试

### v1.0.0/20180822

- 项目搭建，删除原仓库代码
- 初始化 *composer* 管理工具
- 编写项目文档资料
- 设计``库``
  - (+) *sR\Db* 类实现，用于获取全局数据库对象，支持多数据库
  - (+) *sR\Query* 接口设计，并实现 ``mysql`` 数据库实现
- PHPunit
  - 项目引用测试框架-