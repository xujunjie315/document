# linux安装docker

## 1.下载需要的包

```bash
    sudo yum install -y yum-utils \
    device-mapper-persistent-data \
    lvm2
```

## 2.配置yum源

```bash
    sudo yum-config-manager \
    --add-repo \
    https://download.docker.com/linux/centos/docker-ce.repo
```

## 3.安装

* 最高版本安装
```bash
    sudo yum install docker-ce docker-ce-cli containerd.io
```
* 特定版本安装
```bash
sudo yum install docker-ce-<VERSION_STRING> docker-ce-cli-<VERSION_STRING> containerd.io
```
* 开机自启动
```bash
systemctl enable docker
```


## 2 参考

* [文档](https://docs.docker.com/install/linux/docker-ce/centos/#install-using-the-repository)
