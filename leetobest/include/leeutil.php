<?php
    /*
	*  对中英文字符串长度的处理
    */
	function my_substr($str,$limit_length,$charset,$omit=''){ 
			$return_str = "";//返回的字符串
			$len = mb_strlen($str,$charset);// 以gb2312格式求字符串的长度，每个汉字算一个长度
			if ( $len > $limit_length ){
				 if(strlen($omit)<=0){
					  $omit = "&hellip;";
				 }
			}else{
				  $limit_length = $len;
				  $omit='';
			}

			for ($i = 0; $i < $limit_length; $i++){
					$curr_char = mb_substr($str,$i,1,$charset);//以gb2312格式取得第$i个位置的字符，取的长度为1
					$curr_length = ord($curr_char) > 127 ? 2 : 1;//如果大于127，则此字符为汉字，算两个长度
					$return_str .= $curr_char;
			}
			return $return_str.$omit;
	}

	/*
	* 过滤所有html标记
	*/
   function helphtml($htmlstr){
	   //$htmlstr=Strtolower($htmlstr);
	   //先过滤空格、换行、Tab标记
	   $htmlstr=str_replace('\n','',$htmlstr);
	   $htmlstr=str_replace('\r','',$htmlstr);
	   $htmlstr=str_replace('\t','',$htmlstr);
	   $htmlstr=str_replace('&nbsp;','',$htmlstr);
	   $str1='';
	   $str2='';
	   $i=0;
	   $int1=0;
	   $int2=0;
	   for(;$i<strlen($htmlstr);){
		  if(strpos($htmlstr,'<',$i) !== false){//此处要小心----由于php是弱类语言,false也等于0,或者在页面输出的时候为空值。所以用不恒等于
               $int1=strpos($htmlstr,'<',$i);
			   if(strpos($htmlstr,'>',$i) !== false){
				   $int2=strpos($htmlstr,'>',$i);
				   $int2=$int2+1;
				   $int2=$int2-$int1;
				   $str1=substr($htmlstr,$int1,$int2);
				   $htmlstr=str_replace($str1,'',$htmlstr);
				   $i=$int1;
			   }else{//防止没有'>'
				   if($int1<strlen($htmlstr)){//如果此时查找的长度没有到字符串末尾
					   $i=$int1+1;
				       continue;
				   }else{//如果此时查找的长度到了字符串最后末尾
					   break;
				   }				   
			   }			   
		  }else{
			   break;
		  }
	   }
	   return $htmlstr;
   }

   /*
	* 过滤所有html标记--不过滤'&nbsp;'
	*/
   function html($htmlstr){
	   //$htmlstr=Strtolower($htmlstr);
	   //先过滤空格、换行、Tab标记
	   $htmlstr=str_replace('\n','',$htmlstr);
	   $htmlstr=str_replace('\r','',$htmlstr);
	   $htmlstr=str_replace('\t','',$htmlstr);
	   //$htmlstr=str_replace('&nbsp;','',$htmlstr);
	   $str1='';
	   $str2='';
	   $i=0;
	   $int1=0;
	   $int2=0;
	   for(;$i<strlen($htmlstr);){
		  if(strpos($htmlstr,'<',$i) !== false){//此处要小心----由于php是弱类语言,false也等于0,或者在页面输出的时候为空值。所以用不恒等于
               $int1=strpos($htmlstr,'<',$i);
			   if(strpos($htmlstr,'>',$i) !== false){
				   $int2=strpos($htmlstr,'>',$i);
				   $int2=$int2+1;
				   $int2=$int2-$int1;
				   $str1=substr($htmlstr,$int1,$int2);
				   $htmlstr=str_replace($str1,'',$htmlstr);
				   $i=$int1;
			   }else{//防止没有'>'
				   if($int1<strlen($htmlstr)){//如果此时查找的长度没有到字符串末尾
					   $i=$int1+1;
				       continue;
				   }else{//如果此时查找的长度到了字符串最后末尾
					   break;
				   }				   
			   }			   
		  }else{
			   break;
		  }
	   }
	   return $htmlstr;
   }

   /*
   *  对图片的处理
   *  $img---图片
   *  $imgurl---图片相对路径
   */
   function getImg($img,$imgurl){
	   $imgeurl='';
	   if(empty($img)){
		   $imgeurl="images/nopic.gif";
	   }else{
		   $dataimgurl=$imgurl.$img;
		   if(file_exists($dataimgurl)){
			   $imgeurl=$dataimgurl;
		   }else{
			   $imgeurl="images/nopic.gif";
		   }
	   }
	   return $imgeurl;
   }

   /*
   * 页面通过js传中文给后端php,出现乱码的解决办法
   * 页面先用js的escape()函数,接着用encodeURI()函数,在后台php文件里用下面的函数即可
   */
   function unescape($str){   
		  $str = rawurldecode($str);   
		  preg_match_all("/%u.{4}|&#x.{4};|&#\d+;|.+/U",$str,$r);   
		  $ar = $r[0];   
		  foreach($ar as $k=>$v) {   
			if(substr($v,0,2) == "%u")   
			  $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,-4)));   
			elseif(substr($v,0,3) == "&#x")   
			  $ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,3,-1)));   
			elseif(substr($v,0,2) == "&#") {   
			  $ar[$k] = iconv("UCS-2","GBK",pack("n",substr($v,2,-1)));   
			}   
		  }   
		  return join("",$ar);   
    }
    
	/*
	* 过滤
	*/
	function filter($str){
   	 	$ss="";
   	 	if(!empty($str)){
	   	 	$ss=$str;
	   	 	$ss=trim($ss);
	   	 	$ss=Strtolower($ss);
	   	 	$ss=str_replace("or"," ",$ss);
   	 		$ss=str_replace("and"," ",$ss);
   	 		$ss=str_replace("select"," ",$ss);
   	 		$ss=str_replace("'"," ",$ss);
   	 		$ss=str_replace("union"," ",$ss);
   	 		$ss=str_replace("order"," ",$ss);
   	 		$ss=str_replace("by"," ",$ss);
   	 	}
   	 	return $ss;
   	 }

	 /*
	 * 获取客户端ip地址
	 */
	 function ip(){
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
		{
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
		{
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
		{
			$ip = getenv('REMOTE_ADDR');
		}
		elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : 'unknown';
	 }
	 /*
	 * 验证邮箱
	 */
	 function checkEmail($str){
		 $flag=false;
		 $emailexp="^[a-zA-Z0-9_\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$";
		 if(is_array($str)){
            foreach($str as $value){
				$flag=ereg($emailexp,$value);
				if(!$flag)
				{
					break;
				}
			}
		 }else{
            $flag=ereg($emailexp,$str);
		 }
		 return $flag;
	 }
     /*
	 * 验证匹配由数字组成
	 */
	 function checknum($str=""){
		 $flag=false;
		 $checkstrexp="^[0-9]+$";
		 $flag=ereg($checkstrexp,$str);
		 return $flag;
	 }

     /*
	 * 验证电话
	 */
	 function checkTelAndPhone($str=""){
		 $flag=false;
		 $TelAndPhoneexp="^((\(\d{3}\))|(\d{3}\-))?13[456789]\d{8}|15[89]\d{8}";
		 $flag=ereg($TelAndPhoneexp,$str);
		 return $flag;
	 }

     /*
	 * 验证服务器域名和地址
	 */
	 function checkstr1($str="",$char=""){
		 $flag=false;
		 $checkstrexp="^[a-zA-Z0-9\-]+\.((com)|(cn)|(com\.cn))+$";
		 $flag=ereg($checkstrexp,$str);
		 return $flag;
	 }
	 /*
	 * 更新某一张表的数据缓存
	 */
	 function one_table_cache($name,$db){
		//先要判断数据库中是否存在此表
		if(!isset($tables_arr)){
			$tables_arr=$db->tables();
		}
		if(in_array($name,$tables_arr))
		{
		  $arr=$db->selectAll($name,array(),array(),array());
		  if(!@empty($arr) && @count($arr)>0){
			 $arr1=array();
			 for($i=0;$i<count($arr);$i++){
				 foreach($arr[$i] as $key => $value){
					 if(is_string($key))
						 $arr2[$key]=$value;
				 }
				 $arr1=array_pad($arr1,count($arr1)+1,$arr2);
			 }
			 $filesize=cache_write($arr1,$name.'.php');//写缓存---在include/cache.func.php定义的方法
			 if(!@empty($filesize)){
				  return 1;
			 }else{
				  return 0;
			 }
		  }else{
			 return -1;
		  }
		  unset($arr);
		}else{
			return -1;//数据库中没有此表
		}
	}
?>