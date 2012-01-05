<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎使用趁霓虹灯未亮系统</title>
<meta name="keywords" content="" />
<meta name="description" content="陈良红" />
<meta name="generator" content="Discuz! X1.5" />
<meta name="author" content="Discuz! Team and Comsenz UI Team" />
<meta name="copyright" content="2001-2010 Comsenz Inc." />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<base href="{% $url_path %}web/" />
<base target="_self">
<link rel="stylesheet" type="text/css" href="skin/css/base.css" />
</head>
<body leftmargin="8" topmargin='8'>

<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center" style="margin-top:8px">
<tr bgcolor="#E7E7E7">
	<td height="24" colspan="10" background="skin/images/tbg.gif">&nbsp;文档列表&nbsp;</td>
</tr>
<tr align="center" bgcolor="#FAFAF1" height="22">
	<td width="10%">编号</td>
	<td width="20%">内容标题</td>
	<td width="10%">类别</td>
	<td width="10%">点击率</td>
	<td width="10%">发布人</td>
	<td width="10%">联系方式</td>
	<td width="10%">发布时间</td>
	<td width="10%">更新时间</td>
	<td width="10%">来源</td>
</tr>
{% foreach name=ss key=aa item=bb from=$contents_list %}
<tr align='center' bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#EEDDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';" height="22" >
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_id %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_title %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.cates_name %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_hits %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_adduserid %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_connect %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_addtime %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_edittime %}</u></a></td>
	<td align="left"><a href='{% $url_path %}2010/{% $bb.contents_url %}'><u>{% $bb.contents_resource %}</u></a></td>
</tr>
{% /foreach %}


</table>

<!--  搜索表单  -->
<form name='form3' action='' method='get'>
<input type='hidden' name='dopost' value='' />
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#CBD8AC' align="center" style="margin-top:8px">
  <tr bgcolor='#EEF4EA'>
    <td background='skin/images/wbg.gif' align='center'>
      <table border='0' cellpadding='0' cellspacing='0'>
        <tr>
          <td width='90' align='center'>搜索条件：</td>
          <td width='160'>
          <select name='cid' style='width:150'>
          <option value='0'>选择类型...</option>
          	<option value='1'>名称</option>
          </select>
        </td>
        <td width='70'>
          关键字：
        </td>
        <td width='160'>
          	<input type='text' name='keyword' value='' style='width:150px' />
        </td>
        <td width='110'>
    		<select name='orderby' style='width:80px'>
            <option value='id'>排序...</option>
            <option value='pubdate'>发布时间</option>
      	</select>
        </td>
        <td>
          <input name="imageField" type="image" src="skin/images/frame/search.gif" width="45" height="20" border="0" class="np" />
        </td>
       </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</body>
</html>