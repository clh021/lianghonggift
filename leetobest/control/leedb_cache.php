<?php
	header("content-type:text/html;charset=utf-8");//设置编码方式
	//添加数据缓存必须保证，表字段中包含的状态字段名为  【表名+'_status'】为了方便程序的处理
	$cache_table_arr=array('channels','ips','models','modules','problems','systems','cates','areas','goalcate','cates_lee','users_type');
	//由于本页面没有可能造成威胁的操作，所以无需权限设置，也不需要验证账号
	//使用方法：
	//1、传递method='structure'参数，则更新
	//2、传递method='date'参数，则更新所有缓存数据
	//3、传递method='table_表名'参数，则
	//		必须再同时传递name='表名'的参数，则更新此表的缓存数据，此时会有返回参数，1，更新成功，0，更新失败，-1，没有数据可更新
   /*
   * 生成指定缓存
   */
   include_once('../include/config.php');
   include_once '../include/leecommon.php';
   include_once('../include/mysql.php');
   include_once('../include/cache.func.php');

	$method=@trim($method);
	if(empty($method)){
		echo "<script>alert('没有方法');window.history.back();</script>";
		exit;
	}else{
	    $methods=array('structure','data','table');
		if(!in_array($method,$methods)){
		   unset($methods);
           echo "<script>alert('没有".$method."方法');window.history.back();</script>";
		   unset($method);
		   exit;
		}
	}
	if(isset($show_thispage)){
		$show_thispage=false;
	}else{
		$show_thispage=true;
	}
	function one_table($name){
		global $show_thispage;
		//先要判断数据库中是否存在此表
		if(!isset($tables_arr)){
			global $db;
			$tables_arr=$db->tables();
		}
		if(in_array($name,$tables_arr))
		{
		  $arr=$db->selectAll($name,array(),array(),array());
		  if(!@empty($arr) && @count($arr)>0){
			 $arr1=array();
			 for($i=0;$i<count($arr);$i++){
				 foreach($arr[$i] as $key => $value){
					 if(is_string($key))
						 $arr2[$key]=$value;
				 }
				 $arr1=array_pad($arr1,count($arr1)+1,$arr2);
			 }
			 $filesize=cache_write($arr1,$name.'.php');//写缓存---在include/cache.func.php定义的方法
			 if(!@empty($filesize)){
				  if($show_thispage){echo '更新表名为'.$name.'数据缓存成功！<br />';}else{return 1;}
			 }else{
				  if($show_thispage){echo '更新表名为'.$name.'数据缓存失败……<br />';}else{return 0;}
			 }
		  }else{
			 if($show_thispage){echo '数据库里没有表名为'.$name.'信息。<br />';}else{return -1;}
		  }
		  unset($arr);
		}else{
			if($show_thispage){echo '数据库中不存在有表名为'.$name.'的表。<br />';}else{return -1;}
		}
	}
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
	if($method=='table'){
		$name=@trim($name);
		if(empty($name)){
			echo "<script>alert('没有指定要更新的表名称。');window.history.back();</script>";
			exit;
		}else{
			one_table($name);
		}
	}elseif($method=='structure'){//生成所有表信息的缓存
		$arr=$db->tables_fields();
		$filesize=cache_write($arr,'tables.php');//写缓存---在include/cache.func.php定义的方法
		if(!@empty($filesize)){
			echo '更新“数据库表结构”缓存成功！<br>';
		}else{
			echo '更新“数据库表结构”缓存失败……<br>';
		}
		unset($arr);
	}elseif($method=='data'){
		foreach($cache_table_arr as $value){
			 one_table($value);
		}
	}else{
		echo "<script>alert('没有此方法的操作');window.history.back();</script>";
		exit;
	}
   
   
    $db->close();
	unset($db);
	unset($cache_table_arr);
?>