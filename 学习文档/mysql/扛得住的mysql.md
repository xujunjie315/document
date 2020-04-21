# 1.什么影响数据库性能

## 1.1 cpu和内存

* cpu的频率和数量，看时候是计算密集型
* myisam索引缓存在内存中，数据通过操作系统来缓存，innodb会在内存中缓存索引和数据

## 1.2 磁盘

* 传统机器硬盘:存储容量、传输速度、访问时间、主轴转速、物理尺寸
* raid增强传统机器硬盘：多个硬盘同时写入，增加硬盘速度
* 固态存储ssd和pcie卡：更好的随机读写性能，更好的支持并发，更容易损坏
* 网络存储nas和san:  网络备份

## 1.3 操作系统

* centos系统参数优化

```bash
#内核相关参数
/etc/sysctl.conf
    #网络参数，每个端口监听队列长度
    net.core.somaxconn=65535
    net.core.netdev_max_backlog=65535
    net.ipv4.tcp_max_syn_backlog=65535
    #tcp连接等待时间的长度，和回收
    net.ipv4.tcp_fin_timeout=10
    net.ipv4.tcp_tw_reuse=1
    net.ipv4.tcp_tw_recycle=1
    #tcp连接的接受和发送的缓冲区大小
    net.core.wmem_default=87380
    net.core.wmem_max=16777216
    net.core.rmem_default=87380
    net.core.rmem_max=16777216
    #失效连接占用的系统资源,和资源回收的效率
    net.ipv4.tcp_keepalive_time=120
    net.ipv4.tcp_keepalive_intvl=30
    net.ipv4.tcp_keepalive_probes=3
    #共享内存,大于innodb缓冲池的大小
    kernel.shmmax=4294967295
    #虚拟内存使用完了，使用交换分区
    vm.swappiness=0
#增加资源限制
/etc/security/limit.conf
    #打开文件数量
    * soft nofile 65535
    * hard nofile 65535
#磁盘调度策略
/sys/block/devname/queue/scheduler
    #noop:闪存设置、ram及嵌入式系统
    #deadline:数据库类应用最好的选择
    #anticipatory:写入较多的环境，比如文件服务器
    echo deadline > /sys/block/devname/queue/scheduler
```

## 1.4 mysql体系结构

* myisam:frm,myd和myi，表锁，修复表check table tablename,repair table tablename，压缩表，不支持事务
* innodb:frm和ibd,行锁，支持事务
* csv:frm,csm和csv,数据非空，不支持索引，以csv格式存储，支持对数据文件直接编辑
* archive:frm,arz,只支持insert和select，只允许自增列增加索引
* memory:frm,存在内存中，重启数据丢失，表结构不丢失，不支持blog、text,表级锁
* federated:默认禁止，
* 存储引擎选择：事务、备份、崩溃恢复、存储引擎特性

## 1.5 mysql参数配置

* 读取mysql配置文件顺序：mysqld --help --verbose | grep -A 1 'Default options'

* 内存配置参数

```bash
    #确定可以使用的内存的上限
    #确定msyql的每个连接的使用内存
    sort_buffer_size  #排序缓冲区大小
    join_buffer_size  #连接缓冲区大小
    read_buffer_size  #全表扫描所分配读缓冲区大小
    read_rnd_buffer_size  #索引缓冲区大小
    #缓存池分配内存
    Innodb_buffer_pool_size  #innodb缓存池大小
    key_buffer_size  #myisam缓存池大小
```

* IO配置参数

```bash
#Innodb
    Innodb_log_file_size  #事务日志大小
    Innodb_log_files_in_group  #事务日志个数
    Innodb_log_buffer_size  #事务缓冲区大小
    Innodb_flush_log_at_trx_commit #0:每秒就事务日志写入cache，并flush log到磁盘；1：每次提交写入；2：每次提交写入cache,每秒写入磁盘
    Innodb_flush_method=O_DIRECT  #和文件系统的交互方式
    Innodb_file_per_table=1  #单独表空间
    Innodb_doublewrite=1  #双写缓存
#myisam
    delay_key_write
```

* 安全配置参数

```bash
    expire_logs_days  #指定自动清除binlog的天数
    max_allowed_packet  #控制mysql可以接收的包大小
    skip_name_resolve  #禁用dns查找
    sysdate_is_now  #确保sysdate()返回确定日期
    read_only  #禁止非super权限的用户写权限
    skip_slave_start  #禁用slave自动恢复
    sql_mode  #设置mysql所使用的sql模式，strict_trans_tables,no_engine_subtitution,no_zero_date,no_zero_in_date,only_full_group_by
```

* 其他常用配置

```bash
    sync_binlog #控制mysql如何向磁盘刷新binlog
    tmp_table_size,max_heap_table_size  #磁盘临时表大小
    max_connections  #允许最大连接数
```

## 1.6 性能优化顺序

* 表结构、索引、sql语句
* 数据库存储引擎的选择和参数配置
* 系统选择及优化
* 硬件升级
 
## 2.mysql基准测试

## 3.mysql数据库结构优化

### 3.1 数据库结构优化的目的

* 减少数据冗余
* 尽量避免数据维护中出现更新，插入和删除异常
* 节约数据存储空间
* 提高查询效率

## 3.2 范式化设计和反范式化设计

> 范式优点

* 可以尽量减少数据冗余
* 更新操作更快
* 范式化设计表更小

> 范式缺点

* 查询需要多个表进行关联
* 更难将进行索引优化

> 反范式优点

* 可以减少表的关联
* 可以更好的索引优化

> 反范式缺点

* 数据冗余和数据缺点
* 对数据修改需要更多的成本

## 3.3 物理设计

> 定义数据库、表及字段的命名规范

* 可读性原则
* 表意性原则
* 长名原则

> 选择合适的存储引擎

> 为表中的字段选择合适的数据类型

* 当一个可以选择多个数据类型时，优先考虑数字类型，其次日期或者二进制类型，最后字符类型。对于相同级别的数据类型，优先选择占用空间小的数据类型

* 整数类型

列类型|存储空间|signed|unsigned
-|-|-|-|
tinyint|1字节|-128~127|0~255
smallint|2字节|-32768~32767|0~65535
mediumint|3|-8388608
int|4|-2147483648
bigint|8|-9223372036854775808

* 实数类型

列类型|存储空间|是否精确类型
-|-|-|
float|4字节|否
double|8字节|否
decimal|每4个字节存9个数字，小数点占一个字节|是

* 字符串类型

列类型|存储空间
-|-|-|
varchar|列宽小于255一个字节记录字符串长度，大于255需要2个字节
char|最大宽度255

* 日期存储

列类型|存储空间|和时区是否有段
-|-|-|
datetime|8个字节|无关
timestamp|4个字节|同样的值，不同时区显示不同
date|3字节
time|

# 4.mysql高可用架构设计

## 4.1 mysql日志

* mysql服务层日志：二进制日志、慢查询日志、通用日志
* mysql存储引擎层日志：innodb的重做日志、回滚日志

### 4.1.1 二进制日志

* 基于段的格式 binlog_format=statement,mysqlbinlog filename

> 优点

* 日志记录sql语句，日志相对较小，节约磁盘及网络I/O

> 缺点

* 可能造成mysql复制的主备服务器数据不一致

* 基于行的格式 binlog_format=row，binglog_row_image=[full|minimal|noblob],mysqlbinlog -vv filename

> 优点

* 使mysql主从复制更安全
* 对一行数据的修改比基于段的复制高效

> 缺点

* 记录日志量较大

* 混合日志格式 binlog_format=mixed,由系统决定基于段和基于行的日志格式


## 4.2 mysql复制功能

### 4.2.1 功能介绍

* 实现在不同服务器上的数据分布
* 实现数据读取的负载均衡
* 增强数据安全性
* 实现数据库高可用和故障切换
* 实现数据在线升级

### 4.2.2 工作方式

* 主将变更写入二进制日志
* 从读取主的二进制日志变更并写入到relay_log(中继日志)中
* 在从上重放relay_log中的日志

### 4.2.3 基于日志点的复制

> 在主DB服务器上建立复制账号

* create user 'repl' @'ip段' identified by 'password';
* grant replication slave on *.* to 'repl' @ 'ip段';

> 配置主数据库服务器

* bin_log=mysql-bin
* server_id=100

> 配置从数据库服务器

* bin_log=mysql-bin
* server_id=101
* relay_log=mysql-relay-bin
* log_slave_update=on(可选)
* read_only=on(可选)

> 初始化从数据库数据

* mysqldump --single-transaction --master-date --triggers --routines --all-databases >> all.sql
* scp all.sql root@ip:/root/
* mysql -uroot -p < all.sql

> 启动复制链路

* change master to master_host='master_host_ip',master_user='repl',master_password='password',master_log_file='mysql_log_file_name',master_log_pos=4;
* show slave status \G
* start slave;

### 4.2.4 基于GTID的复制

> 在主DB服务器上建立复制账号

* create user 'repl' @'ip段' identified by 'password';
* grant replication slave on *.* to 'repl' @ 'ip段';

> 配置主数据库服务器

* bin_log=/usr/local/mysql/log/mysql-bin
* server_id=100
* gtid_mode=on
* enforce-gtid-consiste #不能使用create table ...select,create temporary table
* log-slave-updates=on #5.7以后不需要

> 配置从数据库服务器

* bin_log=mysql-bin
* server_id=101
* relay_log=/usr/local/mysql/log/relay_log
* gtid_mode=on
* enforce-gtid-consistency
* log-slave-update=on(可选)
* read_only=on(可选)
* master_info_repository=table(可选)
* relay_log_info_repository=table(可选)

> 初始化从数据库数据

* mysqldump --single-transaction --master-date=2 --triggers --routines --all-databases -uroot -p  >> all.sql
* scp all.sql root@ip:/root/
* mysql -uroot -p < all.sql

> 启动复制链路

* change master to master_host='master_host_ip',master_user='repl',master_password='password',master_auto_position=1
* show slave status \G
* start slave;

### 4.2.5 mysql复制性能优化

> 影响主从延迟的因素

* 主库写入二进制日志的时间
* 二进制日志传输时间
* 默认情况下从只有一个sql线程，主上并发的修改在从上变成串行

> 优化

* 控制主库的事务大小，分割大事务
* 使用多线程复制

```bash
    #多线程复制
    stop slave
    set global slave_parallel_type='logical_clock';
    set global slave_parallel_workers=4;
    start slave;
```

### 4.2.6 mysql复制停止

```bash
    stop slave;
    reset slave all;
```

### 4.2.7 mysql复制问题

## 4.3 高可用构架

### 4.3.1 MMM构架

### 4.3.2 MHA架构

### 4.3.3 读写分离和负载均衡

# 5. 数据库索引优化

## 5.1 索引介绍

> B-tree索引

* 能快加快数据查询速度
* 顺序存储，适合范围查找

> hash索引

* 查询条件精确匹配hash中所有列
* hash索引无法排序
* hash索引不支持范围查找

## 5.2 索引优化

> 前缀索引

```bash
    create index index_name on table(col_name(n))
```

> 联合索引

* 经常会被使用的列优先
* 选择性高的列优先
* 宽度小的列优先


> 覆盖索引

可以优化缓存，减少磁盘IO操作
可以减少随机IO，变随机IO操作为顺序IO操作
可以避免对Innodb逐渐索引的二次查询
可以避免MyISAM表进行系统调用

* 索引列上不能使用表达式或函数

```bash
    #out_date索引
    select ... from product where to_days(out_date)-to_days(current_date)<=30
    #改
    select ... from product where out_date<=date_add(currency_date,interval 30 day)
```

> 索引优化排序

* 索引的列顺序和order by 子句的顺序完全一致
* 索引中的所有列的方向和order by 子句完全一致
* order by 中的字段全部在关联表中的第一张表中

* 模拟Hash索引优化查询

* 利用索引优化锁
* 索引可以减少锁定行的行数
* 索引可以加快处理速度，同时也加快了锁的释放

* 删除重复和冗余的索引
* 查找未被使用过的索引

# 6.sql优化

## 6.1 慢查询日志

```bash
    set global slow_query_log=on
    slow_query_log   #慢查询日志
    slow_query_log_file  #指定慢查询日志存储路径及文件
    long_query_time      #指定记录慢查询日志sql执行时间
    log_queries_not_using_indexes  #是否记录未使用索引的sql
```

## 6.2 实时获取sql性能

```bash
    select id,`user`,`host`,DB,command,`time`,`state`,info from information_schema.Processlist where time>=60
```

## 6.3 mysql执行过程

* 客户端发送sql请求给服务器
* 服务器检查是否可以在查询缓存中命中该sql
* 服务器端进行sql解析，预处理，再由优化器生成对应的执行计划
* 根据执行计划，调用存储引擎api来查询数据
* 将结果返回给客户端

## 6.4 sql执行过程优化

> 查询缓存

* 查询缓存hash匹配，读写频繁不建议使用查询缓存
* query_cache_type  设置查询缓存是否可用
* query_cache_size  设置查询缓存的内存大小
* query_cache_limit 设置缓存可用存储的最大值
* query_cache_wlock_invalidate  设置数据表被锁是否返回缓存中的数据
* query_cache_min_res_unit 设置查询缓存分配的内存最小单位

> 解析sql

* 语法错误终止
* 根据语法关键字检查sql,生成“解析树”

> 预处理

* 解析树是否合法
* 表是否存在

> 优化sql执行计划

* 根据不同的索引查询
* mysql优化器会自动优化的地方：关联表的顺序，外联转内联，where表达式等价转换

## 6.5 确定查询各个阶段所消耗的时间

> profile

```bash
    set profiling=1; #启动profile功能
    show profiles;   #查看profile的记录
    show profile for query N; #查看每个阶段时间记录
    show profile cpu for query N;  #查看cpu消耗
```

> performance_schema

```bash
    #启动
    use performance_schema;
    update `setup_instruments` set enabled='YES',TIMED='YES' WHERE NAME LIKE 'STAGE%';
    update `setup_consumers` set enabled='YES' where name like 'events%';
    #每个sql消耗时间信息
    select a.THRED_ID,SQL_TEXT,c.EVENT_NAME,(c.TIMER_END-c.TIMER_START)/1000000000 AS 'DURATION(ms)' FROM EVENTS_STATEMENTS_HISTORY_LONG a join threads b on a.`THREAD_ID`=b.`THREAD_ID` join events_stages_history_long c on c.`THREAD_ID`=b.`THREAD_ID` and c.`EVENT_ID` BETWEEN a.END_EVENT_ID WHERE b.`PROCESSLIST_ID`=CONNECTION_ID() and a.EVENT_NAME='statement/sql/select' order by a.THREAD_ID,c.EVENT_ID
```

## 6.6 特定sql查询优化

* 大表数据修改分批

```bash
    delimiter &&
    user `imooc`&&
    drop procedure if exists `p_delete_rows`&&
    create definer='root'@127.0.0.1 procedure 'p_delete_rows'()
    begin
    declare v_rows int;
    set v_rows=1;
    while v_rows>0
    do
        delete from sbtest1 where id>=90000 and id<=190000 limit 5000;
        select row_count() into v_rows;
        select sleep(5);
        end while;
    end&&
    delimiter;
```

* 修改大表表结构:建新表，同步老表数据，建立触发器同步数据，老表加排它锁，重命名新表

```bash
    pt-online-schema-change \
    --alter="MODIFY c VARCHAR(150) NOT NULL DEFAULT ''" \
    --user=root --password=Password D=imooc,t=sbtest4 \
    --charset=utf8 --execute
```

* not in和<>查询

```bash
    left join ... where ... is null 
```

* 使用汇总表优化查询

```bash
    #每天晚上计算下总量，存入汇总表中
    #查询用汇总表union all 当天的数据
```

# 7.分库分表

## 7.1 把一个实例中的多个数据库拆分不同的实例

## 7.2 把一个库中的表分离到不同的数据库中

## 7.3 水品拆分

> 选择分区键

* 分区键要尽量避免跨分片查询的发生
* 分区键要尽量使各个分片中的数据平均

> 如何存储无需分片的表

* 每个分片存储一份相同的数据
* 使用额外的节点统一存储

> 如何再节点上部署分片

* 每个分片使用单一数据库，并且数据名相同
* 将多个分片表存储再一个数据库中，并在表名上加入分片号后缀
* 再一个节点中部署多个数据库，每个数据库包含一个分片

> 如何分配分片中的数据

* 按分区键的hash值取模来分配分片数据
* 按分区键的范围来分配分片数据

> 如何生成全局唯一ID

* 使用auto_increment_increment和auto_increment_offset参数
* 使用全局节点生成ID
* 再redis等缓存服务器生成ID

# 8 数据库监控

## 8.1 数据库监控

* 对数据库服务可用性进行监控
* 对数据库性能监控
* 对主从复制进行监控
* 对服务器资源监控

## 8.2 数据库可用性监控

* 数据库是否可以连接

```bash
    #远程测试数据库是否可以连接
    mysqladmin -umonitor_user -p -h ping
    #人工测试
    telnet ip db_port
    #使用程序通过网络建立数据库连接

```

* 数据库是否可读写

```bash
    #检测数据库的read_only参数是否为off
    #建立监控表并对表中数据进行更新
    #执行简单的查询select @@version
```

* 数据库的连接数

```bash
    show variables like 'max_connections';  #mysql最大连接数量
    show global status like 'Threads_connected'; #当前连接数
```

## 8.3 数据库性能监控

* QPS：每秒查询的数量，即query的数量

* TPS：每秒钟处理事务的数量，即insert，update,delete的数量

* 数据库并发请求数量

```bash
    show global status like 'Threads_running'  #并发数量
    #innodb监控阻塞
    select b.trx_mysql_thread_id as '被阻塞线程',b.trx_query as '被阻塞sql',c.trx_mysql_thread_id '阻塞线程',c.trx_query as '阻塞sql',(UNIX_TIMESTAMP()-UNIX_TIMESTAMP(C.trx_started)) as '阻塞时间' from information_schema.innodb_lock_waits a join information_schema.innodb_trx b on a.requesting_trx_id=b.trx_id join information_schema.innodb_trx c on a.blocking_trx_id=c.trx_id where (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(c.trx_started))>60
```

## 8.4 mysql主从复制监控

```bash
    # 多线程在主从服务器上获取数据
    show master status \G
    show slave status \G
    #使用pt工具
    grant select,process,super,replication slave on *.* to 'dba'@'ip' IDENTIFIED BY 'password';
    pt-table-checksum u=dba,p='password' \
    --databases mysql \
    --replicate test.checksums
```


## 9 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)




