<?php
   /*
   * 后台对模块的管理
   */
   include_once('../admin/leesession.php');
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
   * 后台增加模块
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
	  $arr2=$arr['modules'][0];//表字段名
	  array_shift($arr2);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
      $arr3=$arr['modules'][1];//字段数据类型
	  array_shift($arr3);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变

	  /*
	  * 对表单数据的处理
	  */
	  $modules_name=@trim($modules_name);
	  if(@empty($modules_name) || @strlen($modules_name)<0){
          echo "<script>alert('请填写中文名');window.history.back();</script>";
		  exit;
	  }else{
          $modules_name=html($modules_name);
	  }

	  $modules_path=@trim($modules_path);
	  if(@empty($modules_path) || @strlen($modules_path)<0){
          echo "<script>alert('请填写英文名');window.history.back();</script>";
		  exit;
	  }else{
          $modules_path=html($modules_path);
	  }

	  $modules_cate=@trim($modules_cate);
	  if(!@empty($modules_cate) && @strlen($modules_cate)>0){
          $modules_cate=html($modules_cate);
	  }else{
          echo "<script>alert('请选择是否启用栏目');window.history.back();</script>";
		  exit;
	  }

	  $modules_channel=@trim($modules_channel);
	  if(!@empty($modules_channel) && @strlen($modules_channel)>0){
          $modules_channel=html($modules_channel);
	  }else{
          echo "<script>alert('请选择所属频道');window.history.back();</script>";
		  exit;
	  }

	  $modules_description=@trim($modules_description);
	  if(@empty($modules_description) || @strlen($modules_description)<0){
		  $modules_description='';
	  }
	  
      $modules_status=@trim($modules_status);
	  if(@empty($modules_status) || @strlen($modules_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $modules_status=helphtml($modules_status);
          $modules_status=intval($modules_status);
		  if($modules_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $modules_sort=@trim($modules_sort);
	  if(@empty($modules_sort) || @strlen($modules_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $modules_sort=helphtml($modules_sort);
          $modules_sort=intval($modules_sort);
		  if($modules_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $modules_remark1=@trim($modules_remark1);
	  if(@strlen($modules_remark1)>0){
          $modules_remark1=html($modules_remark1);
	  }else{
		  $modules_remark1='';
	  }

	  $modules_remark2=@trim($modules_remark2);
	  if(@strlen($modules_remark2)>0){
          $modules_remark1=html($modules_remark2);
	  }else{
		  $modules_remark2='';
	  }

	  $modules_remark3=@trim($modules_remark3);
	  if(@strlen($modules_remark3)>0){
          $modules_remark3=html($modules_remark3);
	  }else{
		  $modules_remark3='';
	  }

		  $modules_addusersid=$nowuserid;
		  $modules_addtime=$nowtime;
		  $modules_editusersid=$nowuserid;
		  $modules_edittime=$nowtime;
	  $arr1=array($modules_name,$modules_path,$modules_cate,$modules_channel,$modules_description,$modules_addusersid,$modules_addtime,$modules_editusersid,$modules_edittime,$modules_sort,$modules_status,$modules_remark1,$modules_remark2,$modules_remark3);
	  //中文名称和英文名称都不允许相同，故作两次判断
	  $flag=$db->selectBool('modules',$modules_name,'modules_name','VARCHAR');
	  $flag1=$db->selectBool('modules',$modules_path,'modules_path','VARCHAR');
	  if($flag===false && $flag1===false){
		  $success=$db->insert('modules',$arr1,$arr2,$arr3);//增加数据
		  if($success!==false){
			  one_table_cache('modules');//更新模块表缓存
			  header("Location:../admin/listModules.php");
		  }else{
			  echo "<script>alert('增加模块失败');window.history.back();</script>";
		      exit;
		  }
	  }else{
		  echo "<script>alert('中文名为".$modules_name."的、或者英文名为".$modules_path."的模块已存在');window.history.back();</script>";
		  exit;
	  } 
   }

   /*
   * 后台修改模块
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
	  $arr2=$arr['modules'][0];//表字段名
      $arr3=$arr['modules'][1];//字段数据类型

	  /*
	  * 对表单数据的处理
	  */
	  $modules_id=@trim($modules_id);
	  if(empty($modules_id)){
			 echo "<script>alert('模块编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $modules_id=(int)$modules_id;
			 if($modules_id<=0){
				 echo "<script>alert('模块编号不对');window.history.back();</script>";
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

	  $modules_name=@trim($modules_name);
	  if(@empty($modules_name) || @strlen($modules_name)<0){
          echo "<script>alert('请填写中文名');window.history.back();</script>";
		  exit;
	  }else{
          $modules_name=html($modules_name);
	  }

	  $modules_path=@trim($modules_path);
	  if(@empty($modules_path) || @strlen($modules_path)<0){
          echo "<script>alert('请填写英文名');window.history.back();</script>";
		  exit;
	  }else{
          $modules_path=html($modules_path);
	  }

	  $modules_cate=@trim($modules_cate);
	  if(!@empty($modules_cate) && @strlen($modules_cate)>0){
          $modules_cate=html($modules_cate);
	  }else{
          echo "<script>alert('请选择是否启用栏目');window.history.back();</script>";
		  exit;
	  }
	  //print_r($_POST);return;
	  $modules_channel=@trim($modules_channel);
	  if(!@empty($modules_channel) && @strlen($modules_channel)>0){
          $modules_channel=html($modules_channel);
	  }else{
          echo "<script>alert('请选择所属频道');window.history.back();</script>";
		  exit;
	  }

	  $modules_description=@trim($modules_description);
	  if(@empty($modules_description) || @strlen($modules_description)<0){
		  $modules_description='';
	  }
	  $modules_addusersid=@trim($modules_addusersid);
	  if(!@empty($modules_addusersid) && @strlen($modules_addusersid)>0){
          $modules_addusersid=html($modules_addusersid);
	  }else{
		  $modules_addusersid='';
	  }
	  $modules_addtime=@trim($modules_addtime);
	  if(!@empty($modules_addtime) && @strlen($modules_addtime)>0){
          $modules_addtime=html($modules_addtime);
	  }else{
		  $modules_addtime='';
	  }
	  
      $modules_status=@trim($modules_status);
	  if(@empty($modules_status) || @strlen($modules_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $modules_status=helphtml($modules_status);
          $modules_status=intval($modules_status);
		  if($modules_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $modules_sort=@trim($modules_sort);
	  if(@empty($modules_sort) || @strlen($modules_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $modules_sort=helphtml($modules_sort);
          $modules_sort=intval($modules_sort);
		  if($modules_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $modules_remark1=@trim($modules_remark1);
	  if(@strlen($modules_remark1)>0){
          $modules_remark1=html($modules_remark1);
	  }else{
		  $modules_remark1='';
	  }

	  $modules_remark2=@trim($modules_remark2);
	  if(@strlen($modules_remark2)>0){
          $modules_remark1=html($modules_remark2);
	  }else{
		  $modules_remark2='';
	  }

	  $modules_remark3=@trim($modules_remark3);
	  if(@strlen($modules_remark3)>0){
          $modules_remark3=html($modules_remark3);
	  }else{
		  $modules_remark3='';
	  }

	  $falg=$db->selectBool('modules',$modules_id,'modules_id','INTEGER');
	  if($falg===true){
		 //中文名称和英文名称都不允许相同，故作两次判断
		 $arr_1=array($modules_name,$modules_id);//注意id在后面
		 $arr_2=array('modules_name','modules_id');
		 $arr_3=array('VARCHAR','INTEGER');
         $flag1=$db->selectBoolByIdName('modules',$arr_1,$arr_2,$arr_3);

		 $arr2_1=array($modules_path,$modules_id);
		 $arr2_2=array('modules_path','modules_id');
		 $arr2_3=array('VARCHAR','INTEGER');
	     $flag2=$db->selectBoolByIdName('modules',$arr2_1,$arr2_2,$arr2_3);
		 if($flag1===false && $flag2===false){
			  $modules_editusersid=$nowuserid;
			  $modules_edittime=$nowtime;
			$arr1=array($modules_id,$modules_name,$modules_path,$modules_cate,$modules_channel,$modules_description,$modules_addusersid,$modules_addtime,$modules_editusersid,$modules_edittime,$modules_sort,$modules_status,$modules_remark1,$modules_remark2,$modules_remark3);
             $success=$db->update('modules',$arr1,$arr2,$arr3);//修改数据
			 if($success!==false){
				  //更新表的缓存
				  one_table_cache('modules',$db);//util中的方法
				  header("Location:../admin/listModules.php?pageNo=$pageNo");
			 }else{
				  echo "<script>alert('修改模块失败');window.history.back();</script>";
				  exit;
			 }
		 }else{
			 echo "<script>alert('中文名为".$modules_name."的、或者英文名为".$modules_path."的模块已存在');window.history.back();</script>";
		     exit;
		 }
	  }else{
		  echo "<script>alert('该数据已经不存在');window.history.back();</script>";
		  exit;
	  }
   }

   /*
   * 后台删除模块
   */
   if($method=='delete'){
			 echo "<script>alert('不建议删除模块，请联系管理员');window.history.back();</script>";
			 exit;
	  /*
	  * 对传参的处理
	  */
	  $modules_id=@trim($modules_id);
	  if(empty($modules_id)){
			 echo "<script>alert('模块编号不允许为空');window.history.back();</script>";
			 exit;
	  }else{
			 $modules_id=(int)$modules_id;
			 if($modules_id<=0){
				 echo "<script>alert('模块编号不对');window.history.back();</script>";
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

	  $falg=$db->selectBool('modules',$modules_id,'modules_id','INTEGER');//判断记录是否存在
	  if($falg===true){
		  $success=$db->delete('modules',$modules_id,'modules_id','INTEGER');//删除数据
		  if($success!==false){
			  one_table_cache('modules',$db);//更新模块表缓存
			  $totalRecord=$db->selectCount('modules');//总记录数
			  if($totalRecord>0){
				  $totalPage=ceil($totalRecord / $pageSize);//总页数
				  if($pageNo>$totalPage){
					  $pageNo=$totalPage;
				  }
				  header("Location:../admin/listModules.php?pageNo=$pageNo");
			  }else{
				  header("Location:../admin/listModules.php");
			  }
		  }else{
			  echo "<script>alert('删除模块失败');window.history.back();</script>";
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