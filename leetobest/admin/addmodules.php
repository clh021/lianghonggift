<?php
    include_once('leesession.php');
	checkmodules('modules');//陈良红对管理员权限的判断//$m_id=4;
    include_once('../include/config.php');
    include_once('../db_cache/channels.php');
	include_once('../include/leecommon.php');//防止sql注入、预编义
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加模块 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
  <form action="../control/leemodules.php?method=add" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">中文名：</td>
		   <td align="left"><input type="text" id="modules_name" name="modules_name"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">英文名：</td>
		   <td align="left"><input type="text" id="modules_path" name="modules_path"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">启用栏目：</td>
		   <td align="left">
		   <select id="modules_cate" name="modules_cate">
			<option value="2" selected>不启用</option>
			<option value="1">启用</option>
		   </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">所属频道：</td>
		   <td align="left">
			   <input id="modules_channel" name="modules_channel" type="hidden">
			     <?php
				    include_once '../include/cache.func.php';//加载缓存
					$channels_array=@cache_read('channels.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
					if(!@empty($channels_array) && @count($channels_array)>0){
						for($i=0;$i<count($channels_array);$i++){
							if($channels_array[$i]['channels_status']==1){
								?>
									<input type="checkbox" id="check<?php echo $channels_array[$i]["channels_id"]; ?>" name="check<?php echo $channels_array[$i]["channels_id"]; ?>" value="<?php echo $channels_array[$i]["channels_id"]; ?>" onclick="ckeckMethodp(this,<?php echo $channels_array[$i]["channels_id"]; ?>)"> <?php echo $channels_array[$i]["channels_name"]; ?>
								
								<?php
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
		   <td align="left"><textarea id="modules_description" name="modules_description" style="height:50px; width:97%" ></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="modules_status" name="modules_status"/>
			     <option value="1">激活</option>
				 <option value="2">废弃</option>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="modules_sort" name="modules_sort"/>
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
			   <input type="hidden" id="modules_remark1" name="modules_remark1" value="" />
			   <input type="hidden" id="modules_remark2" name="modules_remark2" value="" />
			   <input type="hidden" id="modules_remark3" name="modules_remark3" value="" />
		       <input type="submit" value="提交"/>&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
		</tr>
		<tr>
		   <td align="center" bgcolor="#f1f1f1" colspan="2">
				请一定确保数据库中已经存在此表。
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>
