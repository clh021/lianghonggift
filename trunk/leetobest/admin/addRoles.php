<?php
    include_once 'leesession.php';
	checkmodules('roles');//陈良红对管理员权限的判断//$m_id=10;
    include_once '../include/config.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加角色 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
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
		});
		/*
		* 添加所有选项到右边
		*/
		$("#add_all").click(function(){
		    var $options=$("#select1 option");
		    $options.appendTo("#select2");
		    qx();
		});
		/*
		* 双击选项添加到右边
		*/
		$("#select1").dblclick(function(){
		    var $options=$("option:selected",this);
		    $options.appendTo("#select2");
		    qx();
		});
		
		/*
		* 添加选中项到左边
		*/
		$("#remove").click(function(){
		    var $options=$("#select2 option:selected");
		    $options.appendTo("#select1");
		    qx();
		});
		/*
		* 添加所有选项到左边
		*/
		$("#remove_all").click(function(){
		    var $options=$("#select2 option");
		    $options.appendTo("#select1");
		    qx();
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
  <form action="../control/roles.php?method=add" method="post" id="form1">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">角色名称：</td>
		   <td align="left"><input type="text" id="roles_name" name="roles_name"/><font color="red">( * 必填 )</font></td>
		</tr>
		
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">权限设置：</td>
		   <td align="left" >
			<div class="centent">
		      <select multiple="multiple" id="select1" >
		       <?php
                   include_once '../include/mysql.php';
                   $db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
				   $sql="SELECT * FROM modules WHERE modules_status=1";				   
				   $res=mysql_query($sql);
				   while($row=mysql_fetch_array($res,MYSQL_BOTH)){
			   ?>
			     <option value="<?php echo $row['modules_id']; ?>" title="<?php echo $row['modules_name'];?>"><?php echo $row['modules_name'];?>
			   </option>
			   <?php 
				}
				?>
			  </select>
		   </div>
		   <div class="centent"><br />
		       <input type="button" id="add" value=">|" style="width:50px" /><br />
			   <input type="button" id="add_all" value=">>" style="width:50px" /><br />
			   <input type="button" id="remove" value="|<" style="width:50px" /><br />
			   <input type="button" id="remove_all" value="<<" style="width:50px" />
		   </div>
		   <div class="centent" >
		      <select multiple="multiple" id="select2">
			      
			  </select>
			 
		   </div>
		   <input type="hidden" id="modules_id_set" name="modules_id_set"><br />
		  </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="roles_status" name="roles_status">
			     <option value="1">激活</option>
				 <option value="2">废弃</option>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="roles_sort" name="roles_sort">
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
		      
			   <input type="hidden" id="roles_remark1" name="roles_remark1" value="" />
			   <input type="hidden" id="roles_remark2" name="roles_remark2" value="" />
			   <input type="hidden" id="roles_remark3" name="roles_remark3" value="" />
		       <input type="submit" value="提交" id="sub" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>

