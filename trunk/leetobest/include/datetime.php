<?php
     /*
	 * 对日期和时间的处理
	 */
     
	 /*
	 * int型的时间转换为string型时间
	 * time_int---int型数据
	 */
	 function intToString($time=0){
		return date("Y-m-d H:i:s",$time); 
	 }

	 /*
	 * 把string型的时间转换为int---秒
	 * 格式:如1977-05-03 11:12:33
	 */
	 function stringToInt($str_date=''){
		$second=0;//秒
		if(@strlen($str_date)>0){
			$arr=explode(' ',$str_date);

			$arr1=@explode('-',$arr[0]);//年-月-日
			$year=@intval($arr1[0]);//年份数
			$month=@intval($arr1[1]);//月份数
			$day=@intval($arr1[2]);//天数

			$arr2=@explode(':',$arr[1]);//时:分:秒
			$hour=@intval($arr2[0]);//小时数
			$minute=@intval($arr2[1]);//分钟数
			$sec=@intval($arr2[2]);//秒数(一分钟之内)

			$second=mktime($hour,$minute,$sec,$month,$day,$year);
		}

		return $second;
	 }

	 /*
	 * 判断是不是同一天
	 */
	 function curr_day($time=0,$pre_time=0){
		 $flag=false;
		 if($pre_time<=0){
			 $pre_time=time();
		 }

		 if($time<=0){
			 $time=time();
		 }
		 $arr=getdate($time);
		 //print_r($arr);echo '<br>';
		 $arr_pre=getdate($pre_time);
		 //print_r($arr_pre);echo '<br>';
		 if($arr['year']==$arr_pre['year'] && $arr['yday']==$arr_pre['yday']){//表示是同一天
            $flag=true; 
		 }
		 return $flag;
	 }
     
	 /*
	 * 判断是不是本周
	 */
	 function curr_week($time=0,$pre_time=0){
		 $flag=false;
		 if($pre_time<=0){
			 $pre_time=time();
		 }

		 if($time<=0){
			 $time=time();
		 }
		 $arr=getdate($time);
		 $arr_pre=getdate($pre_time);
		 if($arr['year']==$arr_pre['year'] && getWeek($time)==getWeek($pre_time)){//表示是本周
            $flag=true; 
		 }
		 return $flag;
	 }

	 /*
	 * 判断是不是本月
	 */
	 function curr_month($time=0,$pre_time=0){
		 $flag=false;
		 if($pre_time<=0){
			 $pre_time=time();
		 }

		 if($time<=0){
			 $time=time();
		 }
		 $arr=getdate($time);
		 $arr_pre=getdate($pre_time);
		 if($arr['year']==$arr_pre['year'] && $arr['mon']==$arr_pre['mon']){//表示是本月
            $flag=true; 
		 }
		 return $flag;
	 }

	 /*
	 * 判断是不是本年
	 */
	 function curr_year($time=0,$pre_time=0){
		 $flag=false;
		 if($pre_time<=0){
			 $pre_time=time();
		 }

		 if($time<=0){
			 $time=time();
		 }
		 $arr=getdate($time);
		 $arr_pre=getdate($pre_time);
		 if($arr['year']==$arr_pre['year']){//表示是本年
            $flag=true; 
		 }
		 return $flag;
	 }

	 /*
	 * 一年中第几周
	 */
	 function getWeek($time=0){
		 $num=0;
		 if($time<=0){
			 $time=time();
		 }
		 $date_arr = getdate($time);
		 $year  = strtotime($date_arr['year'].'-01-01');
		 $start_date = getdate($year); 
		 $firstweekday  = 7-$start_date['wday'];//获得第一周几天  
         $yday = $date_arr['yday']+1-$firstweekday;//今年的第几天
		 $num=ceil($yday/7)+1;//取到第几周 
		 return $num;
	 }
     
	 //echo getWeek();
	 //echo intToString(1285862400);
	 //echo '<br>';
	 //echo stringToInt('2010-10-01');
	 //echo '<br>';
	 //print_r(getdate(time()));
?>