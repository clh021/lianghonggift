<?php
    include_once 'leesession.php';//判断是不是管理员
    include_once '../include/config.php';//配置文件
	
	$ut_id=@trim($ut_id);
	if(empty($ut_id)){
		 echo "<script>alert('用户类型编号不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $ut_id=(int)$ut_id;
		 if($ut_id<=0){
			 echo "<script>alert('用户类型编号不对');window.history.back();</script>";
		     exit;
		 }
	}
    
	$pageNo=@trim($pageNo);
	if(empty($pageNo)){
		 echo "<script>alert('当前页码不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $pageNo=(int)$pageNo;
		 if($pageNo<=0){
			 echo "<script>alert('当前页码不对');window.history.back();</script>";
		     exit;
		 }
	}
	
	include('../include/mysql.php');//加载数据库操作文件
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	$sql_bool="SELECT * FROM users_type WHERE ut_id='$ut_id'";
	$res=mysql_query($sql_bool);
	$num=mysql_num_rows($res);
	if($num<=0){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
	$sql="SELECT * FROM users_type WHERE ut_id='$ut_id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改用户类别模块 </title>
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
        ut_name=trim(ut_name);//调用函数---去掉前后空格
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
		
		var ut_sort=document.getElementById('ut_sort').value;
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
 <body onload="load()">
  <form action="../control/users_type.php?method=update" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">名称：</td>
		   <td align="left"><input type="text" id="ut_name" name="ut_name" value="<?php echo empty($row['ut_name'])?'':$row['ut_name']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="ut_status" name="ut_status">
			     <?php
				     if($row['ut_status']==1){
				 ?>
                 <option value="1" selected="true">激活</option>
				 <option value="2">废弃</option>
				 <?php
					 }else{
				 ?>
                 <option value="1">激活</option>
				 <option value="2" selected="true">废弃</option>
				 <?php
					 }
				 ?>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="ut_sort" name="ut_sort">
			     <?php
				     for($i=1;$i<=9;$i++){
						 if($row['ut_sort']==$i){
				 ?>
                 <option value="<?php echo $i;?>" selected="true"><?php echo $i;?></option>
				 <?php
						 }else{
				 ?>
				 <option value="<?php echo $i;?>"><?php echo $i;?></option>
				 <?php
						 }
					 }
				 ?>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1"></td>
		   <td align="left">
		       <input type="hidden" id="ut_id" name="ut_id" value="<?php echo $ut_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
			   <input type="hidden" id="users_id" name="users_id" value="<?php echo empty($row['users_id'])?'0':$row['users_id']; ?>" />
		       <input value="修改" type="submit" onClick="return confirm('确认要修改？');" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input onClick="location.href='listUsers_type.php?pageNo=<?php echo $pageNo; ?>'" value="返回" type="reset">
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>
<?php
   $db->close();//关闭数据库连接
   unset($db);
?>