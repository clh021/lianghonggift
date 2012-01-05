<?php
    set_magic_quotes_runtime(0);//
	function strip_sql($string){ //过滤SQL脚本敏感字符
		//array_map 将回调函数作用到给定数组的单元上
		//preg_replace 执行正则表达式的搜索和替换
		$search_arr = array("/ union /i","/ select /i","/ update /i","/ outfile /i","/ or /i");
		$replace_arr = array('&nbsp;union&nbsp;','&nbsp;select&nbsp;','&nbsp;update&nbsp;','&nbsp;outfile&nbsp;','&nbsp;or&nbsp;');
		return is_array($string) ? array_map('strip_sql', $string) : preg_replace($search_arr, $replace_arr, $string);
		//如果是数组，就递归；否则，过滤SQl敏感字符
	}

	function new_htmlspecialchars($string){//重新编译为页面可以显示的编码
		return is_array($string) ? array_map('new_htmlspecialchars', $string) : htmlspecialchars($string,ENT_QUOTES);
		//																使用html编码，使原字符可以原样打印在页面上（如果有冲突，不覆盖已有的变量）
	}

	function new_addslashes($string){//使用反斜线引用字符串,是存入数据库的需要(当相应的服务设置没有开启时)
		if(!is_array($string)) return addslashes($string);//不是数组，直接转换，是，依次各个转换
		foreach($string as $key => $val) $string[$key] = new_addslashes($val);
		return $string;
	}

	function new_stripslashes($string){//将反斜杠反转译，每三个连续的反斜杠反转译为一个反斜杠，否则转为空
		if(!is_array($string)) return stripslashes($string);//
		foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
		return $string;
	}

	function strip_textarea($string){//将传入字符中的网页保留字符转换为对应的编码
		return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string, ENT_QUOTES)));
	}

	function strip_js($string, $js = 1){//过滤JS脚本敏感字符
		$string = str_replace(array("\n","\r","\""),array('','',"\\\""),$string);
		return $js==1 ? "document.write(\"".$string."\");\n" : $string;
	}

	function safe_replace($string){//安全字母替换，将传入字符串中的敏感字符替换为空
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
	//将所有可能传入数据的点，都过滤SQL敏感字符
	$_POST = strip_sql($_POST);
	$_GET = strip_sql($_GET);
	$_REQUEST = strip_sql($_REQUEST);
	$_COOKIE = strip_sql($_COOKIE);

	$magic_quotes_gpc = get_magic_quotes_gpc();//检查配置文件中的自动转译为插入数据库是否开启
	if(!$magic_quotes_gpc){//如果没有开启，则，用已经定义好的代码转译
		$_POST = new_addslashes($_POST);
		$_GET = new_addslashes($_GET);
		$_REQUEST = new_addslashes($_REQUEST);
		$_COOKIE = new_addslashes($_COOKIE);
	}
	//从数组中将变量导入到当前的符号表
	@extract($_POST,EXTR_SKIP);
	@extract($_GET,EXTR_SKIP);
	@extract($_REQUEST,EXTR_SKIP);
	@extract($_COOKIE,EXTR_SKIP);

	//$_SERVER
	//$_SESSION
	//$_FILES  //共七个全局变量
	
	//通用验证过滤的方法
	//参数说明：
	//object,要进行验证的对象变量
	//class,对象变量的类型
	//notnull || null,是否允许为空，如果允许则自动替换为 字符串'';
	//help || nothelp || not ,是否过滤‘&nbsp’或者都不过滤
	//chinese,中文说明，对象变量是英文，这里是为了弹出窗口显示。
	//min,如果类型是数值型为最小值，如果类型是字符串型为最小长度。（允许范围内的）
	//max,如果本身是整型数值为最大值，如果本身是字符串型数值为最大长度。（允许范围内的）字符串型'@'，不限制最大。
	function check_validate($object='',$class='',$notnull='',$help='',$chinese='',$min='',$max=''){
		if(strlen($class)<=0||strlen($notnull)<=0||strlen($help)<=0||strlen($chinese)<=0||strlen($min)<=0||strlen($max)<=0){
			msg_back('验证过滤中验证对象参数错误。');
		}
		$temp=trim($object);
		if($notnull===true){
			if(strlen($object)<=0 && $notnull==="notnull"){
				msg_back($chinese.'不允许为空');
			}elseif(strlen($object)<=0 && $notnull==="null"){
				$temp='';
			}else{
				msg_back($chinese.'不能为空');
			}
		}
		if($help==="help"){
			$temp=helphtml($temp);//此处不过滤'&nbsp'
		}elseif($help==="nothelp"){
			$temp=html($temp);//此处过滤所有的html标记
		}elseif($help==="not"){
			$temp='&nbsp;'.$temp;//此处过滤所有的html标记
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
						msg_back('您键入的“'.$chinese.'”不应小于'.$min.'，请重试。');
					}
				}else{
					$max=intval($max);
					if($temp<$min){
						msg_back('您键入的“'.$chinese.'”不应小于'.$min.'，请重试。');
					}elseif($temp>$max){
						msg_back('您键入的“'.$chinese.'”不应大于'.$max.'，请重试。');
					}
				}
				break;
			case "float":
			case "FLOAT":
				$temp=floatval($temp);
				$min=floatval($min);
				if($max==='@'){
					if($temp<$min){
						msg_back('您键入的“'.$chinese.'”不应小于'.$min.'，请重试。');
					}
				}else{
					$max=floatval($max);
					if($temp<$min){
						msg_back('您键入的“'.$chinese.'”不应小于'.$min.'，请重试。');
					}elseif($temp>$max){
						msg_back('您键入的“'.$chinese.'”不应大于'.$max.'，请重试。');
					}
				}
				break;
			case "str":
			case "string":
			case "STRING":
				$min=intval($min);
				if($max==='@'){
					if(strlen($temp)<$min){
						msg_back('您键入的“'.$chinese.'”长度不应小于'.$min.'，请重试。');
					}
				}else{
					$max=intval($max);
					if(strlen($temp)<$min){
						msg_back('您键入的“'.$chinese.'”长度不应小于'.$min.'，请重试。');
					}elseif(strlen($temp)>$max){
						msg_back('您键入的“'.$chinese.'”长度不应大于'.$max.'，请重试。');
					}
				}
				break;
			default:
				msg_back('验证过滤中暂不支持"'.$class.'"类型。');
				break;
		}
		unset ($object,$class,$notnull,$help,$chinese,$min,$max);
		return $temp;
	}
//测试代码
	//$demo=check_validate(9999999,'int',true,true,'示例值',0,'99999');
	//$demo=check_validate('fd9fdsfdsa9','str',true,true,'示例值',0,1);
	//echo $demo;
	//return;
?>