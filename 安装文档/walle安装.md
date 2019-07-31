# walle安装

## 部署walle系统

### 1.docker安装

```bash
    sudo yum install -y yum-utils  device-mapper-persistent-data lvm2
    sudo yum-config-manager --add-repo  https://download.docker.com/linux/centos/docker-ce.repo
    sudo yum install docker-ce -y
    sudo systemctl enable docker
    sudo systemctl start docker
```

### 2.docker-compose安装

```bash
    pip install docker-compose -i https://mirrors.aliyun.com/pypi/simple/
```
### 3.配置文件

* walle.env
```bash
    # Set MySQL/Rails environment
    MYSQL_USER=root
    MYSQL_PASSWORD=walle
    MYSQL_DATABASE=walle
    MYSQL_ROOT_PASSWORD=walle
    MYSQL_HOST=db
    MYSQL_PORT=3306
```
* docker-compose.yml

```bash
    # docker version:  18.06.0+
    # docker-compose version: 1.23.2+
    # OpenSSL version: OpenSSL 1.1.0h
    version: "3.7"
    services:
    web:
        image: alenx/walle-web:2.1
        container_name: walle-nginx
        hostname: nginx-web
        ports:
        # 如果宿主机80端口被占用，可自行修改为其他port(>=1024)
        # 0.0.0.0:要绑定的宿主机端口:docker容器内端口80
        - "80:80"
        depends_on:
        - python
        networks:
        - walle-net
        restart: always

    python:
        image: alenx/walle-python:2.1
        container_name: walle-python
        hostname: walle-python
        env_file:
        # walle.env需和docker-compose在同级目录
        - ./walle.env
        command: bash -c "cd /opt/walle_home/ && /bin/bash admin.sh migration &&  python waller.py"
        expose:
        - "5000"
        volumes:
        - /opt/walle_home/plugins/:/opt/walle_home/plugins/
        - /opt/walle_home/codebase/:/opt/walle_home/codebase/
        - /opt/walle_home/logs/:/opt/walle_home/logs/
        - /root/.ssh:/root/.ssh/
        depends_on:
        - db
        networks:
        - walle-net
        restart: always

    db:
        image: mysql
        container_name: walle-mysql
        hostname: walle-mysql
        env_file:
        - ./walle.env
        command: [ '--default-authentication-plugin=mysql_native_password', '--character-set-server=utf8mb4', '--collation-server=utf8mb4_unicode_ci']
        ports:
        - "3306:3306"
        expose:
        - "3306"
        volumes:
        - /data/walle/mysql:/var/lib/mysql
        networks:
        - walle-net
        restart: always

    networks:
    walle-net:
        driver: bridge
```

### 4.启动命令

```bash
    docker-compose up -d && docker-compose logs -f
```

### 5 参考

[官方文档](http://www.walle-web.io/docs/installation_docker.html)

## 配置walle宿主机和目标机器的免密登陆

* 把walle系统的~/.ssh/ssh_rsa.pub，添加到目标机器的~/.ssh/authorized_keys中

## 生成gitlab秘钥

* 生成秘钥
```bash
    ssh-keygen -t rsa -C '你的邮箱替换'
```
* 把公钥拷贝到setting下的SSH Keys里

