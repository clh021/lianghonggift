<?php
    include_once('leesession.php');
	checkmodules('finacelog');//陈良红对管理员权限的判断//$m_id=5;
    include_once('../include/config.php');
	include_once('../include/leecommon.php');//防止sql注入、预编义
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加财务日志 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
 <script type="text/javascript" language="JavaScript" src="../js/calendar.js">
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
//-->
</script>
 <body >
  <form action="../control/finacelog.php?method=add" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">时间：</td>
		   <td align="left"><input type="text" id="finacelog_date" name="finacelog_date" readonly value="<?php echo date("Y-m-d")?>" onfocus="setday(this)"/><font color="red">( * 必填 )</font></td>
		</tr>
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">支出额：</td>
		   <td align="left"><input type="text" id="finacelog_payout" name="finacelog_payout"/><font color="red">( * 必填其一 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">支出原因：</td>
		   <td align="left"><textarea id="finacelog_whypay" name="finacelog_whypay" style="width:60%; height:40px;"></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">收入额：</td>
		   <td align="left"><input type="text" id="finacelog_putin" name="finacelog_putin"/><font color="red">( * 必填其一 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">收入原因：</td>
		   <td align="left"><textarea id="finacelog_whyput" name="finacelog_whyput" style="width:60%; height:40px;"></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">财务结算：</td>
		   <td align="left"><input type="text" id="finacelog_balance" name="finacelog_balance"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">财务总结：</td>
		   <td align="left"><textarea id="finacelog_sumup" name="finacelog_sumup" style="width:60%; height:40px;"></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1"></td>
		   <td align="left">
			   <input type="hidden" id="finacelog_remark1" name="finacelog_remark1" value="" />
			   <input type="hidden" id="finacelog_remark2" name="finacelog_remark2" value="" />
			   <input type="hidden" id="finacelog_remark3" name="finacelog_remark3" value="" />
		       <input type="submit" value="提交"/>&nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>
