# 安装比特币节点

## 1.安装gcc组件

```bash
    yum install gcc gcc++
    yum install gcc gcc-c++ gcc-g77
```

## 2.安装依赖

```bash
    sudo yum install -y autoconf automake libtool libdb-devel boost-devel libevent-devel
```
## 3.下载源码，选择版本

```bash
    git clone https://github.com/bitcoin/bitcoin.git
    cd bitcoin
    git checkout v0.17.0
```

## 4.安装Berkeley DB数据库

```bash
    wget http://download.oracle.com/berkeley-db/db-4.8.30.NC.tar.gz
    tar -xzvf db-4.8.30.NC.tar.gz
    cd db-4.8.30.NC/build_unix/
    ../dist/configure --prefix=/usr/local/berkeleydb --enable-cxx
    make
    sudo make install
    sudo echo '/usr/local/berkeleydb/lib/' >> /etc/ld.so.conf
    sudo ldconfig
```

## 5.编译安装比特币客户端

```bash
    cd bitcoin
    ./autogen.sh
    ./configure LDFLAGS="-L/usr/local/berkeleydb/lib/" CPPFLAGS="-I/usr/local/berkeleydb/include/"
    make
    sudo make install
```

## 6.安装完成了验证下

```bash
    which bitcoind
    which bitcoin-cli
```

## 7.配置启动参数

* vim /root/bitcoin.conf

```bash
    datadir=/root/data
    testnet=0
    server=1
    gen=0
    daemon=0
    rpcport=8332
    rpcuser=xujunjie
    rpcpassword=xujunjie123456
    rpcallowip=0.0.0.0/0
    rpcconnect=127.0.0.1
```

* bitcoind -conf=/root/bitcoin.conf

## 7.参考

* [文档](https://blog.csdn.net/xls6006/article/details/84197995)