<?php
    include_once('leesession.php');//判断是不是管理员
	checkmodules('cates');//陈良红对管理员权限的判断//$m_id=23;
    include_once('../include/config.php');//配置文件
	include_once('../include/leecommon.php');//防止sql注入、预编义
    
	$cates_id=@trim($cates_id);
	if(empty($cates_id)){
		 echo "<script>alert('栏目编号不允许为空');window.history.back();</script>";
		 exit;
	}else{
		 $cates_id=(int)$cates_id;
		 if($cates_id<=0){
			 echo "<script>alert('栏目编号不对');window.history.back();</script>";
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
	$sql_bool="SELECT * FROM cates WHERE cates_id=$cates_id";
	$result=mysql_query($sql_bool);
	$num=mysql_num_rows($result);
	if($num<=0){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
	$res=mysql_query($sql_bool);
    $back_arr=mysql_fetch_array($res,MYSQL_BOTH);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改栏目 </title>
  <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
<script type="text/javascript" language="JavaScript">
<!--
   function check(){
        var cates_name=document.getElementById('cates_name').value;
		cates_name=trim(cates_name);//调用函数---去掉前后空格
		if(cates_name.length<=0){
			alert("请填名称");
			return false;
		}else{
		    if(cates_name.indexOf('-')!=-1 || cates_name.indexOf('@')!=-1 || cates_name.indexOf('!')!=-1 || cates_name.indexOf(',')!=-1){
				alert("栏目名称不能包含- @ ! ,四种特殊符号");
			    return false;
			}
		}
		
		var cates_parentid=document.getElementById('cates_parentid').value;
		cates_parentid=trim(cates_parentid);//调用函数---去掉前后空格
		if(cates_parentid.length<=0){
			alert("请选择上一级");
			return false;
		} 
		
		var cates_status=document.getElementById('cates_status').value;
		cates_status=trim(cates_status);//调用函数---去掉前后空格
		if(cates_status.length<=0){
			alert("请选择状态");
			return false;
		}
		
		var cates_sort=document.getElementById('cates_sort').value;
		cates_sort=trim(cates_sort);//调用函数---去掉前后空格
		if(cates_sort.length<=0){
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
  <form action="../control/cates.php?method=update" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">上一级：</td>
		   <td align="left">
		      <select id="cates_parentid" name="cates_parentid">
			     <?php
			        $cates_sql="SELECT * FROM cates WHERE cates_status=1";
			        $cates_result=mysql_query($cates_sql);
			        $cates_array=array();
			        while($row=mysql_fetch_array($cates_result,MYSQL_BOTH)){
			        	$cates_array=array_pad($cates_array,count($cates_array)+1,$row);
			        }
					$arr_c=array();
					if(!@empty($cates_array) && @count($cates_array)>0){
						$arr1=array();
						for($i=0;$i<count($cates_array);$i++){
							array_push($arr1, $cates_array[$i]['cates_id'].'-'.$cates_array[$i]['cates_parentid'].'-'.$cates_array[$i]['cates_name']);//
						}
                        include_once '../include/recursive.php';//递归
                        $rec=new Recursive($arr1,'&nbsp;&nbsp;');
						$rec->digui('0',0);
						$back=$rec->back;
						$rec1=new Recursive($arr1,'&nbsp;&nbsp;');
						$rec1->digui(strval($cates_id),0);
						$back_c=$rec1->back;
                        
						$back='0@ @ !'.$back;
						$back_c=$cates_id.'@'.$back_arr['cates_parentid'].'@'.$back_arr['cates_name'].'!'.$back_c;

						if(substr($back,-1)=='!'){
                            $back=substr($back,0,-1);
						}

						if(substr($back_c,-1)=='!'){
                            $back_c=substr($back_c,0,-1);
						}

						$arr_b=explode('!',$back);
						$arr_c=explode('!',$back_c);

						include_once '../include/array.php';//删除数组元素
						$arr_b=delete_array($arr_b,$arr_c);
                        
						for($j=0;$j<count($arr_b);$j++){
							$arr2=explode('@',$arr_b[$j]);
							if(intval($arr2[0])==$back_arr['cates_parentid']){
				 ?>
				 <option value="<?php echo $arr2[0]; ?>" selected="true"><?php echo $arr2[2] ;?></option>
				 <?php
							}else{
				 ?>
				 <option value="<?php echo $arr2[0]; ?>"><?php echo $arr2[2] ;?></option>
				 <?php
							}
						}
						unset($rec);
						unset($rec_1);
					}
				 ?>
			  </select>
		   </td>
		</tr>
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">名称：</td>
		   <td align="left"><input type="text" id="cates_name" name="cates_name" value="<?php echo empty($back_arr['cates_name'])?'':$back_arr['cates_name']; ?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">路径：</td>
		   <td align="left"><input type="text" id="cates_path" name="cates_path" value="<?php echo empty($back_arr['cates_path'])?'':$back_arr['cates_path']; ?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">关键字：</td>
		   <td align="left"><input type="text" id="cates_key" name="cates_key" value="<?php echo empty($back_arr['cates_key'])?'':$back_arr['cates_key']; ?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">描述：</td>
		   <td align="left"><textarea type="text" id="cates_des" name="cates_des" style="width:60%; height:40px;"><?php echo empty($back_arr['cates_des'])?'':$back_arr['cates_des']; ?></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">介绍：</td>
		   <td align="left"><textarea type="text" id="cates_content" name="cates_content" style="width:60%; height:40px;"><?php echo empty($back_arr['cates_content'])?'':$back_arr['cates_content']; ?></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">类别：</td>
		   <td align="left">
		      <select id="cates_type" name="cates_type">
			     <?php
				     if($back_arr['cates_status']==1){
				 ?>
			     <option value="1" selected>单网页</option>
				 <option value="2">内部栏目</option>
				 <option value="3">外部栏目</option>
				 <?php
					 }elseif($back_arr['cates_status']==2){
				 ?>
			     <option value="1">单网页</option>
				 <option value="2" selected>内部栏目</option>
				 <option value="3">外部栏目</option>
				 <?php
					 }elseif($back_arr['cates_status']==3){
				 ?>
			     <option value="1">单网页</option>
				 <option value="2">内部栏目</option>
				 <option value="3" selected>外部栏目</option>
				 <?php
					 }
				 ?>
			  </select></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">链接地址：</td>
		   <td align="left"><input type="text" id="cates_url" name="cates_url" value="<?php echo empty($back_arr['cates_url'])?'':$back_arr['cates_url']; ?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="cates_status" name="cates_status"/>
			     <?php
				     if($back_arr['cates_status']==1){
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
		      <select id="cates_sort" name="cates_sort"/>
			     <?php
				     for($i=1;$i<=9;$i++){
						 if($back_arr['cates_sort']==$i){
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
		       <input type="hidden" id="cates_id" name="cates_id" value="<?php echo $cates_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
			   <input type="hidden" id="modules_id" name="modules_id" value="<?php echo empty($back_arr['modules_id'])?0:$back_arr['modules_id']; ?>" />
			   <input type="hidden" id="cates_favorites" name="cates_favorites" value="<?php echo empty($back_arr['cates_favorites'])?0:$back_arr['cates_favorites']; ?>" />
			   <input type="hidden" id="cates_addusersid" name="cates_addusersid" value="<?php echo empty($back_arr['cates_addusersid'])?'0':$back_arr['cates_addusersid']; ?>" />
			   <input type="hidden" id="cates_addtime" name="cates_addtime" value="<?php echo empty($back_arr['cates_addtime'])?'':$back_arr['cates_addtime']; ?>" />
			   <input type="hidden" id="cates_description" name="cates_description" value="<?php echo empty($back_arr['cates_description'])?'':$back_arr['cates_description']; ?>" />
			   <input type="hidden" id="cates_all_parentid" name="cates_all_parentid" value="<?php echo empty($back_arr['cates_all_parentid'])?'':$back_arr['cates_all_parentid']; ?>" />
			   <input type="hidden" id="cates_child" name="cates_child" value="<?php echo empty($back_arr['cates_child'])?'1':$back_arr['cates_child']; ?>" />
			   <input type="hidden" id="cates_all_children" name="cates_all_children" value="<?php echo empty($back_arr['cates_all_children'])?'':$back_arr['cates_all_children']; ?>" />
			   <input type="hidden" id="cates_parentdir" name="cates_parentdir" value="<?php echo empty($back_arr['cates_parentdir'])?'':$back_arr['cates_parentdir']; ?>" />
			   <input type="hidden" id="cates_dir" name="cates_dir" value="<?php echo empty($back_arr['cates_dir'])?'':$back_arr['cates_dir']; ?>" />
			   <input type="hidden" id="cates_url" name="cates_url" value="<?php echo empty($back_arr['cates_url'])?'':$back_arr['cates_url']; ?>" />
			   <input type="hidden" id="cates_image" name="cates_image" value="<?php echo empty($back_arr['cates_image'])?'':$back_arr['cates_image']; ?>" />
			   <input type="hidden" id="cates_hits" name="cates_hits" value="<?php echo empty($back_arr['cates_hits'])?'0':$back_arr['cates_hits']; ?>" />
			   <input type="hidden" id="cates_remark1" name="cates_remark1" value="<?php echo empty($back_arr['cates_remark1'])?'':$back_arr['cates_remark1']; ?>" />
			   <input type="hidden" id="cates_remark2" name="cates_remark2" value="<?php echo empty($back_arr['cates_remark2'])?'':$back_arr['cates_remark2']; ?>" />
			   <input type="hidden" id="cates_remark3" name="cates_remark3" value="<?php echo empty($back_arr['cates_remark3'])?'':$back_arr['cates_remark3']; ?>" />
		       <input value="修改" type="submit" onClick="return confirm('确认要修改？');" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input onClick="location.href='listcates.php?pageNo=<?php echo $pageNo; ?>'" value="返回" type="reset">
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
