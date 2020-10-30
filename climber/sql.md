# climber

> quarter 季度表

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
quarter|int|20201

```bash
create table if not exists `time`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `quarter` int not null default 0 comment '季度'
)engine=innodb default charset=utf8 comment='季度表';
```

> fund_manager 基金经理表

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
name|varchar(32)|名称

```bash
create table if not exists `fund_manager`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `name` varchar(32) not null default '' comment '名称'
)engine=innodb default charset=utf8 comment='基金经理表';
```

> fund 基金表

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
name|varchar(32)|名称
code|char(6)|编码
total_money|int|市值
start_date|date|创建时间
total_revenue|int|总收益
year_revenue|tinyint|年收益
manager_id|int|基金经理
manager_workday|int|工作时长
manager_total_revenue|int|总收益
manager_year_revenue|tinyint|年收益
status|enum(0,1)|是否有效

```bash
create table if not exists `fund`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `name` varchar(32) not null default '' comment '名称',
    `code` char(6) not null default '' comment '编码',
    `total_revenue` int not null default 0 comment '总收益',
    `year_revenue` tinyint not null default 0 comment '年收益',
    `start_date` date not null default '0000-00-00' comment '创建时间',
    `manager_id` int not null default 0 comment '基金经理',
    `manager_workday` int not null default 0 comment '经理工作时长',
    `manager_total_revenue` int not null default 0 comment '经理总收益',
    `manager_year_revenue` tinyint not null default 0 comment '经理年收益',
    `status` enum(0,1) not null default '1' comment '是否有效，1：有效'
)engine=innodb default charset=utf8 comment='基金表';
```

> relation_fund_stock 基金股票关联表

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
quarter_id|int|季度编号
fund_id|int|基金编号
stock_id|int|股票编号
rate|tinyint|比例

```bash
create table if not exists `relation_fund_stock`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `quarter_id` int not null default 0 comment '季度编号',
    `fund_id` int not null default 0 comment '基金编号',
    `stock_id` int not null default 0 comment '股票编号',
    `rate` tinyint not null default 0 comment '比例'
)engine=innodb default charset=utf8 comment='基金股票关联表';
```

> stock 股票

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
name|varchar(32)|名称
code|char(6)|编码
status|enum(0,1)|是否有效

```bash
create table if not exists `stock`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `name` varchar(32) not null default '' comment '名称',
    `code` char(6) not null default '' comment '编码',
    `status` enum(0,1) not null default '1' comment '是否有效，1：有效'
)engine=innodb default charset=utf8 comment='股票';
```
> account 账户表

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
type|enum(1)|账户类型
year|int|年份
money|int|金额


```bash
create table if not exists `account`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `type` enum(1) not null default '1' comment '账户类型',
    `year` int not null default 0 comment '年份',
    `money` int not null default 0 comment '金额'
)engine=innodb default charset=utf8 comment='账户表';
```

