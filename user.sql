create table if not exists `user`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `promoter_id` unsigned int not null default 0 comment '推广人id',
    `note` varchar(128) not null default '' comment '推广备注',
    `type` enum(2,4,6) not null default 2 comment '2:普通用户；4：商家；6：区域合伙人',
    `user_name` varchar(16) not null default '' comment '用户名',
    `ava_url` varchar(128) not null default '' comment '图像地址',
    `phone` char(11) not null default '' comment '手机号',
    `word_help` varchar(256) not null default '' comment ''助记词,
    `password` varchar(32) not null default '' comment '登陆密码',
    `pay_password` varchar(32) not null default '' comment '支付密码',
    `invite_code` varchar(16) not null default '' comment '邀请码',
    `region_id` int not null default 0 comment '区域id',
    `create_time` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8;

create table if not exists `system_notice`(
  `id` int unsigned  primary key auto_increment comment '主键ID',
  `title` varchar(128) not null default '' comment '标题',
  `image_url` varchar(128) not null default '' comment '公告图片',
  `content` varchar(1280) not null default '' comment '公告内容',
  `read_num` mediumint unsigned not null default 0 comment '阅读量',
  `create_time` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8;

create table if not exists `payment_method`(
  `id` int unsigned  primary key auto_increment comment '主键ID',
  `user_id` int unsigned comment '用户ID',
  `payment_type` enum(2,4,6) not null default 2 comment '2：支付宝，4：微信，6：银行卡',
  `name` varchar(16) not null default '' comment '姓名',
  `code` varchar(32) not null default '' comment '账号',
  `pay_url` varchar(128) not null default '' comment '收款二维码',
  `bank_name` varchar(16) not null default '' comment '开户银行',
  `bank_info` varchar(64) not null default '' comment '支行信息',
  `status` tyint not null default 1 comment '1：有效，0：无效',
  `create_time` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8;

create table if not exists `wallet`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `user_id` int unsigned comment '用户ID',
    `type` enum(2,4,6,8,10) not null default 2 comment '钱包类型，2:wocs钱包；4：消费钱包；6：补贴钱包；8:余额钱包；10:加速钱包',
    `balance` decimal(16,4) not null default 0.0000 comment '余额',
    `freeze` decimal(16,4) not null default 0.0000 comment '冻结数',
    `create_time` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8;

create table if not exists `wallet_log`(
    `id` int unsigned  primary key auto_increment comment '主键ID',
    `user_id` int unsigned comment '用户ID',
    `business_id` int unsigned comment '业务ID',
    `business_type` enum(2,4) not null default 2 comment '业务类型',
    `type` enum(2,4,6,8) not null default 2 comment '钱包类型，2：消费钱包；4：补贴钱包；余额钱包；加速钱包',
    `number` decimal(16,4) not null default 0.0000 comment '变化值',
    `create_time` int not null default 0 comment '创建时间'
)engine=innodb default charset=utf8;


区域合伙人、我的团队暂时空白不知道怎样
