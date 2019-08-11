# python连接oracle

## 1 修改历史

日期|修改人|备注
-|-|-
2018-10-20|尹绍彬|首次创建

## 2 安装cx_Oracle

### 2.1 安装依赖
  ```bash
  sudo apt install build-essential unzip python-dev libaio-dev
  ```
### 2.2 下载oracle客户端包,解压放入目录/usr/local/instantclient_12_2下
* Instant Client Package - Basic
* Instant Client Package - SDK 
* [下载地址](https://www.oracle.com/technetwork/topics/linuxx86-64soft-092277.html)

  ```bash
  sudo vi ~/.bashrc
  export ORACLE_HOME="usr/local/instantclient_12_2"
  export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:$ORACLE_HOME
  source ~/.bashrc
  ```
  
### 2.3 版本兼容问题
   ```bash
  cd /usr/local/instantclient_12_2
  ln -s libclntsh.so.12.1   libclntsh.so
  ```
### 2.4 配置oracle
  ```bash
  sudo vi  /etc/ld.so.conf.d/oracle.conf
  /usr/local/instantclient_12_2/libnnz11.so 
  /usr/local/instantclient_12_2/libociei.so 
  /usr/local/instantclient_12_2/libocijdbc11.so 
  /usr/local/instantclient_12_2/libclntsh.so 
  /usr/local/instantclient_12_2/libclntsh.so.11.1 
  /usr/local/instantclient_12_2/libocci.so.11.1 

  sudo sh -c "echo /usr/local/instantclient_12_2 > /etc/ld.so.conf.d/oracle.conf"
  sudo ldconfig
  export LD_LIBRARY_PATH=/usr/local/instantclient_12_2:$LD_LIBRARY_PATH
  ```

### 2.5 安装cx_Oracle
  pip install cx_Oracle


### 2.6 参考
* [oracle 官方文档](https://oracle.github.io/odpi/doc/installation.html#linux)

## 3 cx_oracle代码实例
  ```bash
  import cx_Oracle
  orcl = cx_Oracle.connect('jk/jk123@ipc.rimag.com.cn:21435/orcl')
  curs = orcl.cursor()
  curs.execute('select sysdate from dual')
  print(curs.fetchall())
  orcl.commit()
  curs.close()
  orcl.close()
  ```