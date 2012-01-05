<?php
    /*
	* 对数组的处理
	*/

	/*
	* 删除数组元素
	*
	*/
	function delete_array($arr_1=array(),$arr_2=array()){
       for($x=0;$x<count($arr_1);$x++){
           $ar_r1=explode('@',$arr_1[$x]);
		   for($y=0;$y<count($arr_2);$y++){
			   $ar_r2=explode('@',$arr_2[$y]);
			   if($ar_r1[0]==$ar_r2[0]){
				   unset($arr_1[$x]);
			   }
		   }
	   }

	   $arr_last=array();
	   foreach($arr_1 as $value){
		   array_push($arr_last,$value);
	   }
	   return $arr_last;
	}
    
	//测试数据
	/*$arr1=array('1@0@aa','2@0@bb','3@1@cc','4@1@dd','5@2@ee','6@3@ff');
	$arr2=array('2@0@丰富的爽肤水','5@2@也太容易人体');

    $back=delete_array($arr1,$arr2);
	if(is_array($back)){
		for($z=0;$z<count($back);$z++){
			echo $back[$z].'<br>';
		}
	}*/
?>