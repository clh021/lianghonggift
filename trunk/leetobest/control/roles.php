<?php
   /*
   * 后台对角色的管理
   */
   include_once('../admin/leesession.php');
	checkmodules('roles');
   include_once('../include/config.php');
   include_once '../include/leecommon.php';
   include_once('../include/mysql.php');
   include_once('../include/leeutil.php');
   

   $method=@trim($method);
   if(empty($method)){
		echo "<script>alert('没有方法');window.history.back();</script>";
		exit;
   }else{
	    $methods=array('add','update','delete');
		if(!in_array($method,$methods)){
		   unset($methods);
           echo "<script>alert('没有".$method."方法');window.history.back();</script>";
		   unset($method);
		   exit;
		}
   }
   
   $db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息

   /*
   * 后台增加角色
   */
   if($method=='add'){
	
	  /*
	  * 对表单数据的处理
	  */
   	  
	  $roles_name=@trim($roles_name);
	  if(@empty($roles_name) || @strlen($roles_name)<0){
          echo "<script>alert('请填写角色名');window.history.back();</script>";
		  exit;
	  }else{
          $roles_name=html($roles_name);
	  }
	  $modules_id_set=@trim($modules_id_set);
	  if(@empty($modules_id_set) || @strlen($modules_id_set)<0){
          echo "<script>alert('请选择权限');window.history.back();</script>";
		  exit;
	  }else{
          $modules_id_set=html($modules_id_set);
	  }
	 
      $roles_status=@trim($roles_status);
	  if(@empty($roles_status) || @strlen($roles_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $roles_status=helphtml($roles_status);
          $roles_status=intval($roles_status);
		  if($roles_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $roles_sort=@trim($roles_sort);
	  if(@empty($roles_sort) || @strlen($roles_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $roles_sort=helphtml($roles_sort);
          $roles_sort=intval($roles_sort);
		  if($roles_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $roles_addtime=$nowtime;

	  $roles_remark1=@trim($roles_remark1);
	  if(@strlen($roles_remark1)>0){
          $roles_remark1=html($roles_remark1);
	  }else{
		  $roles_remark1='';
	  }

	  $roles_remark2=@trim($roles_remark2);
	  if(@strlen($roles_remark2)>0){
          $roles_remark1=html($roles_remark2);
	  }else{
		  $roles_remark2='';
	  }

	  $roles_remark3=@trim($roles_remark3);
	  if(@strlen($roles_remark3)>0){
          $roles_remark3=html($roles_remark3);
	  }else{
		  $roles_remark3='';
	  }
	  $sql="INSERT INTO roles(roles_name,modules_ids,roles_status,roles_sort,roles_addusersid,roles_addtime,roles_remark1,roles_remark2,roles_remark3) 
	  VALUES('$roles_name','$modules_id_set',$roles_status,$roles_sort,$nowuserid,'$roles_addtime','$roles_remark1','$roles_remark2','$roles_remark3')";
	  $sql_name="SELECT * FROM roles WHERE roles_name='$roles_name'";
	  echo $sql_name;//return;
	  $res=mysql_query($sql_name);
	  $num=mysql_num_rows($res);
	  if($num<=0){
		  echo $sql;//return;
		  $success=mysql_query($sql);//增加数据
		  if($success!==false){
			  header("Location:../admin/listRoles.php");
		  }else{
			  echo "<script>alert('增加角色失败');window.history.back();</script>";
		      exit;
		  }
	  }else{
		  echo "<script>alert('".$roles_name."角色已存在');window.history.back();</script>";
		  exit;
	  } 
   }

   /*
   * 后台修改角色
   */
   if($method=='update'){
	  /*
	  * 对表单数据的处理
	  */
	  $roles_id=@trim($roles_id);
	  if(empty($roles_id)){
			 echo "<script>alert('角色编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $roles_id=(int)$roles_id;
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
		 $pageNo=(int)$pageNo;
		 if($pageNo<=0){
			 echo "<script>alert('当前页码不对');window.history.back();</script>";
		     exit;
		 }
	  }

	  $roles_name=@trim($roles_name);
	  if(@empty($roles_name) || @strlen($roles_name)<0){
          echo "<script>alert('请填写角色名');window.history.back();</script>";
		  exit;
	  }else{
          $roles_name=html($roles_name);
	  }


      $modules_id_set=@trim($modules_id_set);
      if($modules_id_set==null && @strlen($modules_id_set)<0 ){
	  	   echo "<script>alert('请选择权限');window.history.back();</script>";
		   exit;
	  }else{
	  	   $modules_id_set=html($modules_id_set);
	  }
	  
      $modules_id_set_old=@trim($modules_id_set_old);
	  if($modules_id_set_old==null || @strlen($modules_id_set_old)<=0){
          echo "<script>alert('请选择权限');window.history.back();</script>";
		  exit;
	  }else{
          $modules_id_set_old=html($modules_id_set_old);
	  }
     //if($strlen($modules_id_set)<0){
      	//$modules_id_set=$modules_id_set_old;
     // }//else{
      	//$modules_id_set=$modules_id_set;
      //}
      if($modules_id_set==''){   	
      	$modules_id_set=$modules_id_set_old;

      }
	  
	 
	  
     /* $modules_id_set=@trim($modules_id_set);
	  if(@strlen($modules_id_set)>0){
          $modules_id_set=html($modules_id_set);
	  }else{
		  $modules_id_set='';
	  }*/
	  
      $roles_status=@trim($roles_status);
	  if(@empty($roles_status) || @strlen($roles_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $roles_status=helphtml($roles_status);
          $roles_status=intval($roles_status);
		  if($roles_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $roles_sort=@trim($roles_sort);
	  if(@empty($roles_sort) || @strlen($roles_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $roles_sort=helphtml($roles_sort);
          $roles_sort=intval($roles_sort);
		  if($roles_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  $roles_addtime=@trim($roles_addtime);
	  if(@empty($roles_addtime) || @strlen($roles_addtime)<0){
          echo "<script>alert('未获取到添加时间，请重试。');window.history.back();</script>";
		  exit;
	  }else{
          $roles_sort=helphtml($roles_sort);
          $roles_sort=intval($roles_sort);
		  if($roles_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  $roles_addusersid=@trim($roles_addusersid);
	  if(@empty($roles_addusersid) || @strlen($roles_addusersid)<0){
          echo "<script>alert('未获取到添加者，请重试。');window.history.back();</script>";
		  exit;
	  }else{
          $roles_addusersid=helphtml($roles_addusersid);
          $roles_addusersid=intval($roles_addusersid);
		  if($roles_addusersid<=0){
              echo "<script>alert('添加者不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  $roles_edittime=$nowtime;
	  //$roles_editusersid=$users_id;
	  $roles_remark1=@trim($roles_remark1);
	  if(@strlen($roles_remark1)>0){
          $roles_remark1=html($roles_remark1);
	  }else{
		  $roles_remark1='';
	  }

	  $roles_remark2=@trim($roles_remark2);
	  if(@strlen($roles_remark2)>0){
          $roles_remark1=html($roles_remark2);
	  }else{
		  $roles_remark2='';
	  }

	  $roles_remark3=@trim($roles_remark3);
	  if(@strlen($roles_remark3)>0){
          $roles_remark3=html($roles_remark3);
	  }else{
		  $roles_remark3='';
	  }
	  
	  $sql="SELECT * FROM roles WHERE roles_id=$roles_id";
	  $res=mysql_query($sql);
	  $num=mysql_num_rows($res);
	  if($num>0){
	     $sql_name="SELECT * FROM roles WHERE roles_name='$roles_name' AND roles_id!='$roles_id'";
	     //echo $sql_name;return ;
	     $res=mysql_query($sql_name);
	  	 $num=mysql_num_rows($res);
	     if($num<=0){
             $sql_update="UPDATE roles SET roles_name='$roles_name',modules_ids='$modules_id_set',roles_status=$roles_status,roles_sort=$roles_sort,roles_addusersid=$roles_addusersid,roles_addtime='$roles_addtime',roles_editusersid=$nowuserid,roles_edittime='$roles_edittime',roles_remark1='$roles_remark1',roles_remark2='$roles_remark2',roles_remark3='$roles_remark3' WHERE roles_id=$roles_id";
             //echo $sql_update;return;
             $success=mysql_query($sql_update);//修改数据
			 if($success!==false){
				  header("Location:../admin/listRoles.php?pageNo=$pageNo");
			 }else{
				  echo "<script>alert('修改角色失败');window.history.back();</script>";
				  exit;
			 }
		 }else{
			 echo "<script>alert('".$roles_name."角色已存在');window.history.back();</script>";
		     exit;
		 }
	   }else{
		  echo "<script>alert('该数据已经不存在');window.history.back();</script>";
		  exit;
	   }
   }
 
   /*
   * 后台删除角色
   */
   if($method=='delete'){
	  /*
	  * 对传参的处理
	  */
	  $roles_id=@trim($roles_id);
	  if(empty($roles_id)){
			 echo "<script>alert('角色编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $roles_id=(int)$roles_id;
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
		 $pageNo=(int)$pageNo;
		 if($pageNo<=0){
			 echo "<script>alert('当前页码不对');window.history.back();</script>";
		     exit;
		 }
	  }

	  $pageSize=@trim($pageSize);
	  if(empty($pageSize)){
		 echo "<script>alert('页面大小不允许为空');window.history.back();</script>";
		 exit;
	  }else{
		 $pageSize=(int)$pageSize;
		 if($pageSize<=0){
			 echo "<script>alert('页面大小不对');window.history.back();</script>";
		     exit;
		 }
	  }
	  $sql="SELECT * FROM roles WHERE roles_id=".$roles_id;
	  $res=mysql_query($sql);
	  $num=mysql_num_rows($res);//判断记录是否存在
	  if($num>0){
	  	  $sql_del="DELETE FROM roles WHERE roles_id=".$roles_id;
		  $success=mysql_query($sql_del);//删除数据
		  if($success!==false){
		  	  $sql_count="SELECT * FROM roles ";
		  	  $result=mysql_query($sql_count);
			  $totalRecord=mysql_num_rows($result,MYSQL_BOTH);//总记录数
			  if($totalRecord>0){
				  $totalPage=ceil($totalRecord / $pageSize);//总页数
				  if($pageNo>$totalPage){
					  $pageNo=$totalPage;
				  }
				  header("Location:../admin/listRoles.php?pageNo=$pageNo");
			  }else{
				  header("Location:../admin/listRoles.php");
			  }
		  }else{
			  echo "<script>alert('删除角色失败');window.history.back();</script>";
			  exit;
		  }
	  }else{
		  echo "<script>alert('该数据已经不存在');window.history.back();</script>";
		  exit;
	  }
   }

   $db->close();//关闭数据库连接
   unset($db);
?>
