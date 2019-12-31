## money

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

> fund 基金股票

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
name|varchar(32)|名称
code|char(6)|编码
type|enum('1','2','3','4')|1:基金；2：指数；3：板块；4：股票\
status|enum('0','1')|0:无效；1：有效

```bash
create table if not exists `fund`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `name` varchar(32) not null default '' comment '名称',
    `code` char(6) not null default '' comment '编码',
    `type` enum('1','2','3','4') not null default '1' comment '1:基金；2：指数；3：板块；4：股票',
    `status` enum('0','1') not null default '1' comment '0:无效；1：有效'
)engine=innodb default charset=utf8;
```

> value 价值

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
fund_id|int|名称编号
time_id|int|时间编号
price|decimal(10,2)|价格

```bash
create table if not exists `value`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `fund_id` int not null comment '名称编号',
    `time_id` int not null comment '名称编号',
    `price` decimal(10,2) not null default 0.00 comment '价格'
)engine=innodb default charset=utf8;
```




> node_order 节点订单

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
user_id|int|用户编号
accounty_type|int|账户类型
pay_type|enum('1','2')|1：充值；2：提现
pay_id|varchar(100)|交易编号
send_address|varchar(64)|发送地址
receive_address|varchar(64)|接受地址
number|decimal(20,8)|数量
pound_number|decimal(20,8)|手续费
actual_number|decimal(20,8)|实际转账
create_time|timestamp|创建时间
trading_time|timestamp|交易时间
status|enum('10','20')|10:待确认；20：支付失败；30：支付成功

```bash
create table if not exists `node_order`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `user_id` int not null comment '用户编号',
    `account_type` int not null comment '账户类型',
    `pay_type` enum('1','2') not null default '1' comment '1：充值；2：提现',
    `pay_id` varchar(100) not null default '' comment '交易编号',
    `send_address` varchar(64) not null default '' comment '发送地址',
    `receive_address` varchar(64) not null default '' comment '接受地址',
    `number` decimal(20,8) not null default '0.0000' comment '数量',
    `pound_number` decimal(20,8) not null default '0.0000' comment '手续费',
    `actual_number` decimal(20,8) not null default '0.0000' comment '实际转账',
    `create_time` timestamp not null default CURRENT_TIMESTAMP comment '创建时间',
    `trading_time` timestamp not null default '0000-00-00 00:00:00' comment '交易时间',
    `status` enum('10','20','30') not null default '10' comment '10:待确认；20：支付失败；30：支付成功',
    KEY node_order_user_id(`user_id`)
)engine=innodb default charset=utf8;
```





> account_record 账户记录

字段名称|类型|描述|备注
-|-|-|-|
id|int|主键|自增长
account_id|int|账户编号
user_id|int|用户编号
accounty_type|int|账户类型
cultivation_order_id|int|养殖订单编号
promote_id|int|推广人编号
type|enum('1','2','3','4','5','6','7','8','9','10')|1:充值；2：提现;3：养殖消费;4:养殖收益；5：充值固定红利；6：充值新增红利；7：推广收益;8:兑换送农场之星;9:转入擂台；10：擂台转出
start_time|timestamp|开始时间
end_time|timestamp|结束时间
number|decimal(20,8)|发放金额
create_time|timestamp|操作时间
status|enum('0','1')|0:未发放；1：发放

```bash
create table if not exists `account_record`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `account_id` int not null comment '账户编号',
    `user_id` int not null comment '用户编号',
    `account_type` int not null comment '账户类型',
    `cultivation_order_id` int not null default 0 comment '养殖订单编号',
    `promote_id` int not null default 0 comment '推广人编号',
    `type` enum('1','2','3','4','5','6','7','8','9','10','11','12') not null default '2' comment '1:充值；2：提现;3：养殖消费;4:养殖收益；5：充值固定红利；6：充值新增红利；7：推广收益;8:兑换送农场之星,9:转入擂台；10：擂台转出;11：注册送农场之星；12：邀请送农场之星',
    `start_time` timestamp not null default '0000-00-00 00:00:00' comment '开始时间',
    `end_time` timestamp not null default '0000-00-00 00:00:00' comment '结束时间',
    `number` decimal(20,8) not null default 0.00000000 comment '发放金额',
    `create_time` timestamp not null default CURRENT_TIMESTAMP comment '操作时间',
    `status` enum('0','1') not null default '0' comment '是否发放',
    KEY account_record_account_id(`account_id`),
    KEY account_record_user_id(`user_id`),
    KEY account_record_cultivation_order_id(`cultivation_order_id`)
)engine=innodb default charset=utf8;
```





