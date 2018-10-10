# jcsr.phar

## 项目介绍
*基于框架`srong`的phar管理包,用于打包 phar*



## 使用

`$ php jcsr.phar <file>/<directory>`



> 压缩时配置文件命名

*/srong-phar.conf*

```ini
; 2018年10月10日 星期三
; Joshua Conero

; {name}.phar
name = jcsr

; dist-directory
dist = dist/ 

; default Stub
defStub = static/index.php

; ignore
ignore[] = .git
ignore[] = runtime
ignore[] = tests
ignore[] = server.php
ignore[] = composer.*
ignore[] = LICENSE

```

