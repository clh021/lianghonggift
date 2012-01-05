<?php
    /*
	* 读缓存
	*/
    function cache_read($file='', $path = '',$backPage=''){
       if(strlen($backPage)<0){
		   $backPage=$_SERVER['HTTP_REFERER'];//返回本页面的上一个页面？？
	   }
	   if(@strlen($file)<=0){
           echo "<script>alert('文件名不能为空');window.location.href='".$backPage."';</script>";
		   exit;
	   }
	   $cachefile=($path ? $path : CACHE_PATH).$file;//CACHE_PATH---在include/config.php里定义的(缓存默认存储路径)
	   return @include $cachefile;
	}

	/*
	* 写缓存
	*/
    function cache_write($arr=array(),$file='', $path = '',$backPage=''){
	   if(strlen($backPage)<0){
		   $backPage=$_SERVER['HTTP_REFERER'];//返回本页面的上一个页面？？
	   }
	   if(!is_array($arr) || @count($arr)<=0){
           echo "<script>alert('数组不能为空');window.location.href='".$backPage."';</script>";
		   exit;
	   }
	   if(@strlen($file)<=0){
           echo "<script>alert('文件名不能为空');window.location.href='".$backPage."';</script>";
		   exit;
	   }
	   $array = "<?php\nreturn ".var_export($arr, true).";\n?>";
	   $cachefile=($path ? $path : CACHE_PATH).$file;//CACHE_PATH---在include/config.php里定义的(缓存默认存储路径)
					//	有字符串且不为空，则为真，否则为假
	   $strlen = file_put_contents($cachefile, $array);
	   @chmod($cachefile, 0777);

       unset($array);
	   unset($cachefile);

	   return $strlen;
	}
?>
