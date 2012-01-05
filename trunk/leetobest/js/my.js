/*
 *去掉前后空格
 */
function trim(str){
	return str.replace(/(^\s*)|(\s*$)/g, "");
}

/*
 * 把字符串变为数组
 * str---要被分割为数组的字符串
 * str_fg---分隔符 (单个字符)
 */
 function stringToArray(str,str_fg){
	   var str_arr=new Array();
	   if(str_fg==null || str_fg.length<=0){
		   str_fg=',';
	   }
	   
	   if(str.length>1){
		   if(str.substring(str.length-1,str.length)==str_fg){
			   str=str.substr(0,str.length-1);
		   }
	   }
	   
	   if(str.length>0){
		   str_arr=str.split(str_fg);//分割
	   }
	   
	   return str_arr;
 }