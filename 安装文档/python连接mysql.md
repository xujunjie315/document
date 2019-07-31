# python连接mysql

## 1 修改历史

日期|修改人|备注
-|-|-
2018-10-20|尹绍彬|首次创建

## 2 安装python的mysql连接工具

### 2.1 安装mysql-connector-python
  ```bash
  pip install mysql-connector-python
  ```
### 2.2 参考文档

* [mysql 官方文档](https://dev.mysql.com/doc/connectors/en/connector-python-installation-binary.html)

## 3 代码实例
  ```bash
  import mysql.connector
  cnx = mysql.connector.connect(user='rms_test', password='rmsTest',host='webtest.rimag.com.cn',database='rms_test')
  cursor = cnx.cursor()
  cursor.execute('select * from city limit 10')
  print(cursor.fetchall());
  cnx.commit()
  cursor.close()
  cnx.close()
  ```
