# mysql优化

## 1.sql语句优化

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

* 慢查询日志工具分析

```bash
    mysqldumpslow -t 3 /home/mysql/data/mysql-slow.log | more
```

```bash
    #输出到文件
    pt-query-digest slow-log > slow_log.report
    #输出到数据库
    pt-query-digest slow-log -review \
    h=127.0.0.1,D=test,p=root,P=3306,u=root,t=query_review \
    --create-reviewtable \
    --review-history t= hostname-slow
```

* 需要分析的sql

    1.查询次数多且每次查询占用时间长的sql  
    2.io大的sql  
    3.未命中索引的sql  

### 1.2 explain查询sql的执行计划

* 返回字段类型

    table:显示关于哪张表
    type:显示使用了何种类型，const、eq_reg、ref、range、index、all  
    possible_keys:显示可能使用的索引
    key:实际使用的索引
    key_len:使用索引的长度
    ref:显示索引的哪一列被使用了
    rows:表扫描的行数
    using filesort:需要额外的步骤对返回的行进行排序
    using temporary:需要临时表存储结果

* count()和max()

    在max列加索引，索引是按顺序排列
    count(*)包括null值的行,count(列)不包括为null的行

* 子查询

    可以考虑改为join

* group by

    可以考虑子查询

* limit

    order by列最好用主键，比较多的页可以加where条件

## 2.索引优化

### 2.1 索引的选择

* where从句，group by从句，order by从句，on从句出现的列  
* 索引字段越小越好
* 离散度大的列放在联合索引前面

### 2.2 查询索引是否重复

```bash
    use information_schema;
    select a.table_schema as '数据库名',a.table_name as '表名',a.index_name as '索引1',b.index_name as '索引2',a.column_name as '重复列名' from statistics a join statistics b on a.table_schema=b.table_schema and a.table_name=b.table_name and a.seq_in_index=b.seq_in_index and a.column_name=b.column_name where a.seq_in_index=1 and a.index_name<>b.index_name;
    pt-duplicate-key-checker \
    -uroot \
    -p '' \
    -h 127.0.0.1
```

### 2.3 删除不使用的索引

```bash
    select object_schema,object_name,index_name,b.`TABLE_ROWS` from performance_schema.table_io_waits_summary_by_index_usage a join information_schema.table b on a.`OBJECT_SHCEMA`=b.`TABLE_SCHEMA` and a.`OBJECT_NAME`=b.`TABLE_NAME` where index_name IS NOT NULL and count_star=0 order by object_schema,object_name;
    pt-index-usage \
    -uroot \
    -p '' \
    mysql-slow.log
```

## 3.数据库结构优化



## 4.系统配置优化

## 5.服务器硬件优化

### 5.1 系统配置优化

```bash
    /etc/sysctl.conf
    #增加tcp支持的队列数
    net.ipv4.tcp_max_syn_backlog=65535
    #减少断开连接时，资源回收
    net.ipv4.tcp_max_tw_buckets=8000
    net.ipv4.tcp_tw_reuse=1
    net.ipv4.tcp_tw_recycle=1
    net.ipv4.tcp_fin_timeout=10
    #打开文件数限制，ulimit -a查看目录的各位限制
    /etc/security/limits.conf
    soft nofile 65535
    hard nofile 65535
    #最好关闭iptables,selinux等防火墙软件

```


### 将下载的Apache解压

* 在cmd中执行：

```bash
    httpd.exe -k uninstall -n “Apache24″
```

## 2 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)

