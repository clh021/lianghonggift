<?php
    /*
	* �ݹ���
	*/

	class Recursive{
	   var $arr=array();//������������
	   var $back='';//����ֵ
	   var $character='&nbsp;&nbsp;';//������

       /*
	   * ���캯��
	   */
	   function Recursive($arr=array(),$character='&nbsp;&nbsp;'){
		   $this->arr=$arr;
		   $this->character=$character;
	   }
       
	   /*
	   * �ݹ�
	   * 
	   * m--���ĸ�id��ʼ
	   * n--��������
	   */
	   function digui($m='0',$n=0){
		   for($i=0;$i<count($this->arr);$i++){
			   $arr1=explode('-',$this->arr[$i]);
			   if($arr1[2]==$m){
                  $html=$this->incremental($n);
				  $this->back=$this->back.$arr1[0]."@".$arr1[1]."@".$arr1[2]."@".$html.$arr1[3]."!";//ֵ��ֵ֮����"@"�ֿ�,ÿ��ֵ��"!"�ֿ�--ÿ�����ɣ�����id@���@��ID@����
				  $j=$n+1;
                  $this->digui($arr1[0],$j);
			   }
		   }
	   }
       
	   /*
	   * ����
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
	* ��������
	*/
	//$arr=array('1-1-0-aa','2-2-0-bb','3-1-1-cc','4-1-1-dd','5-2-2-ee','6-1-3-ff');//����ID-���-��ID-����
    //$rec=new Recursive($arr);
	//$rec->digui('1',0);
	//echo $rec->back;
?>