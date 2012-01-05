<?php
   header("content-type:text/html;charset=utf-8");//设置编码方式
   define('FILE_PATH', str_replace("\\", '/', substr(dirname(__FILE__), 0, -7)));//服务器文件目录
   define("URL_PATH",'http://127.0.0.1/leetobest/');//域名
   define('TIMEZONE', 'Etc/GMT-8'); //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8

   /*
   * 数据库的相关资料
   */
   define('DB_HOST', 'localhost'); //数据库服务器主机地址
   define('DB_USER', 'root'); //数据库帐号
   define('DB_PW', 'root'); //数据库密码
   define('DB_NAME', 'leetobest'); //数据库名
   define('DB_CHARSET', 'utf8'); //数据库字符集
   define('DB_PCONNECT', 0); //0 或1，是否使用持久连接
   define('DB_DATABASE', 'mysql'); //数据库类型

   define('CHARSET', 'utf-8'); //网站字符集
   //特别说明：leesession.php检查用户session和检查权限的文件和此文件没有办法联系起来，设定和更改此处的值时，请注意更改leesession.php中的值。
   define('CACHE_PATH', FILE_PATH.'db_cache/'); //缓存默认存储路径【请注意更改leesession.php中的值。】
   define('UPLOAD_PATH', 'upload/'); //文件上传默认存储路径

   define('LOGIN_LIMIT_TIME', 20); //用户登录时间限定【分钟】
   define('LOGIN_LIMIT_COUNT', 20); //用户登录错误次数限定【即，用户在指定分钟内，登录次数超过限定次数后，账号将被冻结，由管理员和用户自己解冻后才能继续使用。】
	/*
	* 处理静态页面总目录【请勿随意更改】
	*/
	$yearnum=date('Y');
	define('TOHTML_PATH',FILE_PATH.$yearnum.'/');
	define('URLHTML_PATH',URL_PATH.$yearnum.'/');
	if(!file_exists(TOHTML_PATH)){
		if(!mkdir(TOHTML_PATH)){
			echo '<script>alert("创建静态页文件夹失败。请检查权限设置。");</script>';
		}
	}
	unset($yearnum);
   /*
   * smarty相关资料
   */
   /*  定义Smarty目录的绝对路径  */
   define('SMARTY_PATH',FILE_PATH.'/Smarty/');
   /*  加载Smarty类库文件  */
   require SMARTY_PATH.'Smarty.class.php';
   /*  实例化一个Smarty对象  */
   $smarty = new Smarty;
   /*  定义各个目录的路径 */
   $smarty->template_dir = FILE_PATH.'templates/';
   $smarty->compile_dir = FILE_PATH.'templates_c/';
   $smarty->config_dir = FILE_PATH.'configs/';
   $smarty->cache_dir = FILE_PATH.'cache/';
   /* 定义左右结束符 */
   $smarty->left_delimiter = '{%';
   $smarty->right_delimiter = '%}';
   /*  关闭缓存  */
   $smarty->caching=false;
   /*关闭调试*/
   $smarty->debugging=false;

   /*
   *  读取自定义缓存
   */

?>