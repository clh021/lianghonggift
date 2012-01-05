<?
	@header("Content-type: text/html; charset=utf-8");
	$m_id=18;//此处没有做页面访问权限的检查


	include_once '../admin/session.php';//检查管理员账号以及访问权限
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
		unset($GLOBALS['_POST'],$GLOBALS['demo'],$GLOBALS['method'],$GLOBALS['methods'],$GLOBALS['nowtime'],$GLOBALS['nowuserid'],$GLOBALS['friends_id'],$GLOBALS['pageNo'],$GLOBALS['pageSize'],$GLOBALS['object_page'],$GLOBALS['falg'],$GLOBALS['success'],$GLOBALS['arr'],$GLOBALS['arr1'],$GLOBALS['arr2'],$GLOBALS['arr3'],$GLOBALS['arrcheck1'],$GLOBALS['arrcheck2'],$GLOBALS['arrcheck3'],$GLOBALS['cates_id'],$GLOBALS['htmlsucc'],$GLOBALS['updatehtmlpath'],$GLOBALS['cates_array'],$GLOBALS['i'],$GLOBALS['cates_path'],$GLOBALS['friends_list'],$GLOBALS['szx'],$GLOBALS['mo'],$GLOBALS['friends_id'],$GLOBALS['friends_name'],$GLOBALS['friends_friendsid'],$GLOBALS['friends_desc'],$GLOBALS['friends_content'],$GLOBALS['cates_id'],$GLOBALS['positions_id'],$GLOBALS['friends_images'],$GLOBALS['friends_flashs'],$GLOBALS['friends_videos'],$GLOBALS['friends_downs'],$GLOBALS['friends_status'],$GLOBALS['friends_sort'],$GLOBALS['friends_hits'],$GLOBALS['friends_content'],$GLOBALS['friends_addusersid'],$GLOBALS['friends_addtime'],$GLOBALS['friends_editusersid'],$GLOBALS['friends_edittime'],$GLOBALS['friends_url'],$GLOBALS['friends_resource'],$GLOBALS['friends_remark1'],$GLOBALS['friends_remark2'],$GLOBALS['friends_remark3']);
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
	
	/*
	* 对表单数据的处理
	*/
	//处理表单的模版注释
	$demo="12";//示例注释，此为接收到的一个值
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
		$methods=array('add','update','del');
		if(!in_array($method,$methods)){
			msg_back('接收到错误的方法'.$method.'，请自觉遵守国家法律法规！');
		}
	}
	if($method='del'){
			msg_back('不建议删除人脉。请冷静考虑。');
	}

						//处理添加和编辑的共同的字段

						$friends_name=@trim($friends_name);
						if(strlen($friends_name)<=0){
							msg_back('没有接受到人脉的姓名。');
						}elseif(strlen($friends_name)<=45){
							$friends_name=html($friends_name);
						}else{
							msg_back('人脉的姓名太长。');
						}
						
						$friends_friendsid=@trim($friends_friendsid);
						if(strlen($friends_friendsid)<=0){
							$friends_friendsid='';//允许此字段为空
						}else{
							$friends_friendsid=html($friends_friendsid);
							$friends_friendsid=intval($friends_friendsid);
							if($friends_friendsid<=0){
								msg_back('人脉注册ID不对。');
							}
						}

						$friends_relations=@trim($friends_relations);
						if(strlen($friends_relations)<=0){
							msg_back('没有接受到与人脉的关系。');
						}elseif(strlen($friends_relations)<=45){
							$friends_relations=html($friends_relations);
						}else{
							msg_back('与人脉的关系太长。');
						}
						$friends_sex=@trim($friends_sex);
						if(strlen($friends_sex)<=0){
							$friends_sex='';
						}else{
							$friends_sex=html($friends_sex);
							$friends_sex=intval($friends_sex);
						}

						$friends_birthday=@trim($friends_birthday);
						if(strlen($friends_birthday)<=0){
							$friends_birthday='';
						}else{
							$friends_birthday=html($friends_birthday);
						}
						$friends_calendar=@trim($friends_calendar);
						if(strlen($friends_calendar)<=0){
							$friends_calendar=3;
						}else{
							$friends_calendar=html($friends_calendar);
							$friends_calendar=intval($friends_calendar);
						}
						$friends_qq=@trim($friends_qq);
						if(strlen($friends_qq)<=0){
							$friends_qq='';
						}else{
							$friends_qq=html($friends_calendar);
						}
						$friends_mobile=@trim($friends_mobile);
						if(strlen($friends_mobile)<=0){
							$friends_mobile='';
						}else{
							$friends_mobile=html($friends_mobile);
						}
						$friends_email=@trim($friends_email);
						if(strlen($friends_email)<=0){
							$friends_email='';
						}else{
							$friends_email=html($friends_email);
						}
						$friends_genus=@trim($friends_genus);
						if(strlen($friends_genus)<=0){
							$friends_genus='';
						}else{
							$friends_genus=html($friends_genus);
						}
						$friends_bloodtype=@trim($friends_bloodtype);
						if(strlen($friends_bloodtype)<=0){
							$friends_bloodtype='';
						}else{
							$friends_bloodtype=html($friends_bloodtype);
						}
						$friends_worklive=@trim($friends_worklive);
						if(strlen($friends_worklive)<=0){
							$friends_worklive='';
						}else{
							$friends_worklive=html($friends_worklive);
						}
						$friends_interest=@trim($friends_interest);
						if(strlen($friends_interest)<=0){
							$friends_interest='';
						}else{
							$friends_interest=html($friends_interest);
						}
						$friends_worklive=@trim($friends_worklive);
						if(strlen($friends_worklive)<=0){
							$friends_worklive='';
						}else{
							$friends_worklive=html($friends_worklive);
						}
						$friends_interest=@trim($friends_interest);
						if(strlen($friends_interest)<=0){
							$friends_interest='';
						}else{
							$friends_interest=html($friends_interest);
						}
						$friends_workunit=@trim($friends_workunit);
						if(strlen($friends_workunit)<=0){
							$friends_workunit='';
						}else{
							$friends_workunit=html($friends_workunit);
						}
						$friends_sectionduty=@trim($friends_sectionduty);
						if(strlen($friends_sectionduty)<=0){
							$friends_sectionduty='';
						}else{
							$friends_sectionduty=html($friends_sectionduty);
						}
						$friends_workplace=@trim($friends_workplace);
						if(strlen($friends_workplace)<=0){
							$friends_workplace='';
						}else{
							$friends_workplace=html($friends_workplace);
						}
						$friends_companytel=@trim($friends_companytel);
						if(strlen($friends_companytel)<=0){
							$friends_companytel='';
						}else{
							$friends_companytel=html($friends_companytel);
						}
						$friends_familyaddress=@trim($friends_familyaddress);
						if(strlen($friends_familyaddress)<=0){
							$friends_familyaddress='';
						}else{
							$friends_familyaddress=html($friends_familyaddress);
						}
						$friends_houseaddress=@trim($friends_houseaddress);
						if(strlen($friends_houseaddress)<=0){
							$friends_houseaddress='';
						}else{
							$friends_houseaddress=html($friends_houseaddress);
						}
						$friends_housetel=@trim($friends_housetel);
						if(strlen($friends_housetel)<=0){
							$friends_housetel='';
						}else{
							$friends_housetel=html($friends_housetel);
						}
						$friends_graduateacademy=@trim($friends_graduateacademy);
						if(strlen($friends_graduateacademy)<=0){
							$friends_graduateacademy='';
						}else{
							$friends_graduateacademy=html($friends_graduateacademy);
						}
						$friends_graduatetime=@trim($friends_graduatetime);
						if(strlen($friends_graduatetime)<=0){
							$friends_graduatetime='';
						}else{
							$friends_graduatetime=html($friends_graduatetime);
						}
						$friends_specialty=@trim($friends_specialty);
						if(strlen($friends_specialty)<=0){
							$friends_specialty='';
						}else{
							$friends_specialty=html($friends_specialty);
						}
						$friends_birthplace=@trim($friends_birthplace);
						if(strlen($friends_birthplace)<=0){
							$friends_birthplace='';
						}else{
							$friends_birthplace=html($friends_birthplace);
						}
						$friends_sort=@trim($friends_sort);
						if(strlen($friends_sort)<=0){
							msg_back('没有接受到排序值。');
						}else{
							$friends_sort=html($friends_sort);
							$friends_sort=intval($friends_sort);
							if($friends_sort<0){
								msg_back('排序值不对。');
							}
						}
						
						$friends_status=@trim($friends_status);
						if(strlen($friends_status)<=0){
							msg_back('没有接受到状态。');
						}else{
							$friends_status=html($friends_status);
							$friends_status=intval($friends_status);
							if($friends_status<0){
								msg_back('状态编号不对。');
							}
						}
						$friends_remark1=@trim($friends_remark1);
						//if(strlen($friends_remark1)<=0){
						//	msg_back('没有接受到备用字段1。');
						//}else
							if(strlen($friends_remark1)<=45){
							$friends_remark1=html($friends_remark1);
						}else{
							msg_back('备用字段1太长。');
						}
						
						$friends_remark2=@trim($friends_remark2);
						//if(strlen($friends_remark2)<=0){
						//	msg_back('没有接受到备用字段2。');
						//}else
						if(strlen($friends_remark2)<=45){
							$friends_remark2=html($friends_remark2);
						}else{
							msg_back('备用字段2太长。');
						}
						
						$friends_remark3=@trim($friends_remark3);
						//if(strlen($friends_remark3)<=0){
						//	msg_back('没有接受到备用字段3。');
						//}else
						if(strlen($friends_remark3)<=45){
							$friends_remark3=html($friends_remark3);
						}else{
							msg_back('备用字段3太长。');
						}
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
			$arr2=$arr['friends'][0];//表字段名
			array_shift($arr2);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
			$arr3=$arr['friends'][1];//字段数据类型
			array_shift($arr3);//将数组开头的单元移出数组---将数组的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
			//处理添加操作相关信息
						$friends_level='21';
						$friends_img='';//添加人脉，上传图像的字段未处理
			$friends_addtime=$nowtime;
			$friends_edittime=$nowtime;
			//准备执行操作的数组
			$arr1=array($nowuserid,$friends_friendsid,$friends_desc,$friends_content,$cates_id,$positions_id,$friends_images,$friends_flashs,$friends_videos,$friends_downs,$friends_status,$friends_sort,$friends_hits,$friends_connect,$friends_addusersid,$friends_addtime,$friends_editusersid,$friends_edittime,$friends_url,$friends_resource,$friends_remark1,$friends_remark2,$friends_remark3);
			//检查该类型中是否已经存在有该标题的记录，如果有，则提醒，并停止
			$arrcheck1=array($friends_name,$cates_id);
			$arrcheck2=array('friends_name','cates_id');
			$arrcheck3=array('VARCHAR','INTEGER');
			$flag=$db->selectBool_F('friends',$arrcheck1,$arrcheck2,$arrcheck3);
			if($flag===false ){
				if($cates_id>0){
					$success=$db->insert('friends',$arr1,$arr2,$arr3);//增加数据
					if($success!==false){
						//生成内容页的静态页面
						$arr1=array('url_path','title','content');
						$arr2=array(URL_PATH,$friends_name,$friends_content);
						$friends_id=$db->insert_id();
						$htmlsucc=NewHtmlPage(TOHTML_PATH.$friends_id.'.html','friends_content.tpl',$arr1,$arr2);
						if($htmlsucc){
							$htmlsucc=HtmlPathANDList($friends_id.'.html',$friends_id,'friends');
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
			$friends_edituserid=$nowuserid;
			$friends_edittime=$nowtime;
						$friends_id=@trim($friends_id);  
						if(strlen($friends_id)<=0){
							msg_back('没有接受到内容ID。');
						}else{
							$friends_id=html($friends_id);
							$friends_id=intval($friends_id);
							if($demo<0){
								msg_back('内容ID不对。');
							}
						}
						$friends_hits=@trim($friends_hits);
						if(strlen($friends_hits)<=0){
							msg_back('没有接受到点击率。');
						}else{
							$friends_hits=html($friends_hits);
							$friends_hits=intval($friends_hits);
							if($friends_hits<0){
								msg_back('点击率不对。');
							}
						}
						$friends_adduserid=@trim($friends_adduserid);
						if(strlen($friends_adduserid)<=0){
							msg_back('没有接受到添加者ID。');
						}else{
							$friends_adduserid=html($friends_adduserid);
							$friends_adduserid=intval($friends_adduserid);
							if($friends_adduserid<0){
								msg_back('添加者ID不对。');
							}
						}
						//添加删除不需要，编辑需要，添加需要另外指定
						$friends_addtime=@trim($friends_addtime);
						if(strlen($friends_addtime)<=0){
							msg_back('没有接受到添加时间。');
						}elseif(strlen($friends_addtime)<=255){
							$friends_addtime=html($friends_addtime);
						}else{
							msg_back('添加时间太长。');
						}

						//$friends_url=@trim($friends_url);
						//if(strlen($friends_url)<=0){
						//	msg_back('没有接受到生成静态的地址。');
						//}elseif(strlen($friends_url)<=45){
						//	$friends_url=html($friends_url);
						//}else{
						//	msg_back('生成静态的地址太长。');
						//}
				/*
				* 对数据库的操作
				*/
				$flag=$db->selectBool('friends',$friends_id,'friends_id','INTEGER');
				if($flag===true ){
					//$friends_url=$friends_id.'.html';
					$friends_url='';
					$arrcheck1=array($friends_name,$cates_id,$friends_id);
					$arrcheck2=array('friends_name','cates_id','friends_id');
					$arrcheck3=array('VARCHAR','INTEGER','INTEGER');
					$flag1=$db->selectBoolByIdName('friends',$arrcheck1,$arrcheck2,$arrcheck3);
					if($flag1===false){
						$arr1=array($friends_id,$friends_name,$friends_friendsid,$friends_desc,$friends_content,$cates_id,$positions_id,$friends_images,$friends_flashs,$friends_videos,$friends_downs,$friends_status,$friends_sort,$friends_hits,$friends_connect,$friends_adduserid,$friends_addtime,$friends_edituserid,$friends_edittime,$friends_url,$friends_resource,$friends_remark1,$friends_remark2,$friends_remark3);
						/*
						* 得到表字段名、字段数据类型
						*/
						$arr=array();
						$arr=@cache_read('tables.php');
						if(@empty($arr) || @count($arr)<0){
							msg_back('请更新表信息缓存。');
						}
						$arr2=$arr['friends'][0];//表字段名
						$arr3=$arr['friends'][1];//字段数据类型
						$success=$db->update('friends',$arr1,$arr2,$arr3);//修改数据
						if($success!==false){
							$template_html='friends_content.tpl';
							$object_page=TOHTML_PATH.$friends_id.'.html';
							$arr1=array('url_path','title','content');
							$arr2=array(URL_PATH,$friends_name,$friends_content);
							$htmlsucc=NewHtmlPage($object_page,$template_html,$arr1,$arr2);
							if($htmlsucc){
								$htmlsucc=HtmlPathANDList($friends_id.'.html',$friends_id,'friends');
								if($htmlsucc){
									msg_out('恭喜！添加内容成功，静态页面生成成功。成功更新了数据库和静态列表页。',URL_PATH.'admin/listfriends.php');
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
						msg_back('标题为'.$friends_name.'的内容已存在。');
					}
				}else{
					msg_back('该数据已经不存在了。');
				}
	}

?>
