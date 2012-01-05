<?php
   /*
   * 后台对频道的管理
   */
   include_once('../admin/leesession.php');
	checkmodules('channels');
   include_once('../include/config.php');
   include_once '../include/leecommon.php';
   include_once('../include/mysql.php');
   include_once('../include/cache.func.php');
   include_once('../db_cache/tables.php');
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
   * 后台增加频道
   */
   if($method=='add'){
	  /*
	  * 得到表字段名、字段数据类型
	  */
	  $arr=array();
      $arr=@cache_read('tables.php');
	  if(@empty($arr) || @count($arr)<0){
          echo "<script>alert('请更新表信息缓存');window.history.back();</script>";
		  exit;
	  }
	  $arr2=$arr['channels'][0];//表字段名
	  array_shift($arr2);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
      $arr3=$arr['channels'][1];//字段数据类型
	  array_shift($arr3);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变

	  /*
	  * 对表单数据的处理
	  */
	  $channels_name=@trim($channels_name);
	  if(@empty($channels_name) || @strlen($channels_name)<0){
          echo "<script>alert('请填写中文名');window.history.back();</script>";
		  exit;
	  }else{
          $channels_name=html($channels_name);
	  }

	  $channels_path=@trim($channels_path);
	  if(@empty($channels_path) || @strlen($channels_path)<0){
          echo "<script>alert('请填写英文名');window.history.back();</script>";
		  exit;
	  }else{
          $channels_path=html($channels_path);
	  }

	  $channels_url=@trim($channels_url);
	  if(!@empty($channels_url) && @strlen($channels_url)>0){
          $channels_url=html($channels_url);
	  }else{
		  $channels_url='';
	  }

	  $channels_description=@trim($channels_description);
	  if(@empty($channels_description) || @strlen($channels_description)<0){
		  $channels_description='';
	  }
	  
      $channels_status=@trim($channels_status);
	  if(@empty($channels_status) || @strlen($channels_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $channels_status=helphtml($channels_status);
          $channels_status=intval($channels_status);
		  if($channels_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $channels_sort=@trim($channels_sort);
	  if(@empty($channels_sort) || @strlen($channels_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $channels_sort=helphtml($channels_sort);
          $channels_sort=intval($channels_sort);
		  if($channels_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $channels_remark1=@trim($channels_remark1);
	  if(@strlen($channels_remark1)>0){
          $channels_remark1=html($channels_remark1);
	  }else{
		  $channels_remark1='';
	  }

	  $channels_remark2=@trim($channels_remark2);
	  if(@strlen($channels_remark2)>0){
          $channels_remark1=html($channels_remark2);
	  }else{
		  $channels_remark2='';
	  }

	  $channels_remark3=@trim($channels_remark3);
	  if(@strlen($channels_remark3)>0){
          $channels_remark3=html($channels_remark3);
	  }else{
		  $channels_remark3='';
	  }

	  $arr1=array($channels_name,$channels_path,$channels_url,$channels_description,$channels_status,$channels_sort,$nowuserid,$nowuserid,$nowtime,$nowtime,$channels_remark1,$channels_remark2,$channels_remark3);
	  //中文名称和英文名称都不允许相同，故作两次判断
	  $flag=$db->selectBool('channels',$channels_name,'channels_name','VARCHAR');
	  $flag1=$db->selectBool('channels',$channels_path,'channels_path','VARCHAR');
	  if($flag===false && $flag1===false){
		  $success=$db->insert('channels',$arr1,$arr2,$arr3);//增加数据
		  if($success!==false){
			  //更新表的缓存
			  one_table_cache('channels',$db);//util中的方法
			  //echo $res_cache;return;
			  header("Location:../admin/listChannels.php");
		  }else{
			  echo "<script>alert('增加频道失败');window.history.back();</script>";
		      exit;
		  }
	  }else{
		  echo "<script>alert('中文名为".$channels_name."的、或者英文名为".$channels_path."的频道已存在');window.history.back();</script>";
		  exit;
	  } 
   }

   /*
   * 后台修改频道
   */
   if($method=='update'){
	  /*
	  * 得到表字段名、字段数据类型
	  */
	  $arr=array();
      $arr=@cache_read('tables.php');
	  if(@empty($arr) || @count($arr)<0){
          echo "<script>alert('请更新表信息缓存');window.history.back();</script>";
		  exit;
	  }
	  $arr2=$arr['channels'][0];//表字段名
      $arr3=$arr['channels'][1];//字段数据类型

	  /*
	  * 对表单数据的处理
	  */
	  $channels_id=@trim($channels_id);
	  if(empty($channels_id)){
			 echo "<script>alert('频道编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $channels_id=(int)$channels_id;
			 if($channels_id<=0){
				 echo "<script>alert('频道编号不对');window.history.back();</script>";
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

	  $channels_name=@trim($channels_name);
	  if(@empty($channels_name) || @strlen($channels_name)<0){
          echo "<script>alert('请填写中文名');window.history.back();</script>";
		  exit;
	  }else{
          $channels_name=html($channels_name);
	  }

	  $channels_path=@trim($channels_path);
	  if(@empty($channels_path) || @strlen($channels_path)<0){
          echo "<script>alert('请填写英文名');window.history.back();</script>";
		  exit;
	  }else{
          $channels_path=html($channels_path);
	  }

	  $channels_url=@trim($channels_url);
	  if(!@empty($channels_url) && @strlen($channels_url)>0){
          $channels_url=html($channels_url);
	  }else{
		  $channels_url='';
	  }

	  $channels_description=@trim($channels_description);
	  if(@empty($channels_description) || @strlen($channels_description)<0){
		  $channels_description='';
	  }
	  
      $channels_status=@trim($channels_status);
	  if(@empty($channels_status) || @strlen($channels_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $channels_status=helphtml($channels_status);
          $channels_status=intval($channels_status);
		  if($channels_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $channels_sort=@trim($channels_sort);
	  if(@empty($channels_sort) || @strlen($channels_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $channels_sort=helphtml($channels_sort);
          $channels_sort=intval($channels_sort);
		  if($channels_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  $channels_adduser=@trim($channels_adduser);
	  if(@strlen($channels_adduser)>0){
          $channels_adduser=html($channels_adduser);
		  $channels_adduser=intval($channels_adduser);
	  }else{
		  echo "<script>alert('未获取到添加者');window.history.back();</script>";
		  exit;
	  }
	  $channels_addtime=@trim($channels_addtime);
	  if(@strlen($channels_addtime)>0){
          $channels_addtime=html($channels_addtime);
	  }else{
		  echo "<script>alert('未获取到添加时间');window.history.back();</script>";
		  exit;
	  }

	  $channels_remark1=@trim($channels_remark1);
	  if(@strlen($channels_remark1)>0){
          $channels_remark1=html($channels_remark1);
	  }else{
		  $channels_remark1='';
	  }

	  $channels_remark2=@trim($channels_remark2);
	  if(@strlen($channels_remark2)>0){
          $channels_remark1=html($channels_remark2);
	  }else{
		  $channels_remark2='';
	  }

	  $channels_remark3=@trim($channels_remark3);
	  if(@strlen($channels_remark3)>0){
          $channels_remark3=html($channels_remark3);
	  }else{
		  $channels_remark3='';
	  }
		$users_id=$nowuserid;
		$channels_edittime=$nowtime;
	  $falg=$db->selectBool('channels',$channels_id,'channels_id','INTEGER');
	  if($falg===true){
		 //中文名称和英文名称都不允许相同，故作两次判断
		 $arr_1=array($channels_name,$channels_id);//注意id在后面
		 $arr_2=array('channels_name','channels_id');
		 $arr_3=array('VARCHAR','INTEGER');
         $flag1=$db->selectBoolByIdName('channels',$arr_1,$arr_2,$arr_3);

		 $arr2_1=array($channels_path,$channels_id);
		 $arr2_2=array('channels_path','channels_id');
		 $arr2_3=array('VARCHAR','INTEGER');
	     $flag2=$db->selectBoolByIdName('channels',$arr2_1,$arr2_2,$arr2_3);
		 if($flag1===false && $flag2===false){
             $arr1=array($channels_id,$channels_name,$channels_path,$channels_url,$channels_description,$channels_status,$channels_sort,$channels_adduser,$users_id,$channels_addtime,$channels_edittime,$channels_remark1,$channels_remark2,$channels_remark3);
             $success=$db->update('channels',$arr1,$arr2,$arr3);//修改数据
			 if($success!==false){
				  //更新表的缓存
				  one_table_cache('channels',$db);//util中的方法
				  //echo $res_cache;return;
				  header("Location:../admin/listChannels.php?pageNo=$pageNo");
			 }else{
				  echo "<script>alert('修改频道失败');window.history.back();</script>";
				  exit;
			 }
		 }else{
			 echo "<script>alert('中文名为".$channels_name."的、或者英文名为".$channels_path."的频道已存在');window.history.back();</script>";
		     exit;
		 }
	  }else{
		  echo "<script>alert('该数据已经不存在');window.history.back();</script>";
		  exit;
	  }
   }

   /*
   * 后台删除频道
   */
   if($method=='delete'){
	   
				 echo "<script>alert('不建议删除频道，请与管理员联系。');window.history.back();</script>";
				 exit;
	  /*
	  * 对传参的处理
	  */
	  $channels_id=@trim($channels_id);
	  if(empty($channels_id)){
			 echo "<script>alert('频道编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $channels_id=(int)$channels_id;
			 if($channels_id<=0){
				 echo "<script>alert('频道编号不对');window.history.back();</script>";
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

	  $falg=$db->selectBool('channels',$channels_id,'channels_id','INTEGER');//判断记录是否存在
	  if($falg===true){
		  $success=$db->delete('channels',$channels_id,'channels_id','INTEGER');//删除数据
		  if($success!==false){
			  //更新表的缓存
			  one_table_cache('channels',$db);//util中的方法
			  //echo $res_cache;return;
			  $totalRecord=$db->selectCount('channels');//总记录数
			  if($totalRecord>0){
				  $totalPage=ceil($totalRecord / $pageSize);//总页数
				  if($pageNo>$totalPage){
					  $pageNo=$totalPage;
				  }
				  header("Location:../admin/listChannels.php?pageNo=$pageNo");
			  }else{
				  header("Location:../admin/listChannels.php");
			  }
		  }else{
			  echo "<script>alert('删除频道失败');window.history.back();</script>";
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