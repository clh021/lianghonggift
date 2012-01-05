<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{% $title %}</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<body>
<div id="contain">
	<div id="header"></div>
	<div id="center">
		<div id="nav"></div>
		<div id="speak">
		<a href="index.php"><img border="0" id="indexpage" /></a>&nbsp;&nbsp;{% if $smarty.session.name != '' %}&nbsp;&nbsp;<a href="index.php?act=mess"><img border="0px" id="pubmess" /></a>{% /if %}&nbsp;&nbsp;{% if $smarty.session.name == '' %}<a href="index.php?act=login"><img border="0" src="images/login.gif" width="81" height="24" /></a>&nbsp;&nbsp;<a href="index.php?act=reg"><img border="0" src="images/reg.gif" width="81" height="24" /></a>{% else %}<a href="logout.php"><img border="0" src="images/logout.jpg" width="91" height="25" /></a>{% /if %}&nbsp;&nbsp;</div>
		<div id="content">
			<div style=" height:30px;"></div>
		{% if $tplname != '' %}
		{%	include file=$tplname %}
		{% elseif $phpname != '' %}
		{%  include_php file=$phpname %}
		{% /if %}
		</div>
	</div>
	
	<div id="bottom">技术服务热线：0431-84978981 0431-84978982 400-675-1066<br>Copyright&copy;www.mingrisoft.comAll Rights Reserved!</div>
</div>
</body>
</html>
