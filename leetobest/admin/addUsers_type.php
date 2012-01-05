<?php
    @include_once'leesession.php';
    @include_once'../include/config.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加用户类型 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
<script type="text/javascript" src="../fckeditor/fckeditor.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
   function check(){
        var ut_name=document.getElementById('ut_name').value;
        ut_name=trim(ut_name);
		if(ut_name.length<=0){
		   alert("请填名称");
		   return false;
		}
		
		var ut_status=document.getElementById('ut_status').value;
		ut_status=trim(ut_status);//调用函数---去掉前后空格
		if(ut_status.length<=0){
			alert("请选择状态");
			return false;
		}
		
		var ut_sort=doctument.getElementById('ut_sort').value;
		ut_sort=trim(ut_sort);//调用函数---去掉前后空格
		if(ut_sort.length<=0){
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
<BODY>
<form action="../control/users_type.php?method=add" method="post" onsubmit="return check();">
 <table border="0" cellpadding="0" cellspacing="0" class="add_table">
     <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">类型名称：</td>
		   <td align="left"><input type="text" id="ut_name" name="ut_name"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="ut_status" name="ut_status">
		         <option value="1">激活</option>
		         <option value="2">废弃</option>
		      </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		     <select id="ut_sort" name="ut_sort">
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
		       <input type="submit" value="提交"/>&nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
	 </tr>
 </table>
</form>
</BODY>
</HTML>