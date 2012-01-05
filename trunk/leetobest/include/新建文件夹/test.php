<?php
    include 'config.php';
	include 'mysql.php';
	/*
	* 数据库对象
	*/
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);
	//增加
	/*$arr1=array('你好','123',12.3,1.5,'2010-01-01 12:01:01','2010-01-01 12:01:01',1,2,3,4,21.3,22.4);
	$arr2=array('aaa_name','aaa_pw','aaa_pice','aaa_bt','aaa_1','aaa_2','aaa_3','aaa_4','aaa_5','aaa_6','aaa_7','aaa_8');
	$arr3=array('VARCHAR','TEXT','FLOAT','DOUBLE','DATETIME','TIMESTAMP','TINYINT','TINYINT','INTEGER','BIGINT','DOUBLE','DECIMAL');
	$tablename='aaa';
	$succes=$db->insert($tablename,$arr1,$arr2,$arr3);
	if($succes!==false){
		echo "<br />增加数据成功";
	}else{
		echo "<br />增加数据失败";
	}*/

    //修改----where条件放在数组最后
	/*$arr1=array('你好','123',12.3,1.5,'2010-01-01 12:01:01','2010-01-01 12:01:01',1,2,3,4,21.3,22.4,4);
	$arr2=array('aaa_name','aaa_pw','aaa_pice','aaa_bt','aaa_1','aaa_2','aaa_3','aaa_4','aaa_5','aaa_6','aaa_7','aaa_8','aaa_id');
	$arr3=array('VARCHAR','TEXT','FLOAT','DOUBLE','DATETIME','TIMESTAMP','TINYINT','TINYINT','INTEGER','BIGINT','DOUBLE','DECIMAL','INTEGER');
	$tablename='aaa';
	$succes=$db->update($tablename,$arr1,$arr2,$arr3);
	if($succes!==false){
		echo "<br />修改数据成功";
	}else{
		echo "<br />修改数据失败";
	}*/
    
	//删除
	/*$str1='1';
	$str2='aaa_id';
	$str3='INTEGER';
	$tablename='aaa';
	$succes=$db->delete($tablename,$str1,$str2,$str3);
	if($succes!==false){
		echo "<br />删除数据成功";
	}else{
		echo "<br />删除数据失败";
	}*/
    
	//查找单个
	/*$str1='2';
	$str2='aaa_id';
	$str3='INTEGER';
	$tablename='aaa';
	$back_arr=$db->selectSingle($tablename,$str1,$str2,$str3);
	if(is_array($back_arr)){
		print_r($back_arr);
	}else{
		echo $back_arr;
	}*/

	//判断记录是否存在
    /*$str1='2';
	$str2='aaa_id';
	$str3='INTEGER';
	$tablename='aaa';
	$isExist=$db->selectBool($tablename,$str1,$str2,$str3);
	if($isExist===true){
		echo '存在<br>';
	}else{
		echo '不存在<br>';
	}*/

	//查找多个
    /*$arr1=array();
	$arr2=array();
	$arr3=array();
	$tablename='aaa';
	$back_arr=$db->selectAll($tablename,$arr1,$arr2,$arr3);
	if(is_array($back_arr)){
		print_r($back_arr);
	}else{
		echo $back_arr;
	}*/

	//查找记录条数
    /*$arr1=array();
	$arr2=array();
	$arr3=array();
	$tablename='aaa';
	$num=$db->selectCount($tablename,$arr1,$arr2,$arr3);
	if(is_array($num)){
		print_r($num);
	}else{
		echo $num;
	}*/
    
	//分页查询
	/*$arr1=array();
	$arr2=array();
	$arr3=array();
	$tablename='aaa';
	$order_str='';
	$back_arr=$db->selectPage($tablename,$arr1,$arr2,$arr3,$order_str,0,2);
	if(is_array($back_arr)){
		print_r($back_arr);
	}else{
		echo $back_arr;
	}*/
    
	//查找所有表的字段名
	$back_arr=$db->tables_fields();
	if(is_array($back_arr)){
		print_r($back_arr);
	}else{
		echo $back_arr;
	}


	//关闭数据库
	$db->close();
?>