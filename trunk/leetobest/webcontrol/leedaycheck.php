<?php
	@header("Content-type: text/html; charset=utf-8");
	//$m_id=40;//此处没有做页面访问权限的检查

	//require_once 'checkcookie.php';//检查用户账号账号的方法
	require_once '../include/config.php';//声明页面编码以及设置smarty基本设置
	require_once '../include/common.php';//处理接收到的所有数据，有必要的话自动转译和过滤所有数据
	require_once '../include/mysql.php';//包含有操作数据库的所有方法
	//require_once '../include/cache.func.php';//包含有读写缓存操作的方法
	require_once '../include/util.php';//包含有常用的工具方法(获取图片，
	require_once '../db_cache/tables.php';//包含有以数组形式保存的数据库所有表结构信息
	
	//checkcookie(1);

	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息

	/*
	* 销毁变量，释放内存
	*/
	function unsetall(){
		unset($GLOBALS['_POST'],$GLOBALS['demo'],$GLOBALS['method'],$GLOBALS['methods'],$GLOBALS['nowtime'],$GLOBALS['nowuserid'],$GLOBALS['contents_id'],$GLOBALS['pageNo'],$GLOBALS['pageSize'],$GLOBALS['object_page'],$GLOBALS['falg'],$GLOBALS['success'],$GLOBALS['arr'],$GLOBALS['arr1'],$GLOBALS['arr2'],$GLOBALS['arr3'],$GLOBALS['arrcheck1'],$GLOBALS['arrcheck2'],$GLOBALS['arrcheck3'],$GLOBALS['cates_id'],$GLOBALS['htmlsucc'],$GLOBALS['updatehtmlpath'],$GLOBALS['cates_array'],$GLOBALS['i'],$GLOBALS['cates_path'],$GLOBALS['contents_list'],$GLOBALS['szx'],$GLOBALS['mo'],$GLOBALS['contents_id'],$GLOBALS['contents_title'],$GLOBALS['contents_key'],$GLOBALS['contents_desc'],$GLOBALS['contents_content'],$GLOBALS['cates_id'],$GLOBALS['positions_id'],$GLOBALS['contents_images'],$GLOBALS['contents_flashs'],$GLOBALS['contents_videos'],$GLOBALS['contents_downs'],$GLOBALS['contents_status'],$GLOBALS['contents_sort'],$GLOBALS['contents_hits'],$GLOBALS['contents_content'],$GLOBALS['contents_addusersid'],$GLOBALS['contents_addtime'],$GLOBALS['contents_editusersid'],$GLOBALS['contents_edittime'],$GLOBALS['contents_url'],$GLOBALS['contents_resource'],$GLOBALS['contents_remark1'],$GLOBALS['contents_remark2'],$GLOBALS['contents_remark3']);
	}

	     
    //报错的方法，弹出相应语句，并返回上一页面
    function msg_back($msg=""){
		if($msg==""){
			echo "<script>alert('要弹出窗口的语句不能为空');</script>";
		}else{
			unsetall();//销毁所有变量，释放内存
			echo "<script>alert('$msg');window.history.back();</script>";
			exit;
		}
    }
    //报错的方法，弹出相应语句，并跳出到指定页面
    function msg_out($msg="",$path=""){
		if($msg==""){
			echo "<script>alert('要弹出窗口的语句不能为空');</script>";
		}else{
			if($msg==""){
				echo "<script>alert('要跳出的页面路径不能为空');</script>";
			}else{
				unsetall();//销毁所有变量，释放内存
				echo "<script>alert('".$msg."');window.location.href='".$path."';</script>";
				exit;
			}
		}
    }
	/*
	* 最后处理方法
	*/
	$method=@trim($method);
	if(empty($method)){
		msg_back('没有接收到方法，请自觉遵守国家法律法规！');
	}else{
		$methods=array('add','del','update');
		if(!in_array($method,$methods)){
			msg_back('接收到错误的方法".$method."，请自觉遵守国家法律法规！');
		}
	}
	/*
	* 对表单数据的处理
	*/
	//处理表单的模版注释
	$demo="12";//示例注释，此为接收到的一个值
	$demo=@trim($demo);//过滤此值前后的所有空格
	if(strlen($demo)<=0){//计算值的长度是否小于0，判断是否为空
		msg_back('示例中的值没有任何内容');
	}elseif(strlen($demo)<=255){//值的长度是否小于小于数据库规定的长度
		$demo=html($demo);//如果值不为空就过滤一次所有html标记--不过滤'&nbsp;'是util中的方法
		$demo=intval($demo);//将过滤后的值强制转换为整型
		if($demo<2){//判断整型值是否小于制定的值
			msg_back('示例中的值转为数字后，值小于2');
		}
	}else{//长度太长的字符，不予通过
		msg_back('示例中的值太长。');
	}
	/*
	$users_id=@trim($users_id);  
	if(strlen($users_id)<=0){
		msg_back('没有接受到内容编号。');
	}else{
		$users_id=html($users_id);
		$users_id=intval($users_id);
		if($users_id<0){
			msg_back('内容编号不对。');
		}
	}*/
	/*
	* 用于需要指定的操作参数
	*/
	date_default_timezone_set("Asia/Shanghai");//设置时间分区
	$nowtime=date('Y-m-d H:i:s');//得到现在的时间
	$nowuserid=$users_id;

	//删除内容的操作
	if($method=='del'){
		msg_out('目前不支持删除操作。');
	}elseif($method=='add'){
		$shixian=@$trim($shixian);
		if(strlen($shixian)<=0){
			msg_back('时限不允许为空。');
		}elseif(strlen($shixian)<=45){
			$shixian=html($shixian);
			//$shixian=intval($shixian);
			//if($shixian<2){
			//	msg_back('示例中的值转为数字后，值小于2');
			//}
		}else{
			msg_back('时限字符太长了。');
		}
		$title=@$trim($title);
		if(strlen($title)<=0){
			msg_back('任务标题不允许为空。');
		}elseif(strlen($title)<=45){
			$title=html($title);
		}else{
			msg_back('任务标题太长了。');
		}
		$banfa=@$trim($banfa);
		if(strlen($banfa)<=0){
			msg_back('完成办法不允许为空。');
		}elseif(strlen($banfa)<=45){
			$banfa=html($banfa);
		}else{
			msg_back('完成办法太长了。');
		}
		$place=@$trim($place);
		if(strlen($place)<=0){
			msg_back('完成地点不允许为空。');
		}elseif(strlen($place)<=45){
			$place=html($place);
		}else{
			msg_back('完成地点太长了。');
		}
		$xiezhu=@$trim($xiezhu);
		if(strlen($xiezhu)<=0){
			msg_back('完成协助人不允许为空。');
		}elseif(strlen($xiezhu)<=45){
			$xiezhu=html($xiezhu);
		}else{
			msg_back('完成协助人名字太长了。');
		}
		$zhongyao=@$trim($zhongyao);
		if(strlen($zhongyao)<=0){
			msg_back('完成重要不允许为空。');
		}elseif(strlen($zhongyao)<=45){
			$zhongyao=html($zhongyao);
		}else{
			msg_back('完成重要太长了。');
		}
		$jinji=@$trim($jinji);
		if(strlen($jinji)<=0){
			msg_back('完成紧急不允许为空。');
		}elseif(strlen($jinji)<=45){
			$jinji=html($jinji);
		}else{
			msg_back('完成紧急太长了。');
		}
		$tiaojian=@$trim($tiaojian);
		if(strlen($tiaojian)<=0){
			msg_back('完成条件不允许为空。');
		}elseif(strlen($tiaojian)<=45){
			$tiaojian=html($tiaojian);
		}else{
			msg_back('完成条件太长了。');
		}
		$beizhu=@$trim($beizhu);
		if(strlen($beizhu)<=0){
			msg_back('完成备注不允许为空。');
		}elseif(strlen($beizhu)<=45){
			$beizhu=html($beizhu);
		}else{
			msg_back('完成备注太长了。');
		}
		$zongjie=@$trim($zongjie);
		if(strlen($zongjie)<=0){
			msg_back('完成总结不允许为空。');
		}elseif(strlen($zongjie)<=45){
			$zongjie=html($zongjie);
		}else{
			msg_back('完成总结太长了。');
		}
		$zongjietime=@$trim($zongjietime);
		if(strlen($zongjietime)<=0){
			msg_back('完成总结时间不允许为空。');
		}elseif(strlen($zongjietime)<=45){
			$zongjietime=html($zongjietime);
		}else{
			msg_back('完成总结时间太长了。');
		}
		$addren='lee';
		/*
		* 得到表字段名、字段数据类型
		*/
		$arr=array();
		$arr=@cache_read('tables.php');
		if(@empty($arr) || @count($arr)<0){
			echo "<script>alert('请更新表信息缓存。');window.history.back();</script>";
			exit;
		}
		$arr2=$arr['modules'][0];
		array_shift($arr2);
		$arr3=$arr['modules'][1];
		array_shift($arr3);
		$arr1=array($shixian,$title,$banfa,$place,$xiezhu,$zhongyao,$jinji,$tiaojian,$beizhu,$zongjie,$zongjietime,$addren,$addtime,$edittime);
		$flag=$db->selectBool('tguihua',$title,'title','VARCHAR');
		if($flag){
			msg_back('已经存在此标题。');
		}else{
			$succ=$db->insert('tguihua',$arr1,$arr2,$arr3);
			if($succ!==false){
				msg_out('恭喜！添加成功！'.'../web/main/guihua.php');
			}else{
				msg_back('糟糕，插入数据库失败。');
			}
		}
	}elseif($method=='update'){
		msg_back('更新操作');
	}else{
		msg_back('未定义的操作方法。');
	}


?>