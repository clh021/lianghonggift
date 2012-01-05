<?php
   include_once('leesession.php');
   include_once('../include/config.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>欢迎进入系统后台</TITLE>
<style type="text/css">
<!--
* {
	font: Verdana, Arial, Helvetica, sans-serif;
	color: #333333;
	margin: 0px;
	padding: 0px;
}
-->
</style>
<script src="style/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="style/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
</HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<BODY >

<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0"> 系 统 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 目 标 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 健 康 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 人 脉 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 时 间 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 能 力 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 知 识 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 财 务 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 博 客 </li>
    <li class="TabbedPanelsTab" tabindex="0"> 扩 增 </li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
1、模块表加上字段，存储，生成此表，此模块的MYSQL执行语句<br />
3、生成静态页面的目录不应该以年份命名<br />
5、模块英文名限定不允许输入汉字 <br />
7、注意所有有缓存的表，一旦添加修改删除都需要做一个重新生成缓存的操作<br />
8、栏目修改，不允许列出子下栏目<br />
8、关闭和废弃的，一律使用红色标出<br />
9、登录日志一键清理，一个月之内的不允许清理<br />
10、很多配置文件中的设置都可以封装进系统表里面去，系统表的数据设置状态，不允许删除<br />
11、修改了频道，模块和系统设置之后应该适时刷新页面<br />
12、用户设置自己账号允许登录的开始时间和结束时间<br />
13、我个人觉得，缓存中，我们无法查询得到表字段的备注信息，那么我们可以将我们需要的每个表的字段的中文代替名称可以用一个字段保存下来。那么这样的话，又有一个新的问题了，我要如何将表中这一个字段的所有数据都在保存数据结构的时候保存下来呢？可不可以这样，我们在保存所有表结构信息的时候，就再使用另外一个文件来保存新查询出来的中文名称信息？不行，因为我总是会希望一次加载结构缓存就能够得到所有信息。对了！我想到一个办法：我们本来是应该在模块表中保存所有模块表字段信息，我们可以保存创建该模块需要的表的创建SQL语句，我们可以保存表的所有字段，我们也可以顺便保存一个中文意义，模块又是必定有缓存的，这样也方便。可是？将字段保存在模块表中，真的好吗？<br />
    </div>
    <div class="TabbedPanelsContent">目标</div>
    <div class="TabbedPanelsContent">健康</div>
    <div class="TabbedPanelsContent">
1、人脉增修<br />
2、人脉添加字段，何处何时何地认识，印象，特点，外貌，给人感觉，总结<br />
3、内容自动保存草稿的功能<br />
4、添加人脉，上传图像的字段未处理<br />
6、内容要做搜索功能
	</div>
    <div class="TabbedPanelsContent">时间</div>
    <div class="TabbedPanelsContent">能力</div>
    <div class="TabbedPanelsContent">
搜索功能<br />2、左侧能不能用JQuery做成动态效果<br />
4、内容要做是否私有日志的功能，访问权限的功能<br />
5、所有的include之前都需要加上判断文件是否存在
	</div>
    <div class="TabbedPanelsContent">财务</div>
    <div class="TabbedPanelsContent">
	搜索功能<br /></div>
    <div class="TabbedPanelsContent">
1、“数据库表”明确插入好<br />2、编辑数据库模块，添加你所添加的表的英文名称和中文名称<br />3、拷贝，修改页面权限，模块ID为此ID<br />4、检查加载文件是否齐全<br />5、设置账号的权限<br />6、更新缓存<br />7、注销
	</div>
  </div>
</div>

<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
</script>
</BODY>
</HTML>