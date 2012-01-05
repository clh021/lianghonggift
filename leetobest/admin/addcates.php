<?php
    include_once('leesession.php');//判断是不是管理员
	checkmodules('cates');//陈良红对管理员权限的判断//$m_id=23;
    include_once('../include/config.php');//配置文件
	include_once('../include/leecommon.php');//防止sql注入、预编义
	include_once '../include/cache.func.php';//加载缓存



		   	$modules_array=@cache_read('modules.php',CACHE_PATH);//CACHE_PATH--在include/config.php里定义的常量
			if(@empty($modules_array) && @count($modules_array)<=0){
				echo "<script>alert('请更新缓存。');window.history.back();</script>";
				exit;
			}else{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加栏目 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="style/index.css" type="text/css" rel="stylesheet" />
 </head>
<script type="text/javascript" src="../fckeditor/fckeditor.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
   function check(){
	    var modules_id=document.getElementById('modules_id').value;
		modules_id=trim(modules_id);//调用函数---去掉前后空格
		if(modules_id.length<=0){
			alert("请选择模块");
			return false;
		}

        var cates_name=document.getElementById('cates_name').value;
		cates_name=trim(cates_name);//调用函数---去掉前后空格
		if(cates_name.length<=0){
			alert("请填栏目名称");
			return false;
		}else{
		    if(cates_name.indexOf('-')!=-1 || cates_name.indexOf('@')!=-1 || cates_name.indexOf('!')!=-1 || cates_name.indexOf(',')!=-1){
				alert("栏目名称不能包含- @ ! ,四种特殊符号");
			    return false;
			}
		}
		var cates_path=document.getElementById('cates_path').value;
		cates_path=trim(cates_path);//调用函数---去掉前后空格
		if(cates_path.length<=0){
			alert("请填写栏目路径");
			return false;
		} 
		var cates_key=document.getElementById('cates_key').value;
		cates_key=trim(cates_key);//调用函数---去掉前后空格
		if(cates_key.length<=0){
			alert("请填写栏目关键字");
			return false;
		} 
		var cates_des=document.getElementById('cates_des').value;
		cates_des=trim(cates_des);//调用函数---去掉前后空格
		if(cates_des.length<=0){
			alert("请填写栏目描述");
			return false;
		} 
		var cates_content=document.getElementById('cates_content').value;
		cates_content=trim(cates_content);//调用函数---去掉前后空格
		if(cates_content.length<=0){
			alert("请填写栏目介绍");
			return false;
		} 
		
		var cates_parentid=document.getElementById('cates_parentid').value;
		cates_parentid=trim(cates_parentid);//调用函数---去掉前后空格
		if(cates_parentid.length<=0){
			alert("请选择上一级");
			return false;
		} 
		var cates_type=document.getElementById('cates_type').value;
		cates_type=trim(cates_type);//调用函数---去掉前后空格
		if(cates_type.length<=0){
			alert("请选择栏目类别");
			return false;
		} 
		var cates_url=document.getElementById('cates_url').value;
		cates_url=trim(cates_url);//调用函数---去掉前后空格
		if(cates_url.length<=0){
			//alert("请填写URL");
			//return false;
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
 <body>
  <form action="../control/cates.php?method=add" method="post" onsubmit="return check();">
     <table border="0" cellpadding="0" cellspacing="0" class="add_table">
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">所属模块：</td>
		   <td align="left">
		   <select name="modules_id" id="modules_id">
		   <?php
				for($m=0;$m<count($modules_array);$m++){
					if($modules_array[$m]['modules_status']=='1' && $modules_array[$m]['modules_cate']=='1'){
			?>
			<option value="<?php echo $modules_array[$m]['modules_id'];?>"><?php echo $modules_array[$m]['modules_name'];?></option>
			<?php
					}
				}
			}
		   ?>
		   </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">上一级：</td>
		   <td align="left">
		   
		      <select id="cates_parentid" name="cates_parentid">
			     <?php
					include('../include/mysql.php');//加载数据库操作文件
					$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
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
						$back='0@ @ !'.$back;
						if(substr($back,-1)=='!'){
                            $back=substr($back,0,-1);
						}
						$arr_b=explode('!',$back);

						include_once '../include/array.php';//删除数组元素
                        
						for($j=0;$j<count($arr_b);$j++){
							$arr2=explode('@',$arr_b[$j]);
				 ?>
				 <option value="<?php echo $arr2[0]; ?>"><?php echo $arr2[2] ;?></option>
				 <?php
						}
						unset($rec);
						unset($rec_1);
					}
				 ?>
			  </select>
		   </td>
		</tr>
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">栏目名称：</td>
		   <td align="left"><input type="text" id="cates_name" name="cates_name"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">路径：</td>
		   <td align="left"><input type="text" id="cates_path" name="cates_path"/>英文名<font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">关键字：</td>
		   <td align="left"><input type="text" id="cates_key" name="cates_key"/>针对搜索引擎<font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">描述：</td>
		   <td align="left"><textarea type="text" id="cates_des" name="cates_des" style="width:60%; height:40px;"></textarea>针对搜索引擎<font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">介绍：</td>
		   <td align="left"><textarea type="text" id="cates_content" name="cates_content" style="width:60%; height:40px;"></textarea><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">栏目类别：</td>
		   <td align="left">
		      <select id="cates_type" name="cates_type">
			     <option value="1">单网页</option>
				 <option value="2">内部栏目</option>
				 <option value="3">外部栏目</option>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">链接地址：</td>
		   <td align="left"><input type="text" id="cates_url" name="cates_url"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态：</td>
		   <td align="left">
		      <select id="cates_status" name="cates_status">
			     <option value="1">激活</option>
				 <option value="2">废弃</option>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="cates_sort" name="cates_sort">
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
		       <input type="hidden" id="modules_id" name="modules_id" value="24" />

			   <input type="hidden" id="cates_all_parentid" name="cates_all_parentid" value="" />
			   <input type="hidden" id="cates_parent_dir" name="cates_parent_dir" value="" />
			   <input type="hidden" id="cates_all_parent_dir" name="cates_all_parent_dir" value="" />
			   <input type="hidden" id="cates_hits" name="cates_hits" value="0" />
			   <input type="hidden" id="cates_items" name="cates_items" value="0" />
			   <input type="hidden" id="cates_images" name="cates_images" value="" />
			   <input type="hidden" id="cates_flashs" name="cates_flashs" value="" />
			   <input type="hidden" id="cates_videos" name="cates_videos" value="" />
			   <input type="hidden" id="cates_downs" name="cates_downs" value="" />
			   <input type="hidden" id="cates_remark1" name="cates_remark1" value="" />
			   <input type="hidden" id="cates_remark2" name="cates_remark2" value="" />
			   <input type="hidden" id="cates_remark3" name="cates_remark3" value="" />
		       <input type="submit" value="提交"/>&nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
		   </td>
		</tr>
	 </table>
  </form>
 </body>
</html>