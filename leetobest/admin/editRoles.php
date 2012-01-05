<?php
    include_once 'leesession.php';//判断是不是管理员
	checkmodules('roles');//陈良红对管理员权限的判断//$m_id=10;
    include_once '../include/config.php';//配置文件
	include_once '../include/leecommon.php';//防止sql注入、预编义
    
	$roles_id=@trim($roles_id);
	if(empty($roles_id)){
		 echo "<script>alert('角色编号不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $roles_id=intval($roles_id);
		 if($roles_id<=0){
			 echo "<script>alert('角色编号不对');window.history.back();</script>";
		     exit;
		 }
	}
    
	$pageNo=@trim($pageNo);
	if(empty($pageNo)){
		 echo "<script>alert('当前页码不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $pageNo=intval($pageNo);
		 if($pageNo<=0){
			 echo "<script>alert('当前页码不对');window.history.back();</script>";
		     exit;
		 }
	}

	include('../include/mysql.php');//加载数据库操作文件
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	$sql_bool="SELECT * FROM roles WHERE roles_id=".$roles_id;
	$res=mysql_query($sql_bool);
	$num=mysql_num_rows($res);
	if($num<=0){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
	$sql="SELECT * FROM roles WHERE roles_id=".$roles_id;
	$result=mysql_query($sql);
    $back_arr=mysql_fetch_array($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改角色 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
 <style type="text/css">
	* { margin:0; padding:0; }
	div.centent {
	   float:left;
	   text-align: center;
	   margin: 3px;
	}
	#select1
	{
	    height:150px; 
		width:200px
	}
	#select2
	{
	    height:150px; 
		width:200px
	}
	
	</style>
<script src="../js/jquery.min.js" type="text/javascript" language="JavaScript"></script>
<script type="text/javascript" language="JavaScript">
<!--

	$(document).ready(function(){
	    /*
		* 添加选中项到右边
		*/
		$("#add").click(function(){
		    var $options=$("#select1 option:selected");
		    $options.appendTo("#select2");
		    qx();
		    //alert(qx);
		});
		
		/*
		* 添加所有选项到右边
		*/
		$("#add_all").click(function(){
		    var $options=$("#select1 option");
		    $options.appendTo("#select2");
		    qx();
		    //alert(qx);
		});
		/*
		* 双击选项添加到右边
		*/
		$("#select1").dblclick(function(){
		    var $options=$("option:selected",this);
		    $options.appendTo("#select2");
		    qx();
		   // alert(qx);
		});
	
		/*
		* 添加选中项到左边
		*/
		$("#remove").click(function(){
		    var $options=$("#select2 option:selected");
		    $options.appendTo("#select1");
		    qx();
		   // alert(qx);
		});
		
		/*
		* 添加所有选项到左边
		*/
		$("#remove_all").click(function(){
		    var $options=$("#select2 option");
		    $options.appendTo("#select1");
		    qx();
		    //alert(qx);
		});
		
		/*
		* 双击选项添加到左边
		*/
		$("#select2").dblclick(function(){
		    var $options=$("option:selected",this);
		    $options.appendTo("#select1");
		    qx();
		   
		});

	/*
	* 表单验证
	*/
	$("form#form1").submit(function(){
			var roles_name=$("#roles_name").val();
			roles_name=trim(roles_name);
			if(roles_name.length<=0){
				alert("请填写角色名称");
				return false;
			}
			
			var modules_id_set=$("#modules_id_set").val();
			alert(modules_id_set);
			modules_id_set=trim(modules_id_set);
			if(modules_id_set.length<=0){
				alert("请选择权限");
				return false;
			}
	
			var roles_status=$("#roles_status").val();
			roles_status=trim(roles_status);
			if(roles_status.length<=0){
				alert("请选择状态");
				return false;
			}
			
			var roles_sort=$("#roles_sort").val();
			roles_sort=trim(roles_sort);
			if(roles_sort.length<=0){
				alert("请选择 排序");
				return false;
			}
		});
	})

	/*
	* 权限
	*/

   function qx(){
	   var qx='';//
	   $("#select2 option").each(function(){
		  qx=qx+$(this).attr("value")+",";
	   });
	   
	   $("#modules_id_set").val('');
	   $("#modules_id_set").val(qx);
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
  <form action="../control/roles.php?method=update" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">角色名：</td>
		   <td align="left"><input type="text" id="roles_name" name="roles_name" value="<?php echo empty($back_arr['roles_name'])?'':$back_arr['roles_name']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<?php 
		  $sql="SELECT * FROM modules WHERE modules_status=1";
		  $res=mysql_query($sql);
		  $res1=mysql_query($sql);
		  $modules_id_set=$back_arr['modules_ids'];
		  $modules_ids=array();
		  if(!@empty($modules_id_set)){
			  if(substr($modules_id_set,-1)==','){
			  	$modules_id_set=substr($modules_id_set, 0,-1);
			  }
			  if(!@empty($modules_id_set)){
			  	 $modules_ids=explode(",",$modules_id_set);
			  }
		  }
		?>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">权限设置：</td>
		   <td align="left">
		   <div class="centent">
		      <select multiple="multiple" id="select1" >
		       <?php
		       		$flag=false;
		       		while($row=mysql_fetch_array($res,MYSQL_BOTH)){
		       			for($i=0;$i<count($modules_ids);$i++){
		       				if(intval($modules_ids[$i])==$row['modules_id']){
		       					$flag=true;
		       					break;
		       				}
		       			}
		       			if($flag===false){
		       ?>
		       <option value="<?php echo $row['modules_id']; ?>" title="<?php echo $row['modules_name'];?>"><?php echo $row['modules_name'];?></option>
		       <?php 
		       			}
		       			$flag=false;
		       		}
		       ?>
			  </select>
		   </div>
		   <div class="centent"><br />
		       <input type="button" id="add" value=">|" style="width:50px" /><br />
			   <input type="button" id="add_all" value=">>" style="width:50px" /><br />
			   <input type="button" id="remove" value="|<"  style="width:50px " /><br />
			   <input type="button" id="remove_all" value="<<" style="width:50px" />
		   </div>
		   <div class="centent" >
		      <select multiple="multiple" id="select2">
		      <?php
		       		$flag1=false;
		       		while($row1=mysql_fetch_array($res1,MYSQL_BOTH)){
		       			for($i=0;$i<count($modules_ids);$i++){
		       				if(intval($modules_ids[$i])==$row1['modules_id']){
		       					$flag1=true;
		       					break;
		       				}
		       			}
		       			if($flag1===true){
		       ?>
		       <option value="<?php echo $row1['modules_id']; ?>" title="<?php echo $row1['modules_name'];?>"><?php echo $row1['modules_name'];?></option>
		       <?php 
		       			}
		       			$flag1=false;
		       		}
		       ?>
			  </select>
			  <input type="hidden" id="modules_id_set" name="modules_id_set" ><br />
		   </div>
	     
		  </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="roles_status" name="roles_status">
			     <?php
				     if($back_arr['roles_status']==1){
				 ?>
                 <option value="1" selected="selected">激活</option>
				 <option value="2">废弃</option>
				 <?php
					 }else{
				 ?>
                 <option value="1">激活</option>
				 <option value="2" selected="selected">废弃</option>
				 <?php
					 }
				 ?>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="roles_sort" name="roles_sort">
			     <?php
				     for($i=1;$i<=9;$i++){
						 if($back_arr['roles_sort']==$i){
				 ?>
                 <option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
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
		       <input type="hidden" id="roles_id" name="roles_id" value="<?php echo $roles_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
			   <input type="hidden" id="users_id" name="users_id" value="<?php echo empty($back_arr['users_id'])?'0':$back_arr['users_id']; ?>" />
			   <input type="hidden" id="modules_id_set_old" name="modules_id_set_old" value="<?php echo $modules_id_set; ?>"/>
			   <input type="hidden" id="roles_addtime" name="roles_addtime" value="<?php echo empty($back_arr['roles_addtime'])?'':$back_arr['roles_addtime']; ?>" />
			   <input type="hidden" id="roles_addusersid" name="roles_addusersid" value="<?php echo empty($back_arr['roles_addusersid'])?'':$back_arr['roles_addusersid']; ?>" />
			   <input type="hidden" id="roles_remark1" name="roles_remark1" value="<?php echo empty($back_arr['roles_remark1'])?'':$back_arr['roles_remark1']; ?>" />
			   <input type="hidden" id="roles_remark2" name="roles_remark2" value="<?php echo empty($back_arr['roles_remark2'])?'':$back_arr['roles_remark2']; ?>" />
			   <input type="hidden" id="roles_remark3" name="roles_remark3" value="<?php echo empty($back_arr['roles_remark3'])?'':$back_arr['roles_remark3']; ?>" />
		       <input value="修改" type="submit" onClick="return confirm('确认要修改？');" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input onClick="location.href='listRoles.php?pageNo=<?php echo $pageNo; ?>'" value="返回" type="reset">
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

