<?php 
    @include_once 'leesession.php';//判断是不是管理员
	checkmodules('users_detailed');//陈良红对管理员权限的判断
    include_once '../include/config.php';//配置文件
	include_once '../include/leecommon.php';//防止sql注入、预编义
	include_once '../include/recursive.php';//加载递归处理
	
	$ud_id=@trim($ud_id);
	if(empty($ud_id)){
		echo "<script>alert('用户详细信息编号不允许为空');window.history.back();</script>";
		exit;
	}else{
		$ud_id=(int)$ud_id;
		if($ud_id<=0){
			echo "<script>alert('用户详细信息编号不对');window.history.back();</script>";
		    exit;
		}
	}
	
	include '../include/mysql.php';//加载数据库操作文件
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	$sql_bool="SELECT * FROM users_detailed WHERE ud_id='$ud_id'";
	$res=mysql_query($sql_bool);
	$num=mysql_num_rows($res);
	if($num<=0){
		echo "<script>alert('该数据已经不存在了');window.history.back();</script>";
		exit;
	}
	
	$sql="SELECT * FROM users_detailed WHERE ud_id='$ud_id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 修改用户详细信息 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
	$(document).ready(function(){
		   /*
		   * 表单验证
		   */
		   $("from#from1").submit(function(){
				var ud_name=$('#ud_name').val();
				ud_name=trim(ud_name);//调用函数---去掉前后空格
				if(ud_name.length<=0){
					alert("请填真实姓名");
					return false;
				}  
				
				var problems_id=$('#problems_id').val();
				problems_id=trim(problems_id);//调用函数---去掉前后空格
				if(problems_id.length<=0){
					alert("请选择密保问题");
					return false;
				} 
				
				var ud_sex=$('#ud_sex').val();
				ud_sex=trim(ud_sex);//调用函数---去掉前后空格
				if(ud_sex.length<=0){
					alert("请选择性别");
					return false;
				} 

				var ud_status_set=$('#ud_status_set').val();
				ud_status_set=trim(ud_status_set);//调用函数---去掉前后空格
				if(ud_status_set.length<=0){
					alert("请选择状态集合");
					return false;
				}
				
				var ud_sort=$('#ud_sort').val();
				ud_sort=trim(ud_sort);//调用函数---去掉前后空格
				if(ud_sort.length<=0){
					alert("请选择排序");
					return false;
				} 

				var areas_id=$('#areas_id').val();
				areas_id=trim(areas_id);//调用函数---去掉前后空格
				if(areas_id.length<=0){
					alert("请选择地区");
					return false;
				} 

				var ut_id=$('#ut_id').val();
				ut_id=trim(ut_id);//调用函数---去掉前后空格
				if(ut_id.length<=0){
					alert("请选择用户类型");
					return false;
				} 

				var ud_hits=$('#ud_hits').val();
				ud_hits=trim(ud_hits);//调用函数---去掉前后空格
				if(ud_hits.length<=0){
					alert("请填点击率");
					return false;
				}

				var ud_favorites=$('#ud_favorites').val();
				ud_favorites=trim(ud_favorites);//调用函数---去掉前后空格
				if(ud_favorites.length<=0){
					alert("请填收藏次数");
					return false;
				}
		   });
	})

	function creatImg(obj){
	    var test=document.getElementById('test');//得到对象
	 clearAllNode(test);//清除父节点下的所有子节点
	 var img=document.createElement('img');//创建img元素
	 var imgValue='';//定义一个图片路径变量
	
	 /*
	 * 取图片上传时的路径值
	 */
	 if(document.all){//ie的取值方法
	   imgValue=obj.value;
	 }else{//火狐的取值方法
	   imgValue=obj.files[0].getAsDataURL();
	 }
	
	 /*
	 * 把\替换为/,注意的是\---为转义字符,故为\\
	 */
	 while(imgValue.indexOf('\\')!=-1){
	    imgValue=imgValue.replace('\\','/');
	 }
	    
	    /*
	 * 设置img的src、width、height三个属性值
	 * 在设置之前,先判断文件是不是图片格式
	 */
	 imgValue=trim(imgValue);
	    if(imgValue.length>0){
	    var flag_Pic=isPicture(imgValue);//判断是否为图片
	 if(flag_Pic){//设置
	     img.setAttribute("src",imgValue);
	        img.setAttribute("width",150);
	        img.setAttribute("height",150);
	           test.appendChild(img);//添加节点元素
	 }
	 }
	  }
	
	//清除父节点下的所有子节点
	  function clearAllNode(parentNode){
	while (parentNode.firstChild) {
	    var oldNode = parentNode.removeChild(parentNode.firstChild);
	    oldNode = null;
	}
	}
	  
	/*
	* 判断文件后缀名是不是图片格式
	*/
	function isPicture(str){
	  var flag=false;
	  var strFilter=".jpeg|.gif|.jpg|.png|.bmp|.pic|";
	  if(str.indexOf(".")>-1){
	     var p = str.lastIndexOf(".");
	  var strPostfix=str.substring(p,str.length) + '|';        
	        strPostfix = strPostfix.toLowerCase();
	        if(strFilter.indexOf(strPostfix)>-1){
	              flag= true;
	        }
	  }
	  return flag;
	} 

   /*
      去掉前后空格
    */
   function trim(str){
		 return str.replace(/(^\s*)|(\s*$)/g, "");
   } 

   $(document).ready(function(){
	      $("#bttn1").click(function(){
		     $.post("../control/users_detailed.php?method=delimage",
			   {"ud_image":$("#ud_path_old").val()},
			   function(data,textStatus){
			     if(textStatus=='success'){
					 alert('图片删除成功');
					 $("#ud_path_old").val('');//jQuery赋值
					 //alert(document.getElementById('links_images_old').value);
					 $("#tr_face td img").attr('src','');//jQuery设置属性
					 $("#tr_face").hide();//jQuery隐藏---也可以用$("#tr_img").css('display','none')
					 //document.getElementById('tr_img').style.display='none';
				 }
			   }
			 );
		  }); 
	   })
	   
   /*
   * 复选框的操作---权限的
   */
   function ckeckMethodp(obj,m){
	 var ud_status_set=document.getElementById("ud_status_set");
	 if(obj.checked){
		 ud_status_set.value +=m+",";
	 }else{
		 ud_status_set.value = ud_status_set.value.replace((m+","),"");
	 }
   }
//-->
</script>
 <body>
  <form action="../control/users_detailed.php?method=update" method="post" enctype="multipart/form-data" id="from1">
     <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">真实姓名：</td>
		   <td align="left"><input type="text" id="ud_name" name="ud_name" value="<?php echo empty($row['ud_name'])?'':$row['ud_name'];?>"/><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">用户类别：</td>
		   <td align="left">
		     <select id="ut_id" name="ut_id" >
				 <?php
			          $sql_title="SELECT * FROM users_type WHERE ut_status=1";
			          $res_title=mysql_query($sql_title);
				      while($arr=mysql_fetch_array($res_title,MYSQL_BOTH)){
				      	if($arr['ut_id']==$row['ut_id']){
			   ?>
			     <option value="<?php echo $arr['ut_id']; ?>" selected="true"><?php echo $arr['ut_name'];?>
			   </option>
			   <?php 
				      	}else{
			   ?>
			   <option value="<?php echo $arr['ut_id']; ?>"><?php echo $arr['ut_name']?></option>
			   <?php 
				      	}
					  }
				?>
		     </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">密保问题：</td>
		   <td align="left">
		     <select id="problems_id" name="problems_id" >
				 <?php
			          $sql_title="SELECT * FROM problems";
			          $res_title=mysql_query($sql_title);
				      while($arr=mysql_fetch_array($res_title,MYSQL_BOTH)){
				      	if($arr['problems_id']==$row['problems_id']){
			   ?>
			     <option value="<?php echo $arr['problems_id']; ?>" selected="true"><?php echo $arr['problems_name'];?>
			   </option>
			   <?php 
				      	}else{
			   ?>
			   <option value="<?php echo $arr['problems_id']; ?>"><?php echo $arr['problems_name']?></option>
			   <?php 
				      	}
					  }
				?>
		     </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">密保答案：</td>
		   <td align="left"><input type="text" id="ud_answer" name="ud_answer" value="<?php echo empty($row['ud_answer'])?'':$row['ud_answer'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">地区：</td>
		   <td>
				<select id="areas_id" name="areas_id">
				    <option value="0">--请选择--</option>
					<?php
						 $sql_areas="SELECT * FROM areas WHERE areas_status=1";
						 $res_areas=mysql_query($sql_areas);
						 $arr_areas=array();
						 $back_areas='';
						 while($rowareas=mysql_fetch_array($res_areas,MYSQL_BOTH)){
							 array_push($arr_areas,$rowareas['areas_id'].'-'.$rowareas['areas_parentid'].'-'.$rowareas['areas_name']);
					     }
					     if(!@empty($arr_areas) && @is_array($arr_areas) && @count($arr_areas)>0){
					     	$rec_areas=new Recursive($arr_areas);
					     	$rec_areas->digui();
					     	$back_areas=$rec_areas->back;
					     	unset($rec_areas);
					     	
					     	if(!@empty($back_areas) && @strlen($back_areas)>0){
					     		if(substr($back_areas,-1)=='!'){
					     			$back_areas=substr($back_areas,0,-1);
					     		}
					     		
					     		if(@strlen($back_areas)>0){
					     			$arr_back=explode('!',$back_areas);
					     			for($i=0;$i<count($arr_back);$i++){
					     				$arr_db=explode('@',$arr_back[$i]);
					     				if(intval($arr_db[0])==$row['areas_id']){
					?>
					<option value="<?php echo $arr_db[0] ;?>" selected="true"><?php echo $arr_db[2] ;?></option>
					<?php
					     				}else{
					?>
					<option value="<?php echo $arr_db[0] ;?>"><?php echo $arr_db[2] ;?></option>
					<?php	
					     				}
					     			}
					     		}
					     	}
					     }
					?>
				</select>
			</td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">电子邮箱：</td>
		   <td align="left"><input type="text" id="ud_email" name="ud_email" value="<?php echo empty($row['ud_email'])?'':$row['ud_email'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">生日：</td>
		   <td align="left"><input type="text" id="ud_birthday" name="ud_birthday" value="<?php echo empty($row['ud_birthday'])?'':$row['ud_birthday'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">QQ号：</td>
		   <td align="left"><input type="text" id="ud_qq" name="ud_qq" value="<?php echo empty($row['ud_qq'])?'':$row['ud_qq'];?>"/></td>
		</tr>
		<?php
		   if(!empty($row['ud_image'])){
			   if(file_exists(FILE_PATH.$row['ud_image'])){
	    ?>
	    <tr id="tr_face" name="tr_face">
		  <td align="right" bgcolor="#f1f1f1">个人头像：</td>
		  <td align="left">
			   <img src="<?php echo URL_PATH.$row['ud_image'] ?>" height="150px" width="140px">
			   <button id="bttn1" name="bttn1"><font color="red">删除图片</font></button>
		  </td>
	    </tr>
	    <?php
			   }
		   }
	    ?>
	    <tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">上传头像：</td>
		   <td align="left">
		   <input type="hidden" name="MAX_FILE_SIZE" value="512000" >
		   <div id="test"></div>
		   <input type="file" name="ud_image" id="ud_image" onchange="creatImg(this)"  value="选择">
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">性别：</td>
		   <td align="left">
		      <select id="ud_sex" name="ud_sex">
			     <?php
				     if($row['ud_sex']==1){
				 ?>
                 <option value="1" selected="true">男</option>
				 <option value="2">女</option>
				 <?php
					 }else{
				 ?>
                 <option value="1">男</option>
				 <option value="2" selected="true">女</option>
				 <?php
					 }
				 ?>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">昵称：</td>
		   <td align="left"><input type="text" id="ud_nick" name="ud_nick" value="<?php echo empty($row['ud_nick'])?'':$row['ud_nick'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">电话：</td>
		   <td align="left"><input type="text" id="ud_phone" name="ud_phone" value="<?php echo empty($row['ud_phone'])?'':$row['ud_phone'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">手机：</td>
		   <td align="left"><input type="text" id="ud_tel" name="ud_tel" value="<?php echo empty($row['ud_tel'])?'':$row['ud_tel'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">个人主页：</td>
		   <td align="left"><input type="text" id="ud_homepage" name="ud_homepage" value="<?php echo empty($row['ud_homepage'])?'':$row['ud_homepage'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">联系地址：</td>
		   <td align="left"><input type="text" id="ud_addr" name="ud_addr" value="<?php echo empty($row['ud_addr'])?'':$row['ud_addr'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">个性签名：</td>
		   <td align="left"><textarea type="text" id="ud_signature" name="ud_signature" value="<?php echo empty($row['ud_signature'])?'':$row['ud_signature'];?>"/></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">自我介绍：</td>
		   <td align="left"><textarea type="text" id="ud_introduction" name="ud_introduction" value="<?php echo empty($row['ud_introduction'])?'':$row['ud_introduction'];?>"/></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">点击率：</td>
		   <td align="left"><input type="text" id="ud_hits" name="ud_hits" value="<?php echo empty($row['ud_hits'])?0:$row['ud_hits'];?>"/></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">收藏次数：</td>
		   <td align="left"><input type="text" id="ud_favorites" name="ud_favorites" value="<?php echo empty($row['ud_favorites'])?0:$row['ud_favorites'];?>"/></td>
		</tr>
		<tr>
		<td width="15%" align="right" bgcolor="#f1f1f1">状态集合：</td>
		   <td align="left">
			   <?php
			       $m_set=$row['ud_status_set'];
				   if(substr($m_set,-1)==','){
					   $m_set=substr($m_set,0,strlen($m_set)-1);
				   }
				   $m_sets=explode(',',$m_set);
				   $flag=false;

				   $sql="SELECT * FROM channels";
				   $res=mysql_query($sql);
				   while($rows=mysql_fetch_array($res,MYSQL_BOTH)){
					   for($i=0;$i<sizeof($m_sets);$i++){
						   if($rows['channels_id']==$m_sets[$i]){
                               $flag=true;
							   break;
						   }
					   }

			   		   if($flag){
			   ?>               
               <input type="checkbox" id="check<?php echo $rows['channels_id']; ?>" name="check<?php echo $rows['channels_id']; ?>" value="<?php echo $rows['channels_id']; ?>" onclick="ckeckMethodp(this,<?php echo $rows['channels_id']; ?>)" checked='true'><?php echo $rows['channels_name'];?>
			   <?php
					   }else{
			   ?>
               <input type="checkbox" id="check<?php echo $rows['channels_id']; ?>" name="check<?php echo $rows['channels_id']; ?>" value="<?php echo $rows['channels_id']; ?>" onclick="ckeckMethodp(this,<?php echo $rows['channels_id']; ?>)"><?php echo $rows['channels_name'];?>
			   <?php
					   }
			           $flag=false;
				   }
			   ?>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="ud_sort" name="ud_sort">
			     <?php
				     for($i=1;$i<=9;$i++){
						 if($row['ud_sort']==$i){
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
		       <input id="ud_status_set" name="ud_status_set" type="hidden" value="<?php echo $row['ud_status_set'];?>">
		       <input type="hidden" id="ud_path_old" name="ud_path_old" value="<?php echo empty($row['ud_image'])?'':$row['ud_image'];?>" />
		       <input type="hidden" id="ud_id" name="ud_id" value="<?php echo $ud_id; ?>" />
			   <input type="hidden" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" />
			   <input type="hidden" id="users_id" name="users_id" value="<?php echo empty($row['users_id'])?'0':$row['users_id']; ?>" />
		       <input value="修改" type="submit" onClick="return confirm('确认要修改？');" />&nbsp;&nbsp;&nbsp;&nbsp;
			   <input onClick="location.href='listUsers_detailed.php?pageNo=<?php echo $pageNo; ?>'" value="返回" type="reset">
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