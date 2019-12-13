# mysql

## 1.sql及索引

### 1.1 慢查询日志

* 开启慢查询

```bash
    show variables like 'slow_query_log'    #查看是否开启慢查询日志
    show variables like '%log%'   #查看变量设置
    set global slow_query_log_file='/home/mysql/sql_log/mysql-slow.log'  #设置慢查询日志位置
    set global log_queries_not_using_indexes=on;    #记录没有使用索引的sql
    set global long_query_time=1     #设置sql超过1秒记录慢查询
    set global slow_query_log=on     #开启慢查询日志
```

* 慢查询日志分析

```bash
    mysqldumpslow -t 3 /home/mysql/data/mysql-slow.log | more
```
 
### 将下载的Apache解压

* 在cmd中执行：

```bash
    httpd.exe -k uninstall -n “Apache24″
```

## 2 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)

