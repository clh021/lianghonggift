<?php
class FtpUpload extends Think{
	//R FTP 处理;
	public $ftpUrl = '115.239.227.248';
	public $ftpUser = 'pphere123';
	public $ftpPass = 'pphere123';
	public $ftpDir = '/face/';
	public $ftpR = ''; //R ftp资源;
	public $status = '';
	
	/*
	 	*新增 createdir,sput 创建目录，上传
	 	* @ bone
	 */
	public $fileRule  = 'd';
	
	//R 1:成功;2:无法连接ftp;3:用户错误;
	function ftp() {
	   if ($this->ftpR = ftp_connect($this->ftpUrl, 21)) {
	    if (ftp_login($this->ftpR, $this->ftpUser, $this->ftpPass)) {
	     if (!empty($this->ftpDir)) {
	      ftp_chdir($this->ftpR, $this->ftpDir);
	     }
	     ftp_pasv($this->ftpR, true);//R 启用被动模式;
	     $this->status = 1;
	    } else {
	     $this->status = 3;
	    }
	   } else {
	    $this->status = 2;
	   }
	}
	//R 切换目录;
	function cd($dir) {
	   return ftp_chdir($this->ftpR, $dir);
	}
	
	//R创建目录
	function mkdir($directory){
		return ftp_mkdir($this->ftpR, $directory);
	}
	
	//R 返回当前路劲;
	function pwd() {
	   return ftp_pwd($this->ftpR);
	}
	//R 上传文件;
	function put($localFile, $remoteFile = '') {
	   if ($remoteFile == '') {
	    $remoteFile = end(explode('/', $localFile));
	   }
	   $res = ftp_nb_put($this->ftpR, $remoteFile, $localFile, FTP_BINARY);
	   while ($res == FTP_MOREDATA) {
	    $res = ftp_nb_continue($this->ftpR);
	   }
	   if ($res == FTP_FINISHED) {
	    return true;
	   } elseif ($res == FTP_FAILED) {
	    return false;
	   }
	}
	//R 自动创建目录上传
	function sput($localFile, $remoteFile = ''){
			if ($remoteFile == '') {
	    	$remoteFile = end(explode('/', $localFile));
	   	}
	   $dir = $this->createDirName();
	   $this->mkDirs($dir);
			/*自动数据.*/
	   $res = ftp_nb_put($this->ftpR, $dir.$remoteFile, $localFile, FTP_BINARY);
	   while ($res == FTP_MOREDATA) {
	    $res = ftp_nb_continue($this->ftpR);
	   }
	   if ($res == FTP_FINISHED) {
	    return $dir.$remoteFile;//上传成功..
	   } elseif ($res == FTP_FAILED) {
	    return false;
	   }

	}

	/*目录规则*/
	function createDirName()// 默认按月生成
	{
			$dir = !empty($this->ftpDir) ? $this->ftpDir . '/'  : '';//文件保存目录
			// 创建目录路径
			switch(strtolower($this->fileRule))
			{
				case 'w': //周
					 $dir .= date("W")  ; break;
				case 'm': //月
					 $dir .= date("Y") . '/'  . date("m") ; break;
				case 'd'://日DIRECTORY_SEPARATOR
					 $dir .= date("Y") . '/' . date("m") . '/'  . date('d') ;break;
				default:
					 $dir .= date("W");break;
			}	
			return $dir . '/' ;
	}
		/**
	* 方法：创建目录
	* @path 路径 
	*/ 
	function mkDirs($path) 
	{ 
	  $dir = ftp_pwd($this->ftpDir);
	
	  if($dir != '\\'){
	  	$p = str_replace('\\', '/',$dir);							//替换 '\'
	  	$pathArr  = explode('/',$dir);           // 取目录数组 

	  	for($i=0; $i < count($pathArr); $i++)                  // 回退到根 
	 	  {
	    	ftp_cdup($this->ftpR); 
	  	}
	  }
	
	  $path = str_replace('\\', '/',$path);							//替换 '\'
	  $pathArr  = explode('/',$path);           // 取目录数组 
	  $pathDiv  = count($pathArr);                // 取层数
	  
	  
	  foreach($pathArr as $val)                    // 创建目录 
	  {
	  	if(empty($val)) break;
	  
	   	if($this->cd($val) == FALSE) //如果没有文件夹不存在
	   	{
	    	if(!$this->mkdir($val))
	    	{
	    		 $this->error = 'Ftp目录创建失败,请检查权限及路径！' ; 
					 return false;
				}
	    	$this->cd($val);
	    	
	   	}
	  }
	  for($i=1; $i<=$pathDiv; $i++)                  // 回退到根 
	  {
	    ftp_cdup($this->ftpR); 
	  }
	  return true;
	}
	
	//R 下载文件;
	function get($remoteFile, $localFile = '') {
	   if ($localFile == '') {
	    $localFile = end(explode('/', $remoteFile));
	   }
	   if (ftp_get($this->ftpR, $localFile, $remoteFile, FTP_BINARY)) {
	    $flag = true;
	   } else {
	    $flag = false;
	   }
	   return $flag;
	}
	//R 文件大小;
	function size($file) {
	   return ftp_size($this->ftpR, $file);
	}
	//R 文件是否存在;
	function isFile($file) {
	   if ($this->size($file) >= 0) {
	    return true;
	   } else {
	    return false;
	   }
	}
	//R 文件时间
	function fileTime($file) {
	   return ftp_mdtm($this->ftpR, $file);
	}
	//R 删除文件;
	function unlink($file) {
	   return ftp_delete($this->ftpR, $file);
	}
	function nlist($dir = '/service/resource/') {
	   return ftp_nlist($this->ftpR, $dir);
	}
	//R 关闭连接;
	function bye() {
	   return ftp_close($this->ftpR);
	}
}
?>