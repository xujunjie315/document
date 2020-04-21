# 安装mycat

## 1.安装jdk

```bash
#yum安装
    yum install java-1.7.0-openjdk
#下载安装包安装
    rpm -qa | grep java
    rpm -e --nodeps 包名
```

## 2.下载mycat

```bash
    wget http://dl.mycat.io/1.6.5/Mycat-server-1.6.5-release-20180122220033-linux.tar.gz
    adduser mycat
    tar zxf
    mv mycat /usr/local
    cd /usr/local
    chown mycat:mycat -R mycat
    vi /etc/profile
    export JAVA_HOME=/usr
    export MYCAT_HOME=/usr/local/mycat
    #增加mycat执行文件目录到path
    :/usr/local/mycat/bin
    source /etc/profile
```

## 3.运行mycat

```bash
    su - mycat
    cd /usr/local/mycat
    #启动
    bin/startup_nowrap.sh
```

```bash
    vim /conf/wrapper.conf
    wrapper.java.additional.5=-XX:MaxDirectMemorySize=512M  #mycat内存
    free -m  #查看系统内存
    #启动
    mycat start
```


## 4.mycat配置文件

```bash
    schema.xml  #用于配置逻辑库表及数据节点
    <schema><table></table></schema>  #定义逻辑库表
    <dataNode></dataNode>             #定义数据节点
    <dataHost></dataHost>             #定义数据节点的物理数据源
    rule.xml    #用于配置表的分片规则
    <tableRule name=""></tableRule>   #定义使用的分片规则
    <function name=""></function>     #定义分片算法
    server.xml  #用于配置服务器权限
    <system><property name=""></property><system>  #用于定义系统配置
    <user></user>                                  #用于定义连接mycat的用户
```

## 2 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)
