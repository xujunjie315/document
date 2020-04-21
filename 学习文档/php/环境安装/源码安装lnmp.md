# 源码安装lnmp

## 1.c,c++编译器

```bash
    yum -y install gcc gcc-c++
```

## 2.nginx安装

### 2.1 官网下载源码包

* http://nginx.org/en/download.html

```bash
    wget http://nginx.org/download/nginx-1.16.1.tar.gz
    tar -xzf nginx-1.16.1.tar.gz
    cd nginx-1.16.1
    yum -y install openssl openssl-devel
    wget https://ftp.pcre.org/pub/pcre/pcre-8.43.tar.gz
    tar -xzf pcre-8.43.tar.gz
    wget http://zlib.net/zlib-1.2.11.tar.gz
    tar -xzf zlib-1.2.11.tar.gz
    #配置
    ./configure
    --sbin-path=/usr/local/nginx/nginx
    --conf-path=/usr/local/nginx/nginx.conf
    --pid-path=/usr/local/nginx/nginx.pid
    --with-http_ssl_module
    --with-pcre=../pcre-8.43
    --with-zlib=../zlib-1.2.11
    #编译
    make
    #安装
    make install
```

## 3.php安装

### 3.1 官网下载源码包

```bash
    wget https://www.php.net/distributions/php-7.3.14.tar.gz
    tar -xzf php-7.3.14.tar.gz
    cd php-7.3.14
    yum -y install libxml2-devel
    #配置
    ./configure --enable-fpm --with-mysql --with-mysqli --with-pdo-mysql
    #编译
    make
    #安装
    make install
    cp php.ini-development /usr/local/php/php.ini
    cp /usr/local/etc/php-fpm.d/www.conf.default /usr/local/etc/php-fpm.d/www.conf
    cp sapi/fpm/php-fpm /usr/local/bin
    vim /usr/local/php/php.ini
    cgi.fix_pathinfo=0
    vim /usr/local/etc/php-fpm.d/www.conf
    user = www-data
    group = www-data
    #启动php-fpm
    /usr/local/bin/php-fpm
    vim /usr/local/nginx/conf/nginx.conf
    location / {
        root   html;
        index  index.php index.html index.htm;
    }
    location ~* \.php$ {
        fastcgi_index   index.php;
        fastcgi_pass    127.0.0.1:9000;
        include         fastcgi_params;
        fastcgi_param   SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        fastcgi_param   SCRIPT_NAME        $fastcgi_script_name;
    }
    sudo /usr/local/nginx/sbin/nginx -s stop
    sudo /usr/local/nginx/sbin/nginx
```

## 4.mysql安装

### 3.1 官网下载mysql编译版

```bash
    wget http://nginx.org/download/nginx-1.16.1.tar.gz
    mv mysql  /opt/
    cd /usr/local/
    ln -s /opt/mysql/mysql
```    

## 2 参考

* [文档](https://www.imooc.com/learn/1070)

