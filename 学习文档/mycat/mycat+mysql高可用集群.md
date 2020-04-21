# mycat+mysql高可用集群

## 1.mycat基础

## 2.mycat核心配置

### 2.1 mycat主要配置文件

```bash
    server.xml  #系统参数以及用户权限配置和sql防火墙
    schema.xml  #配置逻辑库逻辑表以及储存节点对应信息
    rule.xml    #水平切分的切分规则
    log4j2.xml  #日志文件
```

### 2.2 server.xml

```bash
#系统参数
    <system><property name="serverPort">3306</property></system>
    serverPort  #对外提供服务端口
    managerPort #管理端口
    nonePasswordLogin #mycat登录是否需要密码验证，0：需要；1：不需要
    bindIp            #监听服务器的哪些ip，需要监听该服务器所有的ip使用0.0.0.0
    frontWriteQueueSize  #前端写队列的大小
    charset               #字符集
    txIsolation           #连接到后端数据库的隔离级别
    processors           #进程数量，通常等于cpu核数
    idleTimeout          #前端应用和mycat超时断开
    sqlExecuteTimeout    #sql执行时间超时断开
    useSqlStat
    useGlobleTableCheck
    sequnceHandlerType   #序列号生成的类型0：本地文件的方式；1：数据库方式；2：时间戳；3：
    defaultMaxLimit      #返回数据集的行数限制
    maxPacketSize        #允许最大包的大小
#用户参数
    <user name="test"><property name="password">123456</property></user>
    password  #密码
    schemas   #可以操作的逻辑库
    readOnly  #是否只读
    usingDecrypt  #是否使用加密密码，1加密
    #表权限定义,duml的值分别表示：insert,update,select,delete
    <user name="test">
        <privileges check="true">
            <schema name="imooc_db" dml="0110">
                <table name="tb01" dml="0000"></table>
                <table name="tb02" dml="1111"></table>
            </schema>
        </privileges>
    </user>
#加密数据库密码
    java -cp Mycat-server-1.6.5-release.jar io.mycat.util.DecryptUtil 0:root:123456
    <property name="usingDecrypt">1</property>
#sql防火墙

```

### 2.3 log4j2.xml

```bash
#配置日志格式
    <PatternLayout>
        <Pattern>%d{yyyy-MM-dd:mm:ss.SSS} %5p [%t] - %m%n</Pattern>
    </PatternLayout>
    %d{yyyy-MM-dd:mm:ss.SSS}  #表示日志的时间格式
    %5p   #表示输出日志级别
    %t    #日志中记录线程名称
    %m    #输出代码中提定的消息
    %n    #输出回车换行符，windows平台为“/r/n”，linux平台为“/n”
#日志级别
    <asyncRoot level="info" includeLocation="true" />
    All < Trace < Debug < Info < Warn < Error < Fatal < OFF
```

### 2.4 rule.xml

```bash
#水平分片
    <tableRule name="hash-mod-4_id">
        <rule>
            <columns>id</columns>
            <algorithm>hash-mod-4</algorithm>
        </rule>
    </tableRule>
    name     #分片规则名称，唯一
    columns  #指定分片列
    algorithm  #指定分片算法
    #function配置表的分片算法
    <function name="hash-mod-4" class="io.mycat.route.function.PartitionByHashMod">
        <property name="count">4</property>
    </function>
    name     #分片算法名
    class    #实现分片算法的具体类名称
    property #分片算法的参数

```

> 分片算法

* 简单取模-PartitionByMod:整数列

```bash
    <tableRule name="customer_login">
        <rule>
            <columns>customer_id</columns>
            <algorithm>mod-long</algorithm>
        </rule>
    </tableRule>
    <function name="mod-long" class="io.mycat.route.function.PartitionByMod">
        <property name="count">2</property>
    </function>
```

* 哈希取模-PartitionByHashMod:hash (分片列) mod 分片基数

```bash
    <tableRule name="customer_login">
        <rule>
            <columns>customer_name</columns>
            <algorithm>mod-long</algorithm>
        </rule>
    </tableRule>
    <function name="mod-long" class="io.mycat.route.function.PartitionByHashMod">
        <property name="count">2</property>
    </function>
```

* 分片枚举-PartitionByFileMap

```bash
    <tableRule name="customer_login">
        <rule>
            <columns>cate_id</columns>
            <algorithm>hash-int</algorithm>
        </rule>
    </tableRule>
    <function name="hash-int" class="io.mycat.route.function.PartitionByFileMap">
        <property name="mapFile">partition-hash-int.txt</property>
        <property name="type">0</property>
        <property name="defaultNode">0</property>
    </function>
    mapFile  #配置枚举分片规则
    vim partition-hash-int.txt  #conf目录下新建
    10000=0
    10001=1
    DEFAULT_NODE=0
    type  #0:值整数型;1：字符串型
    defaultNode  #>=0:启用默认节点；<0:不启用默认节点
```

* 字符串范围取模分片

```bash
    <tableRule name="customer_login">
        <rule>
            <columns>login_name</columns>
            <algorithm>sharding-by-prefix-pattern</algorithm>
        </rule>
    </tableRule>
    <function name="sharding-by-prefix-pattern" class="io.mycat.route.function.PartitionByPrefixPattern">
        <property name="patternValue">128</property>
        <property name="prefixLength">2</property>
        <property name="mapFile">prefix-partition-pattern.txt</property>
    </function>
    patternValue  #取模机数
    prefixLength  #需要截取字符串前缀的长度
    mapFile  #配置枚举分片规则
    vim prefix-partition-pattern.txt  #conf目录下新建
    0-63=0
    64-127=1
```

### 2.5 schema.xml

```bash
#定义逻辑库,可以对应多个真实库
    <schema name="testdb" checkSQLschema="false" sqlMaxLimit="1000"></schema>  
    name   #逻辑库名称
    checkSQLschema  #判断是否检查发给mycat的sql是否包含库名，true：会自动去掉库名
    sqlMaxLimit  #限制返回结果集的行数，-1表示关闭limit限制
#定义逻辑表
    <table name="customer_login" primaryKey="customer_id" dataNode="logindb01,logindb02" rule="customer_login" />
    name         #逻辑表名称
    primartyKey  #逻辑表主键
    dataNode     #物理节点，顺序就是分片顺序
    rule         #逻辑表分片规则，对应rule.xml中的<tableRule>
#定义分片节点
    <dataNode name="imooc" dataHost="mysql0113" database="imooc_db" />
    name       #节点名称
    dataHost   #节点主机的名称
    database   #物理数据库名称
#定义节点主机
    <dataHost name="mysql0103" maxCon="1000" minCon="10" balance="1" writeType="0" dbType="mysql" dbDriver="native" switchType="1">
        <heartbeat>select user()</heartbeat>
        <writeHost host="192.168.1.3" url="192.168.1.3:3306" user="im_mycat" password="123456">
            <readHost host="192.168.1.4" url="192.168.1.4:3306" user="im_mycat" password="123456" />
        </writeHost>
        <writeHost host="192.168.1.4" url="192.168.1.4:3306" user="im_mycat" password="123456" />
    </dataHost>
    dataHost->name    #主机名称
    dataHost->maxCon  #连接数最大值
    dataHost->minCon  #连接数最小值
    dataHost->balance #0：不开启读写分离；1：第二个主和readHost参与select语句的负载均衡；2：所有的readHost和writeHost都参与select语句的负载均衡；3：所有readHost参与select语句负载均衡
    dataHost->writeType #0:第一写主机操作，第一个挂了才使用其他的；1：写请求随机发到writeHost
    dataHost->dbType  #数据库类型
    dataHost->dbDriver #native:mysql原生驱动；jdbc
    dataHost->switchType #1：第一个不可用自动切换为第二个；-1：关闭自动切换
    heartbeat  #检查数据库是否可用
    writeHost->host   #主机名称
    writeHost->url    #mysql实例的ip和端口号
    writeHost->user   #用户名
    writeHost->password #密码
```

### 2.6 配置全局表

```bash
    vim schema.xml
    <table name="region_info" primaryKey="region_id" dataNode="ordb,prodb,custdb" type="global" / >
```

### 2.7 sql拦截器

```bash
    vim server.xml
    <system>
        <property name="sqlInterceptor">io.mycat.server.interceptor.impl.StatisticsSqlInterceptor</property>
        <property name="sqlInterceptorType">UPDATE,DELETE,INSERT</property>
        <property name="sqlInterceptorFile">/tmp/sql.txt</property>
    </system>
```

### 2.8 sql防火墙

```bash
    vim server.xml
    <firewall>
        <writehost>
            <host user="app_imooc" host="192.168.1.5"></host>
        </writehost>
        <blacklist check="true">
            <property name="deleteWhereNoneCheck">true</property>
        </blacklist>
    </firewall>
```



## 2.mycat垂直分库

```bash
vim schema.xml
    #定义逻辑库表
    <schema name="imooc_db" checkSQLschema="false" sqlMaxLimit="1000">
        <table name="order_master" primaryKey="order_id" dataNode="ordb" />
        <table name="order_detail" primaryKey="order_detail_id" dataNode="ordb" />
        <table name="order_cart" primaryKey="cart_id" dataNode="ordb" />

        <table name="product_category" primaryKey="category_id" dataNode="prodb" />
        <table name="product_info" primaryKey="product_id" dataNode="prodb" />
        <table name="product_comment" primaryKey="comment_id" dataNode="prodb" />

        <table name="customer_login" primaryKey="customer_id" dataNode="custdb" />
        <table name="customer_inf" primaryKey="customer_inf_id" dataNode="custdb" />
    </schema>
    #分片节点
    <dataNode name="ordb" dataHost="mysql0103" database="order_db" />
    <dataNode name="prodb" dataHost="mysql0104" database="product_db" />
    <dataNode name="custdb" dataHost="mysql0105" database="customer_db" />
    #节点主机信息
    <dataHost name="mysql0103" maxCon="1000" minCon="10" balance="3" writeType="0" dbType="mysql" dbDriver="native" switchType="1">
        <heartbeat>select user()</heartbeat>
        <writeHost host="192.168.1.3" url="192.168.1.3:3306" user="im_mycat" password="123456" />
    </dataHost>
    <dataHost name="mysql0103" maxCon="1000" minCon="10" balance="3" writeType="0" dbType="mysql" dbDriver="native" switchType="1">
        <heartbeat>select user()</heartbeat>
        <writeHost host="192.168.1.4" url="192.168.1.4:3306" user="im_mycat" password="123456" />
    </dataHost>
    <dataHost name="mysql0103" maxCon="1000" minCon="10" balance="3" writeType="0" dbType="mysql" dbDriver="native" switchType="1">
        <heartbeat>select user()</heartbeat>
        <writeHost host="192.168.1.5" url="192.168.1.5:3306" user="im_mycat" password="123456" />
    </dataHost>
vim server.xml
    #系统参数
    <system>
        <property name="serverPort">8066</property>
        <property name="managerPort">9066</property>
        <property name="nonePasswordLogin">0</property>
        <property name="bindIp">0.0.0.0</property>
        <property name="frontWriteQueueSize">2048</property>

        <property name="charset">utf8</property>
        <property name="txIsolation">2</property>
        <property name="processors">8</property>
        <property name="idleTimeout">1800000</property>
        <property name="sqlExecuteTimeout">300</property>
        <property name="useSqlStat">0</property>
        <property name="useGlobleTableCheck">0</property>
        <property name="sequnceHandlerType">2</property>
        <property name="defaultMaxLimit">100</property>
        <property name="maxPacketSize">104857600</property>
    </system>
    #用户参数
    <user name="app_imooc">
        <property name="password">123456</property>
        <property name="schemas">imooc_db</property>
    </user>
```

## 3.mycat水平分库

### 3.1 分片键选择

* 尽可能比较均匀分布到各个节点
* 业务最频繁使用或者最重要的查询条件

### 3.2 配置全局自增id

```bash
    #创建mycat库
    create database mycat;
    mysql -uroot -p mycat <./conf/dbseq.sql
    use mycat;
    insert into MYCAT_SEQUENCE values('ORDER_MASTER',1,1);
    #修改配置文件
    vim ./conf/sequence_db_conf.properties
    GLOBAL=mycat
    ORDER_MASTER=mycat
    #增加节点主机和分片节点
    <dataHost></dataHost>
    <dataNode name="mycat" dataHost="mysql0102" database="mycat" />
    #修改数据库生成方式
    <property name="sequnceHandlerType">1</property>
    #配置分片表
    <table name="order_master" primaryKey="order_id" dataNode="orderdb01,orderdb02,orderdb03,orderdb04" rule="order_master" autoIncrement="true" />
```

### 3.3 ER分片

```bash
    #定义子表
    <table name="order_master" primaryKey="order_id" dataNode="orderdb01,orderdb02,orderdb03,orderdb04" rule="order_master" autoIncrement="true">
        <childTable name="order_detail" primaryKey="order_detail_id" joinKey="order_id" parentKey="order_id" autoIncrement="true" />
    </table>
    #增加sequnce记录
    use mycat;
    insert into MYCAT_SEQUENCE values('ORDER_DETAIL',1,1);
    #修改配置文件
    vim ./conf/sequence_db_conf.properties
    ORDER_DETAIL=mycat
```

### 3.4 水平分库

```bash
vim schema.xml
    #定义逻辑库表
    <schema name="imooc_db" checkSQLschema="false" sqlMaxLimit="1000">
        <table name="order_master" primaryKey="order_id" dataNode="orderdb01,orderdb02,orderdb03,orderdb04" rule="order_master" autoIncrement="true">
            <childTable name="order_detail" primaryKey="order_detail_id" joinKey="order_id" parentKey="order_id" autoIncrement="true" />
        </table>
    </schema>
    #分片节点
    <dataNode name="orderdb01" dataHost="mysql0103" database="orderdb01" />
    <dataNode name="orderdb02" dataHost="mysql0103" database="orderdb02" />
    <dataNode name="orderdb03" dataHost="mysql0104" database="orderdb03" />
    <dataNode name="orderdb04" dataHost="mysql0104" database="orderdb04" />

    <dataNode name="mycat" dataHost="mysql0102" database="mycat" />
vim rule.xml
    <tableRule name="order_master">
        <rule>
            <columns>customer_id</columns>
            <algorithm>mod-long</algorithm>
        </rule>
    </tableRule>
    <function name="mod-long" class="io.mycat.route.function.PartitionByMod">
        <property name="count">4</property>
    </function>
vim server.xml
    #系统参数
    <system>
        #修改数据库生成方式
        <property name="sequnceHandlerType">1</property>
    </system>
    #用户参数
    <user name="app_imooc">
        <property name="password">123456</property>
        <property name="schemas">imooc_db</property>
    </user>
```

## 4.mycat高可用集群

### 4.1 zookeeper启动mycat

```bash
    #安装zookeeper集群
    yum install -y java-1.7.0-openjdk
    wget http://mirrors.shuosc.org/apache/zookeeper/zookeeper-3.4.11/zookeeper-3.4.11.tar.gz
    tar zxf zookeeper-3.4.11.tar.gz
    mv zookeeper-3.4.11 /usr/local/zookeeper
    cd zookeeper
    mkdir data
    cd conf
    cp zoo_sample.cfg zoo.cfg
    vim zoo.cfg
    server.0=192.168.1.2:2888:3888
    server.1=192.168.1.3:2888:3888
    server.2=192.168.1.4:2888:3888
    bin/zkServer.sh start   #启动
    #初始化zookeeper中mycat的配置
    cd mycat/conf
    cp schema.xml server.xml rule.xml sequence_db_conf.properties ./zkconf/
    mycat/bin/init_zk_data.sh
    #登录zk客户端
    cd zookeeper/bin
    zkCli.sh
    ls /mycat/mycat-cluster-1
    get /mycat/mycat-cluster-1/schema/dataHost
    #mycat支持zookeeper启动
    vim mycat/conf/myid.properties
    loadZK=true
    zkURL=192.168.1.2:2181,192.168.1.3:2181,192.168.1.4:2181   #zookeeper集群
    myid=mycat_01    #mycat编号
    clusterSize=2    #mycat的数量
    clusterNodes=mycat_01,mycat_04  #mycat的节点名称
```

### 4.2 HAProxy实现多个mycat负载均衡

```bash
    #安装HAProxy
    yum install -y haproxy
    cd /etc/haproxy
    vim haproxy.cfg
    listen admin_status
        bind 0.0.0.0:48800
        stats uri /admin-status
        stats auth admin:admin
    listen allmycat_service
        bind 0.0.0.0:8096
        mode tcp
        option tcplog
        option thhpchk OPTIONS * HTTP/1.1\r\nHost:\ www
        balance roundrobin
        service mycat_01 192.168.1.2:8066 check port 48700 inter 5s rise 2 fall 3
        service mycat_04 192.168.1.4:8066 check port 48700 inter 5s rise 2 fall 3
    listen allmycat_service
        bind 0.0.0.0:7
        mode tcp
        option tcplog
        option thhpchk OPTIONS * HTTP/1.1\r\nHost:\ www
        balance roundrobin
        service mycat_01 192.168.1.2:9066 check port 48700 inter 5s rise 2 fall 3
        service mycat_04 192.168.1.4:9066 check port 48700 inter 5s rise 2 fall 3

    yum install -y xinetd
    xinetd -y
    service xinetd restart

    haproxy -f /etc/hparoxy.cfg
```

```bash
    yum install -y keepalive
    cd /etc/keepalived
    vim keepalived.conf

```

## 5.mycat管理及监控

```bash
    #登录mycat命令行管理端
    mysql -h127.0.0.1 -uroot -p123456 -P9066
    show @@help  #帮助
    reload @@config  #重新加载配置文件
    show @@databases
    show @@datenode
    show @@heartbeat
    show @@connection
    show @@backend
```

* mycat-web

```bash
     
```

## 6.mycat集群优化

```bash
    #操作系统优化
    #mycat优化
```


### 将下载的Apache解压

* 在cmd中执行：

```bash
    httpd.exe -k uninstall -n “Apache24″
```

## 2 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)

