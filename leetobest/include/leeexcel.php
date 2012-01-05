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
     
	 //测试用的
     /*$back_arr=readExcel(FILE_PATH.UPLOAD_PATH.'201010260236513136.xls');
	 print_r($back_arr);
     $arr_title=array('账号','姓名');
	 $arr_value=array(array('张三','张e三'),array('李四','李rr5四'),array('王五','王rr5五'));
	 writeExcel($arr_value,$arr_title);
	 echo FILE_PATH.UPLOAD_PATH;*/
	 
/*以下代码是用于测试和增强功能时参考之用。
	$php_excel=new PHPExcel();
	//$php_excel->getProperties()->setCreator("陈良红，PHP，excel的创建人");
	//$php_excel->getProperties()->setLastModifiedBy("陈良红，最后的修改人");
	//$php_excel->getProperties()->setTitle("陈良红设置的标题");
	//$php_excel->getProperties()->setSubject("陈良红设置，据说这是题目");
	//$php_excel->getProperties()->setDescription("陈良红设置的描述");
	//$php_excel->getProperties()->setKeywords("陈良红关键字");
	//$php_excel->getProperties()->setCategory("陈良红类别种类");
	//经过测试，以上类容并没有写入文件。
	$sheet= $php_excel->setActiveSheetIndex(0);//选定第一张表
	//【经过测试，目前似乎只能操作第一张表】
	$sheet->settitle("第一张表格的标题");
	$sheet->setCellValue("A1","这是第一行的第一列的值,宽度为100");
	$sheet->setCellValue("B1","这是第一行的第二列的值,宽度为100");
	$sheet->setCellValue("C1","这是第一行的第三列的值,宽度自动");
	$sheet->setCellValue("A2","这是第二行的第一列的值");
	$sheet->setCellValue("B2","这是第二行的第二列的值");
	$sheet->setCellValue("C5","这是第五行的第三列的值");
	//插入中文，建议使用utf-8 的编码
	$sheet->setCellValue("A3",iconv("gbk","utf-8","这是第三行的第一列的值"));
	$sheet->setCellValue("B3",iconv("gbk","utf-8","这是第三行的第二列的值"));
	$sheet->setCellValue("B4",iconv("utf-8","gbk","这是第四行的第二列的值"));
	$sheet->setCellValue("C7",iconv("utf-8","gbk","这是第七行的第三列的值"));

	//下面是一些比较花哨的功能。颜色和样式等。有一个单元格居中的功能建议大家通用
	//$sheet= $php_excel->setActivesheetIndex(1);
	$sheet->settitle("表格2字体和颜色");
	$sheet->setCellValue("A8","粗体字体");
	$sheet->setCellValue("B8","Candara的字体");
	$sheet->setCellValue("C8","大小为20的字体");
	$sheet->setCellValue("A9","带下划线的字体FF9933");
	$sheet->setCellValue("B9","宋体");
	$sheet->setCellValue("C10","楷体50号蓝色字体");
	$sheet->getStyle('A8')->getFont()->setBold(true);
	$sheet->getStyle('B8')->getFont()->setName('Candara');//字体名
	$sheet->getStyle('C8')->getFont()->setSize(90);//字体大小
	$sheet->getStyle('A9')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);//下划线
	$sheet->getStyle('B9')->getFont()->setName('宋体');//字体名
	$sheet->getStyle('C8')->getFont()->setSize(20);
	$sheet->getStyle('C10')->getFont()->setName('楷体');//字体名
	$sheet->getStyle('C10')->getFont()->setSize(50);

	$sheet->getStyle('A9')->getBorders()->getTop()->getColor()->setARGB('FF9933');
	$sheet->getStyle('A9')->getBorders()->getLeft()->getColor()->setARGB('FF9933');
	$sheet->getStyle('A9')->getBorders()->getBottom()->getColor()->setARGB('FF9933');
	$sheet->getStyle('A9')->getBorders()->getRight()->getColor()->setARGB('FF9933');

	$sheet->getStyle('A9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$sheet->getStyle('C10')->getFill()->getStartColor()->setARGB('0000ff');

	$sheet->getColumnDimension('A')->setWidth(100);//指定大小
	$sheet->getColumnDimension('B')->setWidth(100);//指定大小
	$sheet->getColumnDimension('C')->setAutoSize(true);//自动
	*/
?>