<?php
/*
 * 全局方法
 */

/*
 *   过滤sql语句的关键字
 */
function strip_sql($string){
	$search_arr = array("/ union /i","/ select /i","/ update /i","/ outfile /i","/ or /i");
	$replace_arr = array('&nbsp;union&nbsp;','&nbsp;select&nbsp;','&nbsp;update&nbsp;','&nbsp;outfile&nbsp;','&nbsp;or&nbsp;');
	return is_array($string) ? array_map('strip_sql', $string) : preg_replace($search_arr, $replace_arr, $string);
}

function new_htmlspecialchars($string){
	return is_array($string) ? array_map('new_htmlspecialchars', $string) : htmlspecialchars($string,ENT_QUOTES);
}

function new_addslashes($string){
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	return $string;
}

function new_stripslashes($string){
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	return $string;
}

function strip_textarea($string){
	return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string, ENT_QUOTES)));
}

function strip_js($string, $js = 1){
	$string = str_replace(array("\n","\r","\""),array('','',"\\\""),$string);
	return $js==1 ? "document.write(\"".$string."\");\n" : $string;
}

function safe_replace($string){
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
?>