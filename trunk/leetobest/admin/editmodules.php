<?php
    include_once('leesession.php');//判断是不是管理员
	checkmodules('modules');//陈良红对管理员权限的判断
    include_once('../include/config.php');//配置文件
	include_once('../include/leecommon.php');//防止sql注入、预编义
    
	$modules_id=@trim($modules_id);
	if(empty($modules_id)){
		 echo "<script>alert('模块编号不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $modules_id=(int)$modules_id;
		 if($modules_id<=0){
			 echo "<script>alert('模块编号不对');window.history.back();</script>";
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

	include '../include/mysql.php';//加载数据库操作文件
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	$falg=$db->selectBool('modules',$modules_id,'modules_id','INTEGER');
	if($falg===false){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
    $back_arr=$db->selectSingle('modules',$modules_id,'modules_id','INTEGER');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改模块 </title>
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
        var modules_name=document.getElementById('modules_name').value;
		modules_name=trim(modules_name);//调用函数---去掉前后空格
		if(modules_name.length<=0){
			alert("请填中文名");
			return false;
		}
		
		var modules_path=document.getElementById('modules_path').value;
		modules_path=trim(modules_path);//调用函数---去掉前后空格
		if(modules_path.length<=0){
			alert("请填英文名");
			return false;
		}  
		
		var modules_status=document.getElementById('modules_status').value;
		modules_status=trim(modules_status);//调用函数---去掉前后空格
		if(modules_status.length<=0){
			alert("请选择状态");
			return false;
		}
		
		var modules_sort=document.getElementById('modules_sort').value;
		modules_sort=trim(modules_sort);//调用函数---去掉前后空格
		if(modules_sort.length<=0){
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
   
  /*
  * 复选框的操作---权限的
  */
  function ckeckMethodp(obj,m){
	 var modules_channel=document.getElementById("modules_channel");
	 if(obj.checked){
		modules_channel.value +=m+",";
	 }else{
		modules_channel.value = modules_channel.value.replace((m+","),"");
	 }
	 //alert(modules_channel.value);
  }    
   
//-->
</script>
 <body>
  <form action="../control/leemodules.php?method=update" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">中文名：</td>
		   <td align="left"><input type="text" id="modules_name" name="modules_name" value="<?php echo empty($back_arr['modules_name'])?'':$back_arr['modules_name']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">英文名：</td>
		   <td align="left"><input type="text" id="modules_path" name="modules_path" value="<?php echo empty($back_arr['modules_path'])?'':$back_arr['modules_path']; ?>"/>( * 必填 )</td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">启用栏目：</td>
		   <td align="left">
		   <select id="modules_cate" name="modules_cate">
		   <?php
		   if($back_arr['modules_cate']==1){
				echo '<option value="2">不启用</option><option value="1" selected>启用</option>';
		   }else{
				echo '<option value="2" selected>不启用</option><option value="1">启用</option>';
		   }
		   ?>
		   </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">所属频道：</td>
		   <td align="left">
			   <input id="modules_channel" name="modules_channel" type="hidden" value="<?php echo empty($back_arr['modules_channel'])?'':$back_arr['modules_channel']; ?>">
			     <?php

	$channels_status=$back_arr['modules_channel'];
    if(substr($channels_status,-1)==','){
	   $channels_status=substr($channels_status,0,strlen($channels_status)-1);
    }
    $channels_status_arr=explode(',',$channels_status);
				    include_once '../include/cache.func.php';//加载缓存
					$channels_array=@cache_read('channels.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
					if(!@empty($channels_array) && @count($channels_array)>0){
						for($i=0;$i<count($channels_array);$i++){
							if(intval($channels_array[$i]['channels_status'])==1){
								if(in_array($channels_array[$i]['channels_id'],$channels_status_arr)){
									?>
										<input type="checkbox" id="check<?php echo $channels_array[$i]["channels_id"]; ?>" name="check<?php echo $channels_array[$i]["channels_id"]; ?>" value="<?php echo $channels_array[$i]["channels_id"]; ?>" onclick="ckeckMethodp(this,<?php echo $channels_array[$i]["channels_id"]; ?>)"  checked='true'> <?php echo $channels_array[$i]["channels_name"]; ?>
									
									<?php
								}else{
									?>
										<input type="checkbox" id="check<?php echo $channels_array[$i]["channels_id"]; ?>" name="check<?php echo $channels_array[$i]["channels_id"]; ?>" value="<?php echo $channels_array[$i]["channels_id"]; ?>" onclick="ckeckMethodp(this,<?php echo $channels_array[$i]["channels_id"]; ?>)"> <?php echo $channels_array[$i]["channels_name"]; ?>
									
									<?php
								}
							}
						}
					}else{
						echo '<font color="red">请更新关键数据缓存再来添加模块。</font>';
					}
				 ?>
			</td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">描述：</td>
		   <td align="left"><textarea id="modules_description" name="modules_description" style="height:50px; width:97%"><?php echo empty($back_arr['modules_description'])?'':$back_arr['modules_description']; ?></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="modules_status" name="modules_status"/>
			     <?php
				     if($back_arr['modules_status']==1){
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
		      <select id="modules_sort" name="modules_sort"/>
			     <?php
				     for($i=1;$i<=9;$i++){
						 if($back_arr['modules_sort']==$i){
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
		       <input type="hidden" id="modules_id" name="modules_id" value="<?php echo $modules_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
		       <input type="hidden" id="modules_addusersid" name="modules_addusersid" value="<?php echo empty($back_arr['modules_addusersid'])?'':$back_arr['modules_addusersid']; ?>" />
		       <input type="hidden" id="modules_addtime" name="modules_addtime" value="<?php echo empty($back_arr['modules_addtime'])?'':$back_arr['modules_addtime']; ?>" />
			   <input type="hidden" id="modules_remark1" name="modules_remark1" value="<?php echo empty($back_arr['modules_remark1'])?'':$back_arr['modules_remark1']; ?>" />
			   <input type="hidden" id="modules_remark2" name="modules_remark2" value="<?php echo empty($back_arr['modules_remark2'])?'':$back_arr['modules_remark2']; ?>" />
			   <input type="hidden" id="modules_remark3" name="modules_remark3" value="<?php echo empty($back_arr['modules_remark3'])?'':$back_arr['modules_remark3']; ?>" />
		       <input value="修改" type="submit" onClick="return confirm('确认要修改？');" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input onClick="location.href='listModules.php?pageNo=<?php echo $pageNo; ?>'" value="返回" type="reset">
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
