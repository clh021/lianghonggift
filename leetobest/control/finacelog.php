<?php
   include_once('../admin/leesession.php');
   checkmodules('finacelog');
   include_once('../include/config.php');
   include_once '../include/leecommon.php';
   include_once('../include/mysql.php');
   include_once('../include/cache.func.php');
   @include_once('../db_cache/tables.php');
   include_once('../include/leeutil.php');
   
   $db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);
	/*
	* 销毁变量，释放内存
	*/
	function unsetall(){
		unset($GLOBALS['finacelog_remark1'],$GLOBALS['finacelog_remark2'],$GLOBALS['finacelog_remark3']);
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
		echo "<script>alert('没有方法');window.history.back();</script>";
		exit;
   }else{
	    $methods=array('add','edit','delete');
		if(!in_array($method,$methods)){
		   unset($methods);
           echo "<script>alert('没有".$method."方法');window.history.back();</script>";
		   unset($method);
		   exit;
		}
   }

   if($method=='add'){
	  $arr=array();
      $arr=@cache_read('tables.php');
	  if(@empty($arr) || @count($arr)<0){
          echo "<script>alert('请更新表信息缓存');window.history.back();</script>";
		  exit;
	  }
	  $arr2=$arr['finacelog'][0];
	  array_shift($arr2);
      $arr3=$arr['finacelog'][1];
	  array_shift($arr3);

	  $finacelog_date=@trim($finacelog_date);
	  if(!@empty($finacelog_date) || @strlen($finacelog_date)>0){
          $finacelog_date=html($finacelog_date);
		  if(strlen($finacelog_date)>10){
				$finacelog_date=mysubstr($finacelog_date,10,'UTF-8');
		  }
	  }else{
		  echo "<script>alert('请填写日期。');window.history.back();</script>";
		  exit;
	  }
	  $finacelog_payout=@trim($finacelog_payout);
	  if(!@empty($finacelog_payout) || @strlen($finacelog_payout)>0){
          $finacelog_payout=floatval($finacelog_payout);
	  }else{
		  $finacelog_payout=0;
		}
	  $finacelog_putin=@trim($finacelog_putin);
	  if(!@empty($finacelog_putin) && @strlen($finacelog_putin)>0){
		  $finacelog_putin=floatval($finacelog_putin);
	  }else{
		  $finacelog_putin=0;
		}
	  if($finacelog_payout==0 && $finacelog_putin==0){
		  echo "<script>alert('收入和支出，至少要填写一个。');window.history.back();</script>";
		  exit;
	  }

	  $finacelog_whypay=@trim($finacelog_whypay);
	  if(@empty($finacelog_whypay) || @strlen($finacelog_whypay)<0){
		  $finacelog_whypay='';
	  }else{
		  $finacelog_whypay=html($finacelog_whypay);
	  }
	  $finacelog_whyput=@trim($finacelog_whyput);
	  if(@empty($finacelog_whyput) || @strlen($finacelog_whyput)<0){
		  $finacelog_whyput='';
	  }else{
		  $finacelog_whyput=html($finacelog_whyput);
	  }
	  $finacelog_balance=@trim($finacelog_balance);
	  if(@empty($finacelog_balance) || @strlen($finacelog_balance)<0){
          echo "<script>alert('请填写财务结算');window.history.back();</script>";
		  exit;
	  }else{
		  $finacelog_balance=floatval($finacelog_balance);
	  }

	  $finacelog_sumup=@trim($finacelog_sumup);
	  if(@empty($finacelog_sumup) || @strlen($finacelog_sumup)<0){
		  $finacelog_sumup='';
	  }else{
		  $finacelog_sumup=html($finacelog_sumup);
	  }

	  $finacelog_remark1=@trim($finacelog_remark1);
	  if(@strlen($finacelog_remark1)>0){
          $finacelog_remark1=html($finacelog_remark1);
	  }else{
		  $finacelog_remark1='';
	  }

	  $finacelog_remark2=@trim($finacelog_remark2);
	  if(@strlen($finacelog_remark2)>0){
          $finacelog_remark2=html($finacelog_remark2);
	  }else{
		  $finacelog_remark2='';
	  }

	  $finacelog_remark3=@trim($finacelog_remark3);
	  if(@strlen($finacelog_remark3)>0){
          $finacelog_remark3=html($finacelog_remark3);
	  }else{
		  $finacelog_remark3='';
	  }

	  $arr1=array($nowuserid,$finacelog_payout,$finacelog_whypay,$finacelog_putin,$finacelog_whyput,$finacelog_balance,$finacelog_sumup,$finacelog_date,$nowtime,$finacelog_remark1,$finacelog_remark2,$finacelog_remark3);
	  //print_r($arr1);echo '<hr />';print_r($arr2);echo '<hr />';print_r($arr3);//return;
	  $success=$db->insert('finacelog',$arr1,$arr2,$arr3);
	  if($success!==false){
		  header("Location:../admin/listfinacelog.php");
	  }else{
		  echo "<script>alert('增加财务日志失败。');window.history.back();</script>";
		  exit;
	  }
   }

   /*
   * 后台修改财务日志
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
	  $arr2=$arr['finacelog'][0];//表字段名
      $arr3=$arr['finacelog'][1];//字段数据类型

	  /*
	  * 对表单数据的处理
	  */
	  $finacelog_id=@trim($finacelog_id);
	  if(empty($finacelog_id)){
			 echo "<script>alert('财务日志编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $finacelog_id=(int)$finacelog_id;
			 if($finacelog_id<=0){
				 echo "<script>alert('财务日志编号不对');window.history.back();</script>";
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
	  $finacelog_date=@trim($finacelog_date);
	  if(!@empty($finacelog_date) || @strlen($finacelog_date)>0){
          $finacelog_date=html($finacelog_date);
	  }else{
		  echo "<script>alert('请填写日期。');window.history.back();</script>";
		  exit;
	  }

	  $finacelog_payout=@trim($finacelog_payout);
	  if(!@empty($finacelog_payout) || @strlen($finacelog_payout)>0){
          $finacelog_payout=floatval($finacelog_payout);
	  }else{
		  $finacelog_payout=0;
		}

	  $finacelog_whypay=@trim($finacelog_whypay);
	  if(@empty($finacelog_whypay) || @strlen($finacelog_whypay)<0){
		  $finacelog_whypay='';
	  }else{
		  $finacelog_whypay=html($finacelog_whypay);
	  }
	  $finacelog_putin=@trim($finacelog_putin);
	  if(!@empty($finacelog_putin) && @strlen($finacelog_putin)>0){
		  $finacelog_putin=floatval($finacelog_putin);
	  }else{
		  $finacelog_putin=0;
		}
	  if($finacelog_payout==0 && $finacelog_putin==0){
		  echo "<script>alert('收入和支出，至少要填写一个。');window.history.back();</script>";
		  exit;
	  }
	  $finacelog_whyput=@trim($finacelog_whyput);
	  if(@empty($finacelog_whyput) || @strlen($finacelog_whyput)<0){
		  $finacelog_whyput='';
	  }else{
		  $finacelog_whyput=html($finacelog_whyput);
	  }
	  $finacelog_balance=@trim($finacelog_balance);
	  if(@empty($finacelog_balance) || @strlen($finacelog_balance)<0){
          echo "<script>alert('请填写财务结算');window.history.back();</script>";
		  exit;
	  }else{
		  $finacelog_balance=floatval($finacelog_balance);
	  }

	  $finacelog_sumup=@trim($finacelog_sumup);
	  if(@empty($finacelog_sumup) || @strlen($finacelog_sumup)<0){
		  $finacelog_sumup='';
	  }else{
		  $finacelog_sumup=html($finacelog_sumup);
	  }

	  $finacelog_remark1=@trim($finacelog_remark1);
	  if(@strlen($finacelog_remark1)>0){
          $finacelog_remark1=html($finacelog_remark1);
	  }else{
		  $finacelog_remark1='';
	  }

	  $finacelog_remark2=@trim($finacelog_remark2);
	  if(@strlen($finacelog_remark2)>0){
          $finacelog_remark2=html($finacelog_remark2);
	  }else{
		  $finacelog_remark2='';
	  }

	  $finacelog_remark3=@trim($finacelog_remark3);
	  if(@strlen($finacelog_remark3)>0){
          $finacelog_remark3=html($finacelog_remark3);
	  }else{
		  $finacelog_remark3='';
	  }
	/*
	* 用于需要指定的操作参数
	*/
	date_default_timezone_set("Asia/Shanghai");//设置时间分区
	$nowtime=date('Y-m-d H:i:s');//得到现在的时间
	$nowuserid=$_SESSION['users_id'];

	  $falg=$db->selectBool('finacelog',$finacelog_id,'finacelog_id','INTEGER');
	  if($falg===true){
			$arr1=array($finacelog_id,$nowuserid,$finacelog_payout,$finacelog_whypay,$finacelog_putin,$finacelog_whyput,$finacelog_balance,$finacelog_sumup,$finacelog_date,$nowtime,$finacelog_remark1,$finacelog_remark2,$finacelog_remark3);
			$success=$db->update('finacelog',$arr1,$arr2,$arr3);//修改数据
			if($success!==false){
			  header("Location:../admin/listfinacelog.php?pageNo=$pageNo");
			}else{
			  echo "<script>alert('修改财务日志失败');window.history.back();</script>";
			  exit;
			}
	  }else{
		  echo "<script>alert('该数据已经不存在');window.history.back();</script>";
		  exit;
	  }
   }

   /*
   * 后台删除财务日志
   */
   if($method=='delete'){
	   
			 echo "<script>alert('财务日志不建议删除');window.history.back();</script>";
			 exit;
	  /*
	  * 对传参的处理
	  */
	  $finacelog_id=@trim($finacelog_id);
	  if(empty($finacelog_id)){
			 echo "<script>alert('财务日志编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $finacelog_id=(int)$finacelog_id;
			 if($finacelog_id<=0){
				 echo "<script>alert('财务日志编号不对');window.history.back();</script>";
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

	  $falg=$db->selectBool('finacelog',$finacelog_id,'finacelog_id','INTEGER');//判断记录是否存在
	  if($falg===true){
		  $success=$db->delete('finacelog',$finacelog_id,'finacelog_id','INTEGER');//删除数据
		  if($success!==false){
			  $totalRecord=$db->selectCount('finacelog');//总记录数
			  if($totalRecord>0){
				  $totalPage=ceil($totalRecord / $pageSize);//总页数
				  if($pageNo>$totalPage){
					  $pageNo=$totalPage;
				  }
				  header("Location:../admin/listfinacelog.php?pageNo=$pageNo");
			  }else{
				  header("Location:../admin/listfinacelog.php");
			  }
		  }else{
			  echo "<script>alert('删除财务日志失败');window.history.back();</script>";
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