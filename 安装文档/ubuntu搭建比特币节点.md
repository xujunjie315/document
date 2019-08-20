# 搭建比特币节点

## apt包列表完全更新
```bash
    apt-get update -y
    apt-get upgrade -y
```

## 安装依赖

* [文档](https://github.com/bitcoin/bitcoin/blob/master/doc/build-unix.md)
```bash
    sudo apt-get install build-essential libtool autotools-dev automake pkg-config bsdmainutils python3
    sudo apt-get install libssl-dev libevent-dev libboost-system-dev libboost-filesystem-dev libboost-chrono-dev libboost-test-dev libboost-thread-dev
    sudo apt-get install libminiupnpc-dev
    sudo apt-get install libzmq3-dev
    sudo apt-get install libqt5gui5 libqt5core5a libqt5dbus5 qttools5-dev qttools5-dev-tools libprotobuf-dev protobuf-compiler
    sudo apt-get install libqrencode-dev
```
* [报错补充文档](https://www.zh30.com/ubuntu-cmake-could-not-find-boost.html)

```bash
    sudo apt-get install libboost-all-dev
```
### 下载源码

```bash
    cd ~
    git clone https://github.com/bitcoin/bitcoin.git
```

## 安装berkeley-db

```bash
    wget http://download.oracle.com/berkeley-db/db-4.8.30.NC.tar.gz
    tar -xzvf db-4.8.30.NC.tar.gz
    cd db-4.8.30.NC/build_unix/
    ../dist/configure --enable-cxx --disable-shared --with-pic --prefix=/home/root/bitcoin/db4/
    make
    sudo make install
```

## 安装比特币客户端

```bash
    cd ~/bitcoin/
    ./autogen.sh
    ./configure LDFLAGS="-L/home/root/bitcoin/db4/lib/" CPPFLAGS="-I/home/root/bitcoin/db4/include/"
    make
    sudo make install
```

## 安装完成了验证下

```bash
    which bitcoind
    which bitcoin-cli
```

## 2 参考

* [文档](https://book.8btc.com/books/6/masterbitcoin2cn/_book/ch03.html)
