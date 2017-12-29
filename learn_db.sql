/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.7.14 : Database - learn_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`learn_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `learn_db`;

/*Table structure for table `org_department` */

DROP TABLE IF EXISTS `org_department`;

CREATE TABLE `org_department` (
  `dept_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `dept_name` varchar(20) DEFAULT NULL COMMENT '部门名称',
  PRIMARY KEY (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf32;

/*Data for the table `org_department` */

insert  into `org_department`(`dept_id`,`dept_name`) values (1,'总监部'),(2,'研发部');

/*Table structure for table `org_user` */

DROP TABLE IF EXISTS `org_user`;

CREATE TABLE `org_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` varchar(20) DEFAULT NULL COMMENT '用户登录名',
  `user_name` varchar(20) DEFAULT NULL COMMENT '用户真实姓名',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `user_priv` int(11) DEFAULT NULL COMMENT '用户权限，关联org_user_priv',
  `dept_id` int(11) DEFAULT NULL COMMENT '部门id，关联org_department',
  `mobile` bigint(20) DEFAULT NULL COMMENT '手机号',
  `email` varchar(20) DEFAULT NULL COMMENT '用户邮箱',
  `extension` int(11) DEFAULT NULL COMMENT '分机号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `org_user` */

insert  into `org_user`(`id`,`user_id`,`user_name`,`password`,`user_priv`,`dept_id`,`mobile`,`email`,`extension`) values (1,'kangaroo','袋鼠','e10adc3949ba59abbe56e057f20f883e',1,2,18824276732,'123456@qq.com',1000);

/*Table structure for table `org_user_priv` */

DROP TABLE IF EXISTS `org_user_priv`;

CREATE TABLE `org_user_priv` (
  `priv_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `priv_name` varchar(20) DEFAULT NULL COMMENT '权限名称',
  `priv_str` varchar(200) DEFAULT NULL COMMENT '权限',
  PRIMARY KEY (`priv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `org_user_priv` */

insert  into `org_user_priv`(`priv_id`,`priv_name`,`priv_str`) values (1,'总经理','customer_add,customer_edit,customer_del'),(2,'坐席','customer_add');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
