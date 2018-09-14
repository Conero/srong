# version

## v1.1

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