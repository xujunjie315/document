# centos7安装lnmp

## 1.镜像源切换

```bash
    cp /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
	wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
	yum clean all
	yum makecache
	yum update
```

## 2.安装Nginx

```bash
    vi /etc/yum.repos.d/nginx.repo
```
```bash
	[nginx]
	name=nginx repo
	baseurl=http://nginx.org/packages/centos/$releasever/$basearch/
	gpgcheck=0
	enabled=1
```
```bash
	yum -y install nginx
	nginx
	# 开机自启动
	systemctl enable nginx
	systemctl daemon-reload
```

## 3.安装MySql

```bash
    rpm -Uvh http://dev.mysql.com/get/mysql57-community-release-el7-9.noarch.rpm
	yum -y install mysql-community-server
	service mysqld start
	systemctl enable mysqld
	systemctl daemon-reload
	# 查看密码
	grep 'temporary password' /var/log/mysqld.log
	mysql -uroot -p
	# 修改密码
	ALTER USER 'root'@'localhost' IDENTIFIED BY 'Xjj@940315';
	#        权限          库 表   用户名 允许ip               密码
	GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'Xjj@940315' WITH GRANT OPTION;
	FLUSH PRIVILEGES;
	
```
```bash
	vim /etc/my.cnf
	character_set_server=utf8
	init_connect='SET NAMES utf8'
	systemctl restart mysqld
```

## 4.安装PHP7

```bash
    rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
	rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
	yum install -y php70w.x86_64 php70w-cli.x86_64 php70w-common.x86_64 php70w-gd.x86_64 php70w-ldap.x86_64 php70w-mbstring.x86_64 php70w-mcrypt.x86_64 php70w-mysql.x86_64 php70w-pdo.x86_64
	yum install -y php70w-fpm php70w-opcache
	#安装php扩展要添加
	yum install php70w-devel
	systemctl start php-fpm
	systemctl enable php-fpm
	systemctl daemon-reload
```
```bash
	vim /etc/nginx/conf.d/default.conf
	location ~ \.php$ {
        root           /usr/share/nginx/html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
```


## 5.配置pathinfo路由和路由重写

```bash
    location ~ \.php(.*)$ {
	    fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
	    fastcgi_index index.php;
	
	    #这一句的作用是可以支持tp5的URL访问模式
	    fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
	
	    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
	
	    #改的时候说这两句是真正支持index.php/index/index/index的pathinfo模式（自己测试的时候上面一句没加是不可以的）
	    fastcgi_param  PATH_INFO  $fastcgi_path_info;
	    fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
	
	    include fastcgi_params;
    }
```

```bash
    location / {
	    if (!-e $request_filename) {
		    rewrite ^/tp5/(.*)$ /tp5/public/index.php/$1 last;
		    break;
	    }
    }
```
* [文档](https://blog.csdn.net/qq_43489208/article/details/92128179)


## 6.参考

* [文档](https://www.cnblogs.com/lishanlei/p/9055344.html)