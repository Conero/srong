# version

## v2.0

### v2.0.7/20180901

> 实现 **cli** 内部命令， *sr* 

- 项目
  - **sR**
    - (+) *sR\Cli*  添加方法 *getRawArgv* 以获取 ``cli`` 模式下原始数据
    - (+) *sR\Config* 添加方法 *hasKey* 检测配置的存在性
    - (优化) *sR\Router*  采用 *CliSr* 类实现 ``cli`` 模式下内置命令
  - **tool**
    - (+) *tool\CliSr* 类用于分发 *sr* 内部命令
    - (+) *tool\clisr\Home* 默认命令实现
    - (优化) *tool\CliSrAbstract* 实现 ``cli`` 应用的统一管理，不在松散编制 cmd输出字符

### v2.0.6/20180831

> 1. 编写 PHPunit 测试用例
> 2. 项目内部自动导入，采用 *psr-4* 配置实现

- 项目
    - *sR\Adapter* 
        - (优化) 系统全局配置获取内部也不直接访问变量，而是通过方法
        - (+) 添加 *autoLoaderPsr4* 以支持 Psr4 导入
    - *sR\Router*
        - (+) 初步实现 *cli* 模式下 *auto-router*
- tests/PHPUnit
    - 添加 *sR\Router* 测试类
- composer
    - (修复) *composer.json*  autoload psr-4 错误


### v2.0.5/20180829

> 1. 更改项目配置中于框架版本相关的常量使用， *sR_{name}*
> 2. *cli* 路由解析实现

- 项目

  - (优化) *sR\sR* 类中添加框架原始的版本信息
    - 替换框架中由此因此的变化
  - (优化) *sR\Cli* 添加支持 *cmd queue*，即命令队列，用于路由解析
  - (实现) *sR\Router* 实现 *cli* 模式下路由配置的解析


### v2.0.4/20180828

> 实现 *cli* 模式解析

- 项目
  - (+) **sR\Cli** 添加命令行程序解析
  - (优化) **sR\Router** 
    - 实现*cli*模式下程序监听
    - 添加方法 *cli* 用于该模式下路由配置
    - 添加方法 *match* 用于通用以及多用路由配置
  - (优化) **sR\CliChan** 命令行工具链优化加载路由文件
- 其他
  - *index.php* 入口文件优化代码代码，以及添加 *cli* 解析



### v2.0.3/20180825

> 初步引入 *日志管理* 

- 项目

  - (+) **sR\Log** 添加日志管理，实现基本的文件日志操作
  - (+) **sR\Runtime**  运行时管理
  - (优化) **sR\Router** 路由完善性写入信息日志
  - (优化) *common.php* 添加调试函数 *debug*
  - (优化) *config.php* 全局配置条件*日志*项


### v2.0.2/20180824

- 项目

  - (+) *sR\Adapter* 添加方法 *getAppConfig()* 获取全局配置文件
  - (优化) *sR\Config* 修复 *value* 多级值失败
  - (+) *sR\Request* 

    - 新增类，实现*method* 后去请求参数方法
  - (+) *sR\Response* 

      - 新增类，实现*json/xml* 数据返回
  - (+) *sR\Router*
      - 实现 *web* 路由规则解析；支持 *get/post*

### v2.0.1-alpha/20180823

- 项目
  - 引入测试框架 *PHPUnit*，以及初始化 *composer* 管理包
  - 设计*config.php* 框架中的参数



### v2.0.0/20180821

- 项目架构
  - 设计框架
- 实现
  - (+) 添加 *适配器* ，达到适应外部输入
  - (+) 添加 *路由器* ，添加路由注册绑定
  - (+) 添加*工具器*，用于初始化项目
    - 搭建 *web/cli* 工具器，完成欢迎页面