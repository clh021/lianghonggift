<?php
     /*
	 * php对excel的操作
	 */
     header("content-type:text/html;charset=utf-8");//设置页面编码
     //include 'config.php';

	 /*
	 * php对excel的读
	 *
	 * filePath---文件路径
	 * 返回一个数组
	 */
	 function readExcel($filePath=''){
        $arr=array();
		if(@strlen($filePath)>0){
			include 'Classes/PHPExcel/Reader/Excel5.php';
	        //include 'Classes/PHPExcel/Reader/Excel2007.php';//excel2007就加载
	        $objReader = new PHPExcel_Reader_Excel5();//产生新的对象
            $objPHPExcel = $objReader->load($filePath);//加载excel文件
            $sheet = $objPHPExcel->getActiveSheet(0);
	        $highestRow = $sheet->getHighestRow(); // 取得总行数 
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数

			for($i=2;$i<=$highestRow;$i++){
				$arr1=array();
				for($j='A';$j<=$highestColumn;$j++){//尤其注意:在php循环里,可以是以单个字符作为循环
					$value=@trim($sheet->getCell("$j$i")->getValue());//取具体单元格的值
					if($value!=null && $value!=''){
						$arr1=array_pad($arr1,count($arr1)+1,$value);
					}
				}
				array_push($arr,$arr1);
			}
		}

		return $arr;
	 }
     
	 /*
	 * php对excel的写
	 *
	 * arr--值
	 * arr1--excel的第一行标题
	 *
	 * 返回一个文件路径
	 */
	 function writeExcel($arr=array(),$arr1=array(),$title='Sheet1',$upfile=UPLOAD_PATH,$path=FILE_PATH){
		 $filepath='';
		 if(@count($arr)>0){
			 //加载文件
	         include 'Classes/PHPExcel.php';
             include 'Classes/PHPExcel/Writer/Excel5.php';
	         //include '../PHPExcel/Writer/Excel2007.php';//excel2007就加载这个

	         $php_excel= new PHPExcel();//创建一个excel对象

			 /*
			 * 设置sheet
			 */
			 $sheet = $php_excel->setActiveSheetIndex(0);//设置当前的sheet
			 $sheet->setTitle($title);//设置sheet的name

			 /*
			 * 设置单元格的值
			 */
			 //添加excel表格第一行的值
			 for($i=65;$i<count($arr1)+65;$i++){
                 $zimu=chr($i);//chr--该函数用于将ASCII码值转化为字符串;old--该函数用于将字符串转化为ASCII码值
                 $sheet->setCellValue($zimu.'1',$arr1[$i-65]);
			 }
             //添加数据
			 for($j=0;$j<count($arr);$j++){
				 for($k=0;$k<count($arr[$j]);$k++){
                     $zimu=chr(65+$k);
					 $cell=$zimu.($j+2);
                     $sheet->setCellValue($cell,$arr[$j][$k]);
				 }
			 }
			 
			 $writer = new PHPExcel_Writer_Excel5($php_excel);
			 //$writer = new PHPExcel_Writer_Excel2007($php_excel);//保存为2007格式
             
			 date_default_timezone_set(TIMEZONE);//设置一个时间分区
		     $dt=date('YmdHis');
		     $rj=rand();
		     $writeFileName=$dt.$rj.'.xls';
		     $writeFileName=$upfile.$writeFileName;

			 $filepath=$writeFileName;
			 $writeFileName=$path.$writeFileName;
			 //保存到文件    
			 $writer->save($writeFileName);  
		 }

		 return $filepath;
	 }
     
	 //测试代码
     /*$back_arr=readExcel(FILE_PATH.UPLOAD_PATH.'201010260236513136.xls');
	 print_r($back_arr);
     $arr_title=array('账号','姓名');
	 $arr_value=array(array('张三','张e三'),array('李四','李rr5四'),array('王五','王rr5五'));
	 writeExcel($arr_value,$arr_title);
	 echo FILE_PATH.UPLOAD_PATH;*/
?>