<?php
    include_once('leesession.php');//判断是不是管理员
	checkmodules('finacelog');//陈良红对管理员权限的判断//$m_id=5;
    include_once('../include/config.php');//配置文件
	include_once('../include/leecommon.php');//防止sql注入、预编义
	include_once('../include/mysql.php');//加载数据库操作文件
    
	$finacelog_id=@trim($finacelog_id);
	if(empty($finacelog_id)){
		 echo "<script>alert('财务日志编号不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $finacelog_id=(int)$finacelog_id;
		 if($finacelog_id<=0){
			 echo "<script>alert('财务日志编号不对');window.history.back();</script>";
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
	$falg=$db->selectBool('finacelog',$finacelog_id,'finacelog_id','INTEGER');
	if($falg===false){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
    $back_arr=$db->selectSingle('finacelog',$finacelog_id,'finacelog_id','INTEGER');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改财务日志 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="style/index.css" type=text/css rel=stylesheet />
 <script type="text/javascript" language="JavaScript" src="../js/calendar.js">
 </head>
<script type="text/javascript" language="JavaScript">
<!--
   function check(){
        var finacelog_name=document.getElementById('finacelog_payout').value;
		finacelog_name=trim(finacelog_name);//调用函数---去掉前后空格
		if(finacelog_name.length<=0){
			var finacelog_path=document.getElementById('finacelog_putin').value;
			finacelog_path=trim(finacelog_path);//调用函数---去掉前后空格
			if(finacelog_path.length<=0){
				alert("收入额和支出额至少填写一个");
				return false;
			}  
		}
		
		
		var finacelog_status=document.getElementById('finacelog_blance').value;
		finacelog_status=trim(finacelog_status);//调用函数---去掉前后空格
		if(finacelog_status.length<=0){
			alert("请填写财务结算");
			return false;
		}
		
		var finacelog_sort=document.getElementById('finacelog_sumup').value;
		finacelog_sort=trim(finacelog_sort);//调用函数---去掉前后空格
		if(finacelog_sort.length<=0){
			alert("请填写财务总结");
			return false;
		}  
   }

   /*
      去掉前后空格
    */
   function trim(str){
		 return str.replace(/(^\s*)|(\s*$)/g, "");
   } 
   //将body开始标签中添入onload="load()"代码。
   function load(){
		var sBasePath = '../fckeditor/'+document.location.href.substring(0,document.location.href.lastIndexOf('_samples')) ;
		var oFCKeditor = new FCKeditor( 'finacelog_whypay' ) ;
		oFCKeditor.BasePath=sBasePath;
		oFCKeditor.ReplaceTextarea();
		var oFCKeditor = new FCKeditor( 'finacelog_whyput' ) ;
		oFCKeditor.BasePath=sBasePath;
		oFCKeditor.ReplaceTextarea();
		var oFCKeditor = new FCKeditor( 'finacelog_sumup' ) ;
		oFCKeditor.BasePath=sBasePath;
		oFCKeditor.ReplaceTextarea();
  }
//-->
</script>
 <body >
  <form action="../control/finacelog.php?method=edit" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">时间：</td>
		   <td align="left"><input type="text" id="finacelog_date" readonly name="finacelog_date" value="<?php echo empty($back_arr['finacelog_date'])?'':$back_arr['finacelog_date']; ?>" onfocus="setday(this)"/><font color="red">( * 必填 )</font></td>
		</tr>
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">支出额：</td>
		   <td align="left"><input type="text" id="finacelog_payout" name="finacelog_payout" value="<?php echo empty($back_arr['finacelog_payout'])?'':$back_arr['finacelog_payout']; ?>"/><font color="red">( * 必填其一 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">支出原因：</td>
		   <td align="left"><textarea id="finacelog_whypay" name="finacelog_whypay" style="width:60%; height:40px;"><?php echo empty($back_arr['finacelog_whypay'])?'':$back_arr['finacelog_whypay']; ?></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">收入额：</td>
		   <td align="left"><input type="text" id="finacelog_putin" name="finacelog_putin" value="<?php echo empty($back_arr['finacelog_putin'])?'':$back_arr['finacelog_putin']; ?>"/><font color="red">( * 必填其一 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">收入原因：</td>
		   <td align="left"><textarea id="finacelog_whyput" name="finacelog_whyput" style="width:60%; height:40px;"><?php echo empty($back_arr['finacelog_whyput'])?'':$back_arr['finacelog_whyput']; ?></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">财务结算：</td>
		   <td align="left"><input type="text" id="finacelog_balance" name="finacelog_balance" value="<?php echo empty($back_arr['finacelog_balance'])?'':$back_arr['finacelog_balance']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">财务总结：</td>
		   <td align="left"><textarea id="finacelog_sumup" name="finacelog_sumup" style="width:60%; height:40px;"><?php echo empty($back_arr['finacelog_sumup'])?'':$back_arr['finacelog_sumup']; ?></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1"></td>
		   <td align="left">
		       <input type="hidden" id="finacelog_id" name="finacelog_id" value="<?php echo $finacelog_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
			   <input type="hidden" id="finacelog_remark1" name="finacelog_remark1" value="<?php echo empty($back_arr['finacelog_remark1'])?'':$back_arr['finacelog_remark1']; ?>" />
			   <input type="hidden" id="finacelog_remark2" name="finacelog_remark2" value="<?php echo empty($back_arr['finacelog_remark2'])?'':$back_arr['finacelog_remark2']; ?>" />
			   <input type="hidden" id="finacelog_remark3" name="finacelog_remark3" value="<?php echo empty($back_arr['finacelog_remark3'])?'':$back_arr['finacelog_remark3']; ?>" />
		       <input value="修改" type="submit" onClick="return confirm('确认要修改？');" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input onClick="location.href='listfinacelog.php?pageNo=<?php echo $pageNo; ?>'" value="返回" type="reset">
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
