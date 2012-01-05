-----------------------------------------------------------------------
------------------���ݿ����-------------------------------------------
-----------------------------------------------------------------------
--΢��ٷ�SQLHELPʹ��ʾ��
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
------��������
----create table LeeToBeST_invitenum
----(
----invitenum_ID int identity(1,1),
----invitenum_num varchar(100),
----invitenum_ctime datetime default getdate(),
----invitenum_gtime datetime
----)
--------------------------------------------------------------------------------
------��һЩ��Ҫ�����������ɢ���ݣ�ϣ���ܹ��洢�����ݿ⵱�У��Է����޸ģ�
------������Ҫ���ⴴ��һ������ı����������Щ�������ɢ���ݡ�
--------           -----           -------         -------         -----   -------
------1�����ڱ�վ����վ�������Ϣ��������Ŀ���������ݣ�˵������������ּ����ȫ����
------2������������ʹ��Э�飬�������
------3��������飬
----create table ToBeST_ScatterDate--��ɢ���ݱ�
----(
----ScatterDate_id int identity(1,1) primary key,
----ScatterDate_pagename varchar(100),--������ҳ�����ƣ�����.aspx��
----ScatterDate_class varchar(100),--��ǵ���������
----ScatterDate_detail varchar(100)
----)
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
------������Ҫһ���˲���Ƹ�б�
----create table ToBeST_InviteTalented--�˲���Ƹ�б�
----(
----InviteTalented_id int identity(1,1) primary key,
------InviteTalented
----)
--------------------------------------------------------------------------------
------������Ҫ������һ������ǣ��ͻ������������Ա�
----create table ToBeST_CustomerWord
----(
----CustomerWord_id int identity(1,1) primary key,
----Users_id int foreign key references LeeToBeST_Users(Users_id),
----CustomerWord_Email varchar(100),--�����ߵ�����
----CustomerWord_QQ varchar(100),--�����ߵ�QQ����
----CustomerWord_message,  --��������
----CustomerWord_back  --�Ƿ�������������Ա�ã�
----)
--------------------------------------------------------------------------------
------���⻹��һ���˺����߱�
----create table ToBeST_UserAppeal
----(
----UserAppeal_id int identity(1,1) primary key,
----Users_id int foreign key references LeeToBeST_Users(Users_id),
----UserAppeal_content varchar(max),--��������
----UserAppeal_examine bit default 0,  --�Ƿ񾭹����
----UserAppeal_pass bit default 0 --�Ƿ�ͨ������
----)
--------------------------------------------------------------------------------
------�´����ģ�ֿ�������
----create table ToBeST_TryBosom
----(
----TryBosom_id int identity(1,1) primary key,
----ZUsers_id int foreign key references LeeToBeST_Users(Users_id),--���������˵�ID
----BUsers_id int foreign key references LeeToBeST_Users(Users_id),--�����˵�ID
----TryBosom_BPrint bit default 0,  --�������Ƿ���ȷ�Ϲ������ͬ����߹رգ��͸��ģ�
----TryBosom_Pass bit default 0,  --�Ƿ�ͨ����ֿ�ѹ�ϵ
----TryBosom_ZPrint bit default 0   --�������Ƿ�֪����ͨ������Ϣ
----)
----------------------------------------------------------------------------
--ͨ���û��ʺ�����
-------------------------------------------------------------------------------
----------------�û���---------------------------------------------
--drop table ToBeST_Users
-------------------------------------------------------------------------------
create table ToBeST_Users
(
Users_id int identity(1,1) primary key,
Users_name varchar(50) unique not null,
Users_dearname varchar(50) default 'С��' not null,--�ǳƣ�������ʾΪ�˱����û���˽������ʾ��¼��
Users_pwd varchar(50) not null,
Users_trueName varchar(50) not null,--��ʵ����
Users_email varchar(100) unique not null,--����
Users_personaID varchar(50) unique not null,--�û������֤����
Users_qq varchar(50) default '������',--��ϵQQ
Users_sex bit not null,
Users_question varchar(max),--�ܱ�����
Users_answer varchar(max),--�ܱ���
Users_personality varchar(max),--����ǩ��
Users_img varchar(100) default 'default.gif',--ͷ��
Users_integral int default 0 not null,--����
Users_birthday datetime default '1980-1-1 00:00:00',--ũ������
Users_bornIn varchar(50) default '������',--������
Users_work varchar(50) default '������',--������ְҵ
Users_tel varchar(50) default '������',--��ϵ�绰
Users_beginLogin datetime default '1980-1-1 00:00:00' not null,--�����¼��ʼʱ��ֻ��Сʱ����
Users_endLogin datetime default '1980-1-1 23:59:00' not null, --�����¼����ʱ��ֻ��Сʱ����
Users_lastUpdate datetime default getdate() not null,--���һ���޸�ʱ��
Users_regtime datetime default getdate() not null,--ע��ʱ��
Users_loginCount int default '0' not null,--ͳ���û���¼����
Users_lastLoginTime datetime,--��¼�û��ϴε�¼ʱ��
Users_enable bit default '1' not null,--�Ƿ�����,�Ƿ���Ч
Users_opposer varchar(max)--ͨ�����Ӽ�¼���оٱ��ߵ�ID�м��ö��Ÿ���
)
----select * from ToBeST_Users
----update ToBeST_Users set img='default.gif'

----alter table ToBeST_Users add constraint ToBeSTUserEmaiil_Unique unique(Users_Email)
----alter table ToBeST_Users add constraint ToBeSTUserEmaiil_Unique unique(Users_Email)
-------------------------------------------------------------------------------
----------------��¼�û���¼����־---------------------------------------------
--drop table ToBeST_UserLog
--------------------------------------------------------------------------------
create table ToBeST_UserLog
(
UserLog_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),
UserLog_UIP varchar(20) not null,
UserLog_UTime datetime default getdate() not null
)

--Ŀ�����ϵͳ
-------------------------------------------------------------------------------
----------------Ŀ���---------------------------------------------
drop table ToBeST_Goal--��ֻ���˵���СĿ�꣩
--------------------------------------------------------------------------------
create table ToBeST_Goal
(
Goal_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--�����û�
Goal_custodianid varchar(max),--�ල�ˣ�ע���û���ID����
Goal_custodians varchar(max) not null,--�ල�ˣ�Ϊע���û���
Goal_cagename varchar(100),--���ͣ�������������������֪ʶ��������Ѷ�����ͣ���������
Goal_name varchar(max) not null,-- Ŀ������
Goal_state varchar(100) not null,--״̬(����ɣ������У�δ���)
Goal_punish varchar(max) not null,--�ͷ�
Goal_power varchar(max) not null,--Ŀ�궯�����ɸ��ӣ��Զ����<br/>��
Goal_share bit not null,--�Ƿ���ֿ����ʾ��Ŀ��
Goal_level int not null default '1',--Ŀ�꼶������Խ�󼶱�Խ�ߣ�
Goal_begin datetime not null,--Ŀ�꿪ʼִ��ʱ�䣨���ʱ�䣩
Goal_end datetime not null,--Ŀ���޶�����ʱ��
Goal_enable bit not null
)
----------------����ִ�б�---------------------------------------------
drop table ToBeST_TaskRuning
--------------------------------------------------------------------------------
create table ToBeST_TaskRuning
(
TaskRuning_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--�����û�
Goal_id int foreign key references ToBeST_Goal(Goal_id),--��Ӧ�������ʲôĿ��
TaskRuning_name varchar(10) not null,--��Ӧ��Ҫִ�����������			�������ʣ�	�����ֱۣ�
TaskRuning_daycount int not null,--����							��һ�죩	��һ�죩
TaskRuning_taskcount int not null,--����������					��ʮ��		��һ��
TaskRuning_taskunite varchar(5) not null,--��������Ӧ��λ				������		������
TaskRuning_taskname varchar(10) not null,--�������ƣ�����				�����ʣ�	�����Գţ�
TaskRuning_increasecount int not null,--��������������������(0������) ����		��һ��
TaskRuning_taskmin int not null,--������������С����(0������С)       ����		��һ��
TaskRuning_taskmax int not null,--�����������������(0�������)		����		��һ��
--TaskRuning_cagename varchar(100),--���ͣ�������������������֪ʶ��������Ѷ�����ͣ���������
TaskRuning_enable bit not null
)
----------------����ִ����־��---------------------------------------------
drop table ToBeST_TaskRuning_Log
--------------------------------------------------------------------------------
create table ToBeST_TaskRuning_Log
(
TaskRuning_Log_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--�����û�
TaskRuning_id int foreign key references ToBeST_TaskRuning(TaskRuning_id),--��Ӧ��ִ������
TaskRuning_Log_taskcount int not null,--ִ������ʵ����
TaskRuning_Log_feel varchar(max),--ִ��������ԣ���������ᣬ
TaskRuning_Log_time datetime default getdate()--��¼ʱ��
)

--��������ϵͳ
------------------------------------------------------------------------------------
----------------------������Դ��-----------------------------------------------------
----drop table ToBeST_Friend
------------------------------------------------------------------------------------
----create table ToBeST_Friend
----(
----Friend_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--���������ĸ��û�
----UsersFriend_id int foreign key references ToBeST_Users(Users_id),--�����ѵ�ע��ID
----Friend_cage int ,--����ʮ��������ѷ��ࣨ��ֵ��������������СΪ����������Ϊ��ֵ*2��
----Friend_name varchar(50),--���ѵ�����
----Friend_img varchar(50),--������Ƭ����
----Friend_sex bit,--���ѵ��Ա�
----Friend_census varchar(100),  --����
----Friend_  --����
----Friend_  --Ѫ��
----Friend_  --��������
----Friend_  --��Ȥ����
----Friend_works varchar(200),--������λ���߹�˾
----Friend_  --�칫��ַ
----Friend_  --��˾�绰
----Friend_  --��ͥ��ַ
----Friend_  --סլ��ַ
----Friend_  --סլ�绰
----
----Friend_position varchar(200),--����ְ��
----Friend_birthday datetime,--���ѵ�����
----Friend_  --����������
----Friend_  --��ҵԺУ
----Friend_  --��ѧרҵ
----Friend_qq varchar(100),--QQ��ϵ����
----Friend_tel varchar(100),--�ֻ�����
----Friend_email varchar(50),--���ѵĵ�������
----Friend_others text--���ѵ�������ע��Ϣ
----)
-----------------------------------------------------------------------------------
----------��Ա����ʹ�õĹ���-------------------------------------
------������չ��������
----create table ToBeST_Friendvipkz
----(
----Friendvipkz_��ò����
----Friendvipkz_����״��
----Friendvipkz_����ϰ��
----Friendvipkz_���Ⱦ���
----Friendvipkz_����ϰ��
----Friendvipkz_��������
----Friendvipkz_ƫ����ʽ
----Friendvipkz_��ʳϰ��
----Friendvipkz_����ס��
----Friendvipkz_ְ���ʸ�
----Friendvipkz_ϲ�û���
----Friendvipkz_�ɻ仰��
----Friendvipkz_ϲ������
----Friendvipkz_ϲ���˶�
----Friendvipkz_����ϲ��
----Friendvipkz_ϲ����Ʒ
----Friendvipkz_������Ը
----Friendvipkz_������Ը
----Friendvipkz_�������
----Friendvipkz_�������
----)
------������չ��ͥ����
----create table ToBeST_Friendvipjy
----(
----���ѧ��
----��ѧרҵ
----��ҵԺУ
----��ҵʱ��
----�ó��˶�
----�μ�����
----��ѧ����
----��������
----��ѧ��̬��
----���۾���
----��߾���
----��ѧʱȤ��
----���ⱳ��
----��ĸ״��
----��ĸ����
----����״��
----��ż����
----��żѧ��
----��żϲ��
----�������
----��Ů����
----��Ů����
----��Ů����
----��Ůϲ��
----�Զ���1
----�Զ���2
----
----)
----
------������չ�ͻ���ϵ
----create table ToBeST_Friendvipkh
----(
----�ͻ�״̬
----�ͻ���Դ
----�ͻ�����
----�ͻ�Ǳ��
----��˾����
----�����˺�
----ǰһ��ְ��
----��˾�ڵ�λ
----��Թ�˾̬��
----��˾����̬��
----����Χ��ҵ���ϵ
----��Χ����ҵ���ϵ
----�ͻ�������Ժ�Ϊ��
----�������Ҫ����
----�ͻ����еĹؼ�����
----�ҵ��ĵ�����
----�Զ���1
----�Զ���2
----�Զ���3
----�Զ���4
----)

------------------------------------------------------------------------------------
----------------------������Դ�����-----------------------------------------------------
----drop table ToBeST_friendconn
------------------------------------------------------------------------------------
----create table ToBeST_friendconn
----(
----Friendconn_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--��Ӧ���û�
----Friendconn_Invite bit ,--������true/false
----Friendconn_date varchar(50),--����������
----Friendconn_time varchar(50),
----Friendconn_connet varchar(max),--����������Ϣ
----Friendconn_integral int,--����������ֻ����0��-1��+1��
----Friendconn_reason varchar(max)--��������
----)
----
------��������ϵͳ
----
------------------------------------------------------------------------------------
----------------------����Ŀ��ʵ��ͳ�Ʊ�-----------------------------------------------------
----drop table ToBeST_Practice
------ʹ�ô����������涨��ÿ����60*60=3600ʱ��ȥ3600��Сʱ����1
------------------------------------------------------------------------------------
----create table ToBeST_Practice
----(
----Practice_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--��Ӧ���û�
----Goalreduce_id int foreign key references ToBeST_Goalreduce(Goalreduce_id),--��Ӧ�Ľ���Ŀ��
----Practice_Name varchar(200),--��Ӧ������
----Practice_cage varchar(100),--��Ӧ�ĵ�λ���֣��룬�����Σ�
----Practice_tenthousand int,--��ϰ������ͳ��
----Practice_tick int --��ϰ�Ĵ���ͳ��
----)


------��������ϵͳ
----
------------------------------------------------------------------------------------
----------------------��������ʵ��ͳ�Ʊ�-----------------------------------------------------
----drop table ToBeST_Health
------ʹ�ô����������涨��ÿ����10000ʱ��ȥ10000���������1
------------------------------------------------------------------------------------
----create table ToBeST_Health
----(
----Health_id int identity(1,1) primary key,
----Users_id int foreign key references ToBeST_Users(Users_id),--��Ӧ���û�
----Goalreduce_id int foreign key references ToBeST_Goalreduce(Goalreduce_id),--��Ӧ�Ľ���Ŀ��
----Health_Name varchar(200),--��Ӧ������
----Health_cage varchar(100),--��Ӧ�ĵ�λ���֣��룬�����Σ�
----Health_tenthousand int,--��ϰ������ͳ��
----Health_tick int   --��ϰ�Ĵ���ͳ��
----)

--֪ʶ����ϵͳ

-------------------------------------------------------------------------------
----------------֪ʶ��������---------------------------------------------
--drop table ToBeST_Study_Cage
-------------------------------------------------------------------------------
create table ToBeST_Study_Cage
--�˴���ѧϰ����б���������ÿ����Ŀ�����ơ�
(
Study_Cage_id int identity(1,1) primary key,
Study_Cage_parent_id int not null,
Study_Cage_parentname varchar(100) not null,
Study_Cage_linkname varchar(100) not null,
Study_Cage_counts int default 0 not null, --�����м�������
Study_Cage_promulgator int foreign key references ToBeST_Users(Users_id),--�����ߵ�ID
Study_Cage_enable bit default 0 not null
)
-------------------------------------------------------------------------------
----------------֪ʶ�������ݱ�---------------------------------------------
-------------------------------------------------------------------------------
--drop table ToBeST_Study_Digest
create table ToBeST_Study_Digest
--�˴���ѧϰ�����б�����ÿ����Ŀ�Ķ�Ӧ���ݡ������˱���Ϊ���Ժ󷽱㹮�������ֶΣ����ӹ��ܡ�
(
Study_Digest_id int identity(1,1) primary key,
Study_Cage_id int foreign key references ToBeST_Study_Cage(Study_Cage_id),--�������ı��
Study_Digest_putout varchar(max) not null,--�����������������ַ��Ҳ�������鼮����
Study_Digest_digest varchar(max) not null,
--Study_Digest_promulgator varchar(100) foreign key references ToBeST_Users(Users_id),--�������ߵ�����
Study_Digest_puttime datetime default getdate() not null,
Study_Digest_good int default '0' not null,--���ۺõĴ���
Study_Digest_bad int default '0' not null,--���۲��õĴ���
Study_Digest_deleted bit default '0' not null,--�û��Ƿ��н���ɾ��
Study_Digest_enable bit default '1' not null,--�Ƿ�����,�Ƿ���Ч
Study_Digest_opposer varchar(max),--ͨ�����Ӽ�¼���оٱ��ߵ�ID,�м��ö��Ÿ���
Study_Digest_promulgator_id int foreign key references ToBeST_Users(Users_id)
)
----select * from ToBeST_Study_Cage
----select * from ToBeST_Study_digest
----update ToBeST_Study_digest set Study_deleted='0'
----------------
--�������ϵͳ

-----------------------------------------------------------------------------------
--------------------�����¼��---------------------------------------------
----drop table ToBeST_Finace_Log
-----------------------------------------------------------------------------------
----select * from ToBeST_Finace_Log
----create table ToBeST_Finace_Log
------�˴���ѧϰ����б���������ÿ����Ŀ�����ơ�
----(
----Finace_Log_id int identity(1,1) primary key, 
----Users_id int foreign key references ToBeST_Users(Users_id),--��Ӧ���û�
----Finace_Log_date varchar(100),--����
----Finace_Log_time datetime default getdate(),--�������ݵ�ʱ��
----Finace_Log_payout int,--֧�����
----Finace_Log_whypayout varchar(max),--֧��ԭ��
----Finace_Log_include int,--������
----Finace_Log_whyinclude varchar(max),--����ԭ��
----Finace_Log_balance int,--����
----Finace_Log_sumup varchar(max)--�ܽ�
----)


-----------------------------------------------------------------------------------
--------------------����Ŀ���---------------------------------------------
----drop table ToBeST_Finace_Goal
-----------------------------------------------------------------------------------
----select * from ToBeST_Finace_Goal
----create table ToBeST_Finace_Goal
------�˴���ѧϰ����б���������ÿ����Ŀ�����ơ�
----(
----Finace_Goal_id int identity(1,1) primary key, 
----Users_id int foreign key references ToBeST_Users(Users_id),--��Ӧ���û�
----Finace_Goal_date varchar(100),--����
----Finace_Goal_time datetime default getdate(),--�������ݵ�ʱ��
----Finace_Goal_text varchar(max) --��������Ŀ��
----)
------ʱ�����ϵͳ
-----------------------------------------------------------------------------------
--------------------ʱ���������ѱ�---------------------------------------------
----drop table ToBeST_Test_Awoke
-----------------------------------------------------------------------------------
----select * from ToBeST_Test_Awoke
----create table ToBeST_Test_Awoke
------�˴���ѧϰ����б���������ÿ����Ŀ�����ơ�
----(
----Test_Awoke_id int identity(1,1) primary key, 
----Users_id int foreign key references ToBeST_Users(Users_id),--��Ӧ���û�
----Test_Awoke_date varchar(100),--����ʱ�䣨Ҫ��ǳ���ϸ��
----Test_Awoke_time datetime default getdate(),--�������ݵ�ʱ��
----Test_Awoke_tittle varchar(100),--���Ѵ��ڵı���
----Test_Awoke_text varchar(max) --�������ݣ�����������
----)

--���಩��ϵͳ

--------------------------------------------------------------------------------
-----------------���ͣ���̳����Ҫ����-------------------------------------------
--drop table ToBeST_Blogs
create table ToBeST_Blogs
(
Blog_id int identity(1,1) primary key,
Users_id int foreign key references ToBeST_Users(Users_id),--��һλ�û�������
Blog_author varchar(100) default '����' not null,--�������ߣ������Լ���ҳ����Ĭ���Լ����ǳơ�
Blog_stitle varchar(100) not null,--����
Blog_digest text not null,--����
Blog_putdate datetime default getdate() not null,--���������
Blog_lastback datetime default getdate() not null,--���ظ�ʱ��
Blog_hitcount int default 0 not null,--�������
Blog_backcount int default 0 not null,--���ظ��Ĵ���
Blog_topYN bit default 0 not null,      --�Ƿ��ö�
Blog_enable bit default '1' not null,--�Ƿ�����,�Ƿ���Ч
Blog_opposer varchar(max)--ͨ�����Ӽ�¼���оٱ��ߵ�ID�м��ö��Ÿ���
)

-----------------------------------------------------------------------------
----------------���ͣ���̳���ظ���-------------------------------------------
--drop table ToBeST_Blog_Review
create table ToBeST_Blog_Review
(
Blog_Review_id int identity(1,1) primary key,
Blog_id int foreign key references ToBeST_Blogs(Blog_id),
Users_id int foreign key references ToBeST_Users(Users_id),--�ظ����û�ID
Blog_Review_content text not null,
Blog_Review_time datetime default getdate() not null,
Blog_Review_enable bit default '1' not null,--�Ƿ�����,�Ƿ���Ч
Blog_Review_opposer varchar(max)--ͨ�����Ӽ�¼���оٱ��ߵ�ID�м��ö��Ÿ���
)
-----------------------------------------------------------------------------

--ϵͳ��������

--���ݿ���������Ĵ���

--���ݿ�洢����


--ͨ���û��ʺ�����

----------------------------------------------------------
-----------------�û�ע��Ĵ洢����------------------
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
-----------------��ȡ�û���Ϣ�Ĵ洢����------------------
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
----------------------����û����Ĵ洢����-------------------
--drop proc Users_Checkname
-------------------------------------------------------------
create proc Users_Checkname
(
@Users_name varchar(500)
)as
select Users_id from ToBeST_users where Users_name=@Users_name
go
-------------------------------------------------------------
----------------------�������Ĵ洢����-------------------
--drop proc Users_Checkemail
-------------------------------------------------------------
create proc Users_Checkemail
(
@Users_Email varchar(500)
)as
select Users_id from ToBeST_users where Users_Email=@Users_Email
go
-------------------------------------------------------------
-----------------��¼�Ĵ洢����------------------------------
drop proc Users_Logining
-------------------------------------------------------------
create proc Users_Logining
(
---�����ǲ�ѯ����ô��ѯ��ʱ��Ҳ�ǿ���ָ��Ҫ��ѯ�Ķ���
---ͬ�����������ģ�������һ����Ĳ�ѯ��䣬��ô��
---��Ȼ�ģ��洢����Ҳ���ܴﵽ�ܺõı�����ʩ��
@Users_name varchar(500),
@Users_pwd varchar(500),
@UserLog_UIP varchar(20)
)as
if exists(select Users_id from ToBeST_Users where Users_name=@Users_name and Users_pwd=@Users_pwd)
begin
	declare @Users_id int
	select @Users_id=Users_id from ToBeST_Users where Users_name=@Users_name and Users_pwd=@Users_pwd
	insert into ToBeST_UserLog(Users_id,UserLog_UIP) values(@Users_id,@UserLog_UIP)
	--ע��,��¼�����޷����������������.
	update ToBeST_Users set Users_loginCount=Users_loginCount+1,Users_lastLoginTime=getdate() where Users_id=@Users_id
	select * from ToBeST_users where Users_id=@Users_id
end
go

---------------------------------------------------------------
----------------�����û���Ϣ�Ĵ洢����-------------------------
--------�˴����������޸����룬�͹涨�����޸ĵĹؼ�������-------
drop proc Users_UpdatingUserInfo
---------------------------------------------------------------
----�����޸ĵ����ݣ�������-------------------------------------
----��ʵ������TrueName��,���֤���루personId��,ע��ʱ�䣨regtime��,
----���䣨email��,���֣�integral����
--��ʱ�����Σ������޸����루userpwd����
--Users_question varchar(max),--�ܱ�����
--Users_answer varchar(max),--�ܱ���
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
--Ŀ�����ϵͳ
--
--��������ϵͳ
--
--��������ϵͳ
--
--��������ϵͳ
--
--֪ʶ����ϵͳ
----------------------------------------------------------------
--��ѯ֪ʶ����Ŀ¼�б�Ĵ洢����
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
--��ѯ֪ʶ���µĴ洢����
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
--��ѯ�ҷ�����֪ʶ�б�Ĵ洢����
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
--��ѯ�ҷ�����֪ʶ���µĴ洢����
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
--�����ҷ��������µĴ洢����
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
--�ҷ�����֪ʶ���µĴ洢����
--------------------------------------------------------------
--drop proc Study_Digest_MyAdding--����һ��/��������
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
--drop proc Study_Digest_MyAdded--���ڶ���/��������
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
-------------���������б��   �洢����-------------------------
--drop proc  Study_Cage_NameBING
--------------------------------------------------------------
create proc Study_Cage_NameBING
(@ParentID int)
as
select Study_Cage_id,Study_Cage_linkname from ToBeST_Study_Cage where Study_Cage_id not in(select Study_Cage_id from ToBeST_Study_Digest) and Study_Cage_parent_id=@ParentID and Study_Cage_enable=1
go
--------------------------------------------------------------
-------------������� ��������� �洢����-------------------------
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
----------------------��������������һ��  ���ڲ�������------------------------
----------create proc Study_Cage_parentname
----------(@Study_Cage_parent_id int)
----------as
----------declare @parentname varchar(100)
----------select @parentname=Study_Cage_linkname from ToBeST_Study_Cage where Study_Cage_id=@Study_Cage_parent_id
----------update ToBeST_Study_Cage set Study_Cage_parentname=@parentname where Study_Cage_parent_id=@Study_Cage_parent_id
----------go
----------update ToBeST_Study_Cage set Study_Cage_parentname='֪ʶ����ƽ̨' where Study_Cage_parent_id='0'
----------
----------exec Study_Cage_parentname '12'
--------------------------------------------------------------
-------------������� ��ȡ������ID �洢����-------------------------
--drop proc Study_GetParentCageID
--------------------------------------------------------------
create proc Study_GetParentCageID
(@ChildID int)
as
select Study_Cage_parent_id from ToBeST_Study_Cage where Study_Cage_id=(select Study_Cage_parent_id from ToBeST_Study_Cage where Study_Cage_id=@ChildID)
go

--�������ϵͳ
--
--ʱ�����ϵͳ
--
--���಩��ϵͳ


--------------------------------------------------------------
------------ͳ����̳��������Ĵ洢����------------------------
---Ҫ�󣺲�ѯ��̳��������һ����̳�������---------------------
--drop proc Blogs_ID_count
--------------------------------------------------------------
create proc Blogs_ID_count
(
@Blog_id int
)as
update ToBeST_blogs set Blog_hitcount=Blog_hitcount+1 where Blog_id=@Blog_id
select * from ToBeST_blogs where Blog_id=@Blog_id
go

------------��̳�������۵Ĵ洢����------------------------
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
------------��ѯ��̳ĳ�����������۵Ĵ洢����------------------------
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
--ϵͳ��������
------------------------------------------------------------------------------------------------------------------------------------------------------------------
--���ݿⴥ����

--Ŀ�����ϵͳ

--��������ϵͳ

--��������ϵͳ

--��������ϵͳ

--֪ʶ����ϵͳ

--�������ϵͳ

--ʱ�����ϵͳ

--���಩��ϵͳ

--------------------ͳ�Ʋ��ͻظ����� �Ĵ�����------------------------------
--drop trigger Blog_backcounting
------------------------------------------------------------------
create trigger Blog_backcounting on ToBeST_Blog_Review for delete,insert
as
update ToBeST_Blogs set Blog_backcount=Blog_backcount+1 where Blog_id=(select Blog_id from inserted)
update ToBeST_Blogs set Blog_backcount=Blog_backcount-1 where Blog_id=(select Blog_id from deleted)
update ToBeST_Blogs set Blog_lastback=getdate() where Blog_id=(select Blog_id from inserted)
------------------------------------------------------------------

--ϵͳ��������

------------------------------------------------------------------------------------------------------------------------------------------------------------------
--���ݿ���ͼ


--Ŀ�����ϵͳ
--
--��������ϵͳ
--
--��������ϵͳ
--
--��������ϵͳ
--
--֪ʶ����ϵͳ

--__________________֪ʶ����ƽ̨  ���µ���ͼ____________---------
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
--�������ϵͳ
--
--ʱ�����ϵͳ
--
--���಩��ϵͳ

--------------------------------------------------------------------------
------��__________________��ѯ���л�����Ϣ���û���Ϣ����ͼ____________________
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

--ϵͳ��������





