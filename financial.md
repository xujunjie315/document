# financial

> time 时间表

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
time|date|时间

```bash
create table if not exists `time`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `time` date not null default '0000-00-00' comment '时间'
)engine=innodb default charset=utf8;
```

## 1.select company

* [公司混合排行](http://fund.eastmoney.com/company/)

* 混合基金排名前10，天相评级5星

> company 基金公司

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
name|varchar(32)|名称

```bash
create table if not exists `company`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `name` varchar(32) not null default '' comment '名称'
)engine=innodb default charset=utf8;
```

## 2.select fund

* [公司基金列表](http://fund.eastmoney.com/Company/80000221.html)

* [晨星评级](http://cn.morningstar.com/main/default.aspx)

* 规模大于30亿，晨星评级5星

> fund 基金

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
company_id|int|公司编号
name|varchar(32)|名称
code|char(6)|编码
start_time|int|开始时间
end_time|int|结束时间

```bash
create table if not exists `fund`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `company_id` int not null comment '公司编号',
    `name` varchar(32) not null default '' comment '名称',
    `code` char(6) not null default '' comment '编码',
    `start_time` int not null default 1 comment '开始时间',
    `end_time` int comment '结束时间',
)engine=innodb default charset=utf8;
```

## 3.select stock

> stock 股票

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
company_id|int|公司编号
fund_id|int|基金编号
name|varchar(32)|名称
code|char(6)|编码
type|enum('1','2')|1:长久；2：新
start_time|int|开始时间
end_time|int|结束时间

```bash
create table if not exists `stock`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `company_id` int not null comment '公司编号',
    `fund_id` int not null comment '基金编号',
    `name` varchar(32) not null default '' comment '名称',
    `code` char(6) not null default '' comment '编码',
    `type` enum('1','2') not null default '1' comment '1：长久；2：新',
    `start_time` int not null default 1 comment '开始时间',
    `end_time` int comment '结束时间'
)engine=innodb default charset=utf8;
```




create table if not exists `user`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `user_no` int unsigned not null default 1 comment'用户ID',
    `name` varchar(32) not null default '' comment '名称'
)engine=innodb default charset=utf8;

create table if not exists `user_detail`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `user_no` int unsigned not null default 1 comment'用户ID',
    `detail` varchar(32) not null default '' comment '详情'
)engine=innodb default charset=utf8;
