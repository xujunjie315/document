# python连接postgresql

## 1 修改历史

日期|修改人|备注
-|-|-
2018-10-20|尹绍彬|首次创建

## 2 安装python的mysql连接工具

### 2.1 安装mysql-connector-python
  ```bash
  pip install psycopg2-binary
  pip install psycopg2
  ```
### 3 参考文档

* [postgresql 官方文档](http://initd.org/psycopg/docs/)

## 3.1 代码实例
  ```bash
  import psycopg2
  conn = psycopg2.connect(database="filmwx", user="postgres", password="Vmt20141118", host="film.rimag.com.cn", port="15432")
  cursor = conn.cursor()
  cursor.execute('SELECT * FROM public."Hospital" ORDER BY "Id" ASC ')
  print(cursor.fetchall())
  conn.commit()
  cursor.close()
  conn.close()
  ```









