<?php
   include_once('../admin/leesession.php');
	checkmodules('testawoke');
   include_once('../include/config.php');
   include_once '../include/leecommon.php';
   include_once('../include/mysql.php');
   include_once('../include/cache.func.php');
   include_once('../db_cache/tables.php');
   include_once('../include/leeutil.php');

	/*
	* 销毁变量，释放内存
	*/
	function unsetall(){
		unset($GLOBALS['testawoke_remark1'],$GLOBALS['testawoke_remark2'],$GLOBALS['testawoke_remark3']);
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
   $method=@trim($method);
   if(empty($method)){
		  msg_back('没有接收到方法');
   }else{
	    $methods=array('add','edit','delete');
		if(!in_array($method,$methods)){
		  msg_back('没有'.$method.'方法');
		}
   }
   
   $db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);

   if($method=='add'){
	  $arr=array();
      $arr=@cache_read('tables.php');
	  if(@empty($arr) || @count($arr)<0){
		  msg_back('请更新表缓存');
	  }
	  $arr2=$arr['testawoke'][0];
	  array_shift($arr2);
      $arr3=$arr['testawoke'][1];
	  array_shift($arr3);

		$testawoke_date=@trim($testawoke_date);
		if(!@empty($testawoke_date) || @strlen($testawoke_date)>0){
		  $testawoke_date=html($testawoke_date);
		}else{
		  msg_back('请选择提醒时间');
		}
		$testawoke_title=@trim($testawoke_title);
		if(!@empty($testawoke_title) && @strlen($testawoke_title)>0){
		  $testawoke_title=html($testawoke_title);
		}else{
		  msg_back('请填写提醒标题');
		}

	  $testawoke_text=@trim($testawoke_text);
	  if(@empty($testawoke_text) || @strlen($testawoke_text)<0){
		  msg_back('请填写提醒内容');
	  }else{
		  $testawoke_text=html($testawoke_text);
	  }
	  $testawoke_sort=@trim($testawoke_sort);
	  if(@empty($testawoke_sort) || @strlen($testawoke_sort)<0){
		  msg_back('请填写重要级别');
	  }else{
		  $testawoke_sort=html($testawoke_sort);
		  $testawoke_sort=intval($testawoke_sort);
	  }
	  /*
	  $testawoke_status=@trim($testawoke_status);
	  if(@empty($testawoke_status) || @strlen($testawoke_status)<0){
		  msg_back('请填写提醒状态');
	  }else{
		  $testawoke_status=html($testawoke_status);
		  $testawoke_status=intval($testawoke_status);
	  }
	  */
	  //本程序是添加时候统一为未完成状态
	  $testawoke_status=1;

	  $testawoke_remark1=@trim($testawoke_remark1);
	  if(@strlen($testawoke_remark1)>0){
          $testawoke_remark1=html($testawoke_remark1);
	  }else{
		  $testawoke_remark1='';
	  }

	  $testawoke_remark2=@trim($testawoke_remark2);
	  if(@strlen($testawoke_remark2)>0){
          $testawoke_remark2=html($testawoke_remark2);
	  }else{
		  $testawoke_remark2='';
	  }

	  $testawoke_remark3=@trim($testawoke_remark3);
	  if(@strlen($testawoke_remark3)>0){
          $testawoke_remark3=html($testawoke_remark3);
	  }else{
		  $testawoke_remark3='';
	  }

	  $arr1=array($nowuserid,$testawoke_date,$testawoke_title,$testawoke_text,$nowtime,$nowtime,$testawoke_sort,$testawoke_status,$testawoke_remark1,$testawoke_remark2,$testawoke_remark3);
	  //print_r($arr1);echo '<hr />';print_r($arr2);echo '<hr />';print_r($arr3);return;
	  $success=$db->insert('testawoke',$arr1,$arr2,$arr3);
	  if($success!==false){
		  header("Location:../admin/listtestawoke.php");
	  }else{
		  echo "<script>alert('增加任务提醒失败。');window.history.back();</script>";
		  exit;
	  }
   }

   /*
   * 后台修改任务提醒
   */
   if($method=='edit'){
	  /*
	  * 得到表字段名、字段数据类型
	  */
	  $arr=array();
      $arr=@cache_read('tables.php');
	  if(@empty($arr) || @count($arr)<0){
          echo "<script>alert('请更新表信息缓存');window.history.back();</script>";
		  exit;
	  }
	  $arr2=$arr['testawoke'][0];//表字段名
      $arr3=$arr['testawoke'][1];//字段数据类型

	  /*
	  * 对表单数据的处理
	  */
	  $testawoke_id=@trim($testawoke_id);
	  if(empty($testawoke_id)){
			 echo "<script>alert('任务提醒编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $testawoke_id=(int)$testawoke_id;
			 if($testawoke_id<=0){
				 echo "<script>alert('任务提醒编号不对');window.history.back();</script>";
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
		$user_id=@trim($user_id);
		if(!@empty($user_id) && @strlen($user_id)>0){
		  $user_id=html($user_id);
		}else{
		  msg_back('未获取到用户编号');
		}

		$testawoke_date=@trim($testawoke_date);
		if(!@empty($testawoke_date) || @strlen($testawoke_date)>0){
		  $testawoke_date=html($testawoke_date);
		}else{
		  msg_back('请选择提醒时间');
		}
		$testawoke_title=@trim($testawoke_title);
		if(!@empty($testawoke_title) && @strlen($testawoke_title)>0){
		  $testawoke_title=html($testawoke_title);
		}else{
		  msg_back('请填写提醒标题');
		}

	  $testawoke_text=@trim($testawoke_text);
	  if(@empty($testawoke_text) || @strlen($testawoke_text)<0){
		  msg_back('请填写提醒内容');
	  }else{
		  $testawoke_text=html($testawoke_text);
	  }
	  $testawoke_addtime=@trim($testawoke_addtime);
	  if(@empty($testawoke_addtime) || @strlen($testawoke_addtime)<0){
		  msg_back('未获取到添加时间');
	  }else{
		  $testawoke_text=html($testawoke_text);
	  }
	  $testawoke_sort=@trim($testawoke_sort);
	  if(@empty($testawoke_sort) || @strlen($testawoke_sort)<0){
		  msg_back('请填写重要级别');
	  }else{
		  $testawoke_sort=html($testawoke_sort);
		  $testawoke_sort=intval($testawoke_sort);
	  }
	  $testawoke_status=@trim($testawoke_status);
	  if(@empty($testawoke_status) || @strlen($testawoke_status)<0){
		  msg_back('请填写提醒状态');
	  }else{
		  $testawoke_status=html($testawoke_status);
		  $testawoke_status=intval($testawoke_status);
	  }

	  $testawoke_remark1=@trim($testawoke_remark1);
	  if(@strlen($testawoke_remark1)>0){
          $testawoke_remark1=html($testawoke_remark1);
	  }else{
		  $testawoke_remark1='';
	  }

	  $testawoke_remark2=@trim($testawoke_remark2);
	  if(@strlen($testawoke_remark2)>0){
          $testawoke_remark2=html($testawoke_remark2);
	  }else{
		  $testawoke_remark2='';
	  }

	  $testawoke_remark3=@trim($testawoke_remark3);
	  if(@strlen($testawoke_remark3)>0){
          $testawoke_remark3=html($testawoke_remark3);
	  }else{
		  $testawoke_remark3='';
	  }
	  $falg=$db->selectBool('testawoke',$testawoke_id,'testawoke_id','INTEGER');
	  if($falg===true){
			$arr1=array($testawoke_id,$nowuserid,$testawoke_date,$testawoke_title,$testawoke_text,$testawoke_addtime,$nowtime,$testawoke_sort,$testawoke_status,$testawoke_remark1,$testawoke_remark2,$testawoke_remark3);
            $success=$db->update('testawoke',$arr1,$arr2,$arr3);//修改数据
			if($success!==false){
				header("Location:../admin/listtestawoke.php?pageNo=$pageNo");
			}else{
				msg_back('修改任务提醒失败');
			}
	  }else{
			msg_back('该数据已经不存在');
	  }
   }

   /*
   * 后台删除任务提醒
   */
   if($method=='delete'){
			msg_back('不建议删除任务提醒，请与管理员联系');
	  /*
	  * 对传参的处理
	  */
	  $testawoke_id=@trim($testawoke_id);
	  if(empty($testawoke_id)){
			 echo "<script>alert('任务提醒编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $testawoke_id=(int)$testawoke_id;
			 if($testawoke_id<=0){
				 echo "<script>alert('任务提醒编号不对');window.history.back();</script>";
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

	  $falg=$db->selectBool('testawoke',$testawoke_id,'testawoke_id','INTEGER');//判断记录是否存在
	  if($falg===true){
		  $success=$db->delete('testawoke',$testawoke_id,'testawoke_id','INTEGER');//删除数据
		  if($success!==false){
			  $totalRecord=$db->selectCount('testawoke');//总记录数
			  if($totalRecord>0){
				  $totalPage=ceil($totalRecord / $pageSize);//总页数
				  if($pageNo>$totalPage){
					  $pageNo=$totalPage;
				  }
				  header("Location:../admin/listtestawoke.php?pageNo=$pageNo");
			  }else{
				  header("Location:../admin/listtestawoke.php");
			  }
		  }else{
			  echo "<script>alert('删除任务提醒失败');window.history.back();</script>";
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