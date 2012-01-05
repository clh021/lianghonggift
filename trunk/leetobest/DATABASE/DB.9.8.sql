-----------------------------------------------------------------------
------------------数据库分析-------------------------------------------
-----------------------------------------------------------------------
--微软官方SQLHELP使用示例
-----------------------------------------------------------------------
--return SQLHelper.ExecuteDataTable
--(CommandType.StoredProcedure, "P_StudentPage", new DataSet(), "studenttable", new SqlParameter[] { new SqlParameter("@PageSize", PageSize), new SqlParameter("@PageIndex", CurrentPageIndex) });
--return SQLHelper.ExecuteScalar
--(CommandType.StoredProcedure, "P_CheckStudentNO", new SqlParameter[] { new SqlParameter("@student_no", student.StudentNo) });
--return SQLHelper.ExecuteReader
--(CommandType.StoredProcedure, "P_SearchStudentByStudentId", new SqlParameter[] { new SqlParameter("@student_id", student.StudentId) });
--return SQLHelper.ExecuteNonQuery
--(CommandType.StoredProcedure, "P_AddStudentInfo", new SqlParameter[] { new SqlParameter("@student_NO", student.StudentNO), new SqlParameter("@info_Changes", student.InfoChanges), new SqlParameter("@info_Cause", student.InfoCause), new SqlParameter("info_Date", student.InfoDate), new SqlParameter("@info_Details", student.InfoDetails), new SqlParameter("@info_Result", student.InfoResult) }) 
-- return SQLHelper.ExecuteDataSet
--(SQLHelper.CONN_STRING_NON_DTC, CommandType.StoredProcedure, "P_SelectMsg", "aa", new SqlParameter[] { new SqlParameter("@student_NO", student.StudentNO) })
--drop database LeeToBeST_DateBase
create database LeeToBeST_DataBase
--------------------------------------------------------------------------------
----drop table LeeToBeST_invitenum
--------------------------------------
------邀请码表格
----create table LeeToBeST_invitenum
----(
----invitenum_ID int identity(1,1),
----invitenum_num varchar(100),
----invitenum_ctime datetime default getdate(),
----invitenum_gtime datetime
----)
--------------------------------------------------------------------------------
------有一些需要处理的其它分散数据，希望能够存储在数据库当中，以方便修改，
------所以需要另外创建一个特殊的表，用来存放这些特殊的零散数据。
--------           -----           -------         -------         -----   -------
------1、关于本站，本站的相关信息，服务项目，服务内容（说明），服务宗旨，安全事宜
------2、免责声明，使用协议，服务条款，
------3、合作伙伴，
----create table ToBeST_ScatterDate--零散数据表
----(
----ScatterDate_id int identity(1,1) primary key,
----ScatterDate_pagename varchar(100),--所属的页面名称（不含.aspx）
----ScatterDate_class varchar(100),--标记的项，或者类别
----ScatterDate_detail varchar(100)
----)
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
------另外需要一个人才招聘列表
----create table ToBeST_InviteTalented--人才招聘列表
----(
----InviteTalented_id int identity(1,1) primary key,
------InviteTalented
----)
--------------------------------------------------------------------------------
------另外需要创建的一个表就是，客户服务中心留言表。
----create table ToBeST_CustomerWord
----(
----CustomerWord_id int identity(1,1) primary key,
----Users_id int foreign key references LeeToBeST_Users(Users_id),
----CustomerWord_Email varchar(100),--留言者的邮箱
----CustomerWord_QQ varchar(100),--留言者的QQ号码
----CustomerWord_message,  --留言内容
----CustomerWord_back  --是否有阅览（管理员用）
----)
--------------------------------------------------------------------------------
------另外还有一个账号申诉表，
----create table ToBeST_UserAppeal
----(
----UserAppeal_id int identity(1,1) primary key,
----Users_id int foreign key references LeeToBeST_Users(Users_id),
----UserAppeal_content varchar(max),--申诉内容
----UserAppeal_examine bit default 0,  --是否经过审查
----UserAppeal_pass bit default 0 --是否通过申诉
----)
--------------------------------------------------------------------------------
------新创建的，挚友申请表
----create table ToBeST_TryBosom
----(
----TryBosom_id int identity(1,1) primary key,
----ZUsers_id int foreign key references LeeToBeST_Users(Users_id),--主动申请人的ID
----BUsers_id int foreign key references LeeToBeST_Users(Users_id),--被动人的ID
----TryBosom_BPrint bit default 0,  --被动人是否有确认过（点击同意或者关闭，就更改）
----TryBosom_Pass bit default 0,  --是否通过了挚友关系
----TryBosom_ZPrint bit default 0   --主动人是否知道了通过的消息
----)
----------------------------------------------------------------------------
--通用用户帐号中心
-------------------------------------------------------------------------------
----------------用户表---------------------------------------------
--drop table ToBeST_Users
-------------------------------------------------------------------------------
create table ToBeST_Users
(
Users_id int identity(1,1) primary key,
Users_name varchar(50) unique not null,
Users_dearname varchar(50) default '小虫' not null,--昵称，用于显示为了保护用户隐私，不显示登录名
Users_pwd varchar(50) not null,
Users_trueName varchar(50) not null,--真实姓名
Users_email varchar(100) unique not null,--邮箱
Users_personaID varchar(50) unique not null,--用户的身份证号码
Users_qq varchar(50) default '待补充',--联系QQ
Users_sex bit not null,
Users_question varchar(max),--密保问题
Users_answer varchar(max),--密保答案
Users_personality varchar(max),--个性签名
Users_img varchar(100) default 'default.gif',--头像
Users_integral int default 0 not null,--积分
Users_birthday datetime default '1980-1-1 00:00:00',--农历生日
Users_bornIn varchar(50) default '待补充',--出生地
Users_work varchar(50) default '待补充',--工作，职业
Users_tel varchar(50) default '待补充',--联系电话
Users_beginLogin datetime default '1980-1-1 00:00:00' not null,--允许登录开始时间只记小时分钟
Users_endLogin datetime default '1980-1-1 23:59:00' not null, --允许登录结束时间只记小时分钟
Users_lastUpdate datetime default getdate() not null,--最后一次修改时间
Users_regtime datetime default getdate() not null,--注册时间
Users_loginCount int default '0' not null,--统计用户登录次数
Users_lastLoginTime datetime,--记录用户上次登录时间
Users_enable bit default '1' not null,--是否被启用,是否有效
Users_opposer varchar(max)--通过叠加记录所有举报者的ID中间用逗号隔开
)
----select * from ToBeST_Users
----update ToBeST_Users set img='default.gif'

----alter table ToBeST_Users add constraint ToBeSTUserEmaiil_Unique unique(Users_Email)
----alter table ToBeST_Users add constraint ToBeSTUserEmaiil_Unique unique(Users_Email)
-------------------------------------------------------------------------------
----------------记录用户登录的日志---------------------------------------------
--drop table ToBeST_UserLog
--------------------------------------------------------------------------------
create table ToBeST_UserLog
(
UserLog_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),
UserLog_UIP varchar(20) not null,
UserLog_UTime datetime default getdate() not null
)

--目标管理系统
-------------------------------------------------------------------------------
----------------目标表---------------------------------------------
drop table ToBeST_Goal--（只适宜单个小目标）
--------------------------------------------------------------------------------
create table ToBeST_Goal
(
Goal_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--创建用户
Goal_custodianid varchar(max),--监督人（注册用户）ID号码
Goal_custodians varchar(max) not null,--监督人（为注册用户）
Goal_cagename varchar(100),--类型（人脉，能力，健康，知识，财务，资讯（博客），其它）
Goal_name varchar(max) not null,-- 目标名称
Goal_state varchar(100) not null,--状态(已完成，正进行，未完成)
Goal_punish varchar(max) not null,--惩罚
Goal_power varchar(max) not null,--目标动力（可附加，自动添加<br/>）
Goal_share bit not null,--是否在挚友显示此目标
Goal_level int not null default '1',--目标级别（数字越大级别越高）
Goal_begin datetime not null,--目标开始执行时间（添加时间）
Goal_end datetime not null,--目标限定到期时间
Goal_enable bit not null
)
----------------任务执行表---------------------------------------------
drop table ToBeST_TaskRuning
--------------------------------------------------------------------------------
create table ToBeST_TaskRuning
(
TaskRuning_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--创建用户
Goal_id int foreign key references ToBeST_Goal(Goal_id),--对应的是针对什么目标
TaskRuning_name varchar(10) not null,--对应的要执行任务的名称			（背单词）	（练手臂）
TaskRuning_daycount int not null,--几天							（一天）	（一天）
TaskRuning_taskcount int not null,--完成任务的量					（十）		（一）
TaskRuning_taskunite varchar(5) not null,--任务量对应单位				（个）		（个）
TaskRuning_taskname varchar(10) not null,--任务名称，名词				（单词）	（俯卧撑）
TaskRuning_increasecount int not null,--（递增量完成任务的量）(0不递增) （）		（一）
TaskRuning_taskmin int not null,--（完成任务的最小量）(0不限最小)       （）		（一）
TaskRuning_taskmax int not null,--（完成任务的最大量）(0不限最大)		（）		（一）
--TaskRuning_cagename varchar(100),--类型（人脉，能力，健康，知识，财务，资讯（博客），其它）
TaskRuning_enable bit not null
)
----------------任务执行日志表---------------------------------------------
drop table ToBeST_TaskRuning_Log
--------------------------------------------------------------------------------
create table ToBeST_TaskRuning_Log
(
TaskRuning_Log_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--创建用户
TaskRuning_id int foreign key references ToBeST_TaskRuning(TaskRuning_id),--对应的执行任务
TaskRuning_Log_taskcount int not null,--执行任务实际量
TaskRuning_Log_feel varchar(max),--执行任务感言，进步，体会，
TaskRuning_Log_time datetime default getdate()--记录时间
)

--人脉管理系统
------------------------------------------------------------------------------------
----------------------人脉资源表-----------------------------------------------------
----drop table ToBeST_Friend
------------------------------------------------------------------------------------
----create table ToBeST_Friend
----(
----Friend_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--此朋友属哪个用户
----UsersFriend_id int foreign key references ToBeST_Users(Users_id),--此朋友的注册ID
----Friend_cage int ,--由三十到零的朋友分类（数值可以无限增大，最小为零联络天数为数值*2）
----Friend_name varchar(50),--朋友的姓名
----Friend_img varchar(50),--朋友照片名称
----Friend_sex bit,--朋友的性别
----Friend_census varchar(100),  --籍贯
----Friend_  --属相
----Friend_  --血型
----Friend_  --工作经历
----Friend_  --兴趣爱好
----Friend_works varchar(200),--工作单位或者公司
----Friend_  --办公地址
----Friend_  --公司电话
----Friend_  --家庭地址
----Friend_  --住宅地址
----Friend_  --住宅电话
----
----Friend_position varchar(200),--部门职务
----Friend_birthday datetime,--朋友的生日
----Friend_  --阳历，阴历
----Friend_  --毕业院校
----Friend_  --所学专业
----Friend_qq varchar(100),--QQ联系号码
----Friend_tel varchar(100),--手机号码
----Friend_email varchar(50),--朋友的电子邮箱
----Friend_others text--朋友的其他备注信息
----)
-----------------------------------------------------------------------------------
----------会员才能使用的功能-------------------------------------
------人脉扩展个人详情
----create table ToBeST_Friendvipkz
----(
----Friendvipkz_外貌特征
----Friendvipkz_健康状况
----Friendvipkz_饮酒习惯
----Friendvipkz_所嗜酒类
----Friendvipkz_吸烟习惯
----Friendvipkz_所嗜烟类
----Friendvipkz_偏爱菜式
----Friendvipkz_饮食习惯
----Friendvipkz_曾居住地
----Friendvipkz_职称资格
----Friendvipkz_喜好话题
----Friendvipkz_忌讳话题
----Friendvipkz_喜读书类
----Friendvipkz_喜好运动
----Friendvipkz_休闲喜好
----Friendvipkz_喜好物品
----Friendvipkz_近期心愿
----Friendvipkz_长期心愿
----Friendvipkz_得意的事
----Friendvipkz_常提的事
----)
------人脉扩展家庭教育
----create table ToBeST_Friendvipjy
----(
----最高学历
----所学专业
----毕业院校
----毕业时间
----擅长运动
----参加社团
----中学名称
----其他教育
----对学历态度
----兵役军种
----最高军衔
----上学时趣事
----特殊背景
----父母状况
----父母工作
----婚姻状况
----配偶姓名
----配偶学历
----配偶喜好
----婚纪念日
----子女姓名
----子女年龄
----子女教育
----子女喜好
----自定义1
----自定义2
----
----)
----
------人脉扩展客户关系
----create table ToBeST_Friendvipkh
----(
----客户状态
----客户来源
----客户类型
----客户潜力
----公司声誉
----银行账号
----前一个职务
----公司内地位
----其对公司态度
----公司对其态度
----与周围人业务关系
----周围人与业务关系
----客户管理层以何为重
----其核心主要需求
----客户眼中的关键问题
----我担心的问题
----自定义1
----自定义2
----自定义3
----自定义4
----)

------------------------------------------------------------------------------------
----------------------人脉资源联络表-----------------------------------------------------
----drop table ToBeST_friendconn
------------------------------------------------------------------------------------
----create table ToBeST_friendconn
----(
----Friendconn_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--对应的用户
----Friendconn_Invite bit ,--主被动true/false
----Friendconn_date varchar(50),--用于算天数
----Friendconn_time varchar(50),
----Friendconn_connet varchar(max),--联络内容信息
----Friendconn_integral int,--操作分数（只能是0，-1，+1）
----Friendconn_reason varchar(max)--操作理由
----)
----
------能力管理系统
----
------------------------------------------------------------------------------------
----------------------能力目标实践统计表-----------------------------------------------------
----drop table ToBeST_Practice
------使用触发器，来规定，每超过60*60=3600时减去3600，小时数加1
------------------------------------------------------------------------------------
----create table ToBeST_Practice
----(
----Practice_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--对应的用户
----Goalreduce_id int foreign key references ToBeST_Goalreduce(Goalreduce_id),--对应的健康目标
----Practice_Name varchar(200),--对应的名称
----Practice_cage varchar(100),--对应的单位（分，秒，个，次）
----Practice_tenthousand int,--练习的万数统计
----Practice_tick int --练习的次数统计
----)


------健康管理系统
----
------------------------------------------------------------------------------------
----------------------健康管理实践统计表-----------------------------------------------------
----drop table ToBeST_Health
------使用触发器，来规定，每超过10000时减去10000，万次数加1
------------------------------------------------------------------------------------
----create table ToBeST_Health
----(
----Health_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--对应的用户
----Goalreduce_id int foreign key references ToBeST_Goalreduce(Goalreduce_id),--对应的健康目标
----Health_Name varchar(200),--对应的名称
----Health_cage varchar(100),--对应的单位（分，秒，个，次）
----Health_tenthousand int,--练习的万数统计
----Health_tick int   --练习的次数统计
----)

--知识管理系统

-------------------------------------------------------------------------------
----------------知识管理类别表---------------------------------------------
--drop table ToBeST_Study_Cage
-------------------------------------------------------------------------------
create table ToBeST_Study_Cage
--此处是学习类别列表，仅仅包含每个项目的名称。
(
Study_Cage_id int identity(1,1) primary key,
Study_Cage_parent_id int not null,
Study_Cage_parentname varchar(100) not null,
Study_Cage_linkname varchar(100) not null,
Study_Cage_counts int default 0 not null, --包含有几个子项
Study_Cage_promulgator int foreign key references ToBeST_Users(Users_id),--发布者的ID
Study_Cage_enable bit default 0 not null
)
-------------------------------------------------------------------------------
----------------知识文章内容表---------------------------------------------
-------------------------------------------------------------------------------
--drop table ToBeST_Study_Digest
create table ToBeST_Study_Digest
--此处是学习内容列表，包含每个项目的对应内容。创建此表是为了以后方便巩固增加字段，增加功能。
(
Study_Digest_id int identity(1,1) primary key,
Study_Cage_id int foreign key references ToBeST_Study_Cage(Study_Cage_id),--所属类别的编号
Study_Digest_putout varchar(max) not null,--出处，可以是网络地址，也可以是书籍名称
Study_Digest_digest varchar(max) not null,
--Study_Digest_promulgator varchar(100) foreign key references ToBeST_Users(Users_id),--真正作者的姓名
Study_Digest_puttime datetime default getdate() not null,
Study_Digest_good int default '0' not null,--评价好的次数
Study_Digest_bad int default '0' not null,--评价不好的次数
Study_Digest_deleted bit default '0' not null,--用户是否有将其删除
Study_Digest_enable bit default '1' not null,--是否被启用,是否有效
Study_Digest_opposer varchar(max),--通过叠加记录所有举报者的ID,中间用逗号隔开
Study_Digest_promulgator_id int foreign key references ToBeST_Users(Users_id)
)
----select * from ToBeST_Study_Cage
----select * from ToBeST_Study_digest
----update ToBeST_Study_digest set Study_deleted='0'
----------------
--财务分配系统

-----------------------------------------------------------------------------------
--------------------财务记录表---------------------------------------------
----drop table ToBeST_Finace_Log
-----------------------------------------------------------------------------------
----select * from ToBeST_Finace_Log
----create table ToBeST_Finace_Log
------此处是学习类别列表，仅仅包含每个项目的名称。
----(
----Finace_Log_id int identity(1,1) primary key, 
----Users_id int foreign key references ToBeST_Users(Users_id),--对应的用户
----Finace_Log_date varchar(100),--日期
----Finace_Log_time datetime default getdate(),--插入数据的时间
----Finace_Log_payout int,--支出金额
----Finace_Log_whypayout varchar(max),--支出原因
----Finace_Log_include int,--收入金额
----Finace_Log_whyinclude varchar(max),--收入原因
----Finace_Log_balance int,--结算
----Finace_Log_sumup varchar(max)--总结
----)


-----------------------------------------------------------------------------------
--------------------财务目标表---------------------------------------------
----drop table ToBeST_Finace_Goal
-----------------------------------------------------------------------------------
----select * from ToBeST_Finace_Goal
----create table ToBeST_Finace_Goal
------此处是学习类别列表，仅仅包含每个项目的名称。
----(
----Finace_Goal_id int identity(1,1) primary key, 
----Users_id int foreign key references ToBeST_Users(Users_id),--对应的用户
----Finace_Goal_date varchar(100),--日期
----Finace_Goal_time datetime default getdate(),--插入数据的时间
----Finace_Goal_text varchar(max) --具体描述目标
----)
------时间管理系统
-----------------------------------------------------------------------------------
--------------------时间任务提醒表---------------------------------------------
----drop table ToBeST_Test_Awoke
-----------------------------------------------------------------------------------
----select * from ToBeST_Test_Awoke
----create table ToBeST_Test_Awoke
------此处是学习类别列表，仅仅包含每个项目的名称。
----(
----Test_Awoke_id int identity(1,1) primary key, 
----Users_id int foreign key references ToBeST_Users(Users_id),--对应的用户
----Test_Awoke_date varchar(100),--提醒时间（要求非常详细）
----Test_Awoke_time datetime default getdate(),--插入数据的时间
----Test_Awoke_tittle varchar(100),--提醒窗口的标题
----Test_Awoke_text varchar(max) --提醒内容，即窗口内容
----)

--分类博客系统

--------------------------------------------------------------------------------
-----------------博客，论坛，按要求来-------------------------------------------
--drop table ToBeST_Blogs
create table ToBeST_Blogs
(
Blog_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--哪一位用户发布的
Blog_author varchar(100) default '匿名' not null,--文章作者，可填自己。页面中默认自己的昵称。
Blog_stitle varchar(100) not null,--标题
Blog_digest text not null,--内容
Blog_putdate datetime default getdate() not null,--发表的日期
Blog_lastback datetime default getdate() not null,--最后回复时间
Blog_hitcount int default 0 not null,--点击次数
Blog_backcount int default 0 not null,--被回复的次数
Blog_topYN bit default 0 not null,      --是否置顶
Blog_enable bit default '1' not null,--是否被启用,是否有效
Blog_opposer varchar(max)--通过叠加记录所有举报者的ID中间用逗号隔开
)

-----------------------------------------------------------------------------
----------------博客，论坛，回复表-------------------------------------------
--drop table ToBeST_Blog_Review
create table ToBeST_Blog_Review
(
Blog_Review_id int identity(1,1) primary key,
Blog_id int foreign key references ToBeST_Blogs(Blog_id),
Users_id int foreign key references ToBeST_Users(Users_id),--回复的用户ID
Blog_Review_content text not null,
Blog_Review_time datetime default getdate() not null,
Blog_Review_enable bit default '1' not null,--是否被启用,是否有效
Blog_Review_opposer varchar(max)--通过叠加记录所有举报者的ID中间用逗号隔开
)
-----------------------------------------------------------------------------

--系统帮助中心

--数据库其他方面的创建

--数据库存储过程


--通用用户帐号中心

----------------------------------------------------------
-----------------用户注册的存储过程------------------
drop proc Users_Reging
-------------------------------------------------------
create proc Users_Reging
(
@Users_name varchar(500),
@Users_pwd varchar(500),
@Users_TrueName varchar(50),
@Users_personId varchar(50),
@Users_sex bit,
@Users_Email varchar(100)
)as
insert into ToBeST_Users(Users_name,Users_pwd,Users_TrueName,Users_personId,Users_sex,Users_Email)values(@Users_name,@Users_pwd,@Users_TrueName,@Users_personId,@Users_sex,@Users_Email)
go
---------------------------------------------------------------
----------------------------------------------------------
-----------------获取用户信息的存储过程------------------
drop proc Users_GetUserinfo
-------------------------------------------------------
create proc Users_GetUserinfo
(
@Users_id int
)as
select * from ToBeST_Users where Users_id=@Users_id
go
---------------------------------------------------------------

-------------------------------------------------------------
----------------------检查用户名的存储过程-------------------
--drop proc Users_Checkname
-------------------------------------------------------------
create proc Users_Checkname
(
@Users_name varchar(500)
)as
select Users_id from ToBeST_users where Users_name=@Users_name
go
-------------------------------------------------------------
----------------------检查邮箱的存储过程-------------------
--drop proc Users_Checkemail
-------------------------------------------------------------
create proc Users_Checkemail
(
@Users_Email varchar(500)
)as
select Users_id from ToBeST_users where Users_Email=@Users_Email
go
-------------------------------------------------------------
-----------------登录的存储过程------------------------------
drop proc Users_Logining
-------------------------------------------------------------
create proc Users_Logining
(
---这里是查询，那么查询的时候也是可以指定要查询的东西
---同样，传过来的，可以是一个多的查询语句，那么，
---显然的，存储过程也不能达到很好的保护措施。
@Users_name varchar(500),
@Users_pwd varchar(500),
@UserLog_UIP varchar(20)
)as
if exists(select Users_id from ToBeST_Users where Users_name=@Users_name and Users_pwd=@Users_pwd)
begin
	declare @Users_id int
	select @Users_id=Users_id from ToBeST_Users where Users_name=@Users_name and Users_pwd=@Users_pwd
	insert into ToBeST_UserLog(Users_id,UserLog_UIP) values(@Users_id,@UserLog_UIP)
	--注意,登录次数无法依靠触发器来完成.
	update ToBeST_Users set Users_loginCount=Users_loginCount+1,Users_lastLoginTime=getdate() where Users_id=@Users_id
	select * from ToBeST_users where Users_id=@Users_id
end
go

---------------------------------------------------------------
----------------更新用户信息的存储过程-------------------------
--------此处不包含有修改密码，和规定不可修改的关键性内容-------
drop proc Users_UpdatingUserInfo
---------------------------------------------------------------
----不可修改的内容，包括：-------------------------------------
----真实姓名（TrueName）,身份证号码（personId）,注册时间（regtime）,
----邮箱（email）,积分（integral），
--暂时（本次）不可修改密码（userpwd）。
--Users_question varchar(max),--密保问题
--Users_answer varchar(max),--密保答案
---------------------------------------------------------------
create proc Users_UpdatingUserInfo
(
@Users_Id int,
@Users_name varchar(50),
@Users_dearname varchar(50),
@Users_qq varchar(50),
@Users_sex bit,
@Users_personality varchar(max),
@Users_img varchar(100),
@Users_birthday datetime,
@Users_bornIn varchar(50),
@Users_work varchar(50),
@Users_tel varchar(50),
@Users_beginLogin datetime,
@Users_endLogin datetime
)as
update ToBeST_users set 
Users_name=@Users_name,
Users_dearname=@Users_dearname,
Users_qq=@Users_qq,
Users_sex=@Users_sex,
Users_personality=@Users_personality,
Users_img=@Users_img,
Users_birthday=@Users_birthday,
Users_bornIn=@Users_bornIn,
Users_work=@Users_work,
Users_tel=@Users_tel,
Users_beginLogin=@Users_beginLogin,
Users_endLogin=@Users_endLogin 
where Users_id=@Users_Id
go

--
--目标管理系统
--
--人脉管理系统
--
--能力管理系统
--
--健康管理系统
--
--知识管理系统
----------------------------------------------------------------
--查询知识所有目录列表的存储过程
----------------------------------------------------------------
drop proc Study_Cage_Select
----------------------------------------
create proc Study_Cage_Select
(
@Study_Cage_parent_id int
)as
select 
Study_Cage_id,
Study_Cage_parentname,
Study_Cage_linkname,
Study_Cage_counts
from ToBeST_Study_Cage join ToBeST_Users on ToBeST_Users.Users_id=
where Study_Cage_parent_id=@Study_Cage_parent_id and Study_Cage_enable=1
go
-----------------------------------------------------------------
--查询知识文章的存储过程
-----------------------------------------------------------------
drop proc Study_Digest_Select
-------------------------------------------
create proc Study_Digest_Select
(
@Study_Cage_id int
)as
select 
Study_Cage_linkname,
Study_Cage_id,
Study_Cage_parentname,
Users_dearname,
Study_Digest_putout,
Study_Digest_puttime,
Study_Digest_digest
from ToBeST_Study_Cage_Digest_view where Study_Cage_id=@Study_Cage_id and Study_Digest_deleted=0 and Study_Digest_enable=1
go

-----------------------------------------------------------------
--查询我发布的知识列表的存储过程
-----------------------------------------------------------------
drop proc Study_listdigest_MySelect
-------------------------------------------
create proc Study_listdigest_MySelect
(
@Study_Users_id int
)as
select 
Study_digest_id,
Study_Cage_id,
Study_Cage_parent_id,
Study_Cage_linkname,
Study_digest_putout,
Study_digest_puttime,
Study_Digest_Enable,
Study_digest_Good,
Study_digest_Bad 
from ToBeST_Study_Cage_Digest_view where Study_Digest_promulgator_id=@Study_Users_id and Study_Digest_deleted=0 and Study_Digest_enable=1
go

-----------------------------------------------------------------
--查询我发布的知识文章的存储过程
-----------------------------------------------------------------
drop proc Study_Digest_MySelect
-------------------------------------------
create proc Study_Digest_MySelect
(
@Study_digest_id int,
@Study_Users_id int
)as
select 
Study_Cage_linkname,
Study_Cage_parentname,
Users_dearname,
Study_digest_putout,
Study_digest_puttime,
Study_digest_digest
from ToBeST_Study_Cage_Digest_view where Study_Digest_id=@Study_digest_id and Study_Digest_promulgator_id=@Study_Users_id and Study_Digest_deleted=0 and Study_Digest_enable=1
go
--------------------------------------------------------------
--更新我发布的文章的存储过程
--------------------------------------------------------------
--drop proc Study_Digest_MyUpdating
----------------------------------------------
create proc Study_Digest_MyUpdating
(
@Study_digest_id int,
@Study_Cage_linkname varchar(100),
@Study_digest_putout varchar(max),
@Study_digest_digest text,
@Study_Users_id int
)as
if exists(select Study_Cage_id from ToBeST_Study_digest where Study_digest_id=@Study_digest_id)
begin
update ToBeST_Study_digest set Study_Digest_putout=@Study_digest_putout,Study_Digest_digest=@Study_digest_digest where Study_Digest_id=@Study_digest_id and Study_Digest_promulgator_id=@Study_Users_id
update ToBeST_Study_Cage set Study_Cage_linkname=@Study_Cage_linkname where Study_Cage_id=(select Study_Cage_id from ToBeST_Study_digest where Study_digest_id=@Study_digest_id) and Study_Cage_id=@Study_Users_id
end
go

--------------------------------------------------------------
--我发布新知识文章的存储过程
--------------------------------------------------------------
--drop proc Study_Digest_MyAdding--【第一步/共两步】
---------------------------------------------
create proc Study_Digest_MyAdding
(
@Study_Cage_parent_id int,
@Study_Cage_linkname varchar(100),
@Study_Users_id int
)as
if not exists(select Study_Cage_id from ToBeST_Study_Cage where Study_Cage_parent_id=@Study_Cage_parent_id and Study_Cage_linkname=@Study_Cage_linkname)
insert into ToBeST_Study_Cage(Study_Cage_parent_id,Study_Cage_linkname,Study_Cage_promulgator,Study_Cage_enable) values(@Study_Cage_parent_id,@Study_Cage_linkname,@Study_Users_id,1)
go

--------------------------------------------------------------
--drop proc Study_Digest_MyAdded--【第二步/共两步】
---------------------------------------------
create proc Study_Digest_MyAdded
(
@Study_Cage_parent_id int,
@Study_Cage_linkname varchar(100),
@Study_digest_putout varchar(max),
@Study_digest_digest text,
@Study_Users_id int
)as
declare @cageid int
select @cageid=Study_Cage_id from ToBeST_Study_Cage where Study_Cage_parent_id=@Study_Cage_parent_id and Study_Cage_linkname=@Study_Cage_linkname and Study_Cage_promulgator=@Study_Users_id
if @cageid is not null
begin
insert into ToBeST_Study_digest(Study_Cage_id,Study_digest_putout,Study_digest_digest,Study_Digest_promulgator_id)values(@cageid,@Study_digest_putout,@Study_digest_digest,@Study_Users_id)
end
go

--------------------------------------------------------------
-------------申请类别的列表绑定   存储过程-------------------------
--drop proc  Study_Cage_NameBING
--------------------------------------------------------------
create proc Study_Cage_NameBING
(@ParentID int)
as
select Study_Cage_id,Study_Cage_linkname from ToBeST_Study_Cage where Study_Cage_id not in(select Study_Cage_id from ToBeST_Study_Digest) and Study_Cage_parent_id=@ParentID and Study_Cage_enable=1
go
--------------------------------------------------------------
-------------申请类别 插入新类别 存储过程-------------------------
drop proc  Study_Insert_NewCageName
--------------------------------------------------------------
create proc Study_Insert_NewCageName
(@Users_ID int,
@Cage_Parent_ID int ,
@CageLinkName varchar(50))
as
----------declare @parentname varchar(100)
----------select @parentname=Study_Cage_linkname from ToBeST_Study_Cage where Study_Cage_id=@Study_Cage_parent_id
----------update ToBeST_Study_Cage set Study_Cage_parentname=@parentname where Study_Cage_parent_id=@Study_Cage_parent_id
declare @Study_Cage_parentname varchar(100)
select @Study_Cage_parentname=Study_Cage_linkname from ToBeST_Study_Cage where Study_Cage_id=@Cage_Parent_ID
insert into ToBeST_Study_Cage (Study_Cage_parent_id,Study_Cage_parentname,Study_Cage_linkname,Study_Cage_promulgator)values (@Cage_Parent_ID,@Study_Cage_parentname,@CageLinkName,@Users_ID)
go

----------select * from ToBeST_Study_Cage
--------------------------------------------------------------------------------
----------drop proc Study_Cage_parentname
----------------------新增父类别的名称一列  正在补充数据------------------------
----------create proc Study_Cage_parentname
----------(@Study_Cage_parent_id int)
----------as
----------declare @parentname varchar(100)
----------select @parentname=Study_Cage_linkname from ToBeST_Study_Cage where Study_Cage_id=@Study_Cage_parent_id
----------update ToBeST_Study_Cage set Study_Cage_parentname=@parentname where Study_Cage_parent_id=@Study_Cage_parent_id
----------go
----------update ToBeST_Study_Cage set Study_Cage_parentname='知识管理平台' where Study_Cage_parent_id='0'
----------
----------exec Study_Cage_parentname '12'
--------------------------------------------------------------
-------------申请类别 获取父类别的ID 存储过程-------------------------
--drop proc Study_GetParentCageID
--------------------------------------------------------------
create proc Study_GetParentCageID
(@ChildID int)
as
select Study_Cage_parent_id from ToBeST_Study_Cage where Study_Cage_id=(select Study_Cage_parent_id from ToBeST_Study_Cage where Study_Cage_id=@ChildID)
go

--财务分配系统
--
--时间管理系统
--
--分类博客系统


--------------------------------------------------------------
------------统计论坛点击次数的存储过程------------------------
---要求：查询论坛，则增加一次论坛浏览次数---------------------
--drop proc Blogs_ID_count
--------------------------------------------------------------
create proc Blogs_ID_count
(
@Blog_id int
)as
update ToBeST_blogs set Blog_hitcount=Blog_hitcount+1 where Blog_id=@Blog_id
select * from ToBeST_blogs where Blog_id=@Blog_id
go

------------论坛插入评论的存储过程------------------------
------------------------------------------------------------
--drop proc Blogs_Review_Adding
--------------------------------------------------------------
create proc Blogs_Review_Adding
(
@Blog_id int,
@Users_id int,
@review_content text
)as
insert into ToBeST_blog_review(Blog_id,Users_id,Blog_Review_content)values(@Blog_id,@Users_id,@review_content)
go
------------查询论坛某博客所有评论的存储过程------------------------
------------------------------------------------------------
--drop proc Blogs_Review_Selecting
--------------------------------------------------------------
create proc Blogs_Review_Selecting
(
@Blog_id int
)
as
select Blog_Review_time,Blog_Review_content,Users_dearname,Users_img,Users_personality,Users_integral from ToBeST_blog_review join ToBeST_Users on ToBeST_blog_review.Users_id=ToBeST_Users.Users_id where Blog_id=@Blog_id and Blog_Review_enable='true' and Users_enable='true'
go
--系统帮助中心
------------------------------------------------------------------------------------------------------------------------------------------------------------------
--数据库触发器

--目标管理系统

--人脉管理系统

--能力管理系统

--健康管理系统

--知识管理系统

--财务分配系统

--时间管理系统

--分类博客系统

--------------------统计博客回复数量 的触发器------------------------------
--drop trigger Blog_backcounting
------------------------------------------------------------------
create trigger Blog_backcounting on ToBeST_Blog_Review for delete,insert
as
update ToBeST_Blogs set Blog_backcount=Blog_backcount+1 where Blog_id=(select Blog_id from inserted)
update ToBeST_Blogs set Blog_backcount=Blog_backcount-1 where Blog_id=(select Blog_id from deleted)
update ToBeST_Blogs set Blog_lastback=getdate() where Blog_id=(select Blog_id from inserted)
------------------------------------------------------------------

--系统帮助中心

------------------------------------------------------------------------------------------------------------------------------------------------------------------
--数据库视图


--目标管理系统
--
--人脉管理系统
--
--能力管理系统
--
--健康管理系统
--
--知识管理系统

--__________________知识管理平台  文章的视图____________---------
drop view ToBeST_Study_Cage_Digest_view
--------------------------------------------------------------------------
create view ToBeST_Study_Cage_Digest_view
as
select 
ToBeST_Study_Cage.Study_Cage_id,
ToBeST_Study_Cage.Study_Cage_parent_id, 
ToBeST_Study_Cage.Study_Cage_parentname, 
ToBeST_Study_Cage.Study_Cage_linkname, 
ToBeST_Study_Cage.Study_Cage_counts, 
ToBeST_Study_Cage.Study_Cage_promulgator,
ToBeST_Study_Cage.Study_Cage_enable,
ToBeST_Study_Digest.Study_Digest_id, 
ToBeST_Study_Digest.Study_Digest_putout, 
ToBeST_Study_Digest.Study_Digest_digest, 
ToBeST_Study_Digest.Study_Digest_puttime, 
ToBeST_Study_Digest.Study_Digest_good, 
ToBeST_Study_Digest.Study_Digest_bad, 
ToBeST_Study_Digest.Study_Digest_enable, 
ToBeST_Study_Digest.Study_Digest_opposer, 
ToBeST_Study_Digest.Study_Digest_promulgator_id,
ToBeST_Study_Digest.Study_Digest_deleted,
ToBeST_Users.Users_dearname
from ToBeST_Study_Cage join ToBeST_Study_Digest on ToBeST_Study_Cage.Study_Cage_id=ToBeST_Study_Digest.Study_Cage_id
join ToBeST_Users on ToBeST_Study_Digest.Study_Digest_promulgator_id=ToBeST_Users.Users_id
go
select * from ToBeST_Study_Cage_Digest_view
--
--财务分配系统
--
--时间管理系统
--
--分类博客系统

--------------------------------------------------------------------------
------—__________________查询所有回帖信息和用户信息的视图____________________
----drop view Users_BlogReview_view
------------------------------------------------------------------------------
----create view Users_BlogReview_view
----as
----select 
----Users_name,
----Users_TrueName,
----Users_personId,
----Users_sex,
----Users_Email,
----Users_personality,
----Users_img,
----Users_integral,
----Users_birthday,
----Users_bornIn,
----Users_Work
----
----review_id,
----Blog_id,
----ToBeST_Users.Users_id,
----review_content,
----review_time
----
---- from ToBeST_users join ToBeST_blog_review on ToBeST_blog_review.Users_id=ToBeST_users.Users_id
----

--系统帮助中心





