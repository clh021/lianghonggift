<?php
	 /*
     * 后台管理
     */
     include('../admin/leesession.php');
     include('../include/config.php');
     include '../include/leecommon.php';
     include('../include/mysql.php');
     include('../include/leeutil.php');
	 
	 
	 $method=@trim($method);
	 if(empty($method)){
	 	echo "<script>alert('没有方法');window.history.back();</script>";
	 	exit;
	 }else{
	 	$methods=array('add','update');
	 	if(!in_array($method, $methods)){
	 		unset($methods);
	 		echo "<script>alert(没有".$method."方法);window.history.back();</script>";
	 		unset($method);
	 		exit;
	 	}
	 }
	 
	 $db = new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);
	 
	  /*
	 * 增加用户类型
	 */
	 if($method=='add'){
	 	$ut_name=@trim($ut_name);
	 	if(empty($ut_name)){
	 		echo "<script>alert('名称不能为空');window.history.back();</script>";
			exit;
	 	}else{
     		$ut_name=helphtml($ut_name);
	    }
	 	
	  $ut_status=@trim($ut_status);
	  if(@empty($ut_status) || @strlen($ut_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $ut_status=helphtml($ut_status);
          $ut_status=intval($ut_status);
		  if($ut_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $ut_sort=@trim($ut_sort);
	  if(@empty($ut_sort) || @strlen($ut_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $ut_sort=helphtml($ut_sort);
          $ut_sort=intval($ut_sort);
		  if($ut_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	 	
	  $users_id=$nowuserid;
	  $sql_sel="SELECT * FROM users_type WHERE ut_name='$ut_name'";
	  $res=mysql_query($sql_sel);
	  $num=mysql_num_rows($res);
	  if($num>0){
	  	 echo "<script>alert('该".$ut_name."名称已存在');window.history.back();</script>";
	     exit;
	  }else{
	 	 $sql="INSERT INTO users_type(ut_name,ut_status,ut_sort,users_id,ut_addtime) VALUES('$ut_name',$ut_status,$ut_sort,$users_id,'$nowtime')";
	 	 $success=mysql_query($sql);
	 	 if($success!=false){
	 	 	header('Location:../admin/listUsers_type.php');
	 	 }else{
				     echo "<script>alert('管理员添加用户类别失败');window.history.back();</script>";
					 exit;
		 }
	    }
	 }
	 
	 
	 /*
	  * 修改用户类型
	  */
	 
	 if($method=='update'){
		  $ut_id=@trim($ut_id);
		  if(empty($ut_id)){
				 echo "<script>alert('用户类型编号不允许为空');window.history.back();</script>";
				 exit;
		  }else{
				 $ut_id=(int)$ut_id;
				 if($ut_id<=0){
					 echo "<script>alert('用户类型编号不对');window.history.back();</script>";
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
	 	
	    $ut_name=@trim($ut_name);
	 	if(empty($ut_name)){
	 		echo "<script>alert('名称不能为空');window.history.back();</script>";
			exit;
	 	}else{
     		$ut_name=helphtml($ut_name);
	    }
	 	
	  $ut_status=@trim($ut_status);
	  if(@empty($ut_status) || @strlen($ut_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $ut_status=helphtml($ut_status);
          $ut_status=intval($ut_status);
		  if($ut_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $ut_sort=@trim($ut_sort);
	  if(@empty($ut_sort) || @strlen($ut_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $ut_sort=helphtml($ut_sort);
          $ut_sort=intval($ut_sort);
		  if($ut_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	 	
	  $users_id=0;
	  if(!empty($_SESSION['users_id'])){
		  $users_id=$_SESSION['users_id'];
	  }else{
		  echo "<script>alert('session失效,请重新登录!');window.parent.location.href='../login/login.php';</script>";
	      exit;
	  }
	  
	  $sql="SELECT * FROM users_type WHERE ut_id=".$ut_id."";
	  $res=mysql_query($sql);
	  $num=mysql_num_rows($res);
	  if($num>0){
	  	 $sql_update="UPDATE users_type SET ut_name='$ut_name',ut_status=$ut_status,ut_sort=$ut_sort WHERE ut_id=$ut_id";
	  	 $success=mysql_query($sql_update);
	      if($success!==false){
				  header("Location:../admin/listUsers_type.php?pageNo=$pageNo");
		  }else{
				  echo "<script>alert('修改用户类型失败');window.history.back();</script>";
				  exit;
		  }
	  }else{
	  	 echo "<script>alert('该数据已经不存在');window.history.back();</script>";
		 exit;
	  }
	 }
?>