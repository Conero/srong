# version

## v2.2

### 2.2.0/alpha

- **sR**
  - ds: _添加 数据结构(`data structure`)包_
    - **Dick** 
      - (+) _新字典数据结构类，实现对字典的的获取、设置、删除等基本的操作_    [181128]
- tests
  - (+) *添加单元测试类“sRdsDickTest”，测试`sR\ds\Dick`类的 create 静态方法*    [181128]



## v2.1

> 1. 优化框架中的目录设计，原则项目根目录下尽量少目录，与php相关的文件基本置于 *app* 下

### v2.1.13/20181125 - (alpha)

- **sR**
  - _Config 类_
    - (+) 添加方法 `delete` 用于删除项目配置项 	[181124]
  - _Adapter 类_
    - (调整) *删除类常量`DevEnv`;使用 `EnvDev/EnvProd`* [181125]
- 其他
  - *tests*
    - (+) *添加 `sR\Config` 测试用例*
    - (+) *添加 `sR\Template` 测试用例*



### v2.1.12/20181121

> 实现日志文件的时间有效性

- **sR**
  - *Log*
    - (+) *添加方法`checkExpire` 用于检测日志文件的有效性*   [181104]
    - (+) 添加方法 `clearLog` 手动请求日志文件目录                [181104]
- **tool\clisr**
  - (+) *添加命令 `log` 用于管理日志，`$ sr log clear` 清空日志*
  - (优化) *`$ sr` 添加`log`命令的介绍*



###v2.1.11/20181010

- **sR**
  - *Router* 
    - (优化) 完善 *unfind* 使用类常量替换，使 *cli* 与 *web* 保持一致
    - (修复) *cli* 模式下 *unfind* 路由无效
- **tool**
  - *CliSrAbstract*
    - (+) *__construct* 接受可选参数，数据格式 `[args, option]`
    - (+) *新增方法 hasOption 用于判断 Option是否存在*
    - (优化) *优化 默认方法 index，使之更加可读*
    - (优化) *方法 `argv` 数据源为 自身的`args` ，不再依赖 Cli::args($key)* 



### v2.1.10/20180911

> *`项目与设计上发生了很大的不同，因此子版本上跨度较大`*
>
> 实现 *PHP-内置服务器* 用于项目快速开发

- **sR**
  - (+) 新增类 *Mime* 实现对 *mime.types* 的解析，并获取文件的 *mime* 类型；同时添加 *mime.types* 资源文件
  - (调整) *Adapter* 适配器初始化(startUp)时，不立即输出内容，即不使用工具链。转移至 *router* 中
  - (调整) *Router* 路由器监听时，使用工具链
- **tool**
  - (实现) *Server* 类实现 *PHP 内置服务器 对其他文件的读取支持* 

### v2.1.1/20180910-alpha

#### alpha.1/180910

- 项目
  - (+) *初步引入server.php， 实现无须服务器软件，依托php 内置服务实现web本地开发* {`向laravel框架学习`}
  - (优化) *composer.json* 优化 autoload 配置
- **sR**
  - (修复) *CliChain* 开启*auto_router* 配置时，项目未初始化无法运行`sr 命令`
- **tool**
  - (+) 新增类 *Server* ，实现*cli-server*地址重写

### v2.1.0/20180902

> 实现新版本的设计理念，实现项目初始化等命令，支持``自动路由``

- 项目

  - (完善) 完善项目说明文档
  - (完善) 配置文件完善，使其符合当前的框架解析

- **sR**
  - (+) *Config* 添加方法 *args* 用于获取参数
  - (+) *Fs* 文件系统类新增，实现多层目录新增/删除(从其他项目而来)
  - (+) 新增类 *Template* 用于解析文本模板，语法格式 ``{}``
  - (+) *sR* 类中添加与项目架构方面的的配置信息
  - (实现) *Router* 实现 web 自动路由解析，以及优化 *cli* 模式下的路由自动解析。 web 返回为 *array* 是默认输出为 *json* 数据
  - (修复) *Adapter*  *autoLoaderPsr4* 解析无效

- **tool**

  - (实现) *Application* 实现项目初始化以及移除初始化等，初始化时根据 *tpl* 模板解析实现
  - (调整) *cli/web* 工具判断项目是否初始化时，实现对 *自动路由* 配置项的支持
  - (+) 新增tpl目录下相关的项目模板


### v2.1.0/20180901-alpha.1

- 项目
  - (优化) 项目目录设计
- **tool**
  - (+) *tool\Application* 添加 app 管理类，搭建空壳
  - (+) *tool\clisr\App* 添加类用于创建或管理 ``sr - cli``命名

## v2.0

> 1. 架构/设计**sRong** 框架，确定基本理念
> 2. 实现 ``cli/web`` 路由功能
> 3. 初步实现日志功能
> 4. 初步引入 *自治/工具化* 管理理念
>    1. 实现 ``cli`` 内部框架集工具 *sr*
> 5. 初步实现*配置*文件的获取

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