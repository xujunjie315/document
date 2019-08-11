# python连接sql server

## 1 修改历史

日期|修改人|备注
-|-|-
2018-10-20|尹绍彬|首次创建

## 2 安装sql server的连接工具odbc

### 2.1 添加官方驱动源地址
  ```bash
  sudo su 
  curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
  curl https://packages.microsoft.com/config/ubuntu/16.04/prod.list > /etc/apt/sources.list.d/mssql-release.list
  exit
  ```
### 2.2 升级源并安装odbc驱动
  ```bash
  sudo apt-get update
  sudo ACCEPT_EULA=Y apt-get install msodbcsql
  ```

### 2.3 安装mssql-tool
  ```bash
  sudo ACCEPT_EULA=Y apt-get install mssql-tools
  echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
  echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
  source ~/.bashrc
  ```

### 2.4 安装pyodbc和依赖
  ```bash
  sudo apt-get install unixodbc-dev
  sudo pip install pyodbc
  ```

### 2.5 查看sql server的odbc配置
  ```bash
  vi /etc/odbcinst.ini 
  ```

### 2.6 安装odbc参考文档

* [sql server 官方文档](https://docs.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-2017#microsoft-odbc-driver-17-for-sql-server)

### 2.7 odbc代码实例
  ```bash
  import pyodbc
  cnxn = pyodbc.connect('DRIVER={ODBC Driver 13 for SQL Server};SERVER=ris.rimag.com.cn,21433;DATABASE=RIS;UID=ymyg;PWD=ymyg')
  cursor = cnxn.cursor()
  cursor.execute('select @@version')
  print(cursor.fetchall())
  cnxn.close()
  ```
  
## 3 安装sql server的连接工具pymssql

### 3.1 安装freeTDS

  ```bash
  yum install -y freetds
  ```
### 3.2安装pymssql

  ```bash
  pip install pymssql
  ```
### 3.3 安装pymssql参考文档

* [pymssql 官方文档](http://www.pymssql.org/en/stable/intro.html#supported-related-software)
  
### 3.4 odbc代码实例

```bash
import pymssql
cur = pymssql.connect(host='ris.rimag.com.cn', user='ymyg', password='ymyg', database='RIS', port=21433).cursor()
cur.execute('select @@version')
print(cur.fetchall())
```

