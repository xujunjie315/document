# mysql开发技巧

## 1.join语句

### 1.1 inner join

### 1.2 left join

```bash
    #left join 代替not in；not in 不使用索引
    sellec * from tableA A left join tableB B on A.key=B.key where B.key is null
```

### 1.3 right join

### 1.4 full join mysql不存在，用union all代替

```bash
    #取两边
    sellec * from tableA A full join tableB B on A.key=B.key where B.key is null or A.key is null
```

### 1.5 cross join

<!-- delete xu,jun from `xu` join `jun` on `xu`.id=`jun`.xid where `xu`.id=1 -->

## 2.分组选择

```bash
    row_number()
```

## 3.行列转换

* 使用场景：报表统计、汇总显示

```bash
    #行转列
    select sum(case when user_name='孙悟空' then kills end) as '孙悟空',sum(case when user_name='猪八戒' then kills end) as '猪八戒'，sum(case when user_name='沙僧' then kills end) as '沙僧' from user1 a join user_kills b on a.id=b.user_id;
    #列转行
    # tb_sequence为序列表，只有自增的那一列
    tb_sequence a cross join user1 b on a.id<=b.size
    #coalesce
    select coalesce( case when id=1 then name1 end,case when id=2 then name2 end,case when id=3 then name3 end)
```

## 4.生成唯一序列号

* 数据库主键
* 存储过程加事务

## 5.删除重复数据

```bash
    #判断是否重复
    select user_name,count(*) from user group by user_name having count(*)>1
    #相同数据保留最大的
    delete from user a join (select user_name count(*),max(id) as id from user group by user_name having count(*)>1) b on a.user_name=b.user_name where a.id<b.id
```

## 6.子查询匹配多列值

```bash
    select a.user_name,b.timestr,b.kills from user1 a join user_kills b on a.id=b.user_id join (select user_id,max(kills) as cnt from user_kills group by user_id) c on b.user_id=c.user_id and b.kills=c.cnt;
    #多列where
    select a.user_name,b.timestr,b.kills from user1 a join user_kills b on a.id=b.user_id where (b.user_id,b.kills) in (select user_id,max(kills) as cnt from user_kills group by user_id);
```

## 7.同列多值过滤

```bash
    select a.user_name,b.skill,c.skill from user1 a join user_skills b on a.id=b.user_id and b.skill = '念经' join user_skills c on c.user_id=b.user_id and b.skill = '变化'
    select a.user_name from user1 a join user_skills b on a.id=b.user_id where b.skill in ('念经','变化','腾云','浮水') group by a.user_name having count(*)>=2 
```

## 8.计算累进税

```bash
    select user_name,sum(curmoney*rate) from (select user_name,money,low,high,least(money-low,high-low) as curmoney,rate from user a join taxRate b on a.money>b.low) a group by user_name
```

## 2 参考

* [文档](https://www.imooc.com/learn/1070)

