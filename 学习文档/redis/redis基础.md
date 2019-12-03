# redis基础

## 1.redis定义

    redis是基于内存的非关系型数据库

## 2.redis主要应用场景

* 缓存
* 队列
* 数据存储

## 3.redis五种数据类型

### 1.string类型

    字符串类型可以存储字符串、整数、浮点，统称为元素，可以对字符串操作，对整数加减。
    get set incr decrby

### 2.list类型

    列表类型为一个序列列表且每个节点为元素，序列可以两端推入或弹出、查找、移除元素。
    lpush rpop llen

### 3.set类型

    无序集合类型为各不相同的元素，从集合中插入或者删除元素。
    sadd scard sismember

### 4.hash类型

    哈希类型为key-value的散列组，其中key为字符串，value是元素，按照key进行增加删除。
    hset hget hlen hmget

### 5.sort set类型

    带分数score-value的有序集合，其中score为浮点,value为元素，集合插入，按照分数范围查找。
    zadd zcard zrange

## 4.redis特性

### 1.多数据库

    move key 1   将key移动到1号数据库

### 2.事务

* multi    开启事务
* exec     提交事务
* discard  回滚事务

### 3.rdb持久化

* 优势

* 劣势

* 配置

```bash
save 900 1      #每900秒至少有一个key发生变化
save 300 10
save 60 20000
dbfilename dump.rdb  #备份文件名
dir ./               #备份文件目录
```

### 4.aof持久化

* 优势

* 劣势

* 配置

```bash
appendonly no   #是否开启aof
appendfsync always     #同步备份
#appendfsync everysec  #每秒备份
#appendfsync no        #不备份
```

## 5.参考

* [文档](https://github.com/phpredis/phpredis)
* [文档](https://www.imooc.com/learn/809)
* [文档](https://www.imooc.com/learn/839)