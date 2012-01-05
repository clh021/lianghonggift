<?php
	include_once('config.php');
	include_once('mysql.php');
	include_once('cache.func.php');
	//陈良红封装更新表缓存的方法。
	//参数说明：
	//$name 你要更新缓存的表的名字
	function update_tablecache($name){
		$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
		$arr=$db->selectAll($name,array(),array(),array());
		if(!@empty($arr) && @count($arr)>0){
			$arr1=array();
			for($i=0;$i<count($arr);$i++){
				foreach($arr[$i] as $key => $value){
					if(is_string($key)){
						$arr2[$key]=$value;
					}
				}
					$arr1=array_pad($arr1,count($arr1)+1,$arr2);
			}
			$filesize=cache_write($arr1,$name.'.php');//写缓存---在include_once/cache.func.php定义的方法
			if(!@empty($filesize)){
				return 1;
			}else{
				return 0;
			}
		}else{
			return -1;
		}
	}
?>