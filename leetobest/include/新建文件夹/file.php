<?php
    /*
	* 对文件的操作
	*/

	 /*
	 * 文件多上传
	 */
	 function uploads($files=array(),$type=array(),$upfile='',$backPage=''){
		if(strlen($backPage)<=0){
			$backPage=$_SERVER['HTTP_REFERER'];//返回本页面的上一个页面
		}
        if(count($files)<=0){
			echo "<script>alert('文件数组不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		}

		if(count($type)<=0){
			echo "<script>alert('文件类型数组不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		}

		if(strlen($upfile)<=0){
			echo "<script>alert('存放路径不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		}
        
        $files_name=$files['name'];//客户端机器文件的原名称
	    $files_type=$files['type'];//文件的 MIME 类型
	    $files_tmp_name=$files['tmp_name'];//文件被上传后在服务端储存的临时文件名
	    $files_error=$files['error'];//错误值
	    $files_size=$files['size'];//上传文件大小

		$text=implode(' ',$type);

        $arr=array();
		for($i=0;$i<sizeof($files_error);$i++){
			if($files_error[$i]===0){//判断是否上传成功
				if(is_uploaded_file($files_tmp_name[$i])){//判断是不是post提交
                    if(strpos($files_name[$i],'.')!==false){//判断文件里是否有"."
                       $f_name=$files_name[$i];
					   $f_name=substr(strrchr($f_name,'.'),1);
					   $f_name=strtolower($f_name);
					   if(in_array($f_name,$type)){
                           date_default_timezone_set("Asia/Shanghai");//设置一个时间分区
				           $dt=date('YmdHis');
				           $rj=rand();
                           $f_name=$dt.$rj.'.'.$f_name;
                           $f_name=$upfile.$f_name;
						   $f_name1=FILE_PATH.$f_name;//FILE_PATH--这个常量在common/config.php里定义的
						
						   $flag=move_uploaded_file($files_tmp_name[$i],$f_name1);
						   if($flag){
							   array_push($arr, $f_name);//为数组添加元素
							}else{
							   /*
							   * 删除文件
							   */
							   if(count($arr)>0){
								   for($x=0;$x<count($arr);$x++){
                                       del($arr[$x],$backPage);//调用删除文件的方法
								   }
								   //把数组清空
								   unset($arr);
								   $arr=array();
							   }
							   echo "<script>alert('上传第".($i+1)."个文件，上传失败');window.location.href='".$backPage."';</script>";
							   exit;
							}
					   }else{
						  /*
						  * 删除文件
						  */
						  if(count($arr)>0){
							   for($x=0;$x<count($arr);$x++){
								   del($arr[$x],$backPage);//调用删除文件的方法
							   }
							   //把数组清空
							   unset($arr);
							   $arr=array();
						  }
                          echo "<script>alert('上传第".($i+1)."个文件时，文件类型不对,应上传以下类型文件：".$text."');window.location.href='".$backPage."';</script>";
					      exit;
					   }
					}else{
					   /*
					   * 删除文件
					   */
					   if(count($arr)>0){
						   for($x=0;$x<count($arr);$x++){
							   del($arr[$x],$backPage);//调用删除文件的方法
						   }
						   //把数组清空
						   unset($arr);
						   $arr=array();
					   }
					   echo "<script>alert('上传第".($i+1)."个文件时，文件有问题');window.location.href='".$backPage."';</script>";
					   exit;
					}
				}else{
				    /*
				    * 删除文件
				    */
				    if(count($arr)>0){
					    for($x=0;$x<count($arr);$x++){
						   del($arr[$x],$backPage);//调用删除文件的方法
					    }
						//把数组清空
						unset($arr);
					    $arr=array();
				    }
					echo "<script>alert('上传第".($i+1)."个文件时，上传方式错误');window.history.go(-1);</script>";
				    exit;
				}
			}else{
				/*
				* 删除文件
				*/
				if(count($arr)>0){
				   for($x=0;$x<count($arr);$x++){
					   del($arr[$x],$backPage);//调用删除文件的方法
				   }
				   //把数组清空
				   unset($arr);
				   $arr=array();
			    }

			    switch ($files_error[$i]){
				   case 1:
                         echo "<script>alert('上传第".($i+1)."个文件发生错误，错误类型是：上传的文件超过了服务器配置文件限制的大小');window.location.href='".$backPage."';</script>";
			             exit;
				   case 2:
                         echo "<script>alert('上传第".($i+1)."个文件发生错误，错误类型是：上传的文件超过了页面表单限制的大小');window.location.href='".$backPage."';</script>";
			             exit;
				   case 3:
                         echo "<script>alert('上传第".($i+1)."个文件发生错误，错误类型是：文件只有部分被上传');window.location.href='".$backPage."';</script>";
			             exit;
				   case 4:
                         echo "<script>alert('上传第".($i+1)."个文件发生错误，错误类型是：没有文件被上传');window.location.href='".$backPage."';</script>";
			             exit;
				   case 6:
                         echo "<script>alert('上传第".($i+1)."个文件发生错误，错误类型是：找不到临时文件目录');window.location.href='".$backPage."';</script>";
			             exit;
				   case 7:
                         echo "<script>alert('上传第".($i+1)."个文件发生错误，错误类型是：写入失败');window.location.href='".$backPage."';</script>";
			             exit;
				   default:
                         echo "<script>alert('上传第".($i+1)."个文件发生错误，错误类型是：未知错误');window.location.href='".$backPage."';</script>";
			             exit;
			    }
			}
		}
		return $arr;
	 }
     
	 /*
	 * 上传单个文件
	 */
	 function upload($file=array(),$type=array(),$upfile='',$backPage=''){
        if(strlen($backPage)<=0){
			$backPage=$_SERVER['HTTP_REFERER'];//返回本页面的上一个页面
		}
        if(count($file)<=0){
			echo "<script>alert('文件数组不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		}

		if(count($type)<=0){
			echo "<script>alert('文件类型数组不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		}

		if(strlen($upfile)<=0){
			echo "<script>alert('存放路径不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		}

		$text=implode(' ',$type);
		$back='';

		if($file['error']==0){//判断是否上传成功
            if(is_uploaded_file($file['tmp_name'])){//判断是不是post提交
                $filename=$file['name'];
		        $isExists=strpos($filename,'.');
				if($isExists!==false){
					$filename=strrchr($filename,'.');
			        $filename=substr($filename,1,strlen($filename));
					if(in_array($filename,$type)){
						date_default_timezone_set("Asia/Shanghai");//设置一个时间分区
					    $dt=date("YmdHis");
					    $sj=rand();
					    $filename=$dt.$sj.".".$filename;
                        $filename=$upfile.$filename;
						$f_name=FILE_PATH.$filename;//FILE_PATH--这个常量在common/config.php里定义的
						$flag=move_uploaded_file($file['tmp_name'],$filename);
						if($flag){
							   $back=$filename;
						 }else{
							   echo "<script>alert('上传失败');window.location.href='".$backPage."';</script>";
							   exit;
						 }
					 }else{
						 echo "<script>alert('文件类型不对,应上传以下类型文件：".$text."');window.location.href='".$backPage."';</script>";
					      exit;
					 }
				}else{
                    echo "<script>alert('文件有问题');window.location.href='".$backPage."';</script>";
					exit;
				}
			}else{
				echo "<script>alert('上传方式错误');window.location.href='".$backPage."';</script>";
				exit;
			}
		}else{
			switch($file['error']){
				case 1:
                      echo "<script>alert('上传文件发生错误，错误类型是：上传的文件超过了服务器配置文件限制的大小');window.location.href='".$backPage."';</script>";
			          exit;
				case 2:
                      echo "<script>alert('上传文件发生错误，错误类型是：上传的文件超过了页面表单限制的大小');window.location.href='".$backPage."';</script>";
			          exit;
				case 3:
                      echo "<script>alert('上传文件发生错误，错误类型是：文件只有部分被上传');window.location.href='".$backPage."';</script>";
			          exit;
				case 4:
                      echo "<script>alert('上传文件发生错误，错误类型是：没有文件被上传');window.location.href='".$backPage."';</script>";
			          exit;
				case 6:
                      echo "<script>alert('上传文件发生错误，错误类型是：找不到临时文件目录');window.location.href='".$backPage."';</script>";
			          exit;
				case 7:
                      echo "<script>alert('上传文件发生错误，错误类型是：写入失败');window.location.href='".$backPage."';</script>";
			          exit;
				default:
                         echo "<script>alert('上传文件发生错误，错误类型是：未知错误');window.location.href='".$backPage."';</script>";
			             exit;
			}
		}
		return $back;
	 }
     
	 /*
	 * 下载
	 */
	 function down($path='',$backPage=''){
		 if(strlen($backPage)<=0){
			$backPage=$_SERVER['HTTP_REFERER'];
		 }

		 if(strlen($path)<=0){
			echo "<script>alert('下载时文件路径不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		 }else{
		    $path=FILE_PATH.$path;//FILE_PATH--这个常量在common/config.php里定义的
		 }

		 if(!empty($path)){
			$filename=basename($path);//basename函数 -- 返回路径中的文件名部分
			$file=fopen($path,"r");
			header("Content-type:application/octet-stream");
			header("Accept-ranges:bytes");
			header("Accept-length:".filesize($path));
			header("Content-Disposition:attachment;filename=".$filename);
			echo fread($file,filesize($path));
			fclose($file);
			exit;
		 }
	 }
     
	 /*
	 * 删除文件
	 */
	 function del($path='',$backPage=''){
		if(strlen($backPage)<=0){
			$backPage=$_SERVER['HTTP_REFERER'];
		}

        if(strlen($path)<=0){
			echo "<script>alert('删除时文件路径不能为空');window.location.href='".$backPage."';</script>";
		    exit;
		}else{
		    $path=FILE_PATH.$path;//FILE_PATH--这个常量在common/config.php里定义的
		}
        
		if(file_exists($path)){//判断文件是否存在
			unlink ($path);//删除文件
		}
	 }
     
	 /*
	 * 判断文件是否存在
	 */
	 function exists($path=''){
		$is_Exists=false;
        if(strlen($path)>0){
			$path=FILE_PATH.$path;//FILE_PATH--这个常量在common/config.php里定义的
			if(file_exists($path)){
               $is_Exists=true;
			}
		}
		return $is_Exists;
	 }
?>