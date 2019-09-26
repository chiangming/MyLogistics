# MyLogistics
Logistics distribution system made by using PHP

# How to config
本系统服务器发布在apache上，数据库连接的mysql。
此工程开发时使用的apache与mysql的集成开发工具XAMPP进行工程的开发。
重新搭建本系统只需要在解压后的文件夹mylogistics放置于XAMPP中的htdocs目录下，然后按照下述SQL进行数据库的建立即可运行本网页项目。此处的mysql_connect.php为数据库连接的配置文件。需更改此配置文件相应参数以符合的新搭建环境。

# SQL
CREATE TABLE `mylogistics`.`user` ( `uid` INT(10) NOT NULL AUTO_INCREMENT COMMENT '用户ID' , `uname` VARCHAR(50) NOT NULL COMMENT '用户名' , `upsw` VARCHAR(50) NOT NULL COMMENT '用户密码' , `uphone`  BIGINT(20) NOT NULL COMMENT '用户电话' , `umail` VARCHAR(50) NOT NULL COMMENT '用户邮箱' , PRIMARY KEY (`uid`), UNIQUE (`uname`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '用户表';

CREATE TABLE `mylogistics`.`courier` ( `cid` INT(10) NOT NULL AUTO_INCREMENT COMMENT '快递员ID' , `cname` VARCHAR(50) NOT NULL COMMENT '快递员名' , `cpsw` VARCHAR(50) NOT NULL COMMENT '快递员密码' , PRIMARY KEY (`cid`), UNIQUE (`cname`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '快递员表';

CREATE TABLE `mylogistics`.`goods` ( `oid` INT(8) NOT NULL AUTO_INCREMENT COMMENT '订单ID' , `oname` VARCHAR(50) NOT NULL COMMENT '订单名' , `odes` VARCHAR(250) NOT NULL COMMENT '订单描述' , `ocid` INT(8) NOT NULL COMMENT '订单快递员ID' , `ouid` INT(8) NOT NULL COMMENT '订单用户ID' , `obll` VARCHAR(50) NOT NULL COMMENT '发货坐标' , `oell` VARCHAR(50) NOT NULL COMMENT '收货坐标' , `obegin` VARCHAR(250) NOT NULL COMMENT '发货地址' , `oend` VARCHAR(250) NOT NULL COMMENT '收货地址' , `ocll` VARCHAR(50) NOT NULL COMMENT '配送员坐标' , `ostate` VARCHAR(250) NOT NULL COMMENT '配送状态' , PRIMARY KEY (`oid`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = '订单表';

ALTER TABLE `goods` ADD `otime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `ostate`;

ALTER TABLE `courier` ADD `cstate` TINYINT NOT NULL AFTER `cpsw`;

ALTER TABLE `goods` CHANGE `ostate` `ostate` TINYINT NOT NULL COMMENT '配送状态';

ALTER TABLE `goods` ADD `obname` VARCHAR(50) NOT NULL COMMENT '发货用户' AFTER `otime`, ADD `obphone` BIGINT NOT NULL COMMENT '发货用户联系方式' AFTER `obname`, ADD `oename` VARCHAR(50) NOT NULL COMMENT '收货用户' AFTER `obphone`, ADD `oephone` BIGINT NOT NULL COMMENT '收货用户联系方式' AFTER `oename`;
