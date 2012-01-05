<?php
   include_once('../admin/leesession.php');
	checkmodules('cates');
   include_once('../include/config.php');
   include_once('../include/leecommon.php');
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
   * 后台增加地区
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
	  $arr2=$arr['cates'][0];//表字段名
	  array_shift($arr2);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
      $arr3=$arr['cates'][1];//字段数据类型
	  array_shift($arr3);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变

	  /*
	  * 对表单数据的处理
	  */

      $modules_id=@trim($modules_id);
	  if(@empty($modules_id) || @strlen($modules_id)<0){
          echo "<script>alert('请选择所属模块。');window.history.back();</script>";
		  exit;
	  }else{
          $modules_id=html($modules_id);
		  $modules_id=intval($modules_id);
		  $sql='SELECT * FROM modules WHERE modules_status=1 AND modules_cate=1 AND modules_id='.$modules_id;
		  $res=mysql_query($sql);
		  $count=mysql_num_rows($res);
		  if($count<1){
			echo "<script>alert('该模块没有启用栏目功能，请设置或更新缓存，重试……');window.history.back();</script>";
			exit;
		  }
	  }
      $cates_name=@trim($cates_name);
	  if(@empty($cates_name) || @strlen($cates_name)<0){
          echo "<script>alert('请填写名称');window.history.back();</script>";
		  exit;
	  }else{
          $cates_name=html($cates_name);
	  }
      $cates_path=@trim($cates_path);
	  if(@empty($cates_path) || @strlen($cates_path)<0){
          echo "<script>alert('请填写路径');window.history.back();</script>";
		  exit;
	  }else{
          $cates_path=html($cates_path);
	  }
      $cates_key=@trim($cates_key);
	  if(@empty($cates_key) || @strlen($cates_key)<0){
          echo "<script>alert('请填写关键字');window.history.back();</script>";
		  exit;
	  }else{
          $cates_key=html($cates_key);
	  }
      $cates_des=@trim($cates_des);
	  if(@empty($cates_des) || @strlen($cates_des)<0){
          echo "<script>alert('请填写描述');window.history.back();</script>";
		  exit;
	  }else{
          $cates_des=html($cates_des);
	  }
      $cates_content=@trim($cates_content);
	  if(@empty($cates_content) || @strlen($cates_content)<0){
          echo "<script>alert('请填写名称');window.history.back();</script>";
		  exit;
	  }else{
          $cates_content=html($cates_content);
	  }

      $cates_parentid=@trim($cates_parentid);
	  if($cates_parentid==null || @strlen($cates_parentid)<0){
          echo "<script>alert('请选择上一级');window.history.back();</script>";
		  exit;
	  }else{
          $cates_parentid=helphtml($cates_parentid);
          $cates_parentid=intval($cates_parentid);
		  if($cates_parentid<0){
              echo "<script>alert('上一级值不对');window.history.back();</script>";
		      exit;
		  }
	  }
      $cates_all_parentid=@trim($cates_all_parentid);
	  if($cates_all_parentid==null || @strlen($cates_all_parentid)<0){
          //echo "<script>alert('请选择上一级');window.history.back();</script>";
		  //exit;
	  }else{
          $cates_all_parentid=helphtml($cates_all_parentid);
	  }

      $cates_parent_dir=@trim($cates_parent_dir);
	  if($cates_parent_dir==null || @strlen($cates_parent_dir)<0){
          //echo "<script>alert('请选择上一级');window.history.back();</script>";
		  //exit;
	  }else{
          $cates_parent_dir=helphtml($cates_parent_dir);
          //$cates_parent_dir=intval($cates_parent_dir);
		  //if($cates_parent_dir<0){
          //    echo "<script>alert('父路径不对');window.history.back();</script>";
		  //    exit;
		  //}
	  }
      $cates_all_parent_dir=@trim($cates_all_parent_dir);
	  if($cates_all_parent_dir==null || @strlen($cates_all_parent_dir)<0){
          //echo "<script>alert('请选择上一级');window.history.back();</script>";
		  //exit;
	  }else{
          $cates_all_parent_dir=helphtml($cates_all_parent_dir);
          //$cates_all_parent_dir=intval($cates_all_parent_dir);
		  //if($cates_all_parent_dir<0){
          //    echo "<script>alert('全夫路径不对');window.history.back();</script>";
		  //    exit;
		  //}
	  }
      $cates_child=@trim($cates_child);
	  if($cates_child==null || @strlen($cates_child)<0){
          //echo "<script>alert('请选择上一级');window.history.back();</script>";
		  //exit;
	  }else{
          $cates_child=helphtml($cates_child);
          //$cates_child=intval($cates_child);
		  //if($cates_child<0){
          //    echo "<script>alert('子ID不对');window.history.back();</script>";
		  //    exit;
		  //}
	  }
      $cates_all_children=@trim($cates_all_children);
	  if($cates_all_children==null || @strlen($cates_all_children)<0){
          //echo "<script>alert('请选择子全路径');window.history.back();</script>";
		  //exit;
	  }else{
          $cates_all_children=helphtml($cates_all_children);
          //$cates_all_parent_dir=intval($cates_all_parent_dir);
		  //if($cates_all_parent_dir<0){
          //    echo "<script>alert('点击率值不对');window.history.back();</script>";
		  //    exit;
		  //}
	  }
	  $cates_hits=@trim($cates_hits);
	  if($cates_hits==null || @strlen($cates_hits)<0){
          echo "<script>alert('请填写点击率');window.history.back();</script>";
		  exit;
	  }else{
          $cates_hits=helphtml($cates_hits);
          $cates_hits=intval($cates_hits);
		  if($cates_hits<0){
              echo "<script>alert('点击率值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  //$cates_hits=0;

	  //$cates_items=@trim($cates_items);
	 // if(@strlen($cates_items)>0){
      //    $cates_items=html($cates_items);
	  //}else{
		  $cates_items=0;
	  //}
	  $cates_images=@trim($cates_images);
	  if(@strlen($cates_images)>0){
          $cates_images=html($cates_images);
	  }else{
		  $cates_images='';
	  }
	  $cates_flashs=@trim($cates_flashs);
	  if(@strlen($cates_flashs)>0){
          $cates_flashs=html($cates_flashs);
	  }else{
		  $cates_flashs='';
	  }
	  $cates_videos=@trim($cates_videos);
	  if(@strlen($cates_videos)>0){
          $cates_videos=html($cates_videos);
	  }else{
		  $cates_videos='';
	  }
	  $cates_downs=@trim($cates_downs);
	  if(@strlen($cates_downs)>0){
          $cates_downs=html($cates_downs);
	  }else{
		  $cates_downs='';
	  }
	  $cates_type=@trim($cates_type);
	  if(@strlen($cates_type)>0){
          $cates_type=html($cates_type);
	  }else{
		  $cates_type='';
	  }

	  $cates_url=@trim($cates_url);
	  if(@strlen($cates_url)>0){
          $cates_url=html($cates_url);
	  }else{
		  $cates_url='';
	  }
	  $cates_nav=@trim($cates_nav);
	  if(@strlen($cates_nav)>0){
          $cates_nav=html($cates_nav);
          $cates_nav=intval($cates_nav);
	  }else{
		  $cates_nav=2;
	  }

      $cates_status=@trim($cates_status);
	  if(@empty($cates_status) || @strlen($cates_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $cates_status=helphtml($cates_status);
          $cates_status=intval($cates_status);
		  if($cates_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $cates_sort=@trim($cates_sort);
	  if(@empty($cates_sort) || @strlen($cates_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $cates_sort=helphtml($cates_sort);
          $cates_sort=intval($cates_sort);
		  if($cates_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  $cates_addusersid=$nowuserid;
	  $cates_addtime=$nowtime;
	  $cates_editusersid=$nowuserid;
	  $cates_edittime=$nowtime;

	  $cates_remark1=@trim($cates_remark1);
	  if(@strlen($cates_remark1)>0){
          $cates_remark1=html($cates_remark1);
	  }else{
		  $cates_remark1='';
	  }

	  $cates_remark2=@trim($cates_remark2);
	  if(@strlen($cates_remark2)>0){
          $cates_remark1=html($cates_remark2);
	  }else{
		  $cates_remark2='';
	  }

	  $cates_remark3=@trim($cates_remark3);
	  if(@strlen($cates_remark3)>0){
          $cates_remark3=html($cates_remark3);
	  }else{
		  $cates_remark3='';
	  }
      
	  /*
	  * 对数据库的操作
	  */ 
		  //准备优化的一个方法，就是这些字段是从缓存当中获取的，使用变量的变量来得到
	  //$arr1=array($modules_id,$cates_name,$cates_path,$cates_key,$cates_des,$cates_content,$cates_parentid,$cates_all_parentid,$cates_parent_dir,$cates_all_parent_dir,$cates_child,$chil$cates_hits,$cates_items,$cates_images,$cates_flashs,$cates_videos,$cates_downs,$cates_type,$cates_url,$cates_status,$cates_sort,$cates_addusersid,$cates_addtime,$cates_editusersid,$cates_edittime,$cates_remark1,$cates_remark2,$cates_remark3);
		$arr1=array();
		foreach($arr2 as &$value){
			array_push($arr1,$$value);
		}
		//print_r($arr1);return;
	  $arr_1=array($modules_id,$cates_name,$cates_parentid);
	  $arr_2=array('modules_id','cates_name','cates_parentid');
	  $arr_3=array('INTEGER','VARCHAR','INTEGER');
	  $flag=$db->selectBool_F('cates',$arr_1,$arr_2,$arr_3);
	  if($flag===false ){
		  if($cates_parentid!=0){
			  $falg1=$db->selectBool('cates',$cates_parentid,'cates_id','INTEGER');
              if($falg1===true){
				  $success=$db->insert('cates',$arr1,$arr2,$arr3);//增加数据
				  if($success!==false){
					  ////修改上一级有关子级的信息
					  //$arr_1=array($cates_parentid,2);
					  //$arr_2=array('cates_id','cates_child');
					  //$arr_3=array('INTEGER','INTEGER');
					  //$succ=$db->update('cates',$arr_1,$arr_2,$arr_3);
					  //if($succ!==false){
						   /*
						   * 更新栏目的缓存
						   */
						   include_once('../include/cache.func.php');
						   $arr_db=$db->selectAll('cates',array(),array(),array());
						   if(!@empty($arr_db) && @count($arr_db)>0){
							  $arr1_db=array();
							  for($i=0;$i<count($arr_db);$i++){
								 foreach($arr_db[$i] as $key => $value){
									 if(is_string($key)){
										 $arr2_db[$key]=$value;
									 }
								 }
								 $arr1_db=array_pad($arr1_db,count($arr1_db)+1,$arr2_db);
							  }
							 
							  $filesize=cache_write($arr1_db,'cates.php');//写缓存---在include_once/cache.func.php定义的方法
						   }

                           header("Location:../admin/listcates.php");
					  //}else{
					//	  echo "<script>alert('修改上一级栏目失败');window.history.back();</script>";
					//      exit;
					//  }
				  }else{
					  //echo "<script>alert('增加栏目失败');window.history.back();</script>";
					  //exit;
				  }
			  }else{
				  echo "<script>alert('上一级已经不存在了');window.history.back();</script>";
				  exit;
			  }
		  }else{
              $success=$db->insert('cates',$arr1,$arr2,$arr3);//增加数据
			  if($success!==false){
				  /*
			      * 更新地区的缓存
			      */
			      include_once('../include/cache.func.php');
				  $arr_db=$db->selectAll('cates',array(),array(),array());
				  if(!@empty($arr_db) && @count($arr_db)>0){
					 $arr1_db=array();
					 for($i=0;$i<count($arr_db);$i++){
						foreach($arr_db[$i] as $key => $value){
							 if(is_string($key)){
								 $arr2_db[$key]=$value;
							 }
						}
						$arr1_db=array_pad($arr1_db,count($arr1_db)+1,$arr2_db);
					 }
					 
					 $filesize=cache_write($arr1_db,'cates.php');//写缓存---在include_once/cache.func.php定义的方法
				  }

				  header("Location:../admin/listcates.php");
			  }else{
				  echo "<script>alert('增加栏目失败');window.history.back();</script>";
				  exit;
			  }
		  }
	  }else{
		  echo "<script>alert('该级别下，名称为".$cates_name."的栏目已存在');window.history.back();</script>";
		  exit;
	  }
   }

















   /*
   * 后台修改地区
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
	  $arr2=$arr['cates'][0];//表字段名
      $arr3=$arr['cates'][1];//字段数据类型

	  /*
	  * 对表单数据的处理
	  */
      $cates_id=@trim($cates_id);
	  if(@empty($cates_id) || @strlen($cates_id)<0){
          echo "<script>alert('没有接收到要操作对象的ID。');window.history.back();</script>";
		  exit;
	  }else{
          $cates_id=html($cates_id);
		  $cates_id=intval($cates_id);
		  if($cates_id<=0){
			echo "<script>alert('该对象ID不对，请重试……');window.history.back();</script>";
			exit;
		  }
	  }

      $modules_id=@trim($modules_id);
	  if(@empty($modules_id) || @strlen($modules_id)<0){
          echo "<script>alert('请选择所属模块。');window.history.back();</script>";
		  exit;
	  }else{
          $modules_id=html($modules_id);
		  $modules_id=intval($modules_id);
		  $sql='SELECT * FROM modules WHERE modules_status=1 AND modules_cate=1 AND modules_id='.$modules_id;
		  $res=mysql_query($sql);
		  $count=mysql_num_rows($res);
		  if($count<1){
			echo "<script>alert('该模块没有启用栏目功能，请设置或更新缓存，重试……');window.history.back();</script>";
			exit;
		  }
	  }
      $cates_name=@trim($cates_name);
	  if(@empty($cates_name) || @strlen($cates_name)<0){
          echo "<script>alert('请填写名称');window.history.back();</script>";
		  exit;
	  }else{
          $cates_name=html($cates_name);
	  }
      $cates_path=@trim($cates_path);
	  if(@empty($cates_path) || @strlen($cates_path)<0){
          echo "<script>alert('请填写路径');window.history.back();</script>";
		  exit;
	  }else{
          $cates_path=html($cates_path);
	  }
      $cates_key=@trim($cates_key);
	  if(@empty($cates_key) || @strlen($cates_key)<0){
          echo "<script>alert('请填写关键字');window.history.back();</script>";
		  exit;
	  }else{
          $cates_key=html($cates_key);
	  }
      $cates_des=@trim($cates_des);
	  if(@empty($cates_des) || @strlen($cates_des)<0){
          echo "<script>alert('请填写描述');window.history.back();</script>";
		  exit;
	  }else{
          $cates_des=html($cates_des);
	  }
      $cates_content=@trim($cates_content);
	  if(@empty($cates_content) || @strlen($cates_content)<0){
          echo "<script>alert('请填写名称');window.history.back();</script>";
		  exit;
	  }else{
          $cates_content=html($cates_content);
	  }

      $cates_parentid=@trim($cates_parentid);
	  if($cates_parentid==null || @strlen($cates_parentid)<0){
          echo "<script>alert('请选择上一级');window.history.back();</script>";
		  exit;
	  }else{
          $cates_parentid=helphtml($cates_parentid);
          $cates_parentid=intval($cates_parentid);
		  if($cates_parentid<0){
              echo "<script>alert('上一级值不对');window.history.back();</script>";
		      exit;
		  }
	  }
      $cates_all_parentid=@trim($cates_all_parentid);
	  if($cates_all_parentid==null || @strlen($cates_all_parentid)<0){
      //    echo "<script>alert('请选择上一级');window.history.back();</script>";
		//  exit;
	  }else{
          $cates_all_parentid=helphtml($cates_all_parentid);
	  }

      $cates_parent_dir=@trim($cates_parent_dir);
	  if($cates_parent_dir==null || @strlen($cates_parent_dir)<0){
      //    echo "<script>alert('请选择上一级');window.history.back();</script>";
	//	  exit;
	  }else{
          $cates_parent_dir=helphtml($cates_parent_dir);
          $cates_parent_dir=intval($cates_parent_dir);
		  if($cates_parent_dir<0){
              echo "<script>alert('点击率值不对');window.history.back();</script>";
		      exit;
		  }
	  }
      $cates_all_parent_dir=@trim($cates_all_parent_dir);
	  if($cates_all_parent_dir==null || @strlen($cates_all_parent_dir)<0){
      //    echo "<script>alert('请选择上一级');window.history.back();</script>";
	//	  exit;
	  }else{
          $cates_all_parent_dir=helphtml($cates_all_parent_dir);
          $cates_all_parent_dir=intval($cates_all_parent_dir);
		  if($cates_all_parent_dir<0){
              echo "<script>alert('点击率值不对');window.history.back();</script>";
		      exit;
		  }
	  }
      $cates_child=@trim($cates_child);
	  if($cates_child==null || @strlen($cates_child)<0){
          //echo "<script>alert('请选择上一级');window.history.back();</script>";
		  //exit;
	  }else{
          $cates_child=helphtml($cates_child);
          //$cates_child=intval($cates_child);
		  //if($cates_child<0){
          //    echo "<script>alert('子ID不对');window.history.back();</script>";
		  //    exit;
		  //}
	  }
      $cates_all_children=@trim($cates_all_children);
	  if($cates_all_children==null || @strlen($cates_all_children)<0){
          //echo "<script>alert('请选择子全路径');window.history.back();</script>";
		  //exit;
	  }else{
          $cates_all_children=helphtml($cates_all_children);
          //$cates_all_parent_dir=intval($cates_all_parent_dir);
		  //if($cates_all_parent_dir<0){
          //    echo "<script>alert('点击率值不对');window.history.back();</script>";
		  //    exit;
		  //}
	  }
	  $cates_hits=@trim($cates_hits);
	  if($cates_hits==null || @strlen($cates_hits)<0){
          echo "<script>alert('请填写点击率');window.history.back();</script>";
		  exit;
	  }else{
          $cates_hits=helphtml($cates_hits);
          $cates_hits=intval($cates_hits);
		  if($cates_hits<0){
              echo "<script>alert('点击率值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $cates_items=@trim($cates_items);
	  if(@strlen($cates_items)>0){
          $cates_items=html($cates_items);
	  }else{
		  $cates_items=0;
	  }
	  $cates_images=@trim($cates_images);
	  if(@strlen($cates_images)>0){
          $cates_images=html($cates_images);
	  }else{
		  $cates_images='';
	  }
	  $cates_flashs=@trim($cates_flashs);
	  if(@strlen($cates_flashs)>0){
          $cates_flashs=html($cates_flashs);
	  }else{
		  $cates_flashs='';
	  }
	  $cates_videos=@trim($cates_videos);
	  if(@strlen($cates_videos)>0){
          $cates_videos=html($cates_videos);
	  }else{
		  $cates_videos='';
	  }
	  $cates_downs=@trim($cates_downs);
	  if(@strlen($cates_downs)>0){
          $cates_downs=html($cates_downs);
	  }else{
		  $cates_downs='';
	  }
	  $cates_type=@trim($cates_type);
	  if(@strlen($cates_type)>0){
          $cates_type=html($cates_type);
	  }else{
		  $cates_type='';
	  }

	  $cates_url=@trim($cates_url);
	  if(@strlen($cates_url)>0){
          $cates_url=html($cates_url);
	  }else{
		  $cates_url='';
	  }
	  $cates_nav=@trim($cates_nav);
	  if(@strlen($cates_nav)>0){
          $cates_nav=html($cates_nav);
          $cates_nav=intval($cates_nav);
	  }else{
		  $cates_nav=2;
	  }

      $cates_status=@trim($cates_status);
	  if(@empty($cates_status) || @strlen($cates_status)<0){
          echo "<script>alert('请选择状态');window.history.back();</script>";
		  exit;
	  }else{
          $cates_status=helphtml($cates_status);
          $cates_status=intval($cates_status);
		  if($cates_status<=0){
              echo "<script>alert('状态值不对');window.history.back();</script>";
		      exit;
		  }
	  }

	  $cates_sort=@trim($cates_sort);
	  if(@empty($cates_sort) || @strlen($cates_sort)<0){
          echo "<script>alert('请选择排序');window.history.back();</script>";
		  exit;
	  }else{
          $cates_sort=helphtml($cates_sort);
          $cates_sort=intval($cates_sort);
		  if($cates_sort<=0){
              echo "<script>alert('排序值不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  $cates_addusersid=@trim($cates_addusersid);
	  if(@empty($cates_addusersid) || @strlen($cates_addusersid)<0){
          echo "<script>alert('没有获取到添加者');window.history.back();</script>";
		  exit;
	  }else{
          $cates_addusersid=helphtml($cates_addusersid);
          $cates_addusersid=intval($cates_addusersid);
		  if($cates_addusersid<=0){
              echo "<script>alert('添加者不对');window.history.back();</script>";
		      exit;
		  }
	  }
	  $cates_addtime=@trim($cates_addtime);
	  if(@empty($cates_addtime) || @strlen($cates_addtime)<0){
          echo "<script>alert('没有获取到添加时间');window.history.back();</script>";
		  exit;
	  }else{
          $cates_addtime=helphtml($cates_addtime);
	  }
	  $cates_editusersid=$nowuserid;
	  $cates_edittime=$nowtime;

	  $cates_remark1=@trim($cates_remark1);
	  if(@strlen($cates_remark1)>0){
          $cates_remark1=html($cates_remark1);
	  }else{
		  $cates_remark1='';
	  }

	  $cates_remark2=@trim($cates_remark2);
	  if(@strlen($cates_remark2)>0){
          $cates_remark1=html($cates_remark2);
	  }else{
		  $cates_remark2='';
	  }

	  $cates_remark3=@trim($cates_remark3);
	  if(@strlen($cates_remark3)>0){
          $cates_remark3=html($cates_remark3);
	  }else{
		  $cates_remark3='';
	  }
      
	  /*
	  * 对数据库的操作
	  */
	  //$arr1=array($cates_id,$modules_id,$cates_name,$cates_path,$cates_key,$cates_des,$cates_content,$cates_parentid,$cates_all_parentid,$cates_parent_dir,$cates_all_parent_dir,$cates_hits,$cates_items,$cates_images,$cates_flashs,$cates_videos,$cates_downs,$cates_type,$cates_url,$cates_status,$cates_sort,$cates_addusersid,$cates_addtime,$cates_editusersid,$cates_edittime,$cates_remark1,$cates_remark2,$cates_remark3);
		$arr1=array();
		foreach($arr2 as &$value){
			array_push($arr1,$$value);
		}
	  $flag=$db->selectBool('cates',$cates_id,'cates_id','INTEGER');
	  if($flag===true ){
		  $arr2_1=array($modules_id,$cates_path,$cates_parentid,$cates_id);
		  $arr2_2=array('modules_id','cates_path','cates_parentid','cates_id');
		  $arr2_3=array('VARCHAR','INTEGER','INTEGER');
	      $flag1=$db->selectBoolByIdName('cates',$arr2_1,$arr2_2,$arr2_3);
		  if($flag1===false){
               if($cates_parentid!=0){
				  $flag2=$db->selectBool('cates',$cates_parentid,'cates_id','INTEGER');
				  if($flag2===true){
					  $success=$db->update('cates',$arr1,$arr2,$arr3);//修改数据
					  if($success!==false){
						  //修改上一级有关子级的信息
						  //$arr_1=array($cates_parentid,2);
						  //$arr_2=array('cates_id','cates_child');
						  //$arr_3=array('INTEGER','INTEGER');
						  //$succ=$db->update('cates',$arr_1,$arr_2,$arr_3);
						  //if($succ!==false){
							   /*
							   * 更新地区的缓存
							   */
							   include_once('../include/cache.func.php');
							   $arr_db=$db->selectAll('cates',array(),array(),array());
							   if(!@empty($arr_db) && @count($arr_db)>0){
								  $arr1_db=array();
								  for($i=0;$i<count($arr_db);$i++){
									 foreach($arr_db[$i] as $key => $value){
										 if(is_string($key)){
											 $arr2_db[$key]=$value;
										 }
									 }
									 $arr1_db=array_pad($arr1_db,count($arr1_db)+1,$arr2_db);
								  }
								 
								  $filesize=cache_write($arr1_db,'cates.php');//写缓存---在include_once/cache.func.php定义的方法
							   }

							   header("Location:../admin/listcates.php");
						  //}else{
							//  echo "<script>alert('修改上一级地区失败');window.history.back();</script>";
							//  exit;
						  //}
					  }else{
						  echo "<script>alert('修改栏目失败');window.history.back();</script>";
						  exit;
					  }
				  }else{
					  //echo "<script>alert('上一级已经不存在了');window.history.back();</script>";
					  //exit;
				  }
			  }else{
				  $success=$db->update('cates',$arr1,$arr2,$arr3);//修改数据
				  if($success!==false){
					  /*
					  * 更新栏目的缓存
					  */
					  include_once('../include/cache.func.php');
					  $arr_db=$db->selectAll('cates',array(),array(),array());
					   if(!@empty($arr_db) && @count($arr_db)>0){
						  $arr1_db=array();
						  for($i=0;$i<count($arr_db);$i++){
							 foreach($arr_db[$i] as $key => $value){
								 if(is_string($key)){
									 $arr2_db[$key]=$value;
								 }
							 }
							 $arr1_db=array_pad($arr1_db,count($arr1_db)+1,$arr2_db);
						  }
						  $filesize=cache_write($arr1_db,'cates.php');//写缓存---在include_once/cache.func.php定义的方法
					   }
					  header("Location:../admin/listcates.php");
				  }else{
					  //echo "<script>alert('修改栏目失败');window.history.back();</script>";
					  //exit;
				  }
			  }
		  }else{
			  echo "<script>alert('名称为".$cates_path."的栏目已存在');window.history.back();</script>";
		      exit;
		  }
	  }else{
		  echo "<script>alert('该数据已经不存在');window.history.back();</script>";
		  exit;
	  }
   }

   /*
   * 删除
   */
   if($method=='delete'){
          echo "<script>alert('抱歉，删除功能暂未启用。');window.history.back();</script>";
		  exit;
	  /*
	  * 对传参的处理
	  */
	  $cates_id=@trim($cates_id);
	  if(empty($cates_id)){
		   echo "<script>alert('密保编号不允许为空');window.history.back();</script>";
		   exit;
	  }else{
		   $cates_id=(int)$cates_id;
		   if($cates_id<=0){
			  echo "<script>alert('密保编号不对');window.history.back();</script>";
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

	  $falg=$db->selectBool('cates',$cates_id,'cates_id','INTEGER');//判断记录是否存在
	  if($falg===true){
		  $success=$db->delete('cates',$cates_id,'cates_id','INTEGER');//删除数据
		  if($success!==false){
			  $totalRecord=$db->selectCount('cates');//总记录数
			  if($totalRecord>0){
				  $totalPage=ceil($totalRecord / $pageSize);//总页数
				  if($pageNo>$totalPage){
					  $pageNo=$totalPage;
				  }

				  /*
				  * 更新地区的缓存
				  */
				  include_once('../include/cache.func.php');
				  $arr_db=$db->selectAll('cates',array(),array(),array());
				   if(!@empty($arr_db) && @count($arr_db)>0){
					  $arr1_db=array();
					  for($i=0;$i<count($arr_db);$i++){
						 foreach($arr_db[$i] as $key => $value){
							 if(is_string($key)){
								 $arr2_db[$key]=$value;
							 }
						 }
						 $arr1_db=array_pad($arr1_db,count($arr1_db)+1,$arr2_db);
					  }
					 
					  $filesize=cache_write($arr1_db,'cates.php');//写缓存---在include_once/cache.func.php定义的方法
				   }
				  header("Location:../admin/listcates.php?pageNo=$pageNo");
			  }else{
				  /*
				  * 更新地区的缓存
				  */
				  include_once('../include/cache.func.php');
				  $arr_db=$db->selectAll('cates',array(),array(),array());
				   if(!@empty($arr_db) && @count($arr_db)>0){
					  $arr1_db=array();
					  for($i=0;$i<count($arr_db);$i++){
						 foreach($arr_db[$i] as $key => $value){
							 if(is_string($key)){
								 $arr2_db[$key]=$value;
							 }
						 }
						 $arr1_db=array_pad($arr1_db,count($arr1_db)+1,$arr2_db);
					  }
					 
					  $filesize=cache_write($arr1_db,'cates.php');//写缓存---在include_once/cache.func.php定义的方法
				   }
				  header("Location:../admin/listcates.php");
			  }
		  }else{
			  echo "<script>alert('删除地区失败');window.history.back();</script>";
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