<?php
    include_once('../admin/leesession.php');
	checkmodules('contents');
	include_once '../include/config.php';//声明页面编码以及设置smarty基本设置
	include_once '../include/leecommon.php';//处理接收到的所有数据，有必要的话自动转译和过滤所有数据
	include_once '../include/mysql.php';//包含有操作数据库的所有方法
	include_once '../include/cache.func.php';//包含有读写缓存操作的方法
	include_once '../include/leeutil.php';//包含有常用的工具方法(获取图片，
	include_once '../db_cache/tables.php';//包含有以数组形式保存的数据库所有表结构信息


	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息

	/*
	* 销毁变量，释放内存
	*/
	function unsetall(){
		unset($GLOBALS['_POST'],$GLOBALS['demo'],$GLOBALS['method'],$GLOBALS['methods'],$GLOBALS['nowtime'],$GLOBALS['nowuserid'],$GLOBALS['contents_id'],$GLOBALS['pageNo'],$GLOBALS['pageSize'],$GLOBALS['object_page'],$GLOBALS['falg'],$GLOBALS['success'],$GLOBALS['arr'],$GLOBALS['arr1'],$GLOBALS['arr2'],$GLOBALS['arr3'],$GLOBALS['arrcheck1'],$GLOBALS['arrcheck2'],$GLOBALS['arrcheck3'],$GLOBALS['cates_id'],$GLOBALS['htmlsucc'],$GLOBALS['updatehtmlpath'],$GLOBALS['cates_array'],$GLOBALS['i'],$GLOBALS['cates_path'],$GLOBALS['contents_list'],$GLOBALS['szx'],$GLOBALS['mo'],$GLOBALS['contents_id'],$GLOBALS['contents_title'],$GLOBALS['contents_key'],$GLOBALS['contents_desc'],$GLOBALS['contents_content'],$GLOBALS['cates_id'],$GLOBALS['positions_id'],$GLOBALS['contents_images'],$GLOBALS['contents_flashs'],$GLOBALS['contents_videos'],$GLOBALS['contents_downs'],$GLOBALS['contents_status'],$GLOBALS['contents_sort'],$GLOBALS['contents_hits'],$GLOBALS['contents_content'],$GLOBALS['contents_addusersid'],$GLOBALS['contents_addtime'],$GLOBALS['contents_editusersid'],$GLOBALS['contents_edittime'],$GLOBALS['contents_url'],$GLOBALS['contents_resource'],$GLOBALS['contents_remark1'],$GLOBALS['contents_remark2'],$GLOBALS['contents_remark3']);
	}

	     
    //报错的方法，弹出相应语句，并返回上一页面
    function msg_back($msg=""){
		if($msg==""){
			echo "<script>alert('要弹出窗口的语句不能为空');</script>";
		}else{
			unsetall();//销毁所有变量，释放内存
			echo "<script>alert('$msg');window.history.back();</script>";
			exit;
		}
    }
    //报错的方法，弹出相应语句，并跳出到指定页面
    function msg_out($msg="",$path=""){
		if($msg==""){
			echo "<script>alert('要弹出窗口的语句不能为空');</script>";
		}else{
			if($msg==""){
				echo "<script>alert('要跳出的页面路径不能为空');</script>";
			}else{
				unsetall();//销毁所有变量，释放内存
				echo "<script>alert('".$msg."');window.location.href='".$path."';</script>";
				exit;
			}
		}
    }




	//生成静态页面的公共方法
	//参数说明：
	//object_page，要生成的目标静态页面的全路径
	//template_html,要使用的静态模版的页面名称
	//arr1,array(),静态页面接受变量的名称数组
	//arr2,array(),静态页面接受变量的值数组///////////////////////////请特别注意，列表页的内容可能被删除为空
	function NewHtmlPage($object_page='',$template_html='',$arr1=array(),$arr2=array()){
		global $smarty;
		$success=false;
		$object_page=@trim($object_page);
		$template_html=@trim($template_html);
		if(strlen($object_page)<=0){
			msg_back('必须指定要生成的目标静态页面的全路径。');
		}else{
			if(strlen($template_html)<=0){
				msg_back('必须指定要使用的静态模版的页面名称。');
			}else{
				if(count($arr1)>0 && count($arr2)>0){
					if(count($arr1)==count($arr2)){
						for($i=0;$i<count($arr1);$i++){
							$smarty->assign($arr1[$i],$arr2[$i]);
						}
						if(file_exists($object_page)){
							unlink($object_page);
						}
						$content=$smarty->fetch($template_html,null,null,false);//生成内容静态网页的实际内容
						file_put_contents($object_page,$content);//生成成功之后，检查文件是否存在并提示。
						if(file_exists($object_page)){
							$success=true;
						}
						$smarty->clear_cache();
						return $success;
					}else{
						msg_back('静态页面接受的变量名和值个数必须相等。');
					}
				}else{
					msg_back('静态页面接受的变量名和值都不能为空。');
				}
			}
		}
	}
	//更新数据库，确认静态页面地址
	//为什么一定要写这个静态地址？因为生成列表，必须要根据已经生成好的静态页面来。其实我也不想这样，要多很多次跑数据库，但是只能这样。
	//参数说明：
	//id_name,ID名称
	//id_value,ID的值
	//table_name,要操作的表名
	function HtmlPath($url_value='',$id_value='',$table_name=''){
		global $db;
		$success=false;
		$id_value=@trim($id_value);
		$url_value=@trim($url_value);
		$table_name=@trim($table_name);
		if(strlen($id_value)<=0){
			msg_back('必须指定要操作的ID。');
		}else{
			$id_value=intval($id_value);
			if($id_value<=0){
				msg_back('指定的操作ID不对。');
			}
			//if(strlen($id_value)<=0){
			//	msg_back('必须指定要更新的URL的值。');
			//}else{
				if(strlen($table_name)<=0){
					msg_back('必须指定要操作的表。');
				}else{
					$success=$db->update($table_name,array($id_value,$url_value),array('contents_id','contents_url'),array('INTEGER','VARCHAR'));
					return $success;
				}
			//}
		}
	}
	//******测试方法的代码。*********//
	//$succ=HtmlPath('1.html','1','contents');
	//if($succ){
	//	msg_back('更新成功了。');
	//}else{
	//	msg_back('更新不成功。');
	//}
	
	function HtmlPathANDList($url_value='',$id_value='',$table_name='',$cates_id=''){
		global $db;
		$success=false;
		$id_value=@trim($id_value);
		$url_value=@trim($url_value);
		$table_name=@trim($table_name);
		if(strlen($id_value)<=0){
			msg_back('必须指定要操作的ID。');
		}else{
			$id_value=intval($id_value);
			if($id_value<=0){
				msg_back('指定的操作ID不对。');
			}else{
				//此处允许URL设置空值。
				if(strlen($table_name)<=0){
					msg_back('必须指定要操作的表。');
				}else{
					$success=$db->update($table_name,array($id_value,$url_value),array('contents_id','contents_url'),array('INTEGER','VARCHAR'));
					if($success){
						include_once '../include/cache.func.php';//加载缓存
						$cates_array=@cache_read('cates.php',CACHE_PATH);//CACHE_PATH--在include_once/config.php里定义的常量
						$cates_path='';
						if(!@empty($cates_array) && @count($cates_array)>0){
							if($cates_id==''){
								$row=$db->select_Single("SELECT * FROM contents WHERE contents_id=$id_value");
								$cates_id=$row['cates_id'];
								for($i=0;$i<count($cates_array);$i++){
									if($cates_array[$i]['cates_id']==$cates_id){
										$cates_path=$cates_array[$i]['cates_path'];
										continue;
									}
								}
							}
							if(@empty($cates_path)||@strlen($cates_path)<1){
								msg_back('缓存数据不是最新的，请更新缓存数据再进行操作。');
							}else{
								if(!file_exists(TOHTML_PATH.$cates_path.'/')){
									if(!mkdir(TOHTML_PATH.$cates_path.'/')){
										msg_back('创建类别文件夹失败。请检查权限设置再进行操作。');
									}
								}
								$arr1=array('url_path','contents_list');
								$contents_addtime=$row['contents_addtime'];
								$contents_limit=' AND ';
								$mo=substr($contents_addtime,5,2);
								$ye=substr($contents_addtime,0,4);
								$szx=substr($contents_addtime,8,2);
								$szx=intval($szx);
								if($szx<11){
									$szx=1;
									$contents_limit=$contents_limit.' o.contents_addtime>="'.$ye.'-'.$mo.'-01 00:00:00"';
									$contents_limit=$contents_limit.' AND o.contents_addtime<"'.$ye.'-'.$mo.'-11 00:00:00"';
								}elseif($szx<21){
									$szx=2;
									$contents_limit=$contents_limit.' o.contents_addtime>="'.$ye.'-'.$mo.'-11 00:00:00"';
									$contents_limit=$contents_limit.' AND o.contents_addtime<"'.$ye.'-'.$mo.'-21 00:00:00"';
								}else{
									$szx=3;
									$contents_limit=$contents_limit.' o.contents_addtime>="'.$ye.'-'.$mo.'-21 00:00:00"';
									$contents_limit=$contents_limit.' AND o.contents_addtime<"'.$ye.'-'.($mo+1).'-01 00:00:00"';
								}
								$sql_list="SELECT o.contents_url,o.contents_id,o.contents_title,a.cates_name,o.contents_hits,o.contents_adduserid,o.contents_connect,o.contents_addtime,o.contents_edittime,o.contents_resource FROM contents o JOIN cates a ON o.cates_id=a.cates_id WHERE o.contents_status='1' AND a.cates_status='1' AND o.cates_id=".$cates_id." AND o.contents_url<>'' ".$contents_limit." ORDER BY o.contents_edittime desc";
								//echo $sql_list;
								$contents_list=$db->select_All($sql_list);
								$arr2=array(URL_PATH,$contents_list);
								$htmlsucc=NewHtmlPage(TOHTML_PATH.$cates_path.'/'.$mo.$szx.'.html','contents_list.tpl',$arr1,$arr2);
								return $htmlsucc;
							}
						}else{
							msg_back('更新数据库成功，因无法加载缓存数据没能更新列表页，请更新关键数据缓存。');
						}
					}else{
						msg_back('糟糕。更新数据库失败，无法更新静态列表页。');
					}
				}
			}
		}
	}
	//******测试方法的代码。*********//
	//HtmlPathANDList('24.html','24','contents');
	//return;
	
	
	/*
	* 对表单数据的处理
	*/
	//处理表单的模版注释
	$demo="99999999";//示例注释，此为接收到的一个值
	$demo=@trim($demo);//过滤此值前后的所有空格
	if(strlen($demo)<=0){//计算值的长度是否小于0，判断是否为空
		msg_back('示例中的值没有任何内容');
	}elseif(strlen($demo)<=255){//值的长度是否小于小于数据库规定的长度
		$demo=html($demo);//如果值不为空就过滤一次所有html标记--不过滤'&nbsp;'是util中的方法
		$demo=intval($demo);//将过滤后的值强制转换为整型
		if($demo<2){//判断整型值是否小于制定的值
			msg_back('示例中的值转为数字后，值小于2');
		}
	}else{//长度太长的字符，不予通过
		msg_back('示例中的值太长。');
	}
	/*
	* 最后处理方法
	*/
	$method=@trim($method);
	if(empty($method)){
		msg_back('没有接收到方法，请自觉遵守国家法律法规！');
	}else{
		$methods=array('add','del','update','html','delhtml');
		if(!in_array($method,$methods)){
			msg_back('接收到错误的方法'.$method.'，请自觉遵守国家法律法规！');
		}
	}
	//print_r($_REQUEST);RETURN;

	//删除内容的操作
	if($method=='del'){
		msg_back('目前不建议删除数据，有问题请联系管理员。');
	//object,要进行验证的对象变量,class,对象变量的类型notnull||null,是否允许为空help||nothelp,是否过滤‘&nbsp’chinese,中文说明min,max,'@'不限制最大。
		$pageNo		=check_validate($pageNo,	"int",	"notnull","help","页面编号",1,"@");
		$pageSize	=check_validate($pageSize,	"int",	"notnull","help","页面大小",1,25);
		$contents_id=check_validate($contents_id,"int",	"notnull","help","内容编号",1,"@");
		$object_page=TOHTML_PATH.$contents_id.'.html';
		if(file_exists($object_page)){
			unlink($object_page);
			//删除文件之后，检查文件是否存在，存在然后提示。
			if(file_exists($object_page)){
				msg_back('文件删除失败。请检查权限设置。');
			}else{
				$falg=$db->selectBool('contents',$contents_id,'contents_id','INTEGER');//判断记录是否存在
				if($falg===true){
					$success=$db->delete('contents',$contents_id,'contents_id','INTEGER');//删除数据
					if($success!==false){
						msg_back('彻底删除成功。请程序员注意，重新生成静态列表页。');
					}else{
						msg_back('删除静态完毕，但数据删除失败。无法更新静态列表页。');
					}
				}else{
					msg_back('不存在该数据。');
				}
			}
		}else{
			$falg=$db->selectBool('contents',$contents_id,'contents_id','INTEGER');//判断记录是否存在
			if($falg===true){
				$success=$db->delete('contents',$contents_id,'contents_id','INTEGER');//删除数据
				if($success!==false){
					$htmlsucc=HtmlPathANDList('',$contents_id,'contents');
					if($htmlsucc){
						msg_back('恭喜！彻底删除成功。成功更新了数据库和静态列表页。');
					}else{
						msg_back('彻底删除成功。更新了数据库，更新静态列表页面失败。');
					}
				}else{
					$htmlsucc=HtmlPathANDList('',$contents_id,'contents');
					if($htmlsucc){
						msg_back('恭喜！彻底删除成功。成功更新了数据库和静态列表页。');
					}else{
						msg_back('静态页面本身不存在。更新了数据库，更新静态列表页面失败。');
					}
				}
			}else{
				msg_back('不存在对应静态页面，而且不存在该数据。');
			}
		}
	//生成静态页面的方法
	}elseif($method=='html'){
		$contents_id=@trim($contents_id); 
		if(strlen($contents_id)<=0){
			msg_back('没有接受到内容编号。');
		}else{
			$contents_id=html($contents_id);
			$contents_id=intval($contents_id);
			if($demo<0){
				msg_back('内容编号不对。');
			}
		}
		$row=$db->selectSingle('contents',$contents_id,'contents_id','INTEGER');
		$arr1=array('url_path','title','content');
		$arr2=array(URL_PATH,$row['contents_title'],$row['contents_content']);
		$cates_id=$row['cates_id'];
		$htmlsucc=NewHtmlPage(TOHTML_PATH.$contents_id.'.html','contents_content.tpl',$arr1,$arr2);
		if($htmlsucc){
			$htmlsucc=HtmlPathANDList($contents_id.'.html',$contents_id,'contents');
			if($htmlsucc){
				msg_back('恭喜！静态内容页生成成功。成功更新了数据库和静态列表页。');
			}else{
				msg_back('静态内容页生成成功。更新了数据库，更新静态列表页面失败。');
			}
		}else{
			msg_back('静态内容页生成出错。');
		}
	}elseif($method=='delhtml'){
						$contents_id=@trim($contents_id);  //mysql中获取上次插入数据的ID
						if(strlen($contents_id)<=0){
							msg_back('没有接受到内容编号。');
						}else{
							$contents_id=html($contents_id);
							$contents_id=intval($contents_id);
							if($demo<0){
								msg_back('内容编号不对。');
							}
						}
		$object_page=TOHTML_PATH.$contents_id.'.html';
		if(file_exists($object_page)){
			unlink($object_page);
			//删除文件之后，检查文件是否存在，存在然后提示。
			if(file_exists($object_page)){
				msg_back('文件删除失败。请检查权限设置再重试。');
			}else{
				$htmlsucc=HtmlPathANDList('',$contents_id,'contents');
				if($htmlsucc){
					msg_back('恭喜！删除静态成功。成功更新了数据库和静态列表页。');
				}else{
					msg_back('删除静态页面成功。更新了数据库，更新静态列表页面失败。');
				}
			}
		}else{
			msg_back('静态页面本身不存在。');
		}
	}else{
//处理添加和编辑的共同的字段
//object,要进行验证的对象变量,class,对象变量的类型notnull||null,是否允许为空help||not,help||nothelp||not,是否过滤‘&nbsp’,chinese,中文说明min,max,'@'不限制最大。
$contents_title		=check_validate($contents_title,	"string",	"notnull",	"nothelp",	"标题",		1,	245);
$contents_key		=check_validate($contents_key,		"string",	"null",		"nothelp",	"关键字",	1,	245);
$contents_desc		=check_validate($contents_desc,		"string",	"null",		"nothelp",	"描述",		1,	"@");
$contents_content	=check_validate($contents_content,	"string",	"notnull",	"not",		"内容",		1,	"@");
$cates_id			=check_validate($cates_id,			"int",		"notnull",	"help",		"所属栏目",	1,	"@");
$positions_id		=check_validate($positions_id,		"int",		"notnull",	"help",		"推荐位",	0,	"@");
$contents_images	=check_validate($contents_images,	"string",	"null",		"help",		"图片",		0,	245);
$contents_flashs	=check_validate($contents_flashs,	"string",	"null",		"help",		"动画",		0,	245);
$contents_videos	=check_validate($contents_videos,	"string",	"null",		"help",		"视频",		0,	245);
$contents_downs		=check_validate($contents_downs,	"string",	"null",		"help",		"下载",		0,	245);
$contents_recive	=check_validate($contents_recive,	"int",		"null",		"help",		"回复总数",	0,	45);
$contents_status	=check_validate($contents_status,	"int",		"notnull",	"help",		"状态",		1,	"@");
$contents_sort		=check_validate($contents_sort,		"int",		"notnull",	"help",		"排序",		1,	"@");
$contents_connect	=check_validate($contents_connect,	"string",	"notnull",	"help",		"联系方式",	1,	"@");
$contents_resource	=check_validate($contents_resource,	"string",	"notnull",	"help",		"内容来源",	1,	"@");
$contents_remark1	=check_validate($contents_remark1,	"string",	"null",		"help",		"备用字段1",	 0,	"@");
$contents_remark2	=check_validate($contents_remark2,	"string",	"null",		"help",		"备用字段2",	 0,	"@");
$contents_remark3	=check_validate($contents_remark3,	"string",	"null",		"help",		"备用字段3",	 0,	"@");
//表单数据处理完毕！

		//添加内容的操作
		if($method=="add"){	  /*
			* 得到表字段名、字段数据类型
			*/
			$arr=array();
			$arr=@cache_read('tables.php');
			if(@empty($arr) || @count($arr)<0){
				msg_back('请更新表结构缓存。');
			}
			$arr2=$arr['contents'][0];//表字段名
			array_shift($arr2);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
			$arr3=$arr['contents'][1];//字段数据类型
			array_shift($arr3);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
			//处理添加操作相关信息
			$contents_adduserid=$nowuserid;
			$contents_addtime=$nowtime;
			$contents_hits=0;
			$contents_edituserid=$nowuserid;
			$contents_edittime=$nowtime;
			$contents_url='';//插入数据之后，才更新静态页面的名称，此名称也将成功静态列表的生成依据。
			//准备执行操作的数组
			$arr1=array();
			foreach($arr2 as &$value){array_push($arr1,$$value);}//利用缓存处理已经准备好的数据
			//print_r($arr1);//return;
			//检查该类型中是否已经存在有该标题的记录，如果有，则提醒，并停止
			$arrcheck1=array($contents_title,$cates_id);
			$arrcheck2=array('contents_title','cates_id');
			$arrcheck3=array('VARCHAR','INTEGER');
			$flag=$db->selectBool_F('contents',$arrcheck1,$arrcheck2,$arrcheck3);
			if($flag===false ){
				if($cates_id>0){
					$success=$db->insert('contents',$arr1,$arr2,$arr3);//增加数据
					if($success!==false){
						//生成内容页的静态页面
						$arr1=array('url_path','title','content');
						$arr2=array(URL_PATH,$contents_title,$contents_content);
						$contents_id=$db->insert_id();
						$htmlsucc=NewHtmlPage(TOHTML_PATH.$contents_id.'.html','contents_content.tpl',$arr1,$arr2);
						if($htmlsucc){
							$htmlsucc=HtmlPathANDList($contents_id.'.html',$contents_id,'contents');
							if($htmlsucc){
								msg_back('恭喜！生成内容静态页成功。成功更新了数据库和静态列表页。');
							}else{
								msg_back('生成内容静态页成功。更新了数据库，更新静态列表页面失败。');
							}
						}else{
							msg_back('添加内容成功,生成内容页静态页面出错。');
						}
					}else{
						msg_back('添加内容出错,可能您要插入的数据太多。');
					}
				}else{
					msg_back('所属类别不对。');
				}
			}else{
				msg_back('抱歉，该类别下已经存在有此标题。');
			}

		//修改内容的操作
		}elseif($method=='update'){
			$contents_edituserid=$nowuserid;
			$contents_edittime=$nowtime;
//object,要进行验证的对象变量,class,对象变量的类型notnull||null,是否允许为空help||not,help||nothelp||not,是否过滤‘&nbsp’,chinese,中文说明min,max,'@'不限制最大。
$contents_id		=check_validate($contents_id,		"int",		"notnull",	"help",	"内容编号",		1,	"@");
$contents_hits		=check_validate($contents_hits,		"int",		"notnull",	"help",	"点击率",		0,	"@");
$contents_adduserid	=check_validate($contents_adduserid,"int",		"notnull",	"help",	"添加者",		1,	"@");
$contents_addtime	=check_validate($contents_addtime,	"string",	"notnull",	"help",	"添加时间",		10,	45);
				/*
				* 对数据库的操作
				*/
				$flag=$db->selectBool('contents',$contents_id,'contents_id','INTEGER');
				if($flag===true ){
					//$contents_url=$contents_id.'.html';
					$contents_url='';
					$arrcheck1=array($contents_title,$cates_id,$contents_id);
					$arrcheck2=array('contents_title','cates_id','contents_id');
					$arrcheck3=array('VARCHAR','INTEGER','INTEGER');
					$flag1=$db->selectBoolByIdName('contents',$arrcheck1,$arrcheck2,$arrcheck3);
					if($flag1===false){
					// 使用缓存得到表字段名、字段数据类型
					$arr=array();
					$arr=@cache_read('tables.php');
					if(@empty($arr) || @count($arr)<0){
						msg_back('请更新表信息缓存。');
					}
					$arr2=$arr['contents'][0];//表字段名
					$arr3=$arr['contents'][1];//字段数据类型
					$arr1=array();
					foreach($arr2 as &$value){array_push($arr1,$$value);}//利用缓存处理已经准备好的数据
						$success=$db->update('contents',$arr1,$arr2,$arr3);//修改数据
						if($success!==false){
							$template_html='contents_content.tpl';
							$object_page=TOHTML_PATH.$contents_id.'.html';
							$arr1=array('url_path','title','content');
							$arr2=array(URL_PATH,$contents_title,$contents_content);
							$htmlsucc=NewHtmlPage($object_page,$template_html,$arr1,$arr2);
							if($htmlsucc){
								$htmlsucc=HtmlPathANDList($contents_id.'.html',$contents_id,'contents');
								if($htmlsucc){
									msg_out('恭喜！添加内容成功，静态页面生成成功。成功更新了数据库和静态列表页。',URL_PATH.'admin/listcontents.php');
								}else{
									msg_out('添加内容成功，静态页面生成成功。更新了数据库，更新静态列表页面失败。','');
								}
							}else{
								msg_back('添加内容成功，静态页面生成出错。');
							}
						}else{
							msg_back('修改内容失败。');
						}
					}else{
						msg_back('标题为'.$contents_title.'的内容已存在。');
					}
				}else{
					msg_back('该数据已经不存在了。');
				}

			//待添加的未知操作
			}else{
				msg_back('一个没有操作内容的方法。');
			}
	}

?>
