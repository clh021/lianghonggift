<?php
    @include 'leesession.php';
    @include '../include/config.php';
	$m_id=49;
    @include 'session1.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加用户 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
   $(document).ready(function(){
	   /*
	   * 表单验证
	   */
	   $("from#from1").submit(function(){
	        var users_account=$('#users_account').val();
			users_account=trim(user_account);
			if(users_account.length<=0){
			   alert("请填账号");
			   return false;
			}
			
			var users_pw=$('#users_pw').val();
			users_pw=trim(users_pw);//调用函数---去掉前后空格
			if(users_pw.length<=0){
				alert("请填密码");
				return false;
			}  
	   });

	   /*
	   * 判断用户是否存在
	   */
	   $("#users_account").blur(function(){
		    var users_account=$("#users_account").val();
			users_account=trim(users_account);
			if(users_account.length>0){
				$.post("../control/users.php?method=ajaxcheck",{"users_account":users_account},function(data,textStatus){
					if(data=='true'){
						alert('该用户已存在');
						$("#users_account").val('');
					}
				});
			} 
	   });
   })

   /*
      去掉前后空格
    */
   function trim(str){
		 return str.replace(/(^\s*)|(\s*$)/g, "");
   }    
//-->
</script>
<BODY>
<form action="../control/users.php?method=add" method="post" id="from1">
 <table border="0" cellpadding="0" cellspacing="0" class="add_table">
     <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">账号：</td>
		   <td align="left"><input type="text" id="users_account" name="users_account"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">密码：</td>
		   <td align="left"><input type="text" id="users_pw" name="users_pw"/><font color="red">( * 必填 )</font></td>
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
