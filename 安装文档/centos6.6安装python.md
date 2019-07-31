# python安装

## 1 修改历史

日期|修改人|备注
-|-|-
2018-10-20|尹绍彬|首次创建

## 2 安装wget,curl,git
```bash
  yum -y install wget
  yum -y install curl
  yum -y install git
```
## 3 升级centos6.6的nss
```bas
  yum -y update nss
```

## 4 安装配置pyenv
```bash
  curl -L https://github.com/pyenv/pyenv-installer/raw/master/bin/pyenv-installer | bash
  把一下三行加入 ~/.bashrc中
  export PATH="~/.pyenv/bin:$PATH"
  eval "$(pyenv init -)"
  eval "$(pyenv virtualenv-init -)"
  source ~/.bashrc
```

## 5 安装配置
```bash
  yum install gcc make patch gdbm-devel openssl-devel sqlite-devel readline-devel zlib-devel bzip2-devel libffi-devel -y
  ```

## 6 升级centos6.6的openssl
* [openssl下载地址](https://www.openssl.org/source/)
* 安装openssl

```bash
  wget https://www.openssl.org/source/openssl-1.1.0c.tar.gz
  tar -zxvf openssl-1.1.0c.tar.gz
  cd openssl-1.1.0c
  ./config shared zlib --prefix=/usr/local/openssl-1.1.0c --openssldir=/usr/local/openssl-1.1.0c/ssl
  make
  make install 
  mv /usr/bin/openssl /usr/bin/openssl.20180814
  mv /usr/include/openssl /usr/include/openssl.20180814
  ln -s /usr/local/openssl-1.1.0c/bin/openssl /usr/bin/openssl
  ln -s /usr/local/openssl-1.1.0c/include/openssl /usr/include/openssl
  ```
* 关联库文件

```bash
  ln -s /usr/local/openssl-1.1.0c/lib/libssl.so.1.1 /usr/lib64/libssl.so.1.1
  ln -s /usr/local/openssl-1.1.0c/lib/libcrypto.so.1.1 /usr/lib64/libcrypto.so.1.1 
  ```
* 查看安装版本

```bash  
  openssl version -a 
```

## 7 安装python3.7
  ```bash
    CFLAGS="-I/usr/local/openssl-1.1.0c/include" \
    LDFLAGS="-L/usr/local/openssl-1.1.0c/lib" \
    pyenv install -v 3.7.0
    pyenv global 3.7.0
  ```

## 8 参考
* [官方文档](https://github.com/pyenv/pyenv/wiki/Common-build-problems#error-the-python-ssl-extension-was-not-compiled-missing-the-openssl-lib)