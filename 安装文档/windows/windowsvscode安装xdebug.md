# vscode使用php xdebug

## 2.php安装xdebug扩展

```bash
[xdebug]

zend_extension=php_xdebug.dll
xdebug.remote_enable = 1
xdebug.remote_autostart = 1
;启用性能检测分析
xdebug.profiler_enable = On
;启用代码自动跟踪
xdebug.auto_trace=On
xdebug.profiler_enable_trigger = On
xdebug.profiler_output_name = cachegrind.out.%t.%p
;指定性能分析文件的存放目录
xdebug.profiler_output_dir ="E:\lamp\php-xdebug"
xdebug.show_local_vars=0
;配置端口和监听的域名
xdebug.remote_port=9000
xdebug.remote_host="localhost"
```

## 2.vscode应用商店搜索php xdebug

* 文件--首选项--设置
* 搜索：php.validate.executablePath
* 在settings.json中添加php路径

```bash
    "php.validate.executablePath": "E:\\lamp\\php\\php.exe"
```

## 2 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)