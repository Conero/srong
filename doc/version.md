# version

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