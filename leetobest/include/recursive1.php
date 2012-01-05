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
		   for($i=0;$i<count($this->arr);$i++){
			   $arr1=explode('-',$this->arr[$i]);
			   if($arr1[2]==$m){
                  $html=$this->incremental($n);
				  $this->back=$this->back.$arr1[0]."@".$arr1[1]."@".$arr1[2]."@".$html.$arr1[3]."!";//值与值之间用"@"分开,每组值用"!"分开--每组的组成：本身id@类别@父ID@名称
				  $j=$n+1;
                  $this->digui($arr1[0],$j);
			   }
		   }
	   }
       
	   /*
	   * 缩进
	   */
	   function incremental($n=0){
		   $str='';
		   for($j=0;$j<$n;$j++){
               $str=$str.$this->character;
		   }
		   return  $str;
	   }
	}
    
	/*
	* 测试数据
	*/
	//$arr=array('1-1-0-aa','2-2-0-bb','3-1-1-cc','4-1-1-dd','5-2-2-ee','6-1-3-ff');//本身ID-类别-父ID-名称
    //$rec=new Recursive($arr);
	//$rec->digui('1',0);
	//echo $rec->back;
?>