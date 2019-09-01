# linux安装redis

## 1 安装redis
```bash
  wget http://download.redis.io/releases/redis-5.0.5.tar.gz
  tar xzf redis-5.0.5.tar.gz
  cd redis-5.0.5
  make
```
## 2 配置redis

* 配置redis后台启动

```bash
  daemonize yes
```

* 配置redis的端口

```bash
  port 6379
```

* 配置redis需密码连接

```bash
  requirepass xujunjie
```

* 配置redis外网连接

```bash
  * bind 127.0.0.1
  protected-mode no
```

## 3 启动redis服务端

```bash
  src/redis-server redis.config
```

## 4 直接连接redis

```bash
  src/redis-cli
```

## 5 参考
* [官方文档](http://www.redis.cn/download.html)