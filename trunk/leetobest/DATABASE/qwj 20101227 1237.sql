-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.18-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema questionnaire
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ questionnaire;
USE questionnaire;

--
-- Table structure for table `questionnaire`.`admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `admins_id` int(10) unsigned NOT NULL auto_increment,
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '用户ID',
  `roles_id` int(10) unsigned NOT NULL default '0' COMMENT '角色ID',
  `admins_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '添加时间',
  `admins_status` int(10) unsigned NOT NULL default '1' COMMENT '状态1-激活 2-关闭',
  `admins_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序 值为1-9 9最大',
  `admins_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `admins_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `admins_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`admins_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='管理员';

--
-- Dumping data for table `questionnaire`.`admins`
--

/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`admins_id`,`users_id`,`roles_id`,`admins_addtime`,`admins_status`,`admins_sort`,`admins_remark1`,`admins_remark2`,`admins_remark3`) VALUES 
 (1,1,1,'2010-12-19 10:06:53',1,1,'','','');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `answers_id` int(10) unsigned NOT NULL auto_increment,
  `questionnaires_id` int(10) unsigned NOT NULL default '0' COMMENT '问卷表id',
  `questions_id` int(10) unsigned NOT NULL default '0' COMMENT '题干表id',
  `answers_answer` text character set utf8 COMMENT '答案',
  `answers_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '回答时间',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '回答者---用户表主键',
  `answers_ip` varchar(45) character set utf8 NOT NULL default '' COMMENT 'ip地址',
  `departments_id` int(10) unsigned NOT NULL default '0' COMMENT '部门表id',
  `answers_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `answers_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `answers_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`answers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='回答表';

--
-- Dumping data for table `questionnaire`.`answers`
--

/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`answers_users`
--

DROP TABLE IF EXISTS `answers_users`;
CREATE TABLE `answers_users` (
  `au_id` int(10) unsigned NOT NULL auto_increment,
  `questionnaires_id` int(10) unsigned NOT NULL default '0' COMMENT '问卷表主键',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '用户表主键',
  `au_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '回答时间',
  `au_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `au_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `au_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`au_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='回答者表';

--
-- Dumping data for table `questionnaire`.`answers_users`
--

/*!40000 ALTER TABLE `answers_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `answers_users` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`attributes`
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE `attributes` (
  `attributes_id` int(10) unsigned NOT NULL auto_increment COMMENT '主键,自增',
  `questions_id` int(10) unsigned NOT NULL default '0' COMMENT '题干表id',
  `attributes_name` varchar(255) character set utf8 NOT NULL default '' COMMENT '名称',
  `attributes_mark` int(10) unsigned NOT NULL default '0' COMMENT '分值',
  `attributes_customize` int(10) unsigned NOT NULL default '1' COMMENT '自填--1 不是 2 是',
  `attributes_value` varchar(255) character set utf8 NOT NULL default '' COMMENT '对应值',
  `attributes_status` int(10) unsigned NOT NULL default '1' COMMENT '状态---1 激活 2 关闭',
  `attributes_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序',
  `users_id` int(10) unsigned NOT NULL default '0',
  `attributes_addtime` varchar(45) character set utf8 NOT NULL default '',
  `attributes_remark1` varchar(45) character set utf8 default NULL,
  `attributes_remark2` varchar(45) character set utf8 default NULL,
  `attributes_remark3` varchar(45) character set utf8 default NULL,
  PRIMARY KEY  (`attributes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='选项表';

--
-- Dumping data for table `questionnaire`.`attributes`
--

/*!40000 ALTER TABLE `attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `attributes` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`attributes_total`
--

DROP TABLE IF EXISTS `attributes_total`;
CREATE TABLE `attributes_total` (
  `at_id` int(10) unsigned NOT NULL auto_increment,
  `questionnaires_id` int(10) unsigned NOT NULL default '0' COMMENT '问卷表id',
  `questions_id` int(10) unsigned NOT NULL default '0' COMMENT '题目表主键',
  `attributes_id` int(10) unsigned NOT NULL default '0' COMMENT '选项表id',
  `at_no` int(10) unsigned NOT NULL default '0' COMMENT '选择次数',
  `at_remark1` varchar(45) default NULL COMMENT '备用字段',
  `at_remark2` varchar(45) default NULL COMMENT '备用字段',
  `at_remark3` varchar(45) default NULL COMMENT '备用字段',
  PRIMARY KEY  (`at_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='选项统计表';

--
-- Dumping data for table `questionnaire`.`attributes_total`
--

/*!40000 ALTER TABLE `attributes_total` DISABLE KEYS */;
/*!40000 ALTER TABLE `attributes_total` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `departments_id` int(10) unsigned NOT NULL auto_increment,
  `departments_name` varchar(255) character set utf8 NOT NULL default '' COMMENT '组织结构名称',
  `departments_parentid` int(10) unsigned NOT NULL default '0' COMMENT '上一级',
  `departments_status` int(10) unsigned NOT NULL default '1' COMMENT '组织结构状态---1 活动 2 关闭',
  `departments_sort` int(10) unsigned NOT NULL default '1' COMMENT '组织结构排序---值为1-9，越大越靠前',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '添加者--用户表主键',
  `departments_addtime` varchar(45) character set utf8 default NULL COMMENT '添加时间',
  `departments_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `departments_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `departments_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`departments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='部门; InnoDB free: 11264 kB';

--
-- Dumping data for table `questionnaire`.`departments`
--

/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` (`departments_id`,`departments_name`,`departments_parentid`,`departments_status`,`departments_sort`,`users_id`,`departments_addtime`,`departments_remark1`,`departments_remark2`,`departments_remark3`) VALUES 
 (8,'董事会',0,1,1,1,'2010-12-23 05:51:35','','',''),
 (9,'院办',8,1,1,1,'2010-12-23 05:51:51','','',''),
 (10,'营运管理中心',9,1,1,1,'2010-12-23 05:52:06','','',''),
 (11,'教学研究与管理中心',9,1,1,1,'2010-12-23 05:52:20','','',''),
 (12,'财务部',9,1,1,1,'2010-12-23 05:52:35','','',''),
 (13,'人力资源部',9,1,1,1,'2010-12-23 05:52:51','','',''),
 (14,'督导培训部',10,1,1,1,'2010-12-23 05:53:08','','',''),
 (15,'市场策划部',10,1,1,1,'2010-12-23 05:53:24','','',''),
 (16,'湖北省区',10,1,1,1,'2010-12-23 05:53:37','','',''),
 (17,'河南省区',10,1,1,1,'2010-12-23 05:53:51','','',''),
 (18,'外省省区',10,1,1,1,'2010-12-23 05:54:05','','',''),
 (19,'湖北一区',16,1,1,1,'2010-12-23 05:54:40','','',''),
 (20,'湖北二区',16,1,1,1,'2010-12-23 05:54:54','','',''),
 (21,'湖北三区',16,1,1,1,'2010-12-23 05:55:12','','','');
INSERT INTO `departments` (`departments_id`,`departments_name`,`departments_parentid`,`departments_status`,`departments_sort`,`users_id`,`departments_addtime`,`departments_remark1`,`departments_remark2`,`departments_remark3`) VALUES 
 (22,'武汉办事处',16,1,1,1,'2010-12-23 05:55:33','','',''),
 (23,'河南一区',17,1,1,1,'2010-12-23 05:55:48','','',''),
 (24,'河南二区',17,1,1,1,'2010-12-23 05:56:50','','',''),
 (25,'江西区',18,1,1,1,'2010-12-23 05:57:12','','',''),
 (26,'湖南区',18,1,1,1,'2010-12-23 05:57:24','','',''),
 (27,'教务处',11,1,1,1,'2010-12-23 05:57:51','','',''),
 (28,'学工处',11,1,1,1,'2010-12-23 05:58:03','','',''),
 (29,'教研室',11,1,1,1,'2010-12-23 05:58:18','','',''),
 (30,'教质办',11,1,1,1,'2010-12-23 05:58:31','','',''),
 (31,'学员就业与服务中心',11,1,1,1,'2010-12-23 05:58:47','','',''),
 (32,'后勤服务部',11,1,1,1,'2010-12-23 05:59:29','','',''),
 (33,'企业高级服务中心',11,1,1,1,'2010-12-23 05:59:42','','',''),
 (34,'资金管理处',12,1,1,1,'2010-12-23 06:00:10','','',''),
 (35,'会计核算处',12,1,1,1,'2010-12-23 06:00:24','','','');
INSERT INTO `departments` (`departments_id`,`departments_name`,`departments_parentid`,`departments_status`,`departments_sort`,`users_id`,`departments_addtime`,`departments_remark1`,`departments_remark2`,`departments_remark3`) VALUES 
 (36,'人资管理处',13,1,1,1,'2010-12-23 06:00:38','','',''),
 (37,'质量管理处',13,1,1,1,'2010-12-23 06:00:52','','',''),
 (38,'网络安全组',29,1,1,1,'2010-12-23 06:01:38','','',''),
 (39,'信息安全一组',29,1,1,1,'2010-12-23 06:01:53','','',''),
 (40,'信息安全二组',29,1,1,1,'2010-12-23 06:02:23','','',''),
 (41,'WEB组',29,1,1,1,'2010-12-23 06:02:43','','',''),
 (42,'数码组',29,1,1,1,'2010-12-23 06:02:59','','',''),
 (43,'职素组',29,1,1,1,'2010-12-23 06:03:16','','',''),
 (44,'数码艺术工作室',29,1,1,1,'2010-12-23 06:03:52','','',''),
 (45,'英语组',29,1,1,1,'2010-12-23 06:04:13','','',''),
 (46,'软件研发工作室',29,1,1,1,'2010-12-23 06:04:30','','',''),
 (47,'IBM组',29,1,1,1,'2010-12-23 07:28:28','','',''),
 (48,'水电维修组',32,1,1,1,'2010-12-23 07:31:17','','',''),
 (49,'资产管理组',32,1,1,1,'2010-12-23 07:31:33','','','');
INSERT INTO `departments` (`departments_id`,`departments_name`,`departments_parentid`,`departments_status`,`departments_sort`,`users_id`,`departments_addtime`,`departments_remark1`,`departments_remark2`,`departments_remark3`) VALUES 
 (50,'保安保洁组',32,1,1,1,'2010-12-23 07:31:52','','',''),
 (51,'车队',32,1,1,1,'2010-12-23 07:34:00','','',''),
 (52,'采购组',32,1,1,1,'2010-12-23 07:34:20','','',''),
 (53,'信阳办事处',24,1,1,1,'2010-12-23 07:42:56','','',''),
 (54,'技术维护科',27,1,1,1,'2010-12-23 07:43:42','','',''),
 (55,'学历组',27,1,1,1,'2010-12-23 07:43:58','','',''),
 (56,'南阳办事处',24,1,1,1,'2010-12-23 07:45:04','','',''),
 (57,'郑州办事处',23,1,1,1,'2010-12-23 07:46:44','','',''),
 (58,'商丘办事处',23,1,1,1,'2010-12-23 07:46:59','','',''),
 (59,'周口办事处',23,1,1,1,'2010-12-23 07:47:21','','',''),
 (60,'开封办事处',23,1,1,1,'2010-12-23 07:47:38','','',''),
 (61,'驻马店办事处',23,1,1,1,'2010-12-23 07:47:54','','',''),
 (62,'许昌办事处',23,1,1,1,'2010-12-23 07:48:11','','',''),
 (63,'新乡办事处',23,1,1,1,'2010-12-23 07:48:28','','','');
INSERT INTO `departments` (`departments_id`,`departments_name`,`departments_parentid`,`departments_status`,`departments_sort`,`users_id`,`departments_addtime`,`departments_remark1`,`departments_remark2`,`departments_remark3`) VALUES 
 (64,'安阳办事处',23,1,1,1,'2010-12-23 07:48:43','','',''),
 (65,'焦作办事处',23,1,1,1,'2010-12-23 07:49:07','','',''),
 (66,'平顶山办事处',24,1,1,1,'2010-12-23 07:49:25','','',''),
 (67,'漯河办事处',24,1,1,1,'2010-12-23 07:49:39','','',''),
 (68,'南昌办事处',25,1,1,1,'2010-12-23 07:50:07','','',''),
 (69,'赣州办事处',25,1,1,1,'2010-12-23 07:50:28','','',''),
 (70,'长沙办事处',26,1,1,1,'2010-12-23 07:50:42','','',''),
 (71,'岳阳办事处',26,1,1,1,'2010-12-23 07:51:10','','',''),
 (72,'学工一组',28,1,1,1,'2010-12-23 07:51:51','','',''),
 (73,'学工二组',28,1,1,1,'2010-12-23 07:52:08','','',''),
 (74,'学工三组',28,1,1,1,'2010-12-23 07:52:26','','',''),
 (75,'武汉就业办事处',31,1,1,1,'2010-12-23 07:52:52','','',''),
 (76,'上海就业办事处',31,1,1,1,'2010-12-23 07:53:08','','','');
INSERT INTO `departments` (`departments_id`,`departments_name`,`departments_parentid`,`departments_status`,`departments_sort`,`users_id`,`departments_addtime`,`departments_remark1`,`departments_remark2`,`departments_remark3`) VALUES 
 (77,'深圳就业办事处',31,1,1,1,'2010-12-23 07:53:25','','',''),
 (78,'杭州就业办事处',31,1,1,1,'2010-12-23 07:53:42','','',''),
 (79,'咸宁办事处',21,1,1,1,'2010-12-23 08:03:55','','',''),
 (80,'黄石办事处',21,1,1,1,'2010-12-23 08:04:16','','',''),
 (81,'黄冈办事处',21,1,1,1,'2010-12-23 08:04:32','','',''),
 (82,'襄樊办事处',20,1,1,1,'2010-12-23 08:04:45','','',''),
 (83,'宜昌办事处',20,1,1,1,'2010-12-23 08:05:06','','',''),
 (84,'随州办事处',20,1,1,1,'2010-12-23 08:05:38','','',''),
 (85,'荆门办事处',20,1,1,1,'2010-12-23 08:07:10','','',''),
 (86,'荆州办事处',19,1,1,1,'2010-12-23 08:07:26','','',''),
 (87,'仙桃办事处',19,1,1,1,'2010-12-23 08:07:51','','',''),
 (88,'孝感办事处',19,1,1,1,'2010-12-23 08:08:04','','',''),
 (89,'新项目办公室',15,1,1,1,'2010-12-23 08:08:20','','','');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `modules_id` int(10) unsigned NOT NULL auto_increment,
  `modules_name` varchar(45) character set utf8 NOT NULL default '' COMMENT '模块名称',
  `modules_path` varchar(45) character set utf8 default NULL COMMENT '路径',
  `modules_url` varchar(45) character set utf8 default NULL COMMENT '地址',
  `modules_description` text character set utf8 COMMENT '描述',
  `modules_status` int(10) unsigned NOT NULL default '1' COMMENT '状态1-激活 2-关闭',
  `modules_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序 值为1-9 9最大',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '添加者--用户表主键',
  `modules_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '添加时间',
  `modules_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `modules_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `modules_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`modules_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='模块';

--
-- Dumping data for table `questionnaire`.`modules`
--

/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` (`modules_id`,`modules_name`,`modules_path`,`modules_url`,`modules_description`,`modules_status`,`modules_sort`,`users_id`,`modules_addtime`,`modules_remark1`,`modules_remark2`,`modules_remark3`) VALUES 
 (1,'模块','modules',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (2,'部门','departments',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (3,'用户','users',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (4,'角色','roles',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (5,'管理员','admins',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (6,'单选题','radios',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (7,'多选题','multiples',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (8,'问答题','questions',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (9,'问卷','questionnaires',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (10,'答案','answers',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL),
 (11,'问卷栏目','questionnaire_category',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL);
INSERT INTO `modules` (`modules_id`,`modules_name`,`modules_path`,`modules_url`,`modules_description`,`modules_status`,`modules_sort`,`users_id`,`modules_addtime`,`modules_remark1`,`modules_remark2`,`modules_remark3`) VALUES 
 (12,'答案统计','answers_total',NULL,NULL,1,1,1,'2010-12-19 09:56:57',NULL,NULL,NULL);
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`questionnaire_category`
--

DROP TABLE IF EXISTS `questionnaire_category`;
CREATE TABLE `questionnaire_category` (
  `qc_id` int(10) unsigned NOT NULL auto_increment,
  `qc_parentid` int(10) unsigned NOT NULL default '0' COMMENT '上一级',
  `qc_name` varchar(255) character set utf8 NOT NULL default '' COMMENT '栏目名称',
  `qc_status` int(10) unsigned NOT NULL default '1' COMMENT '1-激活 2-废弃',
  `qc_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '用户表的主键',
  `qc_addtime` varchar(50) character set utf8 NOT NULL default '' COMMENT '添加时间',
  `qc_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `qc_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `qc_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`qc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='问卷栏目表';

--
-- Dumping data for table `questionnaire`.`questionnaire_category`
--

/*!40000 ALTER TABLE `questionnaire_category` DISABLE KEYS */;
INSERT INTO `questionnaire_category` (`qc_id`,`qc_parentid`,`qc_name`,`qc_status`,`qc_sort`,`users_id`,`qc_addtime`,`qc_remark1`,`qc_remark2`,`qc_remark3`) VALUES 
 (1,0,'企业文化',1,1,1,'2010-12-19 17:19:00','','',''),
 (2,0,'薪资福利',1,1,1,'2010-12-19 17:19:38','','',''),
 (3,0,'个人发展',1,1,1,'2010-12-19 17:19:52','','',''),
 (4,0,'工作环境',1,1,1,'2010-12-19 17:20:02','','',''),
 (5,0,'与工作群体的联系',1,1,1,'2010-12-19 17:20:36','','',''),
 (6,0,'沟通环境',1,1,1,'2010-12-19 17:20:49','','',''),
 (7,0,'学院制度及管理',1,1,1,'2010-12-19 17:21:01','','',''),
 (8,0,'对服务部门的综合评分',1,1,1,'2010-12-19 17:21:55','','',''),
 (9,0,'开放性问题',1,1,1,'2010-12-19 17:22:07','','','');
/*!40000 ALTER TABLE `questionnaire_category` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`questionnaires`
--

DROP TABLE IF EXISTS `questionnaires`;
CREATE TABLE `questionnaires` (
  `questionnaires_id` int(10) unsigned NOT NULL auto_increment,
  `questionnaires_name` varchar(255) character set utf8 NOT NULL default '' COMMENT '问卷名称',
  `questions_id_set` text character set utf8 NOT NULL COMMENT '题干集合---(题干id-类型id-栏目id,多个用逗号分开)',
  `questionnaires_status` int(10) unsigned NOT NULL default '1' COMMENT '状态--1 激活 2--关闭',
  `questionnaires_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序',
  `questionnaires_anonymous` int(10) unsigned NOT NULL default '1' COMMENT '匿名---1-是 2-不是',
  `questionnaires_starttime` varchar(45) character set utf8 NOT NULL default '' COMMENT '开始时间',
  `questionnaires_endtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '结束时间',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '添加者---用户表主键',
  `questionnaires_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '添加时间',
  `questionnaires_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `questionnaires_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `questionnaires_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`questionnaires_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='问卷表';

--
-- Dumping data for table `questionnaire`.`questionnaires`
--

/*!40000 ALTER TABLE `questionnaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `questionnaires` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `questions_id` int(10) unsigned NOT NULL auto_increment,
  `qc_id` int(10) unsigned NOT NULL default '0' COMMENT '栏目表主键',
  `qt_id` int(10) unsigned NOT NULL default '0' COMMENT '题型表主键',
  `questions_no` int(10) unsigned NOT NULL default '0' COMMENT '选项个数',
  `questions_name` varchar(255) character set utf8 NOT NULL default '' COMMENT '名称',
  `questions_status` int(10) unsigned NOT NULL default '1' COMMENT '状态---1 激活 2 关闭',
  `questions_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '添加者---用户表的主键',
  `questions_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '添加时间',
  `questions_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `questions_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `questions_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`questions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='题干表';

--
-- Dumping data for table `questionnaire`.`questions`
--

/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`questions_type`
--

DROP TABLE IF EXISTS `questions_type`;
CREATE TABLE `questions_type` (
  `qt_id` int(10) unsigned NOT NULL auto_increment,
  `qt_name` varchar(255) character set utf8 NOT NULL default '' COMMENT '名称',
  `qt_status` int(10) unsigned NOT NULL default '1' COMMENT '状态--1 激活 2-关闭',
  `qt_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '添加者---用户表主键',
  `qt_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '添加时间',
  `qt_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `qt_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `qt_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`qt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='题型表';

--
-- Dumping data for table `questionnaire`.`questions_type`
--

/*!40000 ALTER TABLE `questions_type` DISABLE KEYS */;
INSERT INTO `questions_type` (`qt_id`,`qt_name`,`qt_status`,`qt_sort`,`users_id`,`qt_addtime`,`qt_remark1`,`qt_remark2`,`qt_remark3`) VALUES 
 (1,'单选题',1,1,1,'2010-12-19 17:39:41',NULL,NULL,NULL),
 (2,'多选题',1,1,1,'2010-12-19 17:39:42',NULL,NULL,NULL),
 (3,'问答题',1,1,1,'2010-12-19 17:39:43',NULL,NULL,NULL);
/*!40000 ALTER TABLE `questions_type` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `roles_id` int(10) unsigned NOT NULL auto_increment,
  `roles_name` varchar(255) character set utf8 NOT NULL default '' COMMENT '角色名称',
  `modules_id_set` text character set utf8 COMMENT '模块ID的合集',
  `roles_description` text character set utf8 COMMENT '描述',
  `users_id` int(10) unsigned NOT NULL default '0' COMMENT '添加者',
  `roles_addtime` varchar(45) character set utf8 NOT NULL default '' COMMENT '创建时间',
  `roles_status` int(10) unsigned NOT NULL default '1' COMMENT '状态1-激活 2-关闭',
  `roles_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序 值为1-9 9最大',
  `roles_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `roles_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `roles_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='角色';

--
-- Dumping data for table `questionnaire`.`roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`roles_id`,`roles_name`,`modules_id_set`,`roles_description`,`users_id`,`roles_addtime`,`roles_status`,`roles_sort`,`roles_remark1`,`roles_remark2`,`roles_remark3`) VALUES 
 (1,'超级管理员','1,2,3,4,5,6,7,8,9,10,11,12,',NULL,1,'2010-12-19 10:06:53',1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


--
-- Table structure for table `questionnaire`.`users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `users_id` int(10) unsigned NOT NULL auto_increment,
  `users_name` varchar(45) character set utf8 NOT NULL default '' COMMENT '员工姓名',
  `users_account` varchar(45) character set utf8 NOT NULL default '' COMMENT '员工工号',
  `users_sex` int(10) unsigned NOT NULL default '1' COMMENT '性别---1 男 2 女',
  `departments_id` int(10) unsigned NOT NULL default '0' COMMENT '部门表主键',
  `users_status` int(10) unsigned NOT NULL default '1' COMMENT '员工状态---1 在职 2 待职 3 离职',
  `users_sort` int(10) unsigned NOT NULL default '1' COMMENT '排序',
  `users_pw` varchar(45) character set utf8 NOT NULL default '' COMMENT '密码',
  `users_date` varchar(45) character set utf8 default NULL COMMENT '入职时间',
  `users_remark1` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `users_remark2` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  `users_remark3` varchar(45) character set utf8 default NULL COMMENT '备用字段',
  PRIMARY KEY  (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='员工';

--
-- Dumping data for table `questionnaire`.`users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (1,'林丽','050918',2,36,1,1,'6a8ef28d60414e58dcef8dec44f29f22','','','',''),
 (2,'刘圣玉','071008',1,46,1,1,'99610a0874cc8351a707fedba30a6fff','','','',''),
 (3,'张文英','061135',1,46,1,1,'5fed859dad227d15d297a88df6a64dae','','','',''),
 (4,'张海','060000',1,9,1,1,'d338922319bb0821d7e7b8015b13c40b','','','',''),
 (5,'李燕','030601',2,9,1,1,'3cd237e1f6ff561f32d440f92baa097e','','','',''),
 (6,'谢红梅','060241',2,9,1,1,'谢红梅','','','',''),
 (7,'徐维仙','030801',2,13,1,1,'徐维仙','','','',''),
 (8,'徐玲','080514',2,37,1,1,'徐玲','','','',''),
 (9,'孙鸽','070629',2,36,1,1,'孙鸽','','','',''),
 (10,'张文娟','100303',2,36,1,1,'张文娟','','','',''),
 (11,'向杰','051012',1,12,1,1,'向杰','','','',''),
 (12,'李桂菊','060510',2,34,1,1,'李桂菊','','','',''),
 (13,'成韦韦','070126',2,34,1,1,'成韦韦','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (14,'罗茜英','040301',2,35,1,1,'罗茜英','','','',''),
 (15,'李娟娟','060348',2,35,1,1,'李娟娟','','','',''),
 (16,'刘燕','060920',2,34,1,1,'刘燕','','','',''),
 (17,'陆秋豆','100908',2,34,1,1,'陆秋豆','','','',''),
 (18,'周俊','020901',1,10,1,1,'周俊','','','',''),
 (19,'黄田田','101102',1,15,1,1,'黄田田','','','',''),
 (20,'苏华','080332',2,15,1,1,'苏华','','','',''),
 (21,'毛诗娟','060360',2,15,1,1,'毛诗娟','','','',''),
 (22,'朱佳','070333',1,15,1,1,'朱佳','','','',''),
 (23,'翁刚军','070607',1,15,1,1,'翁刚军','','','',''),
 (24,'纪玮玮','060867',2,15,1,1,'纪玮玮','','','',''),
 (25,'毛天顺','100535',1,15,1,1,'毛天顺','','','',''),
 (26,'徐鹏','070430',1,15,1,1,'徐鹏','','','',''),
 (27,'冯义华','101101',1,89,1,1,'冯义华','','','',''),
 (28,'程彭好','101104',2,89,1,1,'程彭好','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (29,'修端祥','070144',1,16,1,1,'修端祥','','','',''),
 (30,'王琼','060330',2,19,1,1,'王琼','','','',''),
 (31,'刘艳','090223',2,86,1,1,'刘艳','','','',''),
 (32,'田晶晶','100411',2,86,1,1,'田晶晶','','','',''),
 (33,'张丽','060424',2,87,1,1,'张丽','','','',''),
 (34,'金邦','100324',1,87,1,1,'金邦','','','',''),
 (35,'赵冲','100527',2,87,1,1,'赵冲','','','',''),
 (36,'钟璇','060331',2,87,1,1,'钟璇','','','',''),
 (37,'唐早虹','080615',2,88,1,1,'唐早虹','','','',''),
 (38,'朱莉萍','060420',2,88,1,1,'朱莉萍','','','',''),
 (39,'李蕴珍','080211',2,88,1,1,'李蕴珍','','','',''),
 (40,'李娇','100504',2,88,1,1,'李娇','','','',''),
 (41,'魏丹','060368',1,20,1,1,'魏丹','','','',''),
 (42,'黄卫军','060377',1,85,1,1,'黄卫军','','','',''),
 (43,'孟鹏飞','090303',2,85,1,1,'孟鹏飞','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (44,'孙海霞','100616',2,85,1,1,'孙海霞','','','',''),
 (45,'胡伍成','100204',1,84,1,1,'胡伍成','','','',''),
 (46,'阮晓艳','100307',2,84,1,1,'阮晓艳','','','',''),
 (47,'陶桂玲','100308',2,84,1,1,'陶桂玲','','','',''),
 (48,'郭青慧','100531',2,84,1,1,'郭青慧','','','',''),
 (49,'朱灵一','060408',1,83,1,1,'朱灵一','','','',''),
 (50,'张伟伟','080313',2,83,1,1,'张伟伟','','','',''),
 (51,'李娜','090238',2,82,1,1,'李娜','','','',''),
 (52,'蔺家丽','060608',2,82,1,1,'蔺家丽','','','',''),
 (53,'邓芳','080214',2,82,1,1,'邓芳','','','',''),
 (54,'程谦','080319',1,82,1,1,'程谦','','','',''),
 (55,'吴园园','090708',2,82,1,1,'吴园园','','','',''),
 (56,'杨智华','061028',1,21,1,1,'杨智华','','','',''),
 (57,'汪瑜','101105',1,81,1,1,'汪瑜','','','',''),
 (58,'于程','100331',2,81,1,1,'于程','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (59,'张思思','100401',2,81,1,1,'张思思','','','',''),
 (60,'徐建华','101111',2,81,1,1,'徐建华','','','',''),
 (61,'黄艳红','061208',2,80,1,1,'黄艳红','','','',''),
 (62,'陈静','070391',2,80,1,1,'陈静','','','',''),
 (63,'王丽娇','100701',2,80,1,1,'王丽娇','','','',''),
 (64,'程琴俐','070396',2,79,1,1,'程琴俐','','','',''),
 (65,'张建红','101107',2,79,1,1,'张建红','','','',''),
 (66,'陈姣','101110',2,79,1,1,'陈姣','','','',''),
 (67,'王娟','060235',2,22,1,1,'王娟','','','',''),
 (68,'潘津津','091104',1,22,1,1,'潘津津','','','',''),
 (69,'覃华','100305',2,22,1,1,'覃华','','','',''),
 (70,'冯夏雪','100306',2,22,1,1,'冯夏雪','','','',''),
 (71,'谭琼','070410',2,22,1,1,'谭琼','','','',''),
 (72,'蔡珺','080306',1,22,1,1,'蔡珺','','','',''),
 (73,'杨娟','090403',2,22,1,1,'杨娟','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (74,'焦晶','100342',1,22,1,1,'焦晶','','','',''),
 (75,'刘小燕','100402',2,22,1,1,'刘小燕','','','',''),
 (76,'王红','100413',2,22,1,1,'王红','','','',''),
 (77,'刘元霞','100605',2,22,1,1,'刘元霞','','','',''),
 (78,'陶晶','041002',1,17,1,1,'陶晶','','','',''),
 (79,'卫粉粉','070432',2,57,1,1,'卫粉粉','','','',''),
 (80,'王惠惠','100415',2,57,1,1,'王惠惠','','','',''),
 (81,'边利芬','080614',2,57,1,1,'边利芬','','','',''),
 (82,'崔琳琳','100518',2,57,1,1,'崔琳琳','','','',''),
 (83,'李彬','100615',1,57,1,1,'李彬','','','',''),
 (84,'孙景云','100325',2,57,1,1,'孙景云','','','',''),
 (85,'屈东伟','080352',1,57,1,1,'屈东伟','','','',''),
 (86,'李宁','100409',1,57,1,1,'李宁','','','',''),
 (87,'张朋飞','100507',1,57,1,1,'张朋飞','','','',''),
 (88,'丁金凤','070389',2,58,1,1,'丁金凤','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (89,'唐照鹏','090207',1,58,1,1,'唐照鹏','','','',''),
 (90,'冯文娜','100343',2,58,1,1,'冯文娜','','','',''),
 (91,'王智华','090210',2,59,1,1,'王智华','','','',''),
 (92,'李梦娜','100316',2,59,1,1,'李梦娜','','','',''),
 (93,'胡秋霞','100317',2,59,1,1,'胡秋霞','','','',''),
 (94,'王静静','100319',2,59,1,1,'王静静','','','',''),
 (95,'于佳','100351',2,60,1,1,'于佳','','','',''),
 (96,'朱琳','100350',2,60,1,1,'朱琳','','','',''),
 (97,'王敏2','070525',2,60,1,1,'王敏2','','','',''),
 (98,'宋艳红','090221',2,61,1,1,'宋艳红','','','',''),
 (99,'王果','100315',2,61,1,1,'王果','','','',''),
 (100,'耿秋丽','101108',2,61,1,1,'耿秋丽','','','',''),
 (101,'苑冰','090505',2,62,1,1,'苑冰','','','',''),
 (102,'师娇娇','090314',2,62,1,1,'师娇娇','','','',''),
 (103,'崔凯','100506',1,62,1,1,'崔凯','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (104,'周志方','100530',2,62,1,1,'周志方','','','',''),
 (105,'吴纪忠','080336',1,23,1,1,'吴纪忠','','','',''),
 (106,'康永梅','100329',2,63,1,1,'康永梅','','','',''),
 (107,'梁春辉','070531',2,63,1,1,'梁春辉','','','',''),
 (108,'郭玉红','100333',2,63,1,1,'郭玉红','','','',''),
 (109,'李龙华','100432',2,64,1,1,'李龙华','','','',''),
 (110,'杨苗苗','080337',2,64,1,1,'杨苗苗','','','',''),
 (111,'李娜娜','100327',2,64,1,1,'李娜娜','','','',''),
 (112,'王芳2','100424',2,64,1,1,'王芳2','','','',''),
 (113,'郭永红','090204',2,65,1,1,'郭永红','','','',''),
 (114,'李春晖','100421',2,24,1,1,'李春晖','','','',''),
 (115,'智月楼','070433',1,24,1,1,'智月楼','','','',''),
 (116,'吕莉莉','101106',2,66,1,1,'吕莉莉','','','',''),
 (117,'胡世楠','100312',2,66,1,1,'胡世楠','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (118,'张林娜','101109',2,66,1,1,'张林娜','','','',''),
 (119,'王艳霞','101004',2,67,1,1,'王艳霞','','','',''),
 (120,'佟怡伟','100509',2,67,1,1,'佟怡伟','','','',''),
 (121,'王晓莉','101204',2,67,1,1,'王晓莉','','','',''),
 (122,'尚瑞丽','070356',2,56,1,1,'尚瑞丽','','','',''),
 (123,'何佳岩','100336',2,56,1,1,'何佳岩','','','',''),
 (124,'朱万云','100706',2,56,1,1,'朱万云','','','',''),
 (125,'宋江丹','101103',2,56,1,1,'宋江丹','','','',''),
 (126,'王霞玲','080226',2,53,1,1,'王霞玲','','','',''),
 (127,'杨振','101203',1,53,1,1,'杨振','','','',''),
 (128,'严世杰','060371',1,25,1,1,'严世杰','','','',''),
 (129,'刘华余','100355',1,68,1,1,'刘华余','','','',''),
 (130,'杨勤华','101205',1,68,1,1,'杨勤华','','','',''),
 (131,'陈圆圆','100103',1,69,1,1,'陈圆圆','','','',''),
 (132,'熊哲岗','100434',1,69,1,1,'熊哲岗','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (133,'卢志忠','070207',1,26,1,1,'卢志忠','','','',''),
 (134,'陈成','090501',1,70,1,1,'陈成','','','',''),
 (135,'何晓东','101202',1,71,1,1,'何晓东','','','',''),
 (136,'方兴旺','050911',1,14,1,1,'方兴旺','','','',''),
 (137,'欧小卫','061210',1,14,1,1,'欧小卫','','','',''),
 (138,'苏小冬','060204',2,14,1,1,'苏小冬','','','',''),
 (139,'曾纲','070310',1,14,1,1,'曾纲','','','',''),
 (140,'成艳丽','031201',2,14,1,1,'成艳丽','','','',''),
 (141,'张燕萍','100503',2,14,1,1,'张燕萍','','','',''),
 (142,'金镜','070375',1,14,1,1,'金镜','','','',''),
 (143,'吴媛','090702',2,14,1,1,'吴媛','','','',''),
 (144,'刘婷','100416',2,14,1,1,'刘婷','','','',''),
 (145,'张雁峰','100537',1,14,1,1,'张雁峰','','','',''),
 (146,'刘丽娟','100538',2,14,1,1,'刘丽娟','','','',''),
 (147,'彭沙','100539',2,14,1,1,'彭沙','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (148,'刘果','100541',2,14,1,1,'刘果','','','',''),
 (149,'张书立','010801',1,11,1,1,'张书立','','','',''),
 (150,'龙元华','060810',1,11,1,1,'龙元华','','','',''),
 (151,'周薇2','080510',2,11,1,1,'周薇2','','','',''),
 (152,'郭文成','060914',1,32,1,1,'郭文成','','','',''),
 (153,'方蓉蓉','050309',2,30,1,1,'方蓉蓉','','','',''),
 (154,'刘起源','080410',1,52,1,1,'刘起源','','','',''),
 (155,'肖军','070625',1,51,1,1,'肖军','','','',''),
 (156,'刘岿','100703',1,51,1,1,'刘岿','','','',''),
 (157,'王志国','100705',1,51,1,1,'王志国','','','',''),
 (158,'盛喜军','101001',1,51,1,1,'盛喜军','','','',''),
 (159,'夏胜强','080802',1,48,1,1,'夏胜强','','','',''),
 (160,'陆永华','080803',1,48,1,1,'陆永华','','','',''),
 (161,'鄢李黎','100304',1,49,1,1,'鄢李黎','','','',''),
 (162,'龙谦','090802',1,49,1,1,'龙谦','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (163,'蔡晓丹','100611',2,50,1,1,'蔡晓丹','','','',''),
 (164,'吕慧','030803',2,29,1,1,'吕慧','','','',''),
 (165,'张辅政','060805',1,29,1,1,'张辅政','','','',''),
 (166,'张崇杰','060729',1,47,2,1,'张崇杰','','','',''),
 (167,'夏小山','060518',1,47,1,1,'夏小山','','','',''),
 (168,'万红明','061113',1,47,1,1,'万红明','','','',''),
 (169,'陈少成','100302',1,47,1,1,'陈少成','','','',''),
 (170,'夏丹','100609',1,47,1,1,'夏丹','','','',''),
 (171,'叶小艳','100613',2,47,1,1,'叶小艳','','','',''),
 (172,'冀杰松','100803',1,47,1,1,'冀杰松','','','',''),
 (173,'吴涛','100907',1,47,1,1,'吴涛','','','',''),
 (174,'王树生','030901',1,29,1,1,'王树生','','','',''),
 (175,'赵钟','050403',1,40,1,1,'赵钟','','','',''),
 (176,'陈俊','060825',1,40,1,1,'陈俊','','','',''),
 (177,'成先雄','061136',1,40,1,1,'成先雄','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (178,'侯勇','061004',1,40,1,1,'侯勇','','','',''),
 (179,'吴以刚','070807',1,40,1,1,'吴以刚','','','',''),
 (180,'饶麒','061045',1,40,1,1,'饶麒','','','',''),
 (181,'贺伟能','060943',1,40,1,1,'贺伟能','','','',''),
 (182,'张明','050201',1,40,1,1,'张明','','','',''),
 (183,'张巍','060223',1,40,1,1,'张巍','','','',''),
 (184,'肖发辉','061134',1,39,1,1,'肖发辉','','','',''),
 (185,'李辉2','070704',1,39,1,1,'李辉2','','','',''),
 (186,'黎慧','070853',2,39,1,1,'黎慧','','','',''),
 (187,'胡志朋','070604',1,39,1,1,'胡志朋','','','',''),
 (188,'吴凡','070886',1,39,1,1,'吴凡','','','',''),
 (189,'李倩','050610',2,39,1,1,'李倩','','','',''),
 (190,'李灯登','070813',1,39,1,1,'李灯登','','','',''),
 (191,'龙毅','080901',1,39,1,1,'龙毅','','','',''),
 (192,'胡奕','060734',1,40,1,1,'胡奕','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (193,'黄玉婷','061047',2,39,1,1,'黄玉婷','','','',''),
 (194,'葛萍萍','070817',2,39,1,1,'葛萍萍','','','',''),
 (195,'王勤','100502',2,39,1,1,'王勤','','','',''),
 (196,'刘邱晨','070929',1,39,1,1,'刘邱晨','','','',''),
 (197,'方晓宇','051019',1,46,1,1,'方晓宇','','','',''),
 (198,'潘琦','070821',2,46,1,1,'潘琦','','','',''),
 (199,'尹俊','050315',1,38,1,1,'尹俊','','','',''),
 (200,'吴晓明','021101',1,38,1,1,'吴晓明','','','',''),
 (201,'唐凯','060733',1,38,1,1,'唐凯','','','',''),
 (202,'杨树','070864',1,38,1,1,'杨树','','','',''),
 (203,'钱磊','061021',1,38,1,1,'钱磊','','','',''),
 (204,'张勇（大）','040904',1,38,1,1,'张勇（大）','','','',''),
 (205,'陈妮娜','060736',2,38,1,1,'陈妮娜','','','',''),
 (206,'严战峰','070113',1,38,1,1,'严战峰','','','',''),
 (207,'李国志','050305',1,38,1,1,'李国志','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (208,'胡东','050815',1,38,1,1,'胡东','','','',''),
 (209,'姜游','050615',1,38,1,1,'姜游','','','',''),
 (210,'孙振','060944',1,38,1,1,'孙振','','','',''),
 (211,'方涛','051008',1,38,1,1,'方涛','','','',''),
 (212,'董相烨','061202',1,38,1,1,'董相烨','','','',''),
 (213,'龙威','051117',1,38,1,1,'龙威','','','',''),
 (214,'罗佳','061022',1,38,1,1,'罗佳','','','',''),
 (215,'张允泉','070114',1,38,1,1,'张允泉','','','',''),
 (216,'张俊杰','060321',1,38,1,1,'张俊杰','','','',''),
 (217,'胡林','060701',1,38,1,1,'胡林','','','',''),
 (218,'李熠芳','101003',2,38,1,1,'李熠芳','','','',''),
 (219,'王卓华','101201',2,38,1,1,'王卓华','','','',''),
 (220,'阳军','070707',1,42,1,1,'阳军','','','',''),
 (221,'徐婵','060536',2,42,1,1,'徐婵','','','',''),
 (222,'易明启','070713',1,42,1,1,'易明启','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (223,'孙淑静','070891',2,42,1,1,'孙淑静','','','',''),
 (224,'赵艳芳','070323',2,42,1,1,'赵艳芳','','','',''),
 (225,'赵璇','100201',2,42,1,1,'赵璇','','','',''),
 (226,'樊一苇','100202',1,42,1,1,'樊一苇','','','',''),
 (227,'雷剑','100801',1,42,1,1,'雷剑','','','',''),
 (228,'毕文涛','070902',1,44,1,1,'毕文涛','','','',''),
 (229,'江春辉','030903',1,41,1,1,'江春辉','','','',''),
 (230,'余方','070818',2,41,1,1,'余方','','','',''),
 (231,'黄杰','070829',1,41,1,1,'黄杰','','','',''),
 (232,'夏宇','070834',1,41,1,1,'夏宇','','','',''),
 (233,'俞延文','061124',1,41,1,1,'俞延文','','','',''),
 (234,'魏艳','100203',2,41,1,1,'魏艳','','','',''),
 (235,'孙丽娟','060902',2,45,1,1,'孙丽娟','','','',''),
 (236,'朱菁','050917',2,45,1,1,'朱菁','','','',''),
 (237,'容晶','060417',2,45,1,1,'容晶','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (238,'黄文珊','060338',2,45,1,1,'黄文珊','','','',''),
 (239,'李艳霞','050811',2,45,1,1,'李艳霞','','','',''),
 (240,'白凌','060378',2,43,1,1,'白凌','','','',''),
 (241,'明清','070322',2,43,1,1,'明清','','','',''),
 (242,'张航程','090809',2,43,1,1,'张航程','','','',''),
 (243,'钟怿','090903',1,43,1,1,'钟怿','','','',''),
 (244,'李连群','061024',2,43,1,1,'李连群','','','',''),
 (245,'赵庆勇','100702',1,43,1,1,'赵庆勇','','','',''),
 (246,'赵青','100704',2,43,1,1,'赵青','','','',''),
 (247,'熊礼君','100901',2,43,1,1,'熊礼君','','','',''),
 (248,'漆樱','100904',2,43,1,1,'漆樱','','','',''),
 (249,'高娟','100905',2,43,1,1,'高娟','','','',''),
 (250,'毛江林','010000',1,8,1,1,'毛江林','','','',''),
 (251,'涂川','050601',1,33,1,1,'涂川','','','',''),
 (252,'赵振','050307',1,33,1,1,'赵振','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (253,'王駪','070346',1,27,1,1,'王駪','','','',''),
 (254,'邓峰','070377',1,27,1,1,'邓峰','','','',''),
 (255,'龙晖','060379',2,27,1,1,'龙晖','','','',''),
 (256,'甘甜','050701',2,27,1,1,'甘甜','','','',''),
 (257,'张红艳','050602',2,55,1,1,'张红艳','','','',''),
 (258,'李辉','060737',1,54,1,1,'李辉','','','',''),
 (259,'周大亮','070855',1,54,1,1,'周大亮','','','',''),
 (260,'黄利军','080527',1,54,1,1,'黄利军','','','',''),
 (261,'邓亮','080804',1,54,1,1,'邓亮','','','',''),
 (262,'许翔','100607',1,54,1,1,'许翔','','','',''),
 (263,'杨振华','080705',1,28,1,1,'杨振华','','','',''),
 (264,'陈伶俐','060716',2,28,1,1,'陈伶俐','','','',''),
 (265,'董帆','060841',1,28,1,1,'董帆','','','',''),
 (266,'夏建军','060948',1,28,1,1,'夏建军','','','',''),
 (267,'杨勇','061131',1,28,1,1,'杨勇','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (268,'贾德万','070414',1,28,1,1,'贾德万','','','',''),
 (269,'姜艳艳','070630',2,28,1,1,'姜艳艳','','','',''),
 (270,'张静','070731',2,28,1,1,'张静','','','',''),
 (271,'周波','070732',1,28,1,1,'周波','','','',''),
 (272,'凌群英','0708100',2,28,1,1,'凌群英','','','',''),
 (273,'夏剑鸣','0708101',1,28,1,1,'夏剑鸣','','','',''),
 (274,'曾严','070917',2,28,1,1,'曾严','','','',''),
 (275,'刘剑','070926',1,28,1,1,'刘剑','','','',''),
 (276,'熊义红','070924',2,28,1,1,'熊义红','','','',''),
 (277,'赵培','060955',2,28,1,1,'赵培','','','',''),
 (278,'肖静','080525',2,28,1,1,'肖静','','','',''),
 (279,'刘娜2','080618',2,28,1,1,'刘娜2','','','',''),
 (280,'张珑','080702',2,28,1,1,'张珑','','','',''),
 (281,'吕维杰','0703122',2,28,1,1,'吕维杰','','','',''),
 (282,'刘小娇','070305',2,28,1,1,'刘小娇','','','','');
INSERT INTO `users` (`users_id`,`users_name`,`users_account`,`users_sex`,`departments_id`,`users_status`,`users_sort`,`users_pw`,`users_date`,`users_remark1`,`users_remark2`,`users_remark3`) VALUES 
 (283,'苏彬容','070923',2,28,1,1,'苏彬容','','','',''),
 (284,'倪飞','100902',1,28,1,1,'倪飞','','','',''),
 (285,'陶荣婷','100903',2,28,1,1,'陶荣婷','','','',''),
 (286,'蔡正元','101002',1,28,1,1,'蔡正元','','','',''),
 (287,'周树典','031001',1,30,1,1,'周树典','','','',''),
 (288,'张丽蓉','040401',2,30,1,1,'张丽蓉','','','',''),
 (289,'唐立鹏','060324',1,31,1,1,'唐立鹏','','','',''),
 (290,'杨海军','060909',1,76,1,1,'杨海军','','','',''),
 (291,'程显华','050312',2,77,1,1,'程显华','','','',''),
 (292,'黎承海','060325',1,78,1,1,'黎承海','','','',''),
 (293,'杜鹃','060326',2,75,1,1,'杜鹃','','','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
