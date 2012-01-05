<?php
   /*
   * 对mysql的操作
   */
   class Mysql{
	  var $dbhost; //数据库主机名
      var $dbuser; //数据库连接账号
	  var $dbpw; //数据库连接密码
	  var $dbname; //数据库名
	  var $charset; //数据库编码方式

	  var $dblink; //数据库连接
	  var $int_sjlx=array('TINYINT','INT','SMALLINT','MEDIUMINT','BIGINT','BIT','BOOL','INTEGER');//int型数据
	  var $float_sjlx=array('FLOAT','DOUBLE','REAL','DECIMAL','NUMERIC');//浮点型数据

	  /*
	  * 数据库连接、选择数据库、设置数据库的字符集编码方式
	  */
      function Mysql($dbhost, $dbuser, $dbpw, $dbname = '', $charset = ''){
		 $this->dbhost=$dbhost;
		 $this->dbuser=$dbuser;
		 $this->dbpw=$dbpw;
		 $this->dbname=$dbname;
		 $this->charset=$charset;

	     $this->dblink = mysql_connect($this->dbhost,$this->dbuser,$this->dbpw); 
		 mysql_select_db($this->dbname,$this->dblink);
		 mysql_query("SET NAMES '".$this->charset."'");
	  }
      
	  /*
	  * 释放结果内存
	  */
	  function free_result(&$query){
		 return mysql_free_result($query);
	  }
      
	  /*
	  * 取得上一步 INSERT 操作产生的 ID 
	  */
	  function insert_id(){
		 return mysql_insert_id($this->dblink);
	  }
      
	  /*
	  * 增加数据
	  * tablename---表名字
	  * arr1--数据数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  */
	  function insert($tablename='',$arr1=array(),$arr2=array(),$arr3=array()){
          $sql1="INSERT INTO ".$tablename."(";
		  $sql2="VALUES(";
		  for($i=0;$i<count($arr1);$i++){
			  $sql1=$sql1.$arr2[$i].',';
			  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
				  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
                      $arr1[$i]=intval($arr1[$i]);
				  }else{
					  $arr1[$i]=floatval($arr1[$i]);
				  }
                  $sql2=$sql2.$arr1[$i].",";
			  }else{
				  $sql2=$sql2."'".$arr1[$i]."',";
			  }
		  }

		  //去掉最后一个,
		  if(substr($sql1,-1)==','){
			  $sql1=substr($sql1,0,-1);
		  }
		  if(substr($sql2,-1)==','){
			  $sql2=substr($sql2,0,-1);
		  }
		  $sql1=$sql1.")";
		  $sql2=$sql2.")";
		  $sql=$sql1." ".$sql2;
				//echo $sql;//return;
		  $success=mysql_query($sql);

		  /*
		  * 注销变量
		  */
		  unset($sql1);
		  unset($sql2);
		  unset($sql);
		  return $success;
	  }
      
	  /*
	  * 修改数据
	  * tablename---表名字
	  * arr1--值数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  */
	  function update($tablename='',$arr1=array(),$arr2=array(),$arr3=array()){
          $sql="UPDATE ".$tablename." SET";
		  for($i=1;$i<count($arr1);$i++){
              if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
				  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
                     $arr1[$i]=intval($arr1[$i]);
				  }else{
					  $arr1[$i]=floatval($arr1[$i]);
				  }
                  $sql=$sql." ".$arr2[$i]."=".$arr1[$i].",";
			  }else{
				  $sql=$sql." ".$arr2[$i]."='".$arr1[$i]."',";
			  }
		  }

		  //去掉最后一个,
		  if(substr($sql,-1)==','){
			  $sql=substr($sql,0,-1);
		  }
		  //添加where条件
          $sql=$sql." WHERE ".$arr2[0]."=";
		  if(in_array(strtoupper($arr3[0]),$this->int_sjlx) || in_array(strtoupper($arr3[0]),$this->float_sjlx)){
			  if(in_array(strtoupper($arr3[0]),$this->int_sjlx)){
				  $arr1[0]=intval($arr1[0]);
			  }else{
                  $arr1[0]=floatval($arr1[0]);
			  }
              $sql=$sql.$arr1[0];
		  }else{
			  $sql=$sql."'".$arr1[0]."'";
		  }
			 //echo $sql."<hr />";//return;
		  
		  $success=mysql_query($sql);
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  return $success;
	  }
	  /*
	  * 删除数据
	  * tablename---表名字
	  * str1--值数组
	  * str2--表字段名数组
	  * str3--数据类型数组
	  */
	  function delete($tablename='',$str1='',$str2='',$str3=''){
          $sql="DELETE FROM ".$tablename." WHERE ";
		  //if(in_array(strtoupper($str3),$this->int_sjlx) || in_array(strtoupper($str3),$this->float_sjlx)){
          //   if(in_array(strtoupper($str3),$this->int_sjlx)){
			//	 $str1=intval($str1);
			// }else{
			//	 $str1=floatval($str1);
			// }
            // $sql=$sql.$str2."=".$str1;
		 // }else{
			  $sql=$sql.$str2."='".$str1."'";
		 // }

		  $success=mysql_query($sql);
		  /*
		  * 注销变量
		  */
		  unset($sql);

		  return $success;
	  }

	  /*
	  * 判断记录是否存在
	  * tablename---表名字
	  * str1--值
	  * str2--表字段名
	  * str3--数据类型
	  */
	  function selectBool($tablename='',$str1='',$str2='',$str3=''){
          $sql="SELECT COUNT(0) c FROM ".$tablename." WHERE ";
		  //if(in_array(strtoupper($str3),$this->int_sjlx) || in_array(strtoupper($str3),$this->float_sjlx)){
			//  if(in_array(strtoupper($str3),$this->int_sjlx)){
            //      $str1=intval($str1);
			 // }else{
			//	  $str1=floatval($str1);
			//  }
			//  $sql=$sql.$str2."=".$str1;
		  //}else{
			  $sql=$sql.$str2."='".$str1."'";
		  //}

          $res=mysql_query($sql);
		  $row=mysql_fetch_array($res,MYSQL_BOTH);
		  $flag=false;
		  if($row['c']>=1){
             $flag=true;
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);
		  unset($row);

		  return $flag;
	  }

	  /*
	  * 判断记录是否存在--涉及到上一级
	  * tablename---表名字
	  * arr1--值数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  */
	  function selectBool_F($tablename='',$arr1=array(),$arr2=array(),$arr3=array()){
          $sql="SELECT COUNT(0) c FROM ".$tablename." WHERE 1=1";
		  for($i=0;$i<count($arr1);$i++){
             //if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
			//	  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
             //        $arr1[$i]=intval($arr1[$i]);
			//	  }else{
			//		  $arr1[$i]=floatval($arr1[$i]);
			//	  }
            //      $sql=$sql." AND ".$arr2[$i]."=".$arr1[$i];
			//  }else{
				  $sql=$sql." AND ".$arr2[$i]."='".$arr1[$i]."'";
			//  }
		  }

          $res=mysql_query($sql);
		  $row=mysql_fetch_array($res,MYSQL_BOTH);
		  $flag=false;
		  if($row['c']>=1){
             $flag=true;
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);
		  unset($row);

		  return $flag;
	  }

	  /*
	  * 根据id和关键属性来判断记录是否存在--(用于修改)
	  * tablename---表名字
	  * arr1--值数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  */
	  function selectBoolByIdName($tablename='',$arr1=array(),$arr2=array(),$arr3=array()){
          $sql="SELECT COUNT(0) c FROM ".$tablename." WHERE 1=1";
		  for($i=0;$i<count($arr1)-1;$i++){
             //if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
			//	  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
             //        $arr1[$i]=intval($arr1[$i]);
			//	  }else{
			//		  $arr1[$i]=floatval($arr1[$i]);
			//	  }
              //    $sql=$sql." AND ".$arr2[$i]."=".$arr1[$i];
			  //}else{
				  $sql=$sql." AND ".$arr2[$i]."='".$arr1[$i]."'";
			  //}
		  }

		  //if(in_array(strtoupper($arr3[count($arr3)-1]),$this->int_sjlx) || in_array(strtoupper($arr3[count($arr3)-1]),$this->float_sjlx)){
			  //if(in_array(strtoupper($arr3[count($arr3)-1]),$this->int_sjlx)){
              //    $arr1[count($arr1)-1]=intval($arr1[count($arr1)-1]);
			  //}else{
				  $arr1[count($arr1)-1]=floatval($arr1[count($arr1)-1]);
			  //}
			  //$sql=$sql." AND ".$arr2[count($arr2)-1]."<>".$arr1[count($arr1)-1];
		  //}else{
			  $sql=$sql." AND ".$arr2[count($arr2)-1]."<>'".$arr1[count($arr1)-1]."'";
		  //}

          $res=mysql_query($sql);
		  $row=mysql_fetch_array($res,MYSQL_BOTH);
		  $flag=false;
		  if($row['c']>=1){
             $flag=true;
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);
		  unset($row);

		  return $flag;
	  }

	  /*
	  * 根据id和关键属性来判断记录是否存在--涉及到上一级(用于修改)---该方法可以去掉
	  * tablename---表名字
	  * arr1--值数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  */
	  function selectBoolByIdName_F($tablename='',$arr1=array(),$arr2=array(),$arr3=array()){
          $sql="SELECT COUNT(0) c FROM ".$tablename." WHERE 1=1";
		  for($i=0;$i<count($arr1)-1;$i++){
             //if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
			//	  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
             //        $arr1[$i]=intval($arr1[$i]);
			//	  }else{
				//	  $arr1[$i]=floatval($arr1[$i]);
				//  }
               //   $sql=$sql." AND ".$arr2[$i]."=".$arr1[$i];
			 // }else{
				  $sql=$sql." AND ".$arr2[$i]."='".$arr1[$i]."'";
			 // }
		  }

		  //if(in_array(strtoupper($arr3[count($arr3)-1]),$this->int_sjlx) || in_array(strtoupper($arr3[count($arr3)-1]),$this->float_sjlx)){
			 // if(in_array(strtoupper($arr3[count($arr3)-1]),$this->int_sjlx)){
             //     $arr1[count($arr1)-1]=intval($arr1[count($arr1)-1]);
			 // }else{
			//	  $arr1[count($arr1)-1]=floatval($arr1[count($arr1)-1]);
			 // }
			//  $sql=$sql." AND ".$arr2[count($arr2)-1]."<>".$arr1[count($arr1)-1];
		  //}else{
			  $sql=$sql." AND ".$arr2[count($arr2)-1]."<>'".$arr1[count($arr1)-1]."'";
		  //}

          $res=mysql_query($sql);
		  $row=mysql_fetch_array($res,MYSQL_BOTH);
		  $flag=false;
		  if($row['c']>=1){
             $flag=true;
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);
		  unset($row);

		  return $flag;
	  }
      
      /*
	  * 查找单个--根据id或者关键性字段
	  * tablename---表名字
	  * str1--值
	  * str2--表字段名
	  * str3--数据类型
	  */
	  function selectSingle($tablename='',$str1='',$str2='',$str3=''){
		  $sql="SELECT * FROM ".$tablename." WHERE ";
		  //if(in_array(strtoupper($str3),$this->int_sjlx) || in_array(strtoupper($str3),$this->float_sjlx)){
          //   if(in_array(strtoupper($str3),$this->int_sjlx)){
			//	 $str1=intval($str1);
			// }else{
			//	 $str1=floatval($str1);
			// }
           //  $sql=$sql.$str2."=".$str1;
		  //}else{
			  $sql=$sql.$str2."='".$str1."'";
		  //}

		  $res=mysql_query($sql);
		  $row=mysql_fetch_array($res,MYSQL_BOTH);
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);
		  
		  return $row;
	  }
      
	  /*
	  * 查找多个
	  * tablename---表名字
	  * arr1--值数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  * order_str--排序
	  */
	  function selectAll($tablename='',$arr1=array(),$arr2=array(),$arr3=array(),$order_str=''){
          $sql="SELECT * FROM ".$tablename." WHERE 1=1";
		  if(!@empty($arr1) && @count($arr1)>0){
              for($i=0;$i<count($arr1);$i++){
			//	  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
			//		  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
            //             $arr1[$i]=intval($arr1[$i]);
			//		  }else{
			//			 $arr1[$i]=floatval($arr1[$i]);
			//		  }
			//		  $sql=$sql." AND ".$arr2[$i]."=".$arr1[$i];
			//	  }else{
					  $sql=$sql." AND ".$arr2[$i]."='".$arr1[$i]."'";
			//	  }
			  }
		  }

		  if(strlen($order_str)>0){
             $sql=$sql." ORDER BY ".$order_str;
		  }

		  $res=mysql_query($sql);
		  $back_arr=array();
		  while($row=mysql_fetch_array($res,MYSQL_BOTH)){
              $back_arr=array_pad($back_arr,count($back_arr)+1,$row);
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);

		  return $back_arr;
	  }

	  /*
	  * 查找记录条数
	  * tablename---表名字
	  * arr1--值数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  */
	  function selectCount($tablename='',$arr1=array(),$arr2=array(),$arr3=array()){
		  $num=0;
		  $sql="SELECT COUNT(0) c FROM ".$tablename." WHERE 1=1";
		  if(!@empty($arr1) && @count($arr1)>0){
              for($i=0;$i<count($arr1);$i++){
			//	  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
			//		  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
            //             $arr1[$i]=intval($arr1[$i]);
			//		  }else{
			//			 $arr1[$i]=floatval($arr1[$i]);
			//		  }
			//		  $sql=$sql." AND ".$arr2[$i]."=".$arr1[$i];
			//	  }else{
					  $sql=$sql." AND ".$arr2[$i]."='".$arr1[$i]."'";
			//	  }
			  }
		  }

		  $res=mysql_query($sql);
		  $row=mysql_fetch_array($res,MYSQL_BOTH);
		  $num=$row['c'];
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);
		  unset($row);

		  return $num;
	  }

	  /*
	  * 分页
	  * tablename---表名字
	  * arr1--值数组
	  * arr2--表字段名数组
	  * arr3--数据类型数组
	  * order_str--排序
	  * start--起始位置
	  * pageSize--每页显示多少条
	  */
	  function selectPage($tablename='',$arr1=array(),$arr2=array(),$arr3=array(),$order_str='',$start=0,$pageSize=1){
		  $sql="SELECT * FROM ".$tablename." WHERE 1=1";
		  if(!@empty($arr1) && @count($arr1)>0){
              for($i=0;$i<count($arr1);$i++){
			//	  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx) || in_array(strtoupper($arr3[$i]),$this->float_sjlx)){
			//		  if(in_array(strtoupper($arr3[$i]),$this->int_sjlx)){
            //             $arr1[$i]=intval($arr1[$i]);
			//		  }else{
			//			 $arr1[$i]=floatval($arr1[$i]);
			//		  }
			//		  $sql=$sql." AND ".$arr2[$i]."=".$arr1[$i];
			//	  }else{
					  $sql=$sql." AND ".$arr2[$i]."='".$arr1[$i]."'";
			//	  }
			  }
		  }

		  if(strlen($order_str)>0){
             $sql=$sql." ORDER BY ".$order_str;
		  }
          
		  $sql=$sql." LIMIT ".$start.",".$pageSize;

		  $res=mysql_query($sql);
		  $back_arr=array();
		  while($row=mysql_fetch_array($res,MYSQL_BOTH)){
              $back_arr=array_pad($back_arr,count($back_arr)+1,$row);
		  }
          $this->free_result($res);//释放结果内存
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);

		  return $back_arr;
	  }

	  /*
	  * 查找记录条数--直接传sql语句来执行
	  * sql---sql语句
	  */
	  function select_Num($sql){
		  $res=mysql_query($sql);
		  $num=mysql_num_rows($res);
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($res);
		  
		  return $num;
	  }
      
      /*
	  * 查找单个--直接传sql语句来执行
	  * sql---sql语句
	  */
	  function select_Single($sql){
		  $res=mysql_query($sql);
		  $row=mysql_fetch_array($res,MYSQL_BOTH);
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($res);
		  
		  return $row;
	  }

	  /*
	  * 查找多个--直接传sql语句来执行
	  * sql---sql语句
	  * order_str--排序
	  */
	  function select_All($sql,$order_str=''){
		  if(strlen($order_str)>0){
             $sql=$sql." ORDER BY ".$order_str;
		  }

		  $res=mysql_query($sql);
		  $back_arr=array();
		  while($row=mysql_fetch_array($res,MYSQL_BOTH)){
              $back_arr=array_pad($back_arr,count($back_arr)+1,$row);
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($res);

		  return $back_arr;
	  }

	  /*
	  * 查找记录条数--直接传sql语句来执行
	  * sql---sql语句
	  */
	  function select_Count($sql){
		  $num=0;
		  $res=mysql_query($sql);
		  $num=mysql_num_rows($res);
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($res);

		  return $num;
	  }

	  /*
	  * 分页--直接传sql语句来执行
	  * sql---sql语句
	  * order_str--排序
	  * start--起始位置
	  * pageSize--每页显示多少条
	  */
	  function select_Page($sql,$order_str='',$start=0,$pageSize=1){
		  if(strlen($order_str)>0){
             $sql=$sql." ORDER BY ".$order_str;
		  }
          
		  $sql=$sql." LIMIT ".$start.",".$pageSize;

		  $res=mysql_query($sql);
		  $back_arr=array();
		  while($row=mysql_fetch_array($res,MYSQL_BOTH)){
              $back_arr=array_pad($back_arr,count($back_arr)+1,$row);
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($res);

		  return $back_arr;
	  }

	  /*
	  * ****************以下为生成缓存或者为生成缓存文件做准备的*************************************
	  */

	  /*
	  * 查找所有的表名
	  */
	  function tables(){
		  $sql="SHOW TABLES";
		  $res=mysql_query($sql);
		  $arr=array();
		  while($row=mysql_fetch_array($res,MYSQL_BOTH)){
             $arr=array_pad($arr,count($arr)+1,$row['Tables_in_'.$this->dbname]);
		  }
		  $this->free_result($res);//释放结果内存
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);

		  return $arr;
	  }

	  /*
	  * 查找表的信息---如:字段名、数据类型、默认值
	  */
	  function fields($table){
	     $arr = array();
		 $sql="SHOW COLUMNS FROM ".$table;
		 $res=mysql_query($sql);
         while($row=mysql_fetch_array($res,MYSQL_BOTH)){
			 $arr1=array();
			 $arr1=array_pad($arr1,count($arr1)+1,$row['Field']);
             //对数据类型的处理
			 if(strpos(strtoupper($row['Type']),'TINYINT')!==false || strpos(strtoupper($row['Type']),'INT')!==false || strpos(strtoupper($row['Type']),'SMALLINT')!==false ||  strpos(strtoupper($row['Type']),'MEDIUMINT')!==false || strpos(strtoupper($row['Type']),'BIGINT')!==false || strpos(strtoupper($row['Type']),'BIT')!==false || strpos(strtoupper($row['Type']),'BOOL')!==false || strpos(strtoupper($row['Type']),'INTEGER')!==false){
                $arr1=array_pad($arr1,count($arr1)+1,'INT');
			 }else{
				 if(strpos(strtoupper($row['Type']),'FLOAT')!==false || strpos(strtoupper($row['Type']),'DOUBLE')!==false || strpos(strtoupper($row['Type']),'REAL')!==false || strpos(strtoupper($row['Type']),'DECIMAL')!==false || strpos(strtoupper($row['Type']),'NUMERIC')!==false){
					 $arr1=array_pad($arr1,count($arr1)+1,'FLOAT');
				 }else{
                     $arr1=array_pad($arr1,count($arr1)+1,'VARCHAR');
				 }
			 }
			 //$arr1=array_pad($arr1,count($arr1)+1,$row['Type']);
			 $arr1=array_pad($arr1,count($arr1)+1,$row['Null']);
			 $arr1=array_pad($arr1,count($arr1)+1,$row['Key']);
			 $arr1=array_pad($arr1,count($arr1)+1,$row['Default']);
			 $arr1=array_pad($arr1,count($arr1)+1,$row['Extra']);

			 $arr=array_pad($arr,count($arr)+1,$arr1);
		 }

		 $this->free_result($res);//释放结果内存
		 $arr=$this->array2array($arr);//二维数组的转换
          
		  /*
		  * 注销变量
		  */
		  unset($sql);
		  unset($res);

		  return $arr;
	  }

	  /*
	  * 查找所有表的字段信息
	  */
	  function tables_fields(){
		 $arr=array();
         $arr1=$this->tables();//查找所有的表名
		 for($i=0;$i<count($arr1);$i++){
			 $arr[$arr1[$i]]=$this->fields($arr1[$i]);//查找表的信息---如:字段名、数据类型、默认值
		 }

         /*
		 * 注销变量
		 */
		 unset($arr1);

         return $arr;
	  }
      
	  /*
	  * 二维数组的转换
	  */
	  function array2array($arr=array()){
		  $back_arr=array();
		  for($i=0;$i<count($arr);$i++){
			  for($j=0;$j<count($arr[$i]);$j++){
				  $back_arr[$j][$i]=$arr[$i][$j];
			  }
		  }
		  return $back_arr;
	  }

	  /*
	  * 关闭数据库连接
	  */
	  function close(){
		  mysql_close($this->dblink);
	  }
   }
   	//测试用的代码
	  //$db=new Mysql('localhost','root','123','leetobest','utf8');
	  //$a=$db->update("contents",array('1.html',1),array("contents_url","contents_id"),array('VARCHAR','INTEGER'));
      
?>