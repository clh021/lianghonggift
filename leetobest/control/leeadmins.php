<?php
    session_start();
   //include_once('../admin/leesession.php');
	//checkmodules('admins');
	include('../include/config.php');//声明页面编码以及设置smarty基本设置
	include('../include/leecommon.php');//处理接收到的所有数据，有必要的话自动转译和过滤所有数据
	include('../include/mysql.php');//包含有操作数据库的所有方法
	include('../include/leeutil.php');//包含有常用的工具方法(获取图片，)
	/*
	* 销毁变量，释放内存
	*/
	function unsetall(){
		unset($GLOBALS['_POST'],$GLOBALS['demo'],$GLOBALS['contents_id'],$GLOBALS['contents_title'],$GLOBALS['contents_key'],$GLOBALS['contents_desc'],$GLOBALS['contents_content'],$GLOBALS['cates_id'],$GLOBALS['positions_id'],$GLOBALS['contents_images'],$GLOBALS['contents_flashs'],$GLOBALS['contents_videos'],$GLOBALS['contents_downs'],$GLOBALS['contents_status'],$GLOBALS['contents_sort'],$GLOBALS['contents_hits'],$GLOBALS['contents_connect'],$GLOBALS['contents_addusersid'],$GLOBALS['contents_addtime'],$GLOBALS['contents_editusersid'],$GLOBALS['contents_edittime'],$GLOBALS['contents_url'],$GLOBALS['contents_resource'],$GLOBALS['contents_remark1'],$GLOBALS['contents_remark2'],$GLOBALS['contents_remark3']);
	}


   if(empty($method)){
		echo "<script>alert('没有方法');window.history.back();</script>";
		exit;
   }else{
	    $methods=array('login','add','update');
		if(!in_array($method,$methods)){
		   unset($methods);
           echo "<script>alert('没有".$method."方法');window.history.back();</script>";
		   unset($method);
		   exit;
		}
   }
	$db=new Mysql(DB_HOST,DB_USER,DB_PW,DB_NAME,DB_CHARSET);//生成数据库连接等信息
   /*
   * 记录登录信息的方法
   * 陈良红 2010-12-23
   * 参数说明：
   * 数据库链接	实例化后的数据库操作类
   * 登录IP		尝试登录的IP
   * 登录账号	尝试登录的账号
   * 登录时间	本想自动取，但是传递可能更方便，性能更好
   * 登录状态	1--成功	2--失败
   * 登录失败的原因	当登录状态为'2'时，此不允许为空，为'1'时则忽略此值
   */
	function insert_loginlog($db="",$ip="",$account="",$addtime="",$status=0,$whyfalse=""){
		/*
		if(strlen($db)<1 || strlen($ip)<1 || strlen($account)<1 || strlen($addtime)<1 || strlen($status)<1 ){
			echo "<script>alert('登录日志参数不全');</script>";
		    exit;
		}//由于只有本处，本人才会使用此方法，所以注释以提高性能。
		*/
		if($status===2 || strlen($whyfalse)<1){
			$success=$db->insert('loginlog',
				array($ip,				$account,			$addtime,			$status,			$whyfalse),
				array('loginlog_ip',	'loginlog_account',	'loginlog_addtime',	'loginlog_status',	'loginlog_whyfalse'),
				array('VARCHAR',		'VARCHAR',			'VARCHAR',			'INTEGER',			'VARCHAR'));
			if($success!==false){
				return 1;
			}else{
				return 2;
			}
		}else{
			echo "<script>alert('登录日志失败记录必须写明原因');</script>";
		    exit;
		}
	}
   /*
   * 登陆
   */
   if($method=='login'){
        $users_account=@trim($users_account);
        if(strlen($users_account)<0){
			echo "<script>alert('账号没有值');window.history.back();</script>";
		    exit;
		}else{
		    $users_account=html($users_account);
		}

		$users_password=@trim($users_password);
        if(strlen($users_password)<0){
			echo "<script>alert('密码没有值');window.history.back();</script>";
		    exit;
		}else{
		    $users_password=html($users_password);
            $users_password=md5($users_password);
		}
		date_default_timezone_set("Asia/Shanghai");//设置时间分区
		$nowtime=date('Y-m-d H:i:s');//得到现在的时间
		$ip=ip();
		if(strlen($ip)<8 || strlen($ip)>16){
			echo '<script>alert("您的IP['.$ip.']不正常，请使用合法IP。");window.history.back();</script>';
		    exit;
		}
		$begintime=date('Y-m-d ');
		$hour=date('H');
		$min=date('i');
		$endtime=date('s');
		$limit_time='';
		if($min>LOGIN_LIMIT_TIME){
			$limit_time=$begintime.$hour.":".($min-LOGIN_LIMIT_TIME).":".$endtime;
		}else{
			$limit_time=$begintime.($hour-1).":".($min+60-LOGIN_LIMIT_TIME).":".$endtime;
		}
		$sql_false_count='SELECT loginlog_status FROM loginlog WHERE loginlog_addtime>"'.$limit_time.'" AND loginlog_status=2 AND loginlog_account="'.$users_account.'"';
		//echo $min.'<br />'.LOGIN_LIMIT_TIME.'<br />'.($min+60).'<br />'.($min+60-LOGIN_LIMIT_TIME).'<hr />'.$sql_false_count.'<hr />';
		$login_false_count=$db->select_Count($sql_false_count);
		//echo $login_false_count.'<br />'.LOGIN_LIMIT_COUNT;
		if($login_false_count>LOGIN_LIMIT_COUNT){
			echo "<script>alert('您的账号短时间内频繁登录失败，为了保护您的账号请稍后再试。');window.history.back();</script>";
		    exit;
		}
		//return;
		$sql="SELECT u.*,a.admins_name,a.admins_id,a.admins_status,r.roles_name,r.modules_ids,r.roles_status,ud.ud_status_set FROM users u,admins a,roles r,users_detailed ud WHERE u.users_id=a.users_id AND a.roles_id=r.roles_id AND u.users_account='$users_account' AND u.users_password='$users_password'";
		//echo $sql.'<hr />';return;
		$row=$db->select_All($sql);
		if(count($row)<1){
			$insert_success=insert_loginlog($db,$ip,$users_account,$nowtime,2,'账号或密码错误');
			//echo $insert_success;return;
			//建议加强防护，连续五次出现有密码错误的，要冻结账号，停用账号，要求先解除账号冻结，不管他是不是管理员
			//登录的，一定加强防护，记录IP地址。   哪一个IP地址，何时登录什么账号，是否成功
			echo "<script>alert('登录失败！请检查账号和密码是否正确……');window.history.back();</script>";
		    exit;
		}else{
				if($row[0]['roles_status']!=1){
					$insert_success=insert_loginlog($db,$ip,$users_account,$nowtime,2,'管理角色无效');
					 echo "<script>alert('您对应的管理角色被禁用，如有疑问请与管理员联系……');window.history.back();</script>";
					 return;
				}
				if($row[0]['admins_status']!=1){
					$insert_success=insert_loginlog($db,$ip,$users_account,$nowtime,2,'管理员身份被冻结');
					 echo "<script>alert('您的管理帐号被冻结，如有疑问请与管理员联系……');window.history.back();</script>";
					 return;
				}
				if(count($row[0]['ud_status_set'])<=0){
					$insert_success=insert_loginlog($db,$ip,$users_account,$nowtime,2,'管理角色无效');
					 echo "<script>alert('您的帐号无法访问任何频道，如有疑问请申诉……');window.history.back();</script>";
					 return;
				}
			/*
		    * 设置session
		    */
			if(strlen($row[0]['modules_ids'])>0 && strlen($row[0]['roles_name'])>0 && strlen($row[0]['users_account'])>0 && strlen($row[0]['users_id'])>0 && strlen($row[0]['admins_id'])>0  && strlen($row[0]['admins_name'])>0 ){
				$insert_success=insert_loginlog($db,$ip,$users_account,$nowtime,1,'');
				//echo $insert_success;return;
				$_SESSION['ud_status_set']=$row[0]['ud_status_set'];
				$_SESSION['modules_id_set']=$row[0]['modules_ids'];
				$_SESSION['roles_name']=$row[0]['roles_name'];
				$_SESSION['users_account']=$row[0]['users_account'];
				$_SESSION['users_id']=$row[0]['users_id'];
				$_SESSION['admins_id']=$row[0]['admins_id'];
				$_SESSION['admins_name']=$row[0]['admins_name'];
//echo '---'.count($row).'<br />'.$row[0]['ud_status_set'].'<br />'.$row[0]['modules_ids'].'<br />'.$row[0]['roles_name'].'<br />'.$row[0]['users_account'].'<br />'.$row[0]['users_id'].'<br />'.$row[0]['admins_id'].'<br />'.$row[0]['admins_name'].'<br />';//return;
			}else{
				$insert_success=insert_loginlog($db,$ip,$users_account,$nowtime,2,'管理员身份数据不完整');
				echo "<script>alert('抱歉，没有获取完整的管理员身份数据……');window.history.back();</script>";
				return;
			}
			
			/*
		    echo $_SESSION['modules_id_set']."_1__<br />";
		    echo $_SESSION['roles_name']."_2__<br />";
		    echo $_SESSION['users_account']."_3__<br />";
		    echo $_SESSION['users_id']."_4__<br />";
			echo $_SESSION['admins_id']."_5__<br />";
			echo $_SESSION['admins_name']."_6__<br />";
			return;
			*/



			

			//注销变量
		    unset($users_account);
		    unset($users_password);
		    unset($sql);
			unset($row);
		    $db->close();
			unset($db);

			//页面跳转
            header("Location:".URL_PATH."admin/leeadmin_index.php");
			exit;
		}
   }
   
?>