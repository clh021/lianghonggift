<?php
	@header("content-type:text/html;charset=utf-8");
	require_once '../include/config.php';//声明页面编码以及设置smarty基本设置
	
	//$pageNo=@$_REQUEST['pageNo'];
	//$pageNo=intval($pageNo);
	//if($pageNo<=0){
	//	$pageNo=1;
	//}
	//$pagesize=@$_REQUEST['pagesize'];
	//$pagesize=intval($pagesize);
	//if($pagesize<1){
	//	$pagesize=5;
	//}

	//$dblink=mysql_connect('localhost','root','clhleehom');
	//mysql_select_db('leetobest',$dblink);
	//mysql_query('SET NAMES "utf8"');

	//$succ=mysql_query("select * from users");
	//$result=mysql_fetch_array($succ,MYSQL_BOTH);
	//for($i=0;$i<count($result);$i++){
	//	echo '<>';
	//}

	$listhtmls=scandir(FILE_PATH.date('Y').'/blogs');
	for($i=2;$i<count($listhtmls);$i++){
		echo $listhtmls[$i].'<br />';
	}
	echo '<hr />';
	$listhtmls=scandir(FILE_PATH.date('Y').'/news');
	print_r($listhtmls);



?>