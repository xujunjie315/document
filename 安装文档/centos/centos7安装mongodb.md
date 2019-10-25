# mongodb

## 1.下载并安装mongo

```bash
    curl -O https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-3.0.6.tgz
    tar -zxvf mongodb-linux-x86_64-3.0.6.tgz
    mv  mongodb-linux-x86_64-3.0.6/ /usr/local/mongodb
    export PATH=/usr/local/mongodb/bin:$PATH
    mkdir -p /data/db
    /usr/local/mongo/bin/mongod
```

## 2 参考

* [文档](https://blog.csdn.net/qq_32144341/article/details/51532207)

