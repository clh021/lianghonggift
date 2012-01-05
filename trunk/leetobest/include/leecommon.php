<?php
    set_magic_quotes_runtime(0);//
	function strip_sql($string){ //����SQL�ű������ַ�
		//array_map ���ص��������õ���������ĵ�Ԫ��
		//preg_replace ִ��������ʽ���������滻
		$search_arr = array("/ union /i","/ select /i","/ update /i","/ outfile /i","/ or /i");
		$replace_arr = array('&nbsp;union&nbsp;','&nbsp;select&nbsp;','&nbsp;update&nbsp;','&nbsp;outfile&nbsp;','&nbsp;or&nbsp;');
		return is_array($string) ? array_map('strip_sql', $string) : preg_replace($search_arr, $replace_arr, $string);
		//��������飬�͵ݹ飻���򣬹���SQl�����ַ�
	}

	function new_htmlspecialchars($string){//���±���Ϊҳ�������ʾ�ı���
		return is_array($string) ? array_map('new_htmlspecialchars', $string) : htmlspecialchars($string,ENT_QUOTES);
		//																ʹ��html���룬ʹԭ�ַ�����ԭ����ӡ��ҳ���ϣ�����г�ͻ�����������еı�����
	}

	function new_addslashes($string){//ʹ�÷�б�������ַ���,�Ǵ������ݿ����Ҫ(����Ӧ�ķ�������û�п���ʱ)
		if(!is_array($string)) return addslashes($string);//�������飬ֱ��ת�����ǣ����θ���ת��
		foreach($string as $key => $val) $string[$key] = new_addslashes($val);
		return $string;
	}

	function new_stripslashes($string){//����б�ܷ�ת�룬ÿ���������ķ�б�ܷ�ת��Ϊһ����б�ܣ�����תΪ��
		if(!is_array($string)) return stripslashes($string);//
		foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
		return $string;
	}

	function strip_textarea($string){//�������ַ��е���ҳ�����ַ�ת��Ϊ��Ӧ�ı���
		return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string, ENT_QUOTES)));
	}

	function strip_js($string, $js = 1){//����JS�ű������ַ�
		$string = str_replace(array("\n","\r","\""),array('','',"\\\""),$string);
		return $js==1 ? "document.write(\"".$string."\");\n" : $string;
	}

	function safe_replace($string){//��ȫ��ĸ�滻���������ַ����е������ַ��滻Ϊ��
	   $string = str_replace('%20','',$string);
	   $string = str_replace('%27','',$string);
	   $string = str_replace('*','',$string);
	   $string = str_replace('"','&quot;',$string);
	   $string = str_replace("'",'',$string);
	   $string = str_replace("\"",'',$string);
	   $string = str_replace('//','',$string);
	   $string = str_replace(';','',$string);
	   $string = str_replace('<','&lt;',$string);
	   $string = str_replace('>','&gt;',$string);
	   $string = str_replace('(','',$string);
	   $string = str_replace(')','',$string);
	   $string = str_replace("{",'',$string);
	   $string = str_replace('}','',$string);
	   return $string;
	}
	//�����п��ܴ������ݵĵ㣬������SQL�����ַ�
	$_POST = strip_sql($_POST);
	$_GET = strip_sql($_GET);
	$_REQUEST = strip_sql($_REQUEST);
	$_COOKIE = strip_sql($_COOKIE);

	$magic_quotes_gpc = get_magic_quotes_gpc();//��������ļ��е��Զ�ת��Ϊ�������ݿ��Ƿ���
	if(!$magic_quotes_gpc){//���û�п����������Ѿ�����õĴ���ת��
		$_POST = new_addslashes($_POST);
		$_GET = new_addslashes($_GET);
		$_REQUEST = new_addslashes($_REQUEST);
		$_COOKIE = new_addslashes($_COOKIE);
	}
	//�������н��������뵽��ǰ�ķ��ű�
	@extract($_POST,EXTR_SKIP);
	@extract($_GET,EXTR_SKIP);
	@extract($_REQUEST,EXTR_SKIP);
	@extract($_COOKIE,EXTR_SKIP);

	//$_SERVER
	//$_SESSION
	//$_FILES  //���߸�ȫ�ֱ���
	
	//ͨ����֤���˵ķ���
	//����˵����
	//object,Ҫ������֤�Ķ������
	//class,�������������
	//notnull || null,�Ƿ�����Ϊ�գ�����������Զ��滻Ϊ �ַ���'';
	//help || nothelp || not ,�Ƿ���ˡ�&nbsp�����߶�������
	//chinese,����˵�������������Ӣ�ģ�������Ϊ�˵���������ʾ��
	//min,�����������ֵ��Ϊ��Сֵ������������ַ�����Ϊ��С���ȡ�������Χ�ڵģ�
	//max,���������������ֵΪ���ֵ������������ַ�������ֵΪ��󳤶ȡ�������Χ�ڵģ��ַ�����'@'�����������
	function check_validate($object='',$class='',$notnull='',$help='',$chinese='',$min='',$max=''){
		if(strlen($class)<=0||strlen($notnull)<=0||strlen($help)<=0||strlen($chinese)<=0||strlen($min)<=0||strlen($max)<=0){
			msg_back('��֤��������֤�����������');
		}
		$temp=trim($object);
		if($notnull===true){
			if(strlen($object)<=0 && $notnull==="notnull"){
				msg_back($chinese.'������Ϊ��');
			}elseif(strlen($object)<=0 && $notnull==="null"){
				$temp='';
			}else{
				msg_back($chinese.'����Ϊ��');
			}
		}
		if($help==="help"){
			$temp=helphtml($temp);//�˴�������'&nbsp'
		}elseif($help==="nothelp"){
			$temp=html($temp);//�˴��������е�html���
		}elseif($help==="not"){
			$temp='&nbsp;'.$temp;//�˴��������е�html���
		}
		switch($class){
			case "int":
			case "intval":
			case "INTVAL":
			case "integer":
			case "INTEGER":
				$temp=intval($temp);
				$min=intval($min);
				if($max==='@'){
					if($temp<$min){
						msg_back('������ġ�'.$chinese.'����ӦС��'.$min.'�������ԡ�');
					}
				}else{
					$max=intval($max);
					if($temp<$min){
						msg_back('������ġ�'.$chinese.'����ӦС��'.$min.'�������ԡ�');
					}elseif($temp>$max){
						msg_back('������ġ�'.$chinese.'����Ӧ����'.$max.'�������ԡ�');
					}
				}
				break;
			case "float":
			case "FLOAT":
				$temp=floatval($temp);
				$min=floatval($min);
				if($max==='@'){
					if($temp<$min){
						msg_back('������ġ�'.$chinese.'����ӦС��'.$min.'�������ԡ�');
					}
				}else{
					$max=floatval($max);
					if($temp<$min){
						msg_back('������ġ�'.$chinese.'����ӦС��'.$min.'�������ԡ�');
					}elseif($temp>$max){
						msg_back('������ġ�'.$chinese.'����Ӧ����'.$max.'�������ԡ�');
					}
				}
				break;
			case "str":
			case "string":
			case "STRING":
				$min=intval($min);
				if($max==='@'){
					if(strlen($temp)<$min){
						msg_back('������ġ�'.$chinese.'�����Ȳ�ӦС��'.$min.'�������ԡ�');
					}
				}else{
					$max=intval($max);
					if(strlen($temp)<$min){
						msg_back('������ġ�'.$chinese.'�����Ȳ�ӦС��'.$min.'�������ԡ�');
					}elseif(strlen($temp)>$max){
						msg_back('������ġ�'.$chinese.'�����Ȳ�Ӧ����'.$max.'�������ԡ�');
					}
				}
				break;
			default:
				msg_back('��֤�������ݲ�֧��"'.$class.'"���͡�');
				break;
		}
		unset ($object,$class,$notnull,$help,$chinese,$min,$max);
		return $temp;
	}
//���Դ���
	//$demo=check_validate(9999999,'int',true,true,'ʾ��ֵ',0,'99999');
	//$demo=check_validate('fd9fdsfdsa9','str',true,true,'ʾ��ֵ',0,1);
	//echo $demo;
	//return;
?>