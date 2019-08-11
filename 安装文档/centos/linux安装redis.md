# linux安装redis

## 1 安装redis
```bash
  wget http://download.redis.io/releases/redis-5.0.5.tar.gz
  tar xzf redis-5.0.5.tar.gz
  cd redis-5.0.5
  make
```
## 2 配置外网可访问

* 注释 bind 127.0.0.1
* requirepass xujunjie
* protected-mode no

## 3 启动redis服务端

```bas
  src/redis-server redis.config
```

## 4 直接连接redis

```bas
  src/redis-cli
```

## 5 参考
* [官方文档](http://www.redis.cn/download.html)