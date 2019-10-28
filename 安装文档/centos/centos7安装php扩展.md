# 安装php扩展

## 1.下载

* [下载地址](http://pecl.php.net/package/swoole)

## 2.选择版本

* 注意Dependencies

## 3.编译安装

* 执行phpize命令需要安装php-dev

```bash
    sudo apt-get install php-dev
    yum install php70w-devel
```

* 自动配置需要安装autoconf

```bash
    yum intall autoconf
```

```bash
    cd swoole-4.2.12
    phpize
    ./configure --with-php-config=/usr/local/php/bin/php-config
    make && make install
```

## 4.开启扩展

```bash
    vim /etc/php.ini
    extension=swoole.so
```

## 5.重启php-fpm

```bash
    Service php-fpm restart
```

## 6.参考

* [视频](https://www.imooc.com/learn/757)