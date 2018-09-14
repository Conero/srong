# tool 项目开发工具

> Joshua Conero
>
> 2018年9月14日 星期五



## PHPunit

> https://phpunit.de/



### 使用

1. ``$> composer require --dev phpunit/phpunit`` 安装最新的包
2. ``编写test文件``
3. ``$ ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/{testClassName}``运行测试类



## PHPdoc

> https://www.phpdoc.org/



### 使用

1. `$> composer require --dev phpdocumentor/phpdocumentor`  通过 *composer* 安装包
2. `$> ./vendor/bin/phpdoc -d ./db -t ./doc/api`