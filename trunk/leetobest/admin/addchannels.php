<?php
    include_once('leesession.php');
    include_once('../include/config.php');
	checkmodules('channels');//陈良红对管理员权限的判断//$m_id=1;
	include_once('../include/leecommon.php');//防止sql注入、预编义
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加频道 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
<script type="text/javascript" language="JavaScript">
<!--
   function check(){
        var channels_name=document.getElementById('channels_name').value;
		channels_name=trim(channels_name);//调用函数---去掉前后空格
		if(channels_name.length<=0){
			alert("请填中文名");
			return false;
		}
		
		var channels_path=document.getElementById('channels_path').value;
		channels_path=trim(channels_path);//调用函数---去掉前后空格
		if(channels_path.length<=0){
			alert("请填英文名");
			return false;
		}  
		
		var channels_status=document.getElementById('channels_status').value;
		channels_status=trim(channels_status);//调用函数---去掉前后空格
		if(channels_status.length<=0){
			alert("请选择状态");
			return false;
		}
		
		var channels_sort=document.getElementById('channels_sort').value;
		channels_sort=trim(channels_sort);//调用函数---去掉前后空格
		if(channels_sort.length<=0){
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
 <body>
  <form action="../control/leechannels.php?method=add" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">中文名：</td>
		   <td align="left"><input type="text" id="channels_name" name="channels_name"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">英文名：</td>
		   <td align="left"><input type="text" id="channels_path" name="channels_path"/>( * 必填 )</td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">链接地址：</td>
		   <td align="left"><input type="text" id="channels_url" name="channels_url"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">描述：</td>
		   <td align="left"><textarea id="channels_description" name="channels_description" style="height:50px; width:97%"></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="channels_status" name="channels_status"/>
			     <option value="1">激活</option>
				 <option value="2">废弃</option>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="channels_sort" name="channels_sort"/>
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
			   <input type="hidden" id="channels_remark1" name="channels_remark1" value="" />
			   <input type="hidden" id="channels_remark2" name="channels_remark2" value="" />
			   <input type="hidden" id="channels_remark3" name="channels_remark3" value="" />
		       <input type="submit" value="提交"/>&nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>
