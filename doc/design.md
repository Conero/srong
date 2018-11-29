# 设计

> 2018年9月14日 星期五
>
> Joshua Conero





## 类

### sR\db\Builder

> SQL 生成器

*实例化类*

```php
use sR\db\Builder;
use sR\db\AbstractQuery;
new Builder(
	AbstractQuery $db,
    $setting = [
        'expStr'	=> Builder::setFieldExpStr				// 开启field处理时做字符串分割处理
    ]
)
```





#### where条件

```php
Builder::where($wh, $relation='AND', $isRaw=false);

//1. string
$wh = '字符串'；
    
//2. array => k/v 数据
$wh = ['column' => $value];
    
//3. array	=> [k, relation, v], 含等式的键值
$wh = ['column', 'like', 'value'];

```





## 代码开发风格

`单元测试/与程序开发同步编写`