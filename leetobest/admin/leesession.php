<?php
    session_start();
	header("content-type:text/html;charset=utf-8");//设置编码方式
			/*
		    echo $_SESSION['modules_id_set']."_1__<br />";
		    echo $_SESSION['roles_name']."_2__<br />";
		    echo $_SESSION['users_account']."_3__<br />";
		    echo $_SESSION['users_id']."_4__<br />";
			echo $_SESSION['admins_id']."_5__<br />";
			echo $_SESSION['admins_name']."_6__<br />";
			*/
    if(empty($_SESSION['users_account']) || empty($_SESSION['modules_id_set']) || empty($_SESSION['roles_name'])){
	   //echo "<script>alert('session失效,请重新登录!');window.parent.location.href='../login/login.php';</script>";
	   echo "<script>alert('session失效,请重新登录!');</script>";
	   return;
    }

//	用于检查和设置
//	function check_module_name_id(){
//		if(empty($_SESSION['modules_name_id'])){
//			include_once'../include/cache.func.php';//加载缓存
//			$modules_array=@cache_read('modules.php','../db_cache/');//CACHE_PATH--在include/config.php里定义的常量
//			if(!@empty($modules_array) && @count($modules_array)>0){
//				$modules_name_id=array();
//				for($i=0;$i<count($modules_array);$i++){
//					//$name_id=array($modules_array[$i]['modules_id'],$modules_array[$i]['modules_path']);
//					//array_push($modules_name_id,$name_id);
//					//以上方法不行，还有一个很自然的简单方法
//					$modules_name_id[$modules_array[$i]['modules_path']]=$modules_array[$i]['modules_id'];
//				}
//				$_SESSION['modules_name_id']=$modules_name_id;
//			}else{
//				echo '<font color="red">请更新关键数据缓存,然后重试。</font>';
//			}
//		}
//	}
//	检查权限模块
	function checkmodules($modules_name){
		$modules_cache_path='../db_cache/modules.php';
		$modules_id_set=$_SESSION['modules_id_set'];
		if(substr($modules_id_set,-1)==','){
		   $modules_id_set=substr($modules_id_set,0,strlen($modules_id_set)-1);
		}
		$modules_id_sets=explode(',',$modules_id_set);
		if(file_exists($modules_cache_path)){
		$modules_array= include_once $modules_cache_path;//CACHE_PATH---在include/config.php里定义的(缓存默认存储路径)
		}else{
			echo "<script>alert('没有模块缓存文件，请更新缓存数据以帮助验证您的权限。');window.history.back();</script>";
			return;
		}
		$modules_name_id=array();
		for($i=0;$i<count($modules_array);$i++){
			$modules_name_id[$modules_array[$i]['modules_path']]=$modules_array[$i]['modules_id'];
		}
		if(!in_array($modules_name_id[$modules_name],$modules_id_sets)){
			echo "<script>alert('你的操作权限不够!为了系统安全重新登录。');window.parent.location.href='../login/login.php'</script>";
			//echo "<script>alert('你的操作权限不够!为了系统安全重新登录。');</script>";
			return;
		}
	}
	/*
	* 用于需要指定的操作参数
	*/
	date_default_timezone_set("Asia/Shanghai");//设置时间分区
	$nowtime=date('Y-m-d H:i:s');//得到现在的时间
	
	  $nowuserid=0;
	  if(!empty($_SESSION['users_id'])){
		  $nowuserid=$_SESSION['users_id'];
	  }else{
		  echo "<script>alert('操作超时，请重新登录。');window.parent.location.href='../login/login.php'</script>";
	      exit;
	  }
	$nowuserid=$_SESSION['users_id'];
?>