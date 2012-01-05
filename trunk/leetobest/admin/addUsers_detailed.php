<?php 
    @include_once 'leesession.php';//判断是不是管理员
    include_once '../include/config.php';//配置文件
    include_once '../include/mysql.php';
    $db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> 增加用户详细信息 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link href="style/index.css" type=text/css rel=stylesheet />
 </head>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/my.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
	$(document).ready(function(){
		   /*
		   * 表单验证
		   */
		   $("from#from1").submit(function(){
			    var users_account=$('#users_account').val();
			    users_account=trim(users_account);//调用函数---去掉前后空格
				if(users_account.length<=0){
					alert("请填用户账号");
					return false;
				}

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

	       /*
	       * 通过选择来改变图片预览的显示
	       */
		   $("#pi_path").change(function(){
               var img=$(this).val();
			   var url_path='<?php echo URL_PATH;?>';
			   img=url_path+img;
			   $("#img_yl").attr("src",'');
			   $("#img_yl").attr("src",img);
		   });
	})

	function creatImg(obj){
	   //var test=document.getElementById('test');//得到对象
	   //clearAllNode(test);//清除父节点下的所有子节点
	   //var img=document.createElement('img');//创建img元素
	   var img=document.getElementById("img_yl");
	   var imgValue='';//定义一个图片路径变量
	
	   /*
	   * 取图片上传时的路径值
	   */
	   if(document.all){//ie的取值方法
	     imgValue=obj.value;
	   }else{//火狐的取值方法
	     imgValue=obj.files[0].getAsDataURL();
	   }
	   //alert(imgValue);
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
	    	img.setAttribute("src",'');
	        img.setAttribute("src",imgValue);
	        //img.setAttribute("width",150);
	        //img.setAttribute("height",150);
	        //test.appendChild(img);//添加节点元素
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
  <form action="../control/users_detailed.php?method=add" method="post" enctype="multipart/form-data" id="from1">
     <table border="0" cellpadding="0" cellspacing="0" class="edit_table">
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">用户账号：</td>
		   <td align="left"><input type="text" id="users_account" name="users_account" /><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">真实姓名：</td>
		   <td align="left"><input type="text" id="ud_name" name="ud_name" /><font color="red">( * 必填 )</font></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">用户类别：</td>
		   <td align="left">
		     <select id="ut_id" name="ut_id" >
				 <?php
			          $sql_title="SELECT * FROM users_type WHERE ut_status=1";
			          $res_title=mysql_query($sql_title);
				      while($arr=mysql_fetch_array($res_title,MYSQL_BOTH)){
				 ?>
				 <option value="<?php echo $arr['ut_id'];?>"><?php echo $arr['ut_name'];?></option>
				 <?php     	
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
			          $sql_title="SELECT * FROM problems WHERE problems_status=1";
			          $res_title=mysql_query($sql_title);
				      while($arr=mysql_fetch_array($res_title,MYSQL_BOTH)){
			   ?>
			   <option value="<?php echo $arr['problems_id']; ?>"><?php echo $arr['problems_name']?></option>
			   <?php 
					  }
				?>
		     </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">密保答案：</td>
		   <td align="left"><input type="text" id="ud_answer" name="ud_answer" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">地区：</td>
		   <td align="left">
		     <select id="areas_id" name="areas_id" >
				 <?php
			          $sql_area="SELECT * FROM areas WHERE areas_status=1";
			          $back='';
			          $res_area=mysql_query($sql_area);
			          $arr_areas=array();
				      while($row_area=mysql_fetch_array($res_area,MYSQL_BOTH)){				      	  
				      	  array_push($arr_areas,$row_area['areas_id'].'-'.$row_area['areas_parentid'].'-'.$row_area['areas_name']);
					  }

					  if(!@empty($arr_areas) && @is_array($arr_areas) && @count($arr_areas)>0){
					  	 include_once '../include/recursive.php';
					  	 $rec=new Recursive($arr_areas);
					  	 $rec->digui('0',0);
					  	 $back=$back.$rec->back;
					  	 unset($rec);//注销变量
					  }
					  
					  if(strlen($back)>0){
						  if(substr($back,-1)=='!'){
						  	 $back=substr($back,0,-1);
						  }
					  }

					  if(strlen($back)>0){
					  	 $arr_db=explode('!',$back);
					  	 for($i=0;$i<count($arr_db);$i++){
					  	 	$arr_temp=explode('@',$arr_db[$i]);
				?>
			    <option value="<?php echo $arr_temp[0];?>"><?php echo $arr_temp[2]; ?></option>
			    <?php	  	 	
			                unset($arr_temp);
					  	 }
					  	 unset($arr_db);
					  }
				?>
		     </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">电子邮箱：</td>
		   <td align="left"><input type="text" id="ud_email" name="ud_email" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">生日：</td>
		   <td align="left"><input type="text" id="ud_birthday" name="ud_birthday" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">QQ号：</td>
		   <td align="left"><input type="text" id="ud_qq" name="ud_qq" /></td>
		</tr>
		<tr>
		  <td width="15%" align="right" bgcolor="#f1f1f1">选择头像:</td>
		  <td  align="left">
		      使用系统头像：&nbsp;&nbsp;<select id="pi_path" name="pi_path">
		         <?php 
		            $sql_pi="SELECT * FROM person_image WHERE pi_status=1";
		            $res_pi=mysql_query($sql_pi);
		            $i=0;
		            $img_yl="";
		            while($row_pi=mysql_fetch_array($res_pi,MYSQL_BOTH)){
		            	if($i==0){
		            		$img_yl=$row_pi['pi_path'];
		            	}
		            	$i++;
		         ?>
		         <option value="<?php echo $row_pi['pi_path'] ;?>"><?php echo $row_pi['pi_name'] ; ?></option>
		         <?php  	
		            }
		         ?>
		      </select>
		         <img id="img_yl" src="<?php echo URL_PATH.$img_yl;?>" width="90" height="90">
		      <br />
		      <input type="hidden" name="MAX_FILE_SIZE" value="512000" >
		              上传自定义头像：<input type="file" name="ud_image" id="ud_image" onchange="creatImg(this)"  value="选择">
		  </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">性别：</td>
		   <td align="left">
		      <select id="ud_sex" name="ud_sex">
			     <option value="1" selected="true">男</option>
				 <option value="2">女</option>
			  </select>
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">昵称：</td>
		   <td align="left"><input type="text" id="ud_nick" name="ud_nick" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">电话：</td>
		   <td align="left"><input type="text" id="ud_phone" name="ud_phone" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">手机：</td>
		   <td align="left"><input type="text" id="ud_tel" name="ud_tel" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">个人主页：</td>
		   <td align="left"><input type="text" id="ud_homepage" name="ud_homepage" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">联系地址：</td>
		   <td align="left"><input type="text" id="ud_addr" name="ud_addr" /></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">个性签名：</td>
		   <td align="left"><textarea id="ud_signature" name="ud_signature"/></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">自我介绍：</td>
		   <td align="left"><textarea id="ud_introduction" name="ud_introduction" /></textarea></td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">状态集合：</td>
		   <td align="left">
			   <?php
				   $sql="SELECT * FROM channels WHERE channels_status=1";
				   $res=mysql_query($sql);
				   while($rows=mysql_fetch_array($res,MYSQL_BOTH)){
			   ?>
			   <input type="checkbox" id="check<?php echo $rows['channels_id']; ?>" name="check<?php echo $rows['channels_id']; ?>" value="<?php echo $rows['channels_id']; ?>" onclick="ckeckMethodp(this,<?php echo $rows['channels_id']; ?>)"><?php echo $rows['channels_name'];?>
			   <?php
				   }
			   ?>
			   <input id="ud_status_set" name="ud_status_set" type="hidden">
		   </td>
		</tr>
		<tr>
		   <td width="15%" align="right" bgcolor="#f1f1f1">排序：</td>
		   <td align="left">
		      <select id="ud_sort" name="ud_sort">
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
		       <input type="submit" value="提交"/>&nbsp;&nbsp;&nbsp;&nbsp;
			   <input type="reset" value="重置"/>
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