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
		   for($i=0;$i<count($this->arr);$i++){//���� ������������
			   $arr1=explode('-',$this->arr[$i]);//��ÿ�������е�Ԫ�أ�����"-"���ŷָ��Ϊһ���µ�����
			   if($arr1[1]==$m){//�����Ѿ�Լ���õĸ�ʽ���ڶ�λ���ڶ���������Ԫ�ء��Ǹ�ID���Ӹ�IDΪָ��Ҫ��ʼִ�еݹ��ID��ʼ��
                  $html=$this->incremental($n);//���������ַ��ĳ��ȣ�����������ı�����
				  $this->back=$this->back.$arr1[0]."@".$arr1[1]."@".$html.$arr1[2]."!";//ʹ��@�����������ַ����������鴮����Ҫ���ص��ַ����С�
				  //���ر�ע�⡿��ֵ��ֵ֮����"@"�ֿ�,ÿ��ֵ��"!"�ֿ�--ÿ�����ɣ�����id@��ID@����
				  $j=$n+1;//������ֵ����һ�����ȡ�
                  $this->digui($arr1[0],$j);//�ٴ��Ա���ID��Ϊ��IDȥ�����������������
			   }
		   }
	   }
       
	   /*
	   * ����
	   */
	   function incremental($n=0){
		   $str='';
		   for($j=0;$j<$n;$j++){//���ݸ�������������������������������������أ�Ĭ������0���ַ���
               $str=$str.$this->character;
		   }
		   return  $str;
	   }
	}
    
	/*
	* ��������
	*/
	/*
	$arr=array('1-0-aa','2-0-bb','3-1-cc','4-1-dd','5-2-ee','6-3-ff');//����ID-��ID-����
    $rec=new Recursive($arr);
	$rec->digui('0',0);
	echo $rec->back;//
	*/
?>