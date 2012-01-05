<?php
     /*
	 * php��excel�Ĳ���
	 */
     header("content-type:text/html;charset=utf-8");//����ҳ�����
     //include 'config.php';

	 /*
	 * php��excel�Ķ�
	 *
	 * filePath---�ļ�·��
	 * ����һ������
	 */
	 function readExcel($filePath=''){
        $arr=array();
		if(@strlen($filePath)>0){
			include 'Classes/PHPExcel/Reader/Excel5.php';
	        //include 'Classes/PHPExcel/Reader/Excel2007.php';//excel2007�ͼ���
	        $objReader = new PHPExcel_Reader_Excel5();//�����µĶ���
            $objPHPExcel = $objReader->load($filePath);//����excel�ļ�
            $sheet = $objPHPExcel->getActiveSheet(0);
	        $highestRow = $sheet->getHighestRow(); // ȡ�������� 
            $highestColumn = $sheet->getHighestColumn(); // ȡ��������

			for($i=2;$i<=$highestRow;$i++){
				$arr1=array();
				for($j='A';$j<=$highestColumn;$j++){//����ע��:��phpѭ����,�������Ե����ַ���Ϊѭ��
					$value=@trim($sheet->getCell("$j$i")->getValue());//ȡ���嵥Ԫ���ֵ
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
	 * php��excel��д
	 *
	 * arr--ֵ
	 * arr1--excel�ĵ�һ�б���
	 *
	 * ����һ���ļ�·��
	 */
	 function writeExcel($arr=array(),$arr1=array(),$title='Sheet1',$upfile=UPLOAD_PATH,$path=FILE_PATH){
		 $filepath='';
		 if(@count($arr)>0){
			 //�����ļ�
	         include 'Classes/PHPExcel.php';
             include 'Classes/PHPExcel/Writer/Excel5.php';
	         //include '../PHPExcel/Writer/Excel2007.php';//excel2007�ͼ������

	         $php_excel= new PHPExcel();//����һ��excel����

			 /*
			 * ����sheet
			 */
			 $sheet = $php_excel->setActiveSheetIndex(0);//���õ�ǰ��sheet
			 $sheet->setTitle($title);//����sheet��name

			 /*
			 * ���õ�Ԫ���ֵ
			 */
			 //���excel����һ�е�ֵ
			 for($i=65;$i<count($arr1)+65;$i++){
                 $zimu=chr($i);//chr--�ú������ڽ�ASCII��ֵת��Ϊ�ַ���;old--�ú������ڽ��ַ���ת��ΪASCII��ֵ
                 $sheet->setCellValue($zimu.'1',$arr1[$i-65]);
			 }
             //�������
			 for($j=0;$j<count($arr);$j++){
				 for($k=0;$k<count($arr[$j]);$k++){
                     $zimu=chr(65+$k);
					 $cell=$zimu.($j+2);
                     $sheet->setCellValue($cell,$arr[$j][$k]);
				 }
			 }
			 
			 $writer = new PHPExcel_Writer_Excel5($php_excel);
			 //$writer = new PHPExcel_Writer_Excel2007($php_excel);//����Ϊ2007��ʽ
             
			 date_default_timezone_set(TIMEZONE);//����һ��ʱ�����
		     $dt=date('YmdHis');
		     $rj=rand();
		     $writeFileName=$dt.$rj.'.xls';
		     $writeFileName=$upfile.$writeFileName;

			 $filepath=$writeFileName;
			 $writeFileName=$path.$writeFileName;
			 //���浽�ļ�    
			 $writer->save($writeFileName);  
		 }

		 return $filepath;
	 }
     
	 //�����õ�
     /*$back_arr=readExcel(FILE_PATH.UPLOAD_PATH.'201010260236513136.xls');
	 print_r($back_arr);
     $arr_title=array('�˺�','����');
	 $arr_value=array(array('����','��e��'),array('����','��rr5��'),array('����','��rr5��'));
	 writeExcel($arr_value,$arr_title);
	 echo FILE_PATH.UPLOAD_PATH;*/
	 
/*���´��������ڲ��Ժ���ǿ����ʱ�ο�֮�á�
	$php_excel=new PHPExcel();
	//$php_excel->getProperties()->setCreator("�����죬PHP��excel�Ĵ�����");
	//$php_excel->getProperties()->setLastModifiedBy("�����죬�����޸���");
	//$php_excel->getProperties()->setTitle("���������õı���");
	//$php_excel->getProperties()->setSubject("���������ã���˵������Ŀ");
	//$php_excel->getProperties()->setDescription("���������õ�����");
	//$php_excel->getProperties()->setKeywords("������ؼ���");
	//$php_excel->getProperties()->setCategory("�������������");
	//�������ԣ��������ݲ�û��д���ļ���
	$sheet= $php_excel->setActiveSheetIndex(0);//ѡ����һ�ű�
	//���������ԣ�Ŀǰ�ƺ�ֻ�ܲ�����һ�ű�
	$sheet->settitle("��һ�ű��ı���");
	$sheet->setCellValue("A1","���ǵ�һ�еĵ�һ�е�ֵ,���Ϊ100");
	$sheet->setCellValue("B1","���ǵ�һ�еĵڶ��е�ֵ,���Ϊ100");
	$sheet->setCellValue("C1","���ǵ�һ�еĵ����е�ֵ,����Զ�");
	$sheet->setCellValue("A2","���ǵڶ��еĵ�һ�е�ֵ");
	$sheet->setCellValue("B2","���ǵڶ��еĵڶ��е�ֵ");
	$sheet->setCellValue("C5","���ǵ����еĵ����е�ֵ");
	//�������ģ�����ʹ��utf-8 �ı���
	$sheet->setCellValue("A3",iconv("gbk","utf-8","���ǵ����еĵ�һ�е�ֵ"));
	$sheet->setCellValue("B3",iconv("gbk","utf-8","���ǵ����еĵڶ��е�ֵ"));
	$sheet->setCellValue("B4",iconv("utf-8","gbk","���ǵ����еĵڶ��е�ֵ"));
	$sheet->setCellValue("C7",iconv("utf-8","gbk","���ǵ����еĵ����е�ֵ"));

	//������һЩ�Ƚϻ��ڵĹ��ܡ���ɫ����ʽ�ȡ���һ����Ԫ����еĹ��ܽ�����ͨ��
	//$sheet= $php_excel->setActivesheetIndex(1);
	$sheet->settitle("���2�������ɫ");
	$sheet->setCellValue("A8","��������");
	$sheet->setCellValue("B8","Candara������");
	$sheet->setCellValue("C8","��СΪ20������");
	$sheet->setCellValue("A9","���»��ߵ�����FF9933");
	$sheet->setCellValue("B9","����");
	$sheet->setCellValue("C10","����50����ɫ����");
	$sheet->getStyle('A8')->getFont()->setBold(true);
	$sheet->getStyle('B8')->getFont()->setName('Candara');//������
	$sheet->getStyle('C8')->getFont()->setSize(90);//�����С
	$sheet->getStyle('A9')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);//�»���
	$sheet->getStyle('B9')->getFont()->setName('����');//������
	$sheet->getStyle('C8')->getFont()->setSize(20);
	$sheet->getStyle('C10')->getFont()->setName('����');//������
	$sheet->getStyle('C10')->getFont()->setSize(50);

	$sheet->getStyle('A9')->getBorders()->getTop()->getColor()->setARGB('FF9933');
	$sheet->getStyle('A9')->getBorders()->getLeft()->getColor()->setARGB('FF9933');
	$sheet->getStyle('A9')->getBorders()->getBottom()->getColor()->setARGB('FF9933');
	$sheet->getStyle('A9')->getBorders()->getRight()->getColor()->setARGB('FF9933');

	$sheet->getStyle('A9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$sheet->getStyle('C10')->getFill()->getStartColor()->setARGB('0000ff');

	$sheet->getColumnDimension('A')->setWidth(100);//ָ����С
	$sheet->getColumnDimension('B')->setWidth(100);//ָ����С
	$sheet->getColumnDimension('C')->setAutoSize(true);//�Զ�
	*/
?>