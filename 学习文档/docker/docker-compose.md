# docker-compose

## 1. 安装docker-compose

```bash
sudo curl -L https://github.com/docker/compose/releases/download/1.21.2/docker-compose-$(uname -s)-$(uname -m) -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose -v
```

## 2. 常见命令

* 列出所有运行容器

```bash
docker-compose ps
```

* 查看服务日志输出

```bash
docker-compose logs
```

* 构建或者重新构建服务

```bash
docker-compose build
```

* 启动指定服务已存在的容器

```bash
docker-compose start
```

* 停止已运行的服务的容器

```bash
docker-compose stop
```

* 删除指定服务的容器

```bash
docker-compose rm
```

* 构建、启动容器

```bash
docker-compose up -d
```

* 通过发送 SIGKILL 信号来停止指定服务的容器

```bash
docker-compose kill
```

* 下载服务镜像

```bash
docker-compose pull
```

* 停止、卸载容器

```bash
docker-compose down
```

* 在一个服务上执行一个命令

```bash
docker-compose run
```

## 3. docker-compose.yml属性

* version：指定 docker-compose.yml 文件的写法格式
* services：多个容器集合
* build：配置构建时，Compose 会利用它自动构建镜像，该值可以是一个路径，也可以是一个对象，用于指定 Dockerfile 参数
* version：指定 docker-compose.yml 文件的写法格式
* services：多个容器集合
* build：配置构建时，Compose 会利用它自动构建镜像，该值可以是一个路径，也可以是一个对象，用于指定 Dockerfile 参数
* dns：配置 dns 服务器，可以是一个值或列表
* dns_search：配置 DNS 搜索域，可以是一个值或列表
* environment：环境变量配置，可以用数组或字典两种方式
* env_file：从文件中获取环境变量，可以指定一个文件路径或路径列表，其优先级低于 environment 指定的环境变量
* expose：暴露端口，只将端口暴露给连接的服务，而不暴露给主机
* image：指定服务所使用的镜像
* network_mode：设置网络模式
* ports：对外暴露的端口定义，和 expose 对应
* links：将指定容器连接到当前连接，可以设置别名，避免ip方式导致的容器重启动态改变的无法连接情况
* volumes：卷挂载路径
* logs：日志输出信息

## 4 参考

* [文档](https://www.jianshu.com/p/658911a8cff3)