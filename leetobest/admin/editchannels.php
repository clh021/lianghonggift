<?php
    include_once('leesession.php');//判断是不是管理员
     checkmodules('channels');//陈良红对管理员权限的判断//$m_id=39;
    include_once('../include/config.php');//配置文件
	include_once('../include/leecommon.php');//防止sql注入、预编义
    
	$channels_id=@trim($channels_id);
	if(empty($channels_id)){
		 echo "<script>alert('频道编号不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $channels_id=(int)$channels_id;
		 if($channels_id<=0){
			 echo "<script>alert('频道编号不对');window.history.back();</script>";
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

	include_once '../include/mysql.php';//加载数据库操作文件
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	$falg=$db->selectBool('channels',$channels_id,'channels_id','INTEGER');
	if($falg===false){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
    $back_arr=$db->selectSingle('channels',$channels_id,'channels_id','INTEGER');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改频道 </title>
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
  <form action="../control/leechannels.php?method=update" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">中文名：</td>
		   <td align="left"><input type="text" id="channels_name" name="channels_name" value="<?php echo empty($back_arr['channels_name'])?'':$back_arr['channels_name']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">英文名：</td>
		   <td align="left"><input type="text" id="channels_path" name="channels_path" value="<?php echo empty($back_arr['channels_path'])?'':$back_arr['channels_path']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">链接地址：</td>
		   <td align="left"><input type="text" id="channels_url" name="channels_url" value="<?php echo empty($back_arr['channels_path'])?'':$back_arr['channels_url']; ?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">描述：</td>
		   <td align="left"><textarea id="channels_description" name="channels_description" style="height:50px; width:97%"><?php echo empty($back_arr['channels_description'])?'':$back_arr['channels_description']; ?></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="channels_status" name="channels_status"/>
			     <?php
				     if($back_arr['channels_status']==1){
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
		      <select id="channels_sort" name="channels_sort"/>
			     <?php
				     for($i=1;$i<=9;$i++){
						 if($back_arr['channels_sort']==$i){
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
		       <input type="hidden" id="channels_id" name="channels_id" value="<?php echo $channels_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
		       <input type="hidden" id="channels_adduser" name="channels_adduser" value="<?php echo empty($back_arr['channels_adduser'])?'':$back_arr['channels_adduser']; ?>" />
		       <input type="hidden" id="channels_addtime" name="channels_addtime" value="<?php echo empty($back_arr['channels_addtime'])?'':$back_arr['channels_addtime']; ?>" />
			   <input type="hidden" id="channels_remark1" name="channels_remark1" value="<?php echo empty($back_arr['channels_remark1'])?'':$back_arr['channels_remark1']; ?>" />
			   <input type="hidden" id="channels_remark2" name="channels_remark2" value="<?php echo empty($back_arr['channels_remark2'])?'':$back_arr['channels_remark2']; ?>" />
			   <input type="hidden" id="channels_remark3" name="channels_remark3" value="<?php echo empty($back_arr['channels_remark3'])?'':$back_arr['channels_remark3']; ?>" />
		       <input value="修改" type="submit" onClick="return confirm('确认要修改？');" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input onClick="location.href='listChannels.php?pageNo=<?php echo $pageNo; ?>'" value="返回" type="reset">
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
