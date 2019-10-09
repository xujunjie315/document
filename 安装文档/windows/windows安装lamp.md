# windows 系统下 php环境安装

## 1.下载并安装apache

### 将下载的Apache解压

* [下载地址](http://www.apachehaus.com/cgi-bin/download.plx)

### 修改/apache24/conf/httpd.conf文件
 
* Define SRVROOT "${SRVROOT}"  替换为 Define SRVROOT "E:/lamp/Apache/Apache24"(我的路径)
* DocumentRoot "${SRVROOT}/htdocs" (不改,则PHP文件在\Apache24\htdocs目录下)
* <Directory "${SRVROOT}/htdocs"> (不改,则PHP文件在\Apache24\htdocs目录下)
* 找到DirectoryIndex index.html 替换为 DirectoryIndex index.html index.php index.htm
* 最后添加新内容
```bash
    LoadModule php7_module "D:/ProGrame/PHP/php7apache2_4.dll" （注意PHP版本对应的修改，如果为5.X就改为5）
    AddType application/x-httpd-php .php .html .htm
    PHPIniDir "D:/ProGrame/PHP"   (注意  改为自己PHP的路径)
```

### 运行apache

* 在cmd中执行：
```bash
    D:\ProGrame\Apache\Apache24\bin\httpd -k install  -n “Apache24”
```

### 卸载apache

* 在cmd中执行：
```bash
    httpd.exe -k uninstall -n “Apache24″
```

### apache开启重写模式

* httpd.conf文件
LoadModule reqtimeout_module libexec/apache2/mod_reqtimeout.so 　　把前面的#去掉
Include /private/etc/apache2/extra/httpd-vhosts.conf　　把前面的#去掉
.htaccess下面的那个AllowOverride　将denied  改为all

* 重启apache

## 2.下载并安装php

### 将下载的php解压

* [下载地址](https://windows.php.net/download#php-7.0)

### 修改php配置文件

* 解压的文件中找到php.ini-production或php.ini-development 文件 将其中一个的名字改为php.ini
* 开启php常用扩展

## 3.下载并安装mysql

### 将下载的mysql解压

* [下载地址](https://dev.mysql.com/downloads/file/?id=462316)

## 4.参考

* [文档](https://www.cnblogs.com/li-mei/p/5959217.html)
* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)


