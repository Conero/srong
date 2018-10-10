# srong.phar

## 项目介绍
*基于框架`srong`的phar管理包,用于打包 phar*



## 使用

`$ php srong.phar <file>/<directory>`



> 压缩时配置文件命名

*/srong-phar.conf*

```json
{
    // 忽律文件列表
    "ignore": [
        "*.exe",
        "*.html"
    ]
}
```

