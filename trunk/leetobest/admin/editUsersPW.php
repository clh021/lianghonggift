<?php
     include 'leesession.php';
	 include('../include/config.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/index.css" type="text/css" rel="stylesheet" />
<title>管理员修改用户密码</title>
</head>
<script type="text/javascript" language="JavaScript" src="../js/jquery.min.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
   $(document).ready(function(){
	    /*
	    * 表单验证
	    */
	    $("form#form1").submit(function(){
			var users_account=$('#users_account').val();
			users_account=trim(users_account);//调用函数---去掉前后空格
			if(users_account.length<=0){
				alert("请填用户账号");
				return false;
			} 
			
			var users_pw=$('#users_pw').val();
			users_pw=trim(users_pw);//调用函数---去掉前后空格
			if(users_pw.length<=0){
				alert("请填密码");
				
				return false;
			} 
			
			var users_pw1=$('#users_pw1').val();
			users_pw1=trim(users_pw1);//调用函数---去掉前后空格
			if(users_pw1.length<=0){
				alert("请填确认密码");
				return false;
			}
	
			if(users_pw!=users_pw1){
	            alert("新密码和确认密码不一致");
				return false;
			}
		});

		/*
		* 验证用户账号是否存在
		*/
		$("#users_account").blur(function(){
			var users_account=$("#users_account").val();
			users_account=trim(users_account);
			if(users_account.length>0){
				$.post("../control/users.php?method=ajaxcheck",{"users_account":users_account},function(data,textStatus){
					if(data=='false'){
						alert('该用户不存在');
						$("#users_account").val('');
					}
				});
			}
		});
   })
   
   function trim(str){
	 return str.replace(/(^\s*)|(\s*$)/g, "");
   }    
//-->
</script>
<body>
  <form action="../control/users.php?method=editPw" method="post" id="form1">
      <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
      <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">用户账号：</td>
		   <td align="left"><input type="text" id="users_account" name="users_account"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">密&nbsp;&nbsp;码：</td>
		   <td align="left"><input type="password" id="users_pw" name="users_pw"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">确认密码：</td>
		   <td align="left"><input type="password" id="users_pw1" name="users_pw1"/></td>
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
</body>
</html>      