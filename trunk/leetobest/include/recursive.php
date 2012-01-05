<?php
    /*
	* 递归类
	*/

	class Recursive{
	   var $arr=array();//传进来的数组
	   var $back='';//返回值
	   var $character='&nbsp;&nbsp;';//缩进符

       /*
	   * 构造函数
	   */
	   function Recursive($arr=array(),$character='&nbsp;&nbsp;'){
		   $this->arr=$arr;
		   $this->character=$character;
	   }
       
	   /*
	   * 递归
	   * 
	   * m--从哪个id开始
	   * n--缩进参数
	   */
	   function digui($m='0',$n=0){
		   for($i=0;$i<count($this->arr);$i++){//遍历 传进来的数组
			   $arr1=explode('-',$this->arr[$i]);//将每个数组中的元素，依据"-"符号分割成为一个新的数组
			   if($arr1[1]==$m){//依据已经约定好的格式，第二位【第二个新数组元素】是父ID。从父ID为指定要开始执行递归的ID开始。
                  $html=$this->incremental($n);//给定缩进字符的长度，定义好缩进的变量。
				  $this->back=$this->back.$arr1[0]."@".$arr1[1]."@".$html.$arr1[2]."!";//使用@，！等特殊字符，将新数组串联到要返回的字符串中。
				  //【特别注意】：值与值之间用"@"分开,每组值用"!"分开--每组的组成：本身id@父ID@名称
				  $j=$n+1;//将缩进值增加一个长度。
                  $this->digui($arr1[0],$j);//再次以本身ID作为父ID去遍历出其下所有子项。
			   }
		   }
	   }
       
	   /*
	   * 缩进
	   */
	   function incremental($n=0){
		   $str='';
		   for($j=0;$j<$n;$j++){//依据给定的缩进长度来，定义好缩进变量，并返回，默认缩进0个字符。
               $str=$str.$this->character;
		   }
		   return  $str;
	   }
	}
    
	/*
	* 测试数据
	*/
	/*
	$arr=array('1-0-aa','2-0-bb','3-1-cc','4-1-dd','5-2-ee','6-3-ff');//本身ID-父ID-名称
    $rec=new Recursive($arr);
	$rec->digui('0',0);
	echo $rec->back;//
	*/
?>