<?php
    /*
	* ������
	*/
    function cache_read($file='', $path = '',$backPage=''){
       if(strlen($backPage)<0){
		   $backPage=$_SERVER['HTTP_REFERER'];//���ر�ҳ�����һ��ҳ�棿��
	   }
	   if(@strlen($file)<=0){
           echo "<script>alert('�ļ�������Ϊ��');window.location.href='".$backPage."';</script>";
		   exit;
	   }
	   $cachefile=($path ? $path : CACHE_PATH).$file;//CACHE_PATH---��include/config.php�ﶨ���(����Ĭ�ϴ洢·��)
	   return @include $cachefile;
	}

	/*
	* д����
	*/
    function cache_write($arr=array(),$file='', $path = '',$backPage=''){
	   if(strlen($backPage)<0){
		   $backPage=$_SERVER['HTTP_REFERER'];//���ر�ҳ�����һ��ҳ�棿��
	   }
	   if(!is_array($arr) || @count($arr)<=0){
           echo "<script>alert('���鲻��Ϊ��');window.location.href='".$backPage."';</script>";
		   exit;
	   }
	   if(@strlen($file)<=0){
           echo "<script>alert('�ļ�������Ϊ��');window.location.href='".$backPage."';</script>";
		   exit;
	   }
	   $array = "<?php\nreturn ".var_export($arr, true).";\n?>";
	   $cachefile=($path ? $path : CACHE_PATH).$file;//CACHE_PATH---��include/config.php�ﶨ���(����Ĭ�ϴ洢·��)
					//	���ַ����Ҳ�Ϊ�գ���Ϊ�棬����Ϊ��
	   $strlen = file_put_contents($cachefile, $array);
	   @chmod($cachefile, 0777);

       unset($array);
	   unset($cachefile);

	   return $strlen;
	}
?>
