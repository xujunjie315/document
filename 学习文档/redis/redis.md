# redis

## 1.redis应用场景

* 缓存系统
* 计数器
* 消息队列系统
* 排行榜
* 社交网络
* 实时系统

## 2.redis API的使用和理解

### 2.1 通用命令

```bash
    keys         #遍历所有key
    dbsize       #计算key的总数
    exists key   #检查key是否存在
    del key      #删除指定key-value
    expire key seconds   #key在seconds秒后过期
    ttl key              #查看key的剩余过期时间
    persist key          #去掉key的过期时间
    type key     #返回key的类型
```

* 数据结构和内部编码

* 单线程

### 2.2 字符串类型

* 场景：缓存、计数器、分布式锁

* 命令

```bash
    get key         #设置key
    set key         #获取key
    del key         #删除key
    incr key        #自增1
    decr key        #自减1
    incrby key k    #自增k
    decrby key k    #自减k
    setnx key value   #key不存在才设置
    set key value xx  #key存在才设置
    mget            #批量获取
    mset            #批量设置
    getset key newvalue  #set key newvalue并返回旧的value
    append key value     #将value追加到旧的value
    strlen key           #返回字符串的长度
    incrbyfloat key 3.5       #增加3.5
    getrange key start end    #获取字符串指定下标的值
    setrange key index value  #设置指定下标的值
```

### 2.3 哈希类型

```bash
    hget key field        #设置key
    hset key field        #获取key
    hdel key field        #删除key
    hexists key field     #判断hash key 是否有field
    hlen key              #获取hash key field的数量
    hmget key field field #批量获取hash key的field值
    hmset key field field #批量设置hash key的field值
    hincrby key pageview count #网页访问量
    hgetall key           #返回hash key对应的所有field和value
    hvals key             #返回hash key对应所有的field和value
    hkeys key             #返回hash key对应所有的field
    hsetnx key field value  #设置hash key对应的field的value
    hincryby key field intCounter #hash key对应的field的value自增
    hincrbyfloat key field floatCounter #hincrby浮点数版
```

### 2.4 列表类型

```bash
    rpush key value1 value2  #从右边插入
    lpush key value1 value2  #从左边插入
    linsert key before|after value newValue  #在list指定的值前后插入newValue
    lpop key   #从列表左边弹出一个值
    rpop key   #从列表右边弹出一个值
    lrem key count value  #count>0,从左到右删除count个value,count<0,从右到左，删除count个value,count=0,删除所有value
    ltrim key start end  #保留start到end的元素
    lrange key start end #获取列表指定索引的元素
    lindex key index     #获取列表指定索引的元素
    llen key             #获取列表长度
    lset key index newValue  #设置列表指定索引值为newValue
    blpop key timeout    #lpop阻塞版本，timeout是阻塞超时时间，timeout=0为永不阻塞
    brpop key timeout    #rpop阻塞版本
```

```bash
    lpush + lpop = stack               #栈
    lpush + rpop = queue               #队列
    lpush + ltrim = capped collection  #固定查毒列表
    lpush + brpop = message queue      #消息队列
```

### 2.5 集合类型

```bash
    sadd key element  #向集合key添加元素
    srem key element  #将集合key中元素移除
    scard key         #计算集合元素
    sismember key element  #判断是否在集合中
    srandmember key count  #从集合中随机取出一个元素
    spop key               #从集合中随机弹出一个元素
    smembers key           #取出集合中所有元素
    sdiff key key    #差集
    sinter key key   #交集
    sunion key key   #并集
    sdiff|sinter|sunion + store destkey  #将结果保存destkey中
```

```bash
    SADD = tagging                  #做标签
    SPOP|SRANDMEMBER = Random item  #做随机数
    SADD + SINTER = Social Graph    #社交相关
```

### 2.6 有序集合类型

* 排行榜
  
```bash
    zadd key score element   #添加score和element
    zrem key element         #删除元素
    zscore key element       #返回元素分数
    zincrby key intreScore element  #增加或减少分数
    zcard key                #返回元素个数
    zrank key element        #返回排名
    zrange key start end [withscores]  #返回一段数据
    zrangebyscore key minScore maxScore [withscores]  #返回分数范围数据
    zcount key minScore maxScore   #返回有序集合内指定分数范围的个数
    zremrangebyrank key start end  #删除指定排名内的升序元素
    zremrangebyscore key minScore maxScore  #删除指定分数内的升序元素
    zrevrank    #高到低排序
    zrevrange
    zrevrangebyscore
    zinterstore
    zunionstore
```

## 3.redis其他功能

### 3.1 慢查询

```bash
    #支持动态配置
    config set slowlog-max=len            #多久进入慢查询里
    config set slowlog-log-slower-than    #慢查询保存条数
    slowlog get[n]    #获取慢查询队列
    slowlog len       #获取慢查询队列长度
    slowlog reset     #清空慢查询队列
```

### 3.2 pipeline

* 批量执行命令，减少网络时间

### 3.3 发布订阅

```bash
    publish channel message   #发布命令
    subscribe [channel]       #订阅频道
    unsubcribe [channel]      #取消订阅
    psubscribe [pattern]      #订阅模式
    punsubscribe [pattern]    #退订指定的模式
    pubsub channels           #列出至少有一个订阅的额频道
    pubsub numsub [channel]   #列出给定的频道的订阅者数量
```

### 3.4 bitmap

* 用户统计

```bash
    getbit key offset         #获取位图指定索引值
    setbit key offset value   #给位图指定索引设置值
    bitcount key [start end]  #获取位图指定范围位值为1的个数
    bitop op destkey key      #做多个值的and(交集)、or(并集)、not(非)、xor(异或)，并将结果保存在deskey中
    bitpos key targetBit [start] [end] #计算指定范围对应值为targeBit的位置
```

### 3.5 hyperloglog

* 极小的空间完成独立数量的统计

```bash
    pfadd key element [element...]    #向hyperloglog添加元素
    pfcount key [key...]              #计算hyperloglog的独立总数
    pfmerge destkey sourcekey [sourcekey] #合并多个hyperloglog
```

### 3.6 geo

* 地理位置

```bash
    geo key longitude latitude member          #增加地理位置信息
    geopos key member [member]                 #获取地理位置
    geodist key member member [unit]           #计算距离 m(米)、km(千米)、mi(英里)、ft(尺)
    georadius key longitude latitude 
    georadiusbymember key member  
```

## 2 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)

