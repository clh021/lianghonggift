<?php
    include_once('leesession.php');
	checkmodules('testawoke');//陈良红对管理员权限的判断
    include_once('../include/config.php');
	include_once('../include/leecommon.php');//防止sql注入、预编义
	include_once('../include/mysql.php');//加载数据库操作文件
	
	$testawoke_id=@trim($testawoke_id);
	if(empty($testawoke_id)){
		 echo "<script>alert('模块编号不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $testawoke_id=(int)$testawoke_id;
		 if($testawoke_id<=0){
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

	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	$falg=$db->selectBool('testawoke',$testawoke_id,'testawoke_id','INTEGER');
	if($falg===false){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
    $back_arr=$db->selectSingle('testawoke',$testawoke_id,'testawoke_id','INTEGER');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改任务提醒 </title>
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
  <form action="../control/testawoke.php?method=edit" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">提醒时间：</td>
		   <td align="left"><input type="text" id="testawoke_date" name="testawoke_date" readonly  onfocus="setday(this)" value="<?php echo @empty($back_arr['testawoke_date'])?'':$back_arr['testawoke_date']; ?>"/><font color="red">( * 必选 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">提醒标题：</td>
		   <td align="left"><input type="text" id="testawoke_title" name="testawoke_title" value="<?php echo @empty($back_arr['testawoke_title'])?'':$back_arr['testawoke_title']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">提醒内容：</td>
		   <td align="left"><textarea id="testawoke_text" name="testawoke_text" style="width:60%; height:40px;"><?php echo @empty($back_arr['testawoke_text'])?'':$back_arr['testawoke_text']; ?></textarea><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">重要级别：</td>
		   <td align="left">
		      <select id="testawoke_sort" name="testawoke_sort"/>
			     <?php
				     for($i=1;$i<=9;$i++){
						 if(intval($back_arr['testawoke_sort'])==$i){
				 ?>
				 <option value="<?php echo $i;?>" checked><?php echo $i;?></option>
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
		   <td width="15%" align="right" bgcolor="#f1f1f1">任务状态：</td>
		   <td align="left">
		      <select id="testawoke_status" name="testawoke_status"/>
			     <?php
						 if(intval($back_arr['testawoke_status'])==1){
				 ?>
				 <option value="2">完成</option>
				 <option value="1" selected="true">未完成</option>
				 <?php
						 }else{
				 ?>
				 <option value="1">未完成</option>
				 <option value="2" selected="true">完成</option>
				 <?php
						 }
				 ?>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1"></td>
		   <td align="left">
		       <input type="hidden" id="testawoke_id" name="testawoke_id" value="<?php echo $testawoke_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
		       <input type="hidden" id="user_id" name="user_id" value="<?php echo @empty($back_arr['user_id'])?'':$back_arr['user_id']; ?>" />
		       <input type="hidden" id="testawoke_addtime" name="testawoke_addtime" value="<?php echo @empty($back_arr['testawoke_addtime'])?'':$back_arr['testawoke_addtime']; ?>" />
			   <input type="hidden" id="testawoke_remark1" name="testawoke_remark1" value="<?php echo @empty($back_arr['testawoke_remark1'])?'':$back_arr['testawoke_remark1']; ?>" />
			   <input type="hidden" id="testawoke_remark2" name="testawoke_remark2" value="<?php echo @empty($back_arr['testawoke_remark2'])?'':$back_arr['testawoke_remark2']; ?>" />
			   <input type="hidden" id="testawoke_remark3" name="testawoke_remark3" value="<?php echo @empty($back_arr['testawoke_remark3'])?'':$back_arr['testawoke_remark3']; ?>" />
		       <input type="submit" value="提交"/>&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>
