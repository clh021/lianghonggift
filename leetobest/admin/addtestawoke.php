<?php
    include_once('leesession.php');
	checkmodules('testawoke');//陈良红对管理员权限的判断//$m_id=38;
    include_once('../include/config.php');
	include_once('../include/leecommon.php');//防止sql注入、预编义
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加任务提醒 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
<script type="text/javascript" src="<?php echo URL_PATH."js/calendar.js" ?>"></script>
<script type="text/javascript" language="JavaScript">
<!--
   function check(){
        var testawoke_date=document.getElementById('testawoke_date').value;
		testawoke_date=trim(testawoke_date);//调用函数---去掉前后空格
		if(testawoke_date.length<=0){
			alert("请选择提醒时间");
			return false;
		}
        var testawoke_title=document.getElementById('testawoke_title').value;
		testawoke_title=trim(testawoke_name);//调用函数---去掉前后空格
		if(testawoke_title.length<=0){
			alert("请填写标题");
			return false;
		}
		var testawoke_text=document.getElementById('testawoke_text').value;
		testawoke_text=trim(testawoke_path);//调用函数---去掉前后空格
		if(testawoke_text.length<=0){
			alert("请填写内容");
			return false;
		}  
		
		var testawoke_status=document.getElementById('testawoke_status').value;
		testawoke_status=trim(testawoke_status);//调用函数---去掉前后空格
		if(testawoke_status.length<=0){
			alert("请选择状态");
			return false;
		}
		
		var testawoke_sort=document.getElementById('testawoke_sort').value;
		testawoke_sort=trim(testawoke_sort);//调用函数---去掉前后空格
		if(testawoke_sort.length<=0){
			alert("请选择排序");
			return false;
		}  
   }

   /*
      去掉前后空格
    */
   function trim(str){
		 return str.replace(/(^\s*)|(\s*$)/g, "");
   } 
//-->
</script>
 <body >
  <form action="../control/testawoke.php?method=add" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">提醒时间：</td>
		   <td align="left"><input type="text" id="testawoke_date" name="testawoke_date" readonly  onfocus="setday(this)"/><font color="red">( * 必选 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">提醒标题：</td>
		   <td align="left"><input type="text" id="testawoke_title" name="testawoke_title"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">提醒内容：</td>
		   <td align="left"><textarea id="testawoke_text" name="testawoke_text" style="width:60%; height:40px;"></textarea><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">重要级别：</td>
		   <td align="left">
		      <select id="testawoke_sort" name="testawoke_sort"/>
			     <?php
				     for($i=1;$i<=9;$i++){
				 ?>
				 <option value="<?php echo $i;?>"><?php echo $i;?></option>
				 <?php
					 }
				 ?>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1"></td>
		   <td align="left">
			   <input type="hidden" id="testawoke_remark1" name="testawoke_remark1" value="" />
			   <input type="hidden" id="testawoke_remark2" name="testawoke_remark2" value="" />
			   <input type="hidden" id="testawoke_remark3" name="testawoke_remark3" value="" />
		       <input type="submit" value="提交"/>&nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>
